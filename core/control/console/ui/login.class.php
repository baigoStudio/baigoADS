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
class CONTROL_CONSOLE_UI_LOGIN {

    private $obj_base;
    private $config;
    private $obj_sso;
    private $obj_tpl;
    private $mdl_admin;


    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->chk_install();

        $this->adminLogged      = $this->general_console->ssin_begin();

        $this->obj_tpl          = $this->general_console->obj_tpl;

        $this->obj_sso          = new CLASS_SSO(); //SSO
        $this->mdl_admin        = new MODEL_ADMIN(); //设置管理员对象
    }


    /**
     * ctrl_login function.
     *
     * @access public
     * @return void
     */
    function ctrl_sync() {
        $_arr_adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($_arr_adminLogged);

        $_str_forward   = fn_getSafe(fn_get('forward'), 'txt', '');
        $_str_forward   = fn_forward($_str_forward, 'decode');

        if (fn_isEmpty($_str_forward)) {
            $_str_forward = BG_URL_CONSOLE . 'index.php';
        }

        $_arr_sync = array();

        if (defined('BG_SSO_SYNC') && BG_SSO_SYNC == 'on' && isset($_arr_adminLogged['admin_prefer']['sync']['sync']) && $_arr_adminLogged['admin_prefer']['sync']['sync'] == 'on') {
            $_arr_syncSubmit = array(
                'user_id'           => $_arr_adminLogged['admin_id'],
                'user_access_token' => $_arr_adminLogged['admin_access_token'],
            );
            $_arr_sync = $this->obj_sso->sso_sync_login($_arr_syncSubmit);
        }

        //print_r($_arr_sync);

        $_arr_tplData = array(
            'sync'       => $_arr_sync,
            'forward'    => $_str_forward,
        );

        $this->obj_tpl->tplDisplay('login_sync', $_arr_tplData);
    }


    /**
     * ctrl_login function.
     *
     * @access public
     * @return void
     */
    function ctrl_login() {
        $_str_forward   = fn_getSafe(fn_get('forward'), 'txt', '');
        $_str_jump      = BG_URL_CONSOLE . 'index.php?mod=login&act=sync&forward=' . $_str_forward;

        if ($this->adminLogged['rcode'] == 'y020102') {
            header('Location: ' . $_str_jump);
            exit;
        }

        $_arr_tplData = array(
            'jump'    => $_str_jump,
        );

        $this->obj_tpl->tplDisplay('login_form', $_arr_tplData);
    }


    /**
     * ctrl_logout function.
     *
     * @access public
     * @return void
     */
    function ctrl_logout() {
        $this->general_console->ssin_end();

        header('Location: ' . BG_URL_CONSOLE . 'index.php');
    }
}
