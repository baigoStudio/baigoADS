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

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');


/*-------------控制中心通用控制器-------------*/
abstract class Ctrl extends Ctrl_Base {

    protected $isSuper     = false;
    protected $adminLogged = array(
        'admin_status' => '',
    );

    protected $mdl_login;

    protected $adminAllow = array();

    protected function c_init($param = array()) { //构造函数
        parent::c_init();

        $this->langReplace = array();

        $this->mdl_login    = Loader::model('Login', '', 'console');

        Plugin::listen('action_console_init'); //管理后台初始化时触发

        $_arr_adminLogged = $this->sessionRead();

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


    /*============验证 session, 并获取用户信息============
    返回数组
        admin_id ID
        admin_open_label OPEN ID
        admin_open_site OPEN 站点
        admin_note 备注
        group_allow 权限
        str_rcode 提示信息
    */
    function sessionRead() {
        $_sessionTime    = Session::get('admin_session_time');

        $_arr_session = array(
            'admin_id'              => Session::get('admin_id'),
            'admin_hash'            => Session::get('admin_hash'),
            'admin_session_time'    => $_sessionTime,
            'admin_time_diff'       => $_sessionTime + $this->config['console']['session']['expire'],
        );

        $_cookieTime     = Cookie::get('admin_cookie_time');

        $_arr_cookie = array(
            'admin_id'              => Cookie::get('admin_id'),
            'admin_hash'            => Cookie::get('admin_hash'),
            'admin_cookie_time'     => $_cookieTime,
            'admin_time_diff'       => $_cookieTime + $this->config['console']['session']['expire'],
            'remember_admin_id'     => Cookie::get('remember_admin_id'),
            'remember_admin_hash'   => Cookie::get('remember_admin_hash'),
            'remember_hash_time'    => Cookie::get('remember_hash_time'),
        );

        /*print_r(Session::prefix());
        print_r($_arr_session);
        print_r('<br>');
        print_r($_arr_cookie);
        print_r('<br>');
        exit;*/

        if ($this->haveSession($_arr_session, $_arr_cookie)) {
            $_arr_adminRow = $this->mdl_login->read($_arr_session['admin_id']);
            if ($_arr_adminRow['rcode'] != 'y020102') {
                $this->sessionEnd(0);
                return $_arr_adminRow;
            }

            if ($_arr_adminRow['admin_status'] == 'disabled') {
                $this->sessionEnd(1);
                return array(
                    'rcode' => 'x020402',
                );
            }

            if ($this->hashProcess($_arr_adminRow) != $_arr_session['admin_hash'] || $this->hashProcess($_arr_adminRow) != $_arr_cookie['admin_hash']) {
                $this->sessionEnd(2);
                return array(
                    'rcode' => 'x020403',
                );
            }

            $this->sessionProcess($_arr_adminRow, 'form');
        } else if ($this->haveRemenber($_arr_cookie)) {
            $_num_cookieRemenberDiff = $_arr_cookie['remember_hash_time'] + $this->config['console']['session']['remember']; //记住密码有效期
            if ($_num_cookieRemenberDiff < GK_NOW) {
                $this->sessionEnd(3);
                return array(
                    'rcode' => 'x020403',
                );
            }

            $_arr_adminRow = $this->mdl_login->read($_arr_cookie['remember_admin_id']);
            if ($_arr_adminRow['rcode'] != 'y020102') {
                $this->sessionEnd(4);
                return $_arr_adminRow;
            }

            if ($_arr_adminRow['admin_status'] == 'disabled') {
                $this->sessionEnd(5);
                return array(
                    'rcode' => 'x020402',
                );
            }

            if ($this->hashProcess($_arr_adminRow) != $_arr_cookie['remember_admin_hash']) {
                $this->sessionEnd(6);
                return array(
                    'rcode' => 'x020403',
                );
            }

            $this->sessionProcess($_arr_adminRow, 'auto');
        } else {
            $this->sessionEnd(7);
            return array(
                'rcode' => 'x020403',
            );
        }

        return $_arr_adminRow;
    }


    function sessionLogin($arr_adminRow, $str_remember = '') {
        session_regenerate_id(true);

        $this->mdl_login->inputSubmit    = array_replace_recursive($this->mdl_login->inputSubmit, $arr_adminRow);

        $_arr_loginReturn               = $this->mdl_login->login();

        $arr_adminRow['admin_time_login']  = $_arr_loginReturn['admin_time_login'];
        $arr_adminRow['admin_ip']          = $_arr_loginReturn['admin_ip'];

        if ($str_remember == 'remember') {
            $_arr_optCookie = array(
                'expire'    => $this->config['console']['session']['remember'],
                'path'      => $this->url['route_console'],
            );
            Cookie::set('remember_admin_id', $arr_adminRow['admin_id'], $_arr_optCookie);
            Cookie::set('remember_admin_hash', $this->hashProcess($arr_adminRow), $_arr_optCookie);
            Cookie::set('remember_hash_time', GK_NOW, $_arr_optCookie);
        }

        $this->sessionProcess($arr_adminRow, 'form');

        return array(
            'rcode' => 'y020401',
            'msg'   => $this->obj_lang->get('Login successful', $this->route['mod'] . '.common'),
        );
    }

    /** 结束登录 session
     * $this->sessionEnd function.
     *
     * @access public
     * @return void
     */
    function sessionEnd($id = 0, $regen = false) {
        Session::delete('admin_id');
        Session::delete('admin_session_time');
        Session::delete('admin_hash');
        Cookie::delete('admin_id');
        Cookie::delete('admin_cookie_time');
        Cookie::delete('admin_hash');
        Cookie::delete('remember_admin_id');
        Cookie::delete('remember_admin_hash');
        Cookie::delete('remember_hash_time');

        if ($regen) {
            session_regenerate_id(true);
        }

        //print_r($id);
        //exit;
    }


    function isAdmin() {
        $_str_rcode = '';
        $_str_jump  = '';
        $_str_msg   = '';

        //print_r($this->param);

        if ($this->adminLogged['rcode'] != 'y020102') {
            $this->sessionEnd(8);
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


    private function haveSession($arr_session, $arr_cookie) {
        /*print_r($arr_session);
        print_r('<br>');
        print_r($arr_cookie);*/

        $_str_status = true;

        $_str_status = !Func::isEmpty($arr_session['admin_id']);
        $_str_status = !Func::isEmpty($arr_session['admin_session_time']);
        $_str_status = !Func::isEmpty($arr_session['admin_hash']);
        $_str_status = $arr_session['admin_time_diff'] > GK_NOW;
        $_str_status = !Func::isEmpty($arr_cookie['admin_id']);
        $_str_status = !Func::isEmpty($arr_cookie['admin_cookie_time']);
        $_str_status = !Func::isEmpty($arr_cookie['admin_hash']);
        $_str_status = $arr_cookie['admin_time_diff'] > GK_NOW;

        return $_str_status;
    }

    private function haveRemenber($arr_cookie) {
        $_str_status = true;

        $_str_status = !Func::isEmpty($arr_cookie['remember_admin_id']);
        $_str_status = !Func::isEmpty($arr_cookie['remember_admin_hash']);
        $_str_status = !Func::isEmpty($arr_cookie['remember_hash_time']);

        return $_str_status;
    }

    private function hashProcess($arr_adminRow) {
        return Crypt::crypt($arr_adminRow['admin_id'] . $arr_adminRow['admin_name'] . $arr_adminRow['admin_time_login'], $arr_adminRow['admin_ip']);
    }

    private function sessionProcess($arr_adminRow, $str_loginType = 'form') {
        Session::set('admin_id', $arr_adminRow['admin_id']);
        Session::set('admin_session_time', GK_NOW);
        Session::set('admin_hash', $this->hashProcess($arr_adminRow));
        Session::set('admin_login_type', $str_loginType);

        $_arr_optCookie = array(
            'expire'    => $this->config['console']['session']['expire'],
            'path'      => $this->url['route_console'],
        );

        Cookie::set('admin_id', $arr_adminRow['admin_id'], $_arr_optCookie);
        Cookie::set('admin_cookie_time', GK_NOW, $_arr_optCookie);
        Cookie::set('admin_hash', $this->hashProcess($arr_adminRow), $_arr_optCookie);
        Cookie::set('admin_login_type', $str_loginType, $_arr_optCookie);
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

        $_str_configProfile = BG_PATH_CONFIG . 'console' . DS . 'profile' . GK_EXT_INC;
        Config::load($_str_configProfile, 'profile', 'console');

        $_str_configOpt = BG_PATH_CONFIG . 'console' . DS . 'opt' . GK_EXT_INC;
        Config::load($_str_configOpt, 'opt', 'console');

        $_str_configConsoleMod  = BG_PATH_CONFIG . 'console' . DS . 'console_mod' . GK_EXT_INC;
        Config::load($_str_configConsoleMod, 'console_mod', 'console');
    }
}
