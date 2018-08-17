<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}


/*-------------文章类-------------*/
class CONTROL_API_SSO_SYNC {

    function __construct() { //构造函数
        $this->general_api      = new GENERAL_API();
        $this->obj_sso          = new CLASS_SSO();
        $this->obj_sign         = new CLASS_SIGN();

        $this->general_console  = new GENERAL_CONSOLE();

        $this->arr_data = array(
            'app_id'    => BG_SSO_APPID, //APP ID
            'app_key'   => BG_SSO_APPKEY, //APP KEY
        );
    }


    /**
     * ctrl_list function.
     *
     * @access public
     * @return void
     */
    function ctrl_login() {
        $_arr_notifyInput = $this->general_api->notify_input('get');

        if ($_arr_notifyInput['rcode'] != 'ok') {
            $this->general_api->show_result($_arr_notifyInput);
        }

        $_arr_notifyInput['code'] = urldecode($_arr_notifyInput['code']);

        unset($_arr_notifyInput['rcode']);

        $_tm_diff = $_arr_notifyInput['time'] - time();

        if ($_tm_diff > 1800 || $_tm_diff < -1800) {
            $_arr_return = array(
                'rcode'     => 'x220213',
            );
            $this->general_api->show_result($_arr_return);
        }

        $_arr_decode  = $this->obj_sso->sso_decode($_arr_notifyInput['code'], $_arr_notifyInput['sign']);
        if ($_arr_decode['rcode'] != 'y010102') {
            $this->general_api->show_result($_arr_decode);
        }

        $_arr_appChk    = $this->general_api->app_chk_sso($_arr_decode['app_id'], $_arr_decode['app_key']);
        if ($_arr_appChk['rcode'] != 'ok') {
            $this->general_api->show_result($_arr_appChk);
        }

        $this->general_console->ssin_login($_arr_decode['user_id'], $_arr_decode['user_access_token'], $_arr_decode['user_access_expire'], $_arr_decode['user_refresh_token'], $_arr_decode['user_refresh_expire']);

        $_arr_return = array(
            'rcode' => 'y020405',
        );
        $this->general_api->show_result($_arr_return, false, 'jsonp');
    }


    function ctrl_logout() {
        $_arr_notifyInput = $this->general_api->notify_input('get');
        if ($_arr_notifyInput['rcode'] != 'ok') {
            $this->general_api->show_result($_arr_notifyInput);
        }

        $_arr_notifyInput['code'] = urldecode($_arr_notifyInput['code']);

        unset($_arr_notifyInput['rcode']);

        $_tm_diff = $_arr_notifyInput['time'] - time();

        if ($_tm_diff > 1800 || $_tm_diff < -1800) {
            $_arr_return = array(
                'rcode'     => 'x220213',
            );
            $this->general_api->show_result($_arr_return);
        }

        $_arr_decode  = $this->obj_sso->sso_decode($_arr_notifyInput['code'], $_arr_notifyInput['sign']);
        if ($_arr_decode['rcode'] != 'y010102') {
            $this->general_api->show_result($_arr_decode);
        }

        $_arr_appChk    = $this->general_api->app_chk_sso($_arr_decode['app_id'], $_arr_decode['app_key']);
        if ($_arr_appChk['rcode'] != 'ok') {
            $this->general_api->show_result($_arr_appChk);
        }

        $this->general_api->ssin_end();

        $_arr_return = array(
            'rcode' => 'y020406',
        );
        $this->general_api->show_result($_arr_return, false, 'jsonp');
    }
}
