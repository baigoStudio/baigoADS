<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\install;

use app\classes\install\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Config;
use ginkgo\Cookie;
use ginkgo\Session;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

class Index extends Ctrl {

    function index() {
        $_mix_init = $this->init(true, false);

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_tplData = array(
            'token' => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function type() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_consoleOpt    = Config::get('sso', 'console.opt');
        $_arr_consoleAct    = $_arr_consoleOpt['lists'];

        foreach ($_arr_consoleAct as $_key=>$_value) {
            $_arr_consoleAct[$_key]['this'] = $this->config['var_extra']['sso'][$_key];
        }

        $_mix_installType = $this->chkInstallType();

        if (is_array($_mix_installType) && isset($_mix_installType['rcode'])) {
            $_mix_installType = 'full';
        }

        $_arr_tplData = array(
            'type'          => $_mix_installType,
            'consoleOpt'    => $_arr_consoleAct,
            'token'         => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function typeSubmit() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_arr_inputSubmit = $this->mdl_opt->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y030201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        Session::set('install_type', $_arr_inputSubmit['install_type']);
        $_arr_optCookie = array(
            'expire'    => 30 * GK_DAY,
            'path'      => $this->url['route_install'],
        );
        Cookie::set('install_type', $_arr_inputSubmit['install_type'], $_arr_optCookie);

        if ($_arr_inputSubmit['install_type'] == 'full') {
            $_arr_securityResult = $this->obj_sso->security();

            if ($_arr_securityResult['rcode'] != 'y030401') {
                return $this->fetchJson($_arr_securityResult['msg'], $_arr_securityResult['rcode']);
            }
        }

        $_arr_submitResult = $this->mdl_opt->submit();

        return $this->fetchJson($_arr_submitResult['msg'], $_arr_submitResult['rcode']);
    }


    function dbconfig() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_mix_installType = $this->chkInstallType();

        if (is_array($_mix_installType) && isset($_mix_installType['rcode'])) {
            return $this->error($_mix_installType['msg'], $_mix_installType['rcode']);
        }

        $_arr_tplData = array(
            'token' => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function dbconfigSubmit() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_mix_installType = $this->chkInstallType();

        if (is_array($_mix_installType) && isset($_mix_installType['rcode'])) {
            return $this->fetchJson($_mix_installType['msg'], $_mix_installType['rcode']);
        }

        $_arr_inputDbconfig = $this->mdl_opt->inputDbconfig();

        if ($_arr_inputDbconfig['rcode'] != 'y030201') {
            return $this->fetchJson($_arr_inputDbconfig['msg'], $_arr_inputDbconfig['rcode']);
        }

        $_arr_dbconfigResult = $this->mdl_opt->dbconfig();

        if ($_mix_installType == 'full') {
            $_arr_ssoResult = $this->obj_sso->dbconfig($_arr_inputDbconfig);

            //print_r($_arr_ssoResult);

            if ($_arr_ssoResult['rcode'] != 'y030401') {
                return $this->fetchJson($_arr_ssoResult['msg'], $_arr_ssoResult['rcode']);
            }
        }

        return $this->fetchJson($_arr_dbconfigResult['msg'], $_arr_dbconfigResult['rcode']);
    }


    function data() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_mix_installType = $this->chkInstallType();

        if (is_array($_mix_installType) && isset($_mix_installType['rcode'])) {
            return $this->error($_mix_installType['msg'], $_mix_installType['rcode']);
        }

        $_arr_ssoData = array();

        if ($_mix_installType == 'full') {
            $_arr_ssoData = $this->obj_sso->data();

            if ($_arr_ssoData['rcode'] != 'y030401') {
                return $this->error($_arr_ssoData['msg'], $_arr_ssoData['rcode'], 200);
            }

            $_arr_ssoData['rstatus'] = substr($_arr_ssoData['rcode'], 0, 1);
        }

        $_arr_tplData = array(
            'sso_data'  => $_arr_ssoData,
            'token'     => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function dataSubmit() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_arr_inputData = $this->mdl_opt->inputData();

        if ($_arr_inputData['rcode'] != 'y030201') {
            return $this->fetchJson($_arr_inputData['msg'], $_arr_inputData['rcode']);
        }

        switch ($_arr_inputData['type']) {
            case 'index':
                $_arr_dataResult = $this->createIndex($_arr_inputData['model']);
            break;

            case 'view':
                $_arr_dataResult = $this->createView($_arr_inputData['model']);
            break;

            default:
                $_arr_dataResult = $this->createTable($_arr_inputData['model']);
            break;
        }

        return $this->fetchJson($_arr_dataResult['msg'], $_arr_dataResult['rcode']);
    }


    function admin() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_mix_installType = $this->chkInstallType();

        if (is_array($_mix_installType) && isset($_mix_installType['rcode'])) {
            return $this->error($_mix_installType['msg'], $_mix_installType['rcode']);
        }

        $_arr_tplData = array(
            'token' => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function adminCheck() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_return    = array(
            'msg' => '',
        );

        $_str_adminName = $this->obj_request->get('admin_name');

        if (!Func::isEmpty($_str_adminName)) {
            $_obj_reg       = Loader::classes('Reg', 'sso', 'console');
            $_mdl_admin     = Loader::model('Admin');

            $_arr_userRow   = $_obj_reg->chkname($_str_adminName);

            if ($_arr_userRow['rcode'] == 'x010404') {
                $_arr_adminRow = $_mdl_admin->check($_str_adminName, 'admin_name');
                if ($_arr_adminRow['rcode'] == 'y020102') {
                    $_arr_return = array(
                        'rcode'     => 'x020404',
                        'error_msg' => $this->obj_lang->get('Administrator already exists'),
                    );
                } else {
                    $_arr_return = array(
                        'rcode'     => $_arr_userRow['rcode'],
                        'error_msg' => $this->obj_lang->get('User already exists, please use authorization as administrator'),
                    );
                }
            }
        }

        return $this->json($_arr_return);
    }


    function adminSubmit() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_mix_installType = $this->chkInstallType();

        if (is_array($_mix_installType) && isset($_mix_installType['rcode'])) {
            return $this->fetchJson($_mix_installType['msg'], $_mix_installType['rcode']);
        }

        $_mdl_admin  = Loader::model('Admin');

        $_arr_inputSubmit = $_mdl_admin->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y020201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        if ($_mix_installType == 'full') {
            $_arr_adminResult = $this->obj_sso->admin($_arr_inputSubmit['admin_name'], $_arr_inputSubmit['admin_pass'], $_arr_inputSubmit['admin_mail']);

            if ($_arr_adminResult['rcode'] != 'y020101') {
                return $this->fetchJson($_arr_adminResult['msg'], $_arr_adminResult['rcode']);
            }

            $_mdl_admin->inputSubmit['admin_id'] = $_arr_adminResult['admin_id'];
        } else {
            $_obj_reg = Loader::classes('Reg', 'sso', 'console');

            $_arr_userSubmit = array(
                'user_name' => $_arr_inputSubmit['admin_name'],
                'user_pass' => $_arr_inputSubmit['admin_pass'],
                'user_mail' => $_arr_inputSubmit['admin_mail'],
                'user_nick' => $_arr_inputSubmit['admin_nick'],
            );

            $_arr_regResult = $_obj_reg->reg($_arr_userSubmit);

            if ($_arr_regResult['rcode'] != 'y010101') {
                return $this->fetchJson($_arr_regResult['msg'], $_arr_regResult['rcode']);
            }

            $_mdl_admin->inputSubmit['admin_id'] = $_arr_regResult['user_id'];
        }

        $_arr_adminSubmit = $_mdl_admin->submit();

        return $this->fetchJson($_arr_adminSubmit['msg'], $_arr_adminSubmit['rcode']);
    }


    function auth() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_mix_installType = $this->chkInstallType('auth');

        if (is_array($_mix_installType) && isset($_mix_installType['rcode'])) {
            return $this->error($_mix_installType['msg'], $_mix_installType['rcode']);
        }

        $_arr_tplData = array(
            'token' => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function authCheck() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_mix_installType = $this->chkInstallType('auth');

        if (is_array($_mix_installType) && isset($_mix_installType['rcode'])) {
            return $this->fetchJson($_mix_installType['msg'], $_mix_installType['rcode']);
        }

        $_arr_return    = array(
            'msg' => '',
        );

        $_str_adminName = $this->obj_request->get('admin_name');

        if (!Func::isEmpty($_str_adminName)) {
            $_obj_reg      = Loader::classes('Reg', 'sso', 'console');
            $_mdl_admin    = Loader::model('Admin');

            $_arr_userRow   = $_obj_reg->chkname($_str_adminName);

            if ($_arr_userRow['rcode'] == 'x010404') {
                $_arr_adminRow = $_mdl_admin->check($_arr_userRow['user_id']);

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


    function authSubmit() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_mix_installType = $this->chkInstallType('auth');

        if (is_array($_mix_installType) && isset($_mix_installType['rcode'])) {
            return $this->fetchJson($_mix_installType['msg'], $_mix_installType['rcode']);
        }

        $_obj_reg    = Loader::classes('Reg', 'sso', 'console');
        $_mdl_admin  = Loader::model('Admin');

        $_arr_inputSubmit = $_mdl_admin->inputAuth();

        if ($_arr_inputSubmit['rcode'] != 'y020201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        //检验用户名是否存在
        $_arr_userRow = $_obj_reg->chkname($_arr_inputSubmit['admin_name']);

        if ($_arr_userRow['rcode'] != 'x010404') {
            return $this->fetchJson('User not found, please use add administrator', 'x010102');
        }

        $_arr_adminRow = $_mdl_admin->check($_arr_userRow['user_id']);
        if ($_arr_adminRow['rcode'] == 'y020102') {
            return $this->fetchJson('Administrator already exists', 'x020404');
        }

        $_mdl_admin->inputSubmit['admin_id']   = $_arr_userRow['user_id'];

        $_arr_authResult = $_mdl_admin->submit();

        return $this->fetchJson($_arr_authResult['msg'], $_arr_authResult['rcode']);
    }


    function over() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_mix_installType = $this->chkInstallType();

        if (is_array($_mix_installType) && isset($_mix_installType['rcode'])) {
            return $this->error($_mix_installType['msg'], $_mix_installType['rcode']);
        }

        $_arr_ssoInstalled = array();

        if ($_mix_installType == 'full') {
            $_arr_ssoInstalled = $this->obj_sso->getStatus();

            //print_r($_arr_ssoInstalled);

            if ($_arr_ssoInstalled['rcode'] != 'y030402') {
                return $this->error($_arr_ssoInstalled['msg'], $_arr_ssoInstalled['rcode']);
            }
        }

        //print_r($_arr_ssoInstalled);

        $_arr_tplData = array(
            'sso_installed'  => $_arr_ssoInstalled,
            'token'          => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function overSubmit() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_mix_installType = $this->chkInstallType();

        if (is_array($_mix_installType) && isset($_mix_installType['rcode'])) {
            return $this->fetchJson($_mix_installType['msg'], $_mix_installType['rcode']);
        }

        $_arr_inputOver = $this->mdl_opt->inputCommon();

        if ($_arr_inputOver['rcode'] != 'y030201') {
            return $this->fetchJson($_arr_inputOver['msg'], $_arr_inputOver['rcode']);
        }

        if ($_mix_installType == 'full') {
            $_arr_overResult = $this->obj_sso->over();

            //print_r($_arr_overResult);

            if ($_arr_overResult['rcode'] != 'y050101') {
                return $this->fetchJson($_arr_overResult['msg'], $_arr_overResult['rcode']);
            }

            $this->mdl_opt->inputSubmit['act']          = 'sso';
            $this->mdl_opt->inputSubmit['install_type'] = 'manually';
            $this->mdl_opt->inputSubmit['base_url']     = $_arr_overResult['base_url'];
            $this->mdl_opt->inputSubmit['app_id']       = $_arr_overResult['app_id'];
            $this->mdl_opt->inputSubmit['app_key']      = $_arr_overResult['app_key'];
            $this->mdl_opt->inputSubmit['app_secret']   = $_arr_overResult['app_secret'];

            $_arr_submitResult = $this->mdl_opt->submit();
        }

        $_arr_overResult = $this->mdl_opt->over();

        return $this->fetchJson($_arr_overResult['msg'], $_arr_overResult['rcode']);
    }


    private function chkInstallType($act = '') {
        $_str_installType = Session::get('install_type');

        if (Func::isEmpty($_str_installType)) {
            $_str_installType = Cookie::get('install_type');
        }

        if (Func::isEmpty($_str_installType)) {
            return array(
                'msg'   => 'Installation type is not set',
                'rcode' => 'x030204',
            );
        }

        if ($_str_installType == 'full' && $act == 'auth') {
            return array(
                'msg'   => 'Disabled during full installation',
                'rcode' => 'x030411',
            );
        }

        return $_str_installType;
    }
}
