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
class CONTROL_CONSOLE_REQUEST_FORGOT {

    function __construct() { //构造函数
        $this->general_console          = new GENERAL_CONSOLE();
        $this->general_console->dspType = 'result';
        $this->general_console->chk_install();

        $this->obj_tpl              = $this->general_console->obj_tpl;

        $this->obj_sso              = new CLASS_SSO(); //SSO
        $this->mdl_admin_forgot     = new MODEL_ADMIN_FORGOT(); //设置管理员对象
    }


    /**
     * ctrl_login function.
     *
     * @access public
     * @return void
     */
    function ctrl_bymail() {
        $_arr_bymailInput = $this->mdl_admin_forgot->input_bymail();
        if ($_arr_bymailInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_bymailInput);
        }

        $_arr_returnRow = $this->obj_sso->sso_forgot_bymail($_arr_bymailInput['admin_name']); //sso验证

        $this->obj_tpl->tplDisplay('result', $_arr_returnRow);
    }


    function ctrl_byqa() {
        $_arr_byqaInput = $this->mdl_admin_forgot->input_byqa();
        if ($_arr_byqaInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_byqaInput);
        }

        $_arr_byqaSubmit = array(
            'user_name'         => $_arr_byqaInput['admin_name'],
            'user_pass_new'     => $_arr_byqaInput['admin_pass_new'],
            'user_pass_confirm' => $_arr_byqaInput['admin_pass_confirm'],
        );

        for ($_iii = 1; $_iii <= 3; $_iii++) {
            $_arr_byqaSubmit['user_sec_answ_' . $_iii] = $_arr_byqaInput['admin_sec_answ_' . $_iii];
        }
        $_arr_returnRow = $this->obj_sso->sso_forgot_byqa($_arr_byqaSubmit); //sso验证

        $this->obj_tpl->tplDisplay('result', $_arr_returnRow);
    }
}
