<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}


/*-------------用户类-------------*/
class CONTROL_CONSOLE_REQUEST_PM {

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->dspType = 'result';
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        $this->obj_sso      = new CLASS_SSO(); //获取界面类型
        $this->mdl_pm       = new MODEL_PM(); //获取界面类型
    }


    function ctrl_revoke() {
        $_num_pmId = fn_getSafe(fn_post('pm_id'), 'int', 0);
        if ($_num_pmId < 1) {
            $_arr_tplData = array(
                'rcode' => 'x110211',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_pmSubmit = array(
            'user_access_token' => $this->adminLogged['admin_access_token'],
            'pm_ids'            => array($_num_pmId),
        );
        $_arr_pmRow = $this->obj_sso->sso_pm_revoke($this->adminLogged['admin_id'], 'user_id', $_arr_pmSubmit);

        $this->obj_tpl->tplDisplay('result', $_arr_pmRow);
    }


    function ctrl_status() {
        $_arr_pmIds = $this->mdl_pm->input_ids();
        if ($_arr_pmIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_pmIds);
        }

        $_str_pmStatus  = fn_getSafe($GLOBALS['route']['bg_act'], 'txt', '');

        $_arr_pmSubmit = array(
            'user_access_token' => $this->adminLogged['admin_access_token'],
            'pm_status'         => fn_getSafe($GLOBALS['route']['bg_act'], 'txt', ''),
            'pm_ids'            => $_arr_pmIds['pm_ids'],
        );
        $_arr_pmRow     = $this->obj_sso->sso_pm_status($this->adminLogged['admin_id'], 'user_id', $_arr_pmSubmit);

        $this->obj_tpl->tplDisplay('result', $_arr_pmRow);
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_send() {
        $_arr_pmSend = $this->mdl_pm->input_send();
        if ($_arr_pmSend['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_pmSend);
        }

        $_arr_pmSubmit = array(
            'user_access_token' => $this->adminLogged['admin_access_token'],
            'pm_to'             => $_arr_pmSend['pm_to'],
            'pm_title'          => $_arr_pmSend['pm_title'],
            'pm_content'        => $_arr_pmSend['pm_content'],
        );
        $_arr_pmRow     = $this->obj_sso->sso_pm_send($this->adminLogged['admin_id'], 'user_id', $_arr_pmSubmit);

        $this->obj_tpl->tplDisplay('result', $_arr_pmRow);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        $_arr_pmIds = $this->mdl_pm->input_ids();
        if ($_arr_pmIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_pmIds);
        }

        $_arr_pmSubmit = array(
            'user_access_token' => $this->adminLogged['admin_access_token'],
            'pm_ids'            => $_arr_pmIds['pm_ids'],
        );

        $_arr_pmRow     = $this->obj_sso->sso_pm_del($this->adminLogged['admin_id'], 'user_id', $_arr_pmSubmit);

        $this->obj_tpl->tplDisplay('result', $_arr_pmRow);
    }
}
