<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_FUNC . "http.func.php"); //载入 http
include_once(BG_PATH_CLASS . "notify.class.php");
include_once(BG_PATH_CLASS . "sso.class.php");

/*-------------文章类-------------*/
class API_SYNC {

    function __construct() { //构造函数
        $this->obj_notify = new CLASS_NOTIFY();
        $this->obj_notify->chk_install();
        $this->obj_sso    = new CLASS_SSO();
        $this->arr_data = array(
            "app_id"    => BG_SSO_APPID, //APP ID
            "app_key"   => BG_SSO_APPKEY, //APP KEY
        );
    }


    /**
     * api_list function.
     *
     * @access public
     * @return void
     */
    function api_login() {
        $_arr_notifyInput = $this->obj_notify->notify_input("get");
        if ($_arr_notifyInput["alert"] != "ok") {
            $this->obj_notify->halt_re($_arr_notifyInput);
        }

        $_arr_notifyInput["code"] = fn_htmlcode($_arr_notifyInput["code"], "decode", "crypt");

        $_arr_signature = $this->obj_sso->sso_verify(array_merge($this->arr_data, $_arr_notifyInput), $_arr_notifyInput["signature"]);
        if ($_arr_signature["alert"] != "y050403") {
            $this->obj_notify->halt_re($_arr_signature);
        }

        $_tm_diff = $_arr_notifyInput["time"] - time();

        if ($_tm_diff > 1800 || $_tm_diff < -1800) {
            $_arr_return = array(
                "alert"     => "x220213",
            );
            $this->obj_notify->halt_re($_arr_return);
        }

        $_arr_decode  = $this->obj_sso->sso_decode($_arr_notifyInput["code"]);

        $_arr_appChk    = $this->obj_notify->app_chk($_arr_decode["app_id"], $_arr_decode["app_key"]);
        if ($_arr_appChk["alert"] != "ok") {
            $this->obj_notify->halt_re($_arr_appChk);
        }

        fn_ssin_login($_arr_decode["user_id"]);

        $_arr_return = array(
            "alert" => "y020405",
        );
        $this->obj_notify->halt_re($_arr_return, false, true);
    }


    function api_logout() {
        $_arr_notifyInput = $this->obj_notify->notify_input("get");
        if ($_arr_notifyInput["alert"] != "ok") {
            $this->obj_notify->halt_re($_arr_notifyInput);
        }

        $_arr_notifyInput["code"] = fn_htmlcode($_arr_notifyInput["code"], "decode", "crypt");

        $_arr_signature = $this->obj_sso->sso_verify(array_merge($this->arr_data, $_arr_notifyInput), $_arr_notifyInput["signature"]);
        if ($_arr_signature["alert"] != "y050403") {
            $this->obj_notify->halt_re($_arr_signature);
        }

        $_tm_diff = $_arr_notifyInput["time"] - time();

        if ($_tm_diff > 1800 || $_tm_diff < -1800) {
            $_arr_return = array(
                "alert"     => "x220213",
            );
            $this->obj_notify->halt_re($_arr_return);
        }

        $_arr_decode  = $this->obj_sso->sso_decode($_arr_notifyInput["code"]);

        $_arr_appChk    = $this->obj_notify->app_chk($_arr_decode["app_id"], $_arr_decode["app_key"]);
        if ($_arr_appChk["alert"] != "ok") {
            $this->obj_notify->halt_re($_arr_appChk);
        }

        fn_ssin_end();

        $_arr_return = array(
            "alert" => "y020406",
        );
        $this->obj_notify->halt_re($_arr_return, false, true);
    }
}
