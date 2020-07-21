<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\classes\console;

use app\classes\Ctrl as Ctrl_Base;
use ginkgo\Route;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Session;
use ginkgo\Cookie;
use ginkgo\Config;
use ginkgo\Crypt;
use ginkgo\Plugin;
use ginkgo\Auth;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');


/*-------------控制中心通用控制器-------------*/
abstract class Ctrl extends Ctrl_Base {

    protected $isSuper     = false;
    protected $adminLogged = array(
        'admin_status'  => '',
    );

    protected $obj_auth;
    protected $mdl_login;

    protected $adminAllow = array();

    protected function c_init($param = array()) { //构造函数
        parent::c_init();

        Plugin::listen('action_console_init'); //管理后台初始化时触发

        $this->langReplace = array();

        $this->obj_auth     = Auth::instance(array(), 'admin');
        $this->mdl_login    = Loader::model('Login', '', 'console');

        $_arr_adminLogged = $this->sessionRead();

        //print_r($_arr_adminLogged);

        if (isset($_arr_adminLogged['admin_type']) && $_arr_adminLogged['admin_type'] == 'super') {
            $this->isSuper = true;
        }

        if (isset($_arr_adminLogged['admin_allow'])) {
            $this->adminAllow = $_arr_adminLogged['admin_allow'];
        }

        $this->generalData['adminLogged']   = $_arr_adminLogged;
        $this->adminLogged                  = $_arr_adminLogged;
    }


    protected function init($chk_admin = true) {
        $_arr_chkResult = $this->chkInstall();

        if (!Func::isEmpty($_arr_chkResult['rcode'])) {
            return $_arr_chkResult;
        }

        if ($chk_admin) {
            $_arr_adminResult = $this->isAdmin();

            if (!Func::isEmpty($_arr_adminResult['rcode'])) {
                return $_arr_adminResult;
            }
        }

        $_mdl_link     = Loader::model('Link', '', false);
        $_obj_base     = Loader::classes('Base', 'sso', 'console');

        $_arr_data = array(
            'pm_type'       => $_obj_base->pm(),
            'urls'          => $_obj_base->urls(),
            'links'         => $_mdl_link->cache(),
        );

        if (!isset($_arr_data['pm_type']['type'])) {
            $_arr_data['pm_type']['type'] = array();
        }

        if (!isset($_arr_data['urls']['url_forgot'])) {
            $_arr_data['urls']['url_forgot'] = '';
        }

        $this->generalData = array_replace_recursive($this->generalData, $_arr_data);

        return true;
    }


    /** 验证 session, 并获取用户信息
     * sessionRead function.
     *
     * @access protected
     * @return void
     */
    function sessionRead() {
        $_num_adminId  = 0;
        $_arr_authRow  = $this->obj_auth->read();

        $_arr_session  = $_arr_authRow['session'];
        $_arr_remember = $_arr_authRow['remember'];

        if (isset($_arr_session['admin_id']) && $_arr_session['admin_id'] > 0) {
            $_num_adminId = $_arr_session['admin_id'];
        } else if (isset($_arr_remember['admin_id']) && $_arr_remember['admin_id'] > 0) {
            $_num_adminId = $_arr_remember['admin_id'];
        }

        $_arr_adminRow = $this->mdl_login->read($_num_adminId);
        //print_r($_arr_adminRow);
        if ($_arr_adminRow['rcode'] != 'y020102') {
            $this->obj_auth->end();

            return $_arr_adminRow;
        }

        if ($_arr_adminRow['admin_status'] == 'disabled') {
            $this->obj_auth->end();
            return array(
                'rcode' => 'x020402',
            );
        }

        if (!$this->obj_auth->check($_arr_adminRow, $this->url['route_console'])) {
            return array(
                'msg'   => $this->obj_auth->getError(),
                'rcode' => 'x020403',
            );
        }

        return $_arr_adminRow;
    }


