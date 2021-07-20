<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

class Login extends Ctrl {

    /*protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_login    = Loader::model('Login');
    }*/

    function index() {
        $_mix_init = $this->init(false);

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_str_urlJump = $this->url['route_console'] . 'login/sync/';

        //print_r($this->adminLogged);

        if ($this->adminLogged['rcode'] == 'y020102') {
            return $this->redirect($this->url['route_console']);
        }

        $_arr_tplData = array(
            'jump'  => $_str_urlJump,
            'token' => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function sync() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_str_forward = $this->redirect()->restore();

        if (Func::isEmpty($_str_forward) || stristr($_str_forward, 'sync') || !stristr($_str_forward, 'console')) {
            $_str_forward = $this->url['route_console'];
        }

        $this->obj_sync = Loader::classes('Sync', 'sso');

        $_arr_sync = array();

        if (isset($this->adminLogged['admin_prefer']['sync']['sync']) && $this->adminLogged['admin_prefer']['sync']['sync'] === 'on') {
            $_arr_syncSubmit = array(
                'user_id'           => $this->adminLogged['admin_id'],
                'user_access_token' => $this->adminLogged['admin_access_token'],
            );
            $_arr_sync = $this->obj_sync->login($_arr_syncSubmit);
        }

        //print_r($_arr_sync);

        $_arr_tplData = array(
            'sync'       => $_arr_sync,
            'forward'    => $_str_forward,
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function submit() {
        $_mix_init = $this->init(false);

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_arr_inputSubmit = $this->mdl_login->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y020201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        $_obj_login    = Loader::classes('Login', 'sso');

        $_arr_loginResult = $_obj_login->login($_arr_inputSubmit['admin_name'], $_arr_inputSubmit['admin_pass']);

        if ($_arr_loginResult['rcode'] != 'y010103') {
            return $this->fetchJson($_arr_loginResult['msg'], $_arr_loginResult['rcode']);
        }

        $_arr_adminRow = $this->mdl_login->read($_arr_loginResult['user_id']);
        if ($_arr_adminRow['rcode'] != 'y020102') {
            return $this->fetchJson($_arr_adminRow['msg'], $_arr_adminRow['rcode']);
        }

        if ($_arr_adminRow['admin_status'] != 'enable') {
            return $this->fetchJson('Administrator is disabled', 'x020402');
        }

        $_arr_adminRow['admin_access_token']    = $_arr_loginResult['user_access_token'];
        $_arr_adminRow['admin_access_expire']   = $_arr_loginResult['user_access_expire'];
        $_arr_adminRow['admin_refresh_token']   = $_arr_loginResult['user_refresh_token'];
        $_arr_adminRow['admin_refresh_expire']  = $_arr_loginResult['user_refresh_expire'];

        $_arr_loginResult = $this->sessionLogin($_arr_adminRow, $_arr_inputSubmit['admin_remember']);

        return $this->fetchJson($_arr_loginResult['msg'], $_arr_loginResult['rcode']);
    }

    function logout() {
        $this->obj_auth->end(true);

        return $this->redirect($this->url['route_console']);
    }
}
