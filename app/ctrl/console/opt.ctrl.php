<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Config;
use ginkgo\File;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

class Opt extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_opt    = Loader::model('Opt');
    }


    function form() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->adminAllow['opt'][$this->routeOrig['act']]) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x030301');
        }

        $_arr_consoleOpt  = Config::get($this->routeOrig['act'], 'console.opt');
        $_arr_consoleAct  = $_arr_consoleOpt['lists'];

        $_arr_tplData = array(
            'token'         => $this->obj_request->token(),
        );

        if ($this->routeOrig['act'] == 'base') {
            $_arr_tplData['tplRows']  = File::instance()->dirList(BG_TPL_INDEX);

            $_str_configTimezone    = BG_PATH_CONFIG . 'console' . DS . 'timezone' . GK_EXT_INC;
            $_arr_timezoneRows      = Config::load($_str_configTimezone, 'timezone', 'console');

            $_str_current           = $this->obj_lang->getCurrent();
            $_str_langPath          = GK_APP_LANG . $_str_current . DS . 'console' . DS . 'timezone' . GK_EXT_LANG;
            $_arr_timezoneLang      = $this->obj_lang->load($_str_langPath, 'console.timezone');

            $_arr_timezone[] = '';

            //print_r($this->config['var_extra']['base']);

            if (!isset($this->config['var_extra']['base']['site_timezone']) || strpos($this->config['var_extra']['base']['site_timezone'], '/') === false) {
                $this->config['var_extra']['base']['site_timezone'] = $this->config['var_default']['timezone'];
            }

            if (strpos($this->config['var_extra']['base']['site_timezone'], '/')) {
                $_arr_timezone = explode('/', $this->config['var_extra']['base']['site_timezone']);
            }

            $_arr_tplData['timezoneRows']       = $_arr_timezoneRows;
            $_arr_tplData['timezoneRowsJson']   = json_encode($_arr_timezoneRows);
            $_arr_tplData['timezoneLangJson']   = json_encode($_arr_timezoneLang);
            $_arr_tplData['timezoneType']       = strtolower($_arr_timezone[0]);
        }

        foreach ($_arr_consoleAct as $_key=>$_value) {
            if (isset($this->config['var_extra'][$this->routeOrig['act']][$_key])) {
                $_arr_consoleAct[$_key]['this'] = $this->config['var_extra'][$this->routeOrig['act']][$_key];
            } else {
                $_arr_consoleAct[$_key]['this'] = '';
            }

            if (isset($_value['option']) && is_array($_value['option'])) {
                foreach ($_value['option'] as $_key_opt=>$_value_opt) {
                    if (isset($_value['date_param'])) {
                        $_str_replace = date($_key_opt);
                    } else {
                        $_str_replace = $_key_opt;
                    }

                    $_arr_consoleAct[$_key]['lang_replace'][$_key_opt] = $_str_replace;
                    $_arr_consoleAct[$_key]['lang_replace']['value']   = $_str_replace;
                }
            }
        }

        $_arr_tplData['consoleOpt'] = $_arr_consoleAct;

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

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

        if (!isset($this->adminAllow['opt'][$this->routeOrig['act']]) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x030301');
        }

        $_arr_inputSubmit = $this->mdl_opt->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y030201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        $_arr_submitResult = $this->mdl_opt->submit();

        return $this->fetchJson($_arr_submitResult['msg'], $_arr_submitResult['rcode']);
    }


    function dbconfig() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->adminAllow['opt']['dbconfig']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x030301');
        }

        $_arr_tplData = array(
            'token'     => $this->obj_request->token(),
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

        if (!isset($this->adminAllow['opt']['dbconfig']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x030301');
        }

        $_arr_inputDbconfig = $this->mdl_opt->inputDbconfig();

        if ($_arr_inputDbconfig['rcode'] != 'y030201') {
            return $this->fetchJson($_arr_inputDbconfig['msg'], $_arr_inputDbconfig['rcode']);
        }

        $_arr_dbconfigResult = $this->mdl_opt->dbconfig();

        return $this->fetchJson($_arr_dbconfigResult['msg'], $_arr_dbconfigResult['rcode']);
    }

    function upload() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->adminAllow['opt']['upload']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x030301');
        }

        $_arr_tplData = array(
            'token'     => $this->obj_request->token(),
        );


        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function uploadSubmit() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->adminAllow['opt']['upload']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x030301');
        }

        $_arr_inputUpload = $this->mdl_opt->inputUpload();

        if ($_arr_inputUpload['rcode'] != 'y030201') {
            return $this->fetchJson($_arr_inputUpload['msg'], $_arr_inputUpload['rcode']);
        }

        $_arr_uploadResult = $this->mdl_opt->upload();

        return $this->fetchJson($_arr_uploadResult['msg'], $_arr_uploadResult['rcode']);
    }


    function chkver() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->adminAllow['opt']['chkver']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x030301');
        }

        if (isset($this->config['ui_ctrl']['update_check']) && $this->config['ui_ctrl']['update_check'] != 'on') {
            return $this->error('Check for updated module being disabled', 'x030301');
        }

        $_arr_configBase    = Config::get('base', 'var_extra');
        $_arr_installed     = Config::get('installed'); //当前安装的
        $_arr_latest        = $this->mdl_opt->chkver();

        if (!isset($_arr_installed['prd_installed_pub'])) {
            $_arr_installed['prd_installed_pub'] = PRD_ADS_PUB;
        }

        if (!isset($_arr_latest['prd_pub'])) {
            $_arr_latest['prd_pub'] = PRD_ADS_PUB;
        }

        $_arr_installed['prd_installed_pub_datetime']   = date($_arr_configBase['site_date'], strtotime($_arr_installed['prd_installed_pub']));
        $_arr_installed['prd_installed_datetime']       = date($_arr_configBase['site_date'] . ' ' . $_arr_configBase['site_time_short'], $_arr_installed['prd_installed_time']);

        $_arr_latest['prd_pub_datetime']        = date($_arr_configBase['site_date'], strtotime($_arr_latest['prd_pub']));

        $_arr_tplData = array(
            'installed' => $_arr_installed,
            'latest'    => $_arr_latest,
            'token'     => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function chkverSubmit() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->adminAllow['opt']['chkver']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x030301');
        }

        if (isset($this->config['ui_ctrl']['update_check']) && $this->config['ui_ctrl']['update_check'] != 'on') {
            return $this->fetchJson('Check for updated module being disabled', 'x030301');
        }

        $_arr_inputCommon = $this->mdl_opt->inputCommon();

        if ($_arr_inputCommon['rcode'] != 'y030201') {
            return $this->fetchJson($_arr_inputCommon['msg'], $_arr_inputCommon['rcode']);
        }

        $_arr_latestResult = $this->mdl_opt->latest('manual');

        return $this->fetchJson($_arr_latestResult['msg'], $_arr_latestResult['rcode']);
    }
}
