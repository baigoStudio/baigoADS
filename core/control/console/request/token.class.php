<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}


class CONTROL_CONSOLE_REQUEST_TOKEN {

    function __construct() { //构造函数
        $this->general_console          = new GENERAL_CONSOLE();
        $this->general_console->dspType = 'result';
        $this->general_console->chk_install();

        $this->adminLogged          = $this->general_console->ssin_begin();
        //$this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl              = $this->general_console->obj_tpl;

        $this->obj_sso              = new CLASS_SSO(); //获取界面类型
        $this->mdl_admin_profile    = new MODEL_ADMIN_PROFILE(); //SSO
    }


    /**
     * ajax_check function.
     *
     * @access public
     * @return void
     */
    function ctrl_make() {
        $_num_pmCount = '';
        if ($this->adminLogged['rcode'] == 'y020102') {
            //$_str_token  = fn_token(); //生成令牌
            if ($this->adminLogged['admin_access_expire'] <= time() - 60 && $this->adminLogged['admin_refresh_expire'] > time()) { //过期时间小于1分钟，则刷新口令
                $this->token_process();
            }

            $_arr_pmCount   = $this->obj_sso->sso_pm_check($this->adminLogged['admin_id'], 'user_id', $this->adminLogged['admin_access_token']);
            if ($_arr_pmCount['rcode'] == 'y110402') {
                $_num_pmCount = $_arr_pmCount['pm_count'];
            } else {
                $this->token_process();
            }

            $_str_rcode  = 'y020102';
            $_str_msg    = 'ok';
        } else { //未登录，抛出错误信息
            //$_str_token  = 'none';
            $_str_rcode  = 'x020404';
            $_str_msg    = $this->obj_tpl->lang['rcode']['x020404'];
        }

        $arr_re = array(
            'pm_count'  => $_num_pmCount,
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );

        $this->obj_tpl->tplDisplay('result', $arr_re);
    }


    private function token_process() {
        $_arr_userRefresh = $this->obj_sso->sso_profile_token($this->adminLogged['admin_id'], 'user_id', $this->adminLogged['admin_refresh_token']); //过期时间小于1分钟，则刷新口令

        if ($_arr_userRefresh['rcode'] == 'y010411') { //刷新成功则更新数据库
            $this->mdl_admin_profile->mdl_refresh($this->adminLogged['admin_id'], $_arr_userRefresh['user_access_token'], $_arr_userRefresh['user_access_expire']);

            $this->adminLogged['admin_access_token'] = $_arr_userRefresh['user_access_token']; //用新口令检查短信
        }
    }
}
