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
class CONTROL_CONSOLE_REQUEST_LOGIN {

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->dspType = 'result';
        $this->general_console->chk_install();

        $this->obj_tpl      = $this->general_console->obj_tpl;

        $this->obj_sso    = new CLASS_SSO(); //SSO
        $this->mdl_admin  = new MODEL_ADMIN(); //设置管理员对象
    }


    /**
     * ctrl_login function.
     *
     * @access public
     * @return void
     */
    function ctrl_login() {
        $_arr_consoleLogin = $this->mdl_admin->input_login();
        if ($_arr_consoleLogin['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_consoleLogin);
        }

        $_arr_ssoLogin = $this->obj_sso->sso_user_login($_arr_consoleLogin['admin_name'], $_arr_consoleLogin['admin_pass']); //sso验证
        if ($_arr_ssoLogin['rcode'] != 'y010401') {
            $this->obj_tpl->tplDisplay('result', $_arr_ssoLogin);
        }

        $_arr_ssin = $this->general_console->ssin_login($_arr_ssoLogin['user_id'], $_arr_ssoLogin['user_access_token'], $_arr_ssoLogin['user_access_expire'], $_arr_ssoLogin['user_refresh_token'], $_arr_ssoLogin['user_refresh_expire']);
        if ($_arr_ssin['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_ssin);
        }

        $_arr_tplData = array(
            'rcode' => 'y020401',
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }
}