    function sessionLogin($arr_adminRow, $str_remember = '', $str_type = 'form') {
        $this->mdl_login->inputSubmit   = array_replace_recursive($this->mdl_login->inputSubmit, $arr_adminRow);

        $_arr_loginResult               = $this->mdl_login->login();

        $arr_adminRow = array_replace_recursive($arr_adminRow, $_arr_loginResult);

        $this->obj_auth->write($arr_adminRow, true, $str_type, $str_remember, $this->url['route_console']);

        return array(
            'rcode' => 'y020401',
            'msg'   => $this->obj_lang->get('Login successful', $this->route['mod'] . '.common'),
        );
    }


    function isAdmin() {
        $_str_rcode = '';
        $_str_jump  = '';
        $_str_msg   = '';

        //print_r($this->param);

        if ($this->adminLogged['rcode'] != 'y020102') {
            $this->obj_auth->end();
            $_str_rcode = $this->adminLogged['rcode'];
            $_str_msg   = $this->obj_lang->get('You have not logged in', $this->route['mod'] . '.common');

            if (!isset($this->param['view']) || ($this->param['view'] != 'iframe' && $this->param['view'] != 'modal')) {
                $_str_jump      = $this->url['route_console'] . 'login/';
            }
        }

        if (!Func::isEmpty($_str_jump) && !$this->isAjaxPost) {
            $_obj_redirect = $this->redirect($_str_jump);
            $_obj_redirect->remember();
            return $_obj_redirect->send();
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $this->obj_lang->get($_str_msg, $this->route['mod'] . '.common'),
        );
    }


    private function chkInstall() {
        $_str_rcode     = '';
        $_str_jump      = '';
        $_str_msg       = '';

        $_str_configInstalled     = GK_APP_CONFIG . 'installed' . GK_EXT_INC;

        if (Func::isFile($_str_configInstalled)) { //如果新文件存在
            $_arr_installed       = Config::load($_str_configInstalled, 'installed');

            if (PRD_ADS_PUB > $_arr_installed['prd_installed_pub']) { //如果小于当前版本
                $_str_rcode = 'x030404';
                $_str_msg   = $this->obj_lang->get('Need to execute the upgrader', $this->route['mod'] . '.common');
                $_str_jump  = $this->url['route_install'] . 'upgrade';
            }
        } else { //如已安装文件未找到
            $_str_rcode = 'x030403';
            $_str_msg   = $this->obj_lang->get('Need to execute the installer', $this->route['mod'] . '.common');
            $_str_jump  = $this->url['route_install'];
        }

        if (!Func::isEmpty($_str_jump) && !$this->isAjaxPost) {
            return $this->redirect($_str_jump)->send();
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $this->obj_lang->get($_str_msg, $this->route['mod'] . '.common'),
        );
    }


    protected function pathProcess() {
        parent::pathProcess();

        $_str_tplPath        = Config::get('path', 'tpl');

        $_str_pathTplConsole = GK_PATH_TPL;

        if (!Func::isEmpty($_str_tplPath)) {
            $_str_pathTplConsole = GK_APP_TPL . 'console' . DS . $_str_tplPath . DS;
        }

        $_arr_url = array(
            'path_tpl_console'  => $_str_pathTplConsole,
        );

        $this->url = array_replace_recursive($this->url, $_arr_url);

        $this->generalData = array_replace_recursive($this->generalData, $_arr_url);
    }


    protected function configProcess() {
        parent::configProcess();

        $_str_configOpt = BG_PATH_CONFIG . 'console' . DS . 'opt' . GK_EXT_INC;
        Config::load($_str_configOpt, 'opt', 'console');

        $_str_configConsoleMod  = BG_PATH_CONFIG . 'console' . DS . 'console_mod' . GK_EXT_INC;
        Config::load($_str_configConsoleMod, 'console_mod', 'console');

        $_str_configProfile = BG_PATH_CONFIG . 'console' . DS . 'profile_mod' . GK_EXT_INC;
        Config::load($_str_configProfile, 'profile_mod', 'console');
    }
}
