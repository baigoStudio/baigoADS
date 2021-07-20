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

class Auth extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->obj_reg     = Loader::classes('Reg', 'sso');
        $this->mdl_auth    = Loader::model('Auth');

        $this->generalData['status']    = $this->mdl_auth->arr_status;
        $this->generalData['type']      = $this->mdl_auth->arr_type;
    }


    function form() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->adminAllow['admin']['add']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x020302');
        }
        $_arr_adminRow = array(
            'admin_status'      => $this->mdl_auth->arr_status[0],
            'admin_type'        => $this->mdl_auth->arr_type[0],
            'admin_allow'       => array(),
        );

        $_arr_tplData = array(
            'adminRow'  => $_arr_adminRow,
            'token'     => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_adminRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function submit() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->adminAllow['admin']['add']) && !$this->isSuper) {
            return $this->fetchJson('You do not have permission', 'x020302');
        }

        $_arr_inputSubmit = $this->mdl_auth->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y020201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        //检验用户名是否存在
        $_arr_userRow = $this->obj_reg->chkname($_arr_inputSubmit['admin_name']);

        if ($_arr_userRow['rcode'] != 'x010404') {
            return $this->fetchJson('User not found, please use add administrator', 'x010102');
        }

        $_arr_adminRow = $this->mdl_auth->check($_arr_userRow['user_id']);
        if ($_arr_adminRow['rcode'] == 'y020102') {
            return $this->fetchJson('Administrator already exists', 'x020404');
        }

        $this->mdl_auth->inputSubmit['admin_id'] = $_arr_userRow['user_id'];

        $_arr_submitResult = $this->mdl_auth->submit();

        return $this->fetchJson($_arr_submitResult['msg'], $_arr_submitResult['rcode']);
    }


    function check() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_return = array(
            'msg' => '',
        );

        $_str_adminName = $this->obj_request->get('admin_name');

        if (!Func::isEmpty($_str_adminName)) {
            $_arr_userRow   = $this->obj_reg->chkname($_str_adminName);

            if ($_arr_userRow['rcode'] == 'x010404') {
                $_arr_adminRow = $this->mdl_auth->check($_arr_userRow['user_id']);

                //print_r($_arr_adminRow);

                if ($_arr_adminRow['rcode'] == 'y020102') {
                    $_arr_return = array(
                        'rcode'     => 'x020404',
                        'error_msg' => $this->obj_lang->get('Administrator already exists'),
                    );
                }
            } else {
                $_arr_return = array(
                    'rcode'     => 'x010102',
                    'error_msg' => $this->obj_lang->get('User not found, please use add administrator'),
                );
            }
        }

        return $this->json($_arr_return);
    }
}
