<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}


/*-------------管理员控制器-------------*/
class CONTROL_CONSOLE_REQUEST_PROFILE {

    private $adminLogged;
    private $obj_ajax;
    private $mdl_admin;
    private $is_super = false;

    function __construct() { //构造函数
        $this->general_console          = new GENERAL_CONSOLE();
        $this->general_console->dspType = 'result';
        $this->general_console->chk_install();

        $this->adminLogged          = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl              = $this->general_console->obj_tpl;

        $this->obj_sso              = new CLASS_SSO();
        $this->mdl_admin_profile    = new MODEL_ADMIN_PROFILE(); //设置管理组模型

        if ($this->adminLogged['admin_type'] == 'super') {
            $this->is_super = true;
        }
    }


    function ctrl_mailbox() {
        if (isset($this->adminLogged['admin_allow_profile']['mailbox'])) {
            $_arr_tplData = array(
                'rcode' => 'x020109',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }


        $_arr_mailboxInput = $this->mdl_admin_profile->input_mailbox();
        if ($_arr_mailboxInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_mailboxInput);
        }

        $_arr_adminSubmit   = array(
            'user_pass'             => $_arr_mailboxInput['admin_pass'],
            'user_mail_new'         => $_arr_mailboxInput['admin_mail_new'],
        );

        $_arr_ssoRow = $this->obj_sso->sso_profile_mailbox($this->adminLogged['admin_id'], 'user_id', $_arr_adminSubmit);

        $this->obj_tpl->tplDisplay('result', $_arr_ssoRow);
    }


    /**
     * ajax_my function.
     *
     * @access public
     * @return void
     */
    function ctrl_info() {
        if (isset($this->adminLogged['admin_allow_profile']['info'])) {
            $_arr_tplData = array(
                'rcode' => 'x020108',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_adminProfile = $this->mdl_admin_profile->input_info();
        if ($_arr_adminProfile['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_adminProfile);
        }

        $_arr_adminSubmit   = array(
            'user_pass' => $_arr_adminProfile['admin_pass'],
            'user_nick' => $_arr_adminProfile['admin_nick'],
        );

        $_arr_ssoEdit   = $this->obj_sso->sso_profile_info($this->adminLogged['admin_id'], 'user_id', $_arr_adminSubmit);

        $_arr_adminRow  = $this->mdl_admin_profile->mdl_info($this->adminLogged['admin_id']);
        if ($_arr_adminRow['rcode'] == 'y020103' || $_arr_ssoEdit['rcode'] == 'y010103') {
            $_str_rcode = 'y020108';
        } else {
            $_str_rcode = $_arr_adminRow['rcode'];
        }

        $_arr_tplData = array(
            'rcode' => $_str_rcode,
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }


    function ctrl_qa() {
        if (isset($this->adminLogged['admin_allow_profile']['qa'])) {
            $_arr_tplData = array(
                'rcode' => 'x020109',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_qaInput = $this->mdl_admin_profile->input_qa();
        if ($_arr_qaInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_qaInput);
        }

        $_arr_adminSubmit   = array(
            'user_pass' => $_arr_qaInput['admin_pass'],
        );

        for ($_iii = 1; $_iii <= 3; $_iii++) {
            $_arr_adminSubmit['user_sec_ques_' . $_iii] = $_arr_qaInput['admin_sec_ques_' . $_iii];
            $_arr_adminSubmit['user_sec_answ_' . $_iii] = $_arr_qaInput['admin_sec_answ_' . $_iii];
        }

        $_arr_ssoRow = $this->obj_sso->sso_profile_qa($this->adminLogged['admin_id'], 'user_id', $_arr_adminSubmit);

        $this->obj_tpl->tplDisplay('result', $_arr_ssoRow);
    }


    function ctrl_pass() {
        if (isset($this->adminLogged['admin_allow_profile']['pass'])) {
            $_arr_tplData = array(
                'rcode' => 'x020109',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_adminPass = $this->mdl_admin_profile->input_pass();
        if ($_arr_adminPass['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_adminPass);
        }

        $_arr_adminSubmit   = array(
            'user_pass' => $_arr_adminPass['admin_pass'],
            'user_pass_new' => $_arr_adminPass['admin_pass_new'],
        );

        $_arr_ssoEdit = $this->obj_sso->sso_profile_pass($this->adminLogged['admin_id'], 'user_id', $_arr_adminSubmit);

        if ($_arr_ssoEdit['rcode'] == 'y010103') {
            $_str_rcode = 'y020109';
        } else {
            $_str_rcode = $_arr_ssoEdit['rcode'];
        }

        $_arr_tplData = array(
            'rcode' => $_str_rcode,
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }

}
