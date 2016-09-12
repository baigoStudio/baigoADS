<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_CLASS . "tpl.class.php"); //载入模板类

/*-------------管理员控制器-------------*/
class CONTROL_ALERT {

    private $obj_tpl;

    function __construct() { //构造函数
        $this->obj_base   = $GLOBALS["obj_base"]; //获取界面类型
        $this->config     = $this->obj_base->config;
        $this->obj_tpl    = new CLASS_TPL(BG_PATH_TPL . "advert/" . BG_DEFAULT_UI);
    }


    function ctl_show() {
        $_str_alert   = fn_getSafe(fn_get("alert"), "txt", "");
        //$_str_view    = fn_getSafe(fn_get("view"), "txt", "");

        $arr_data = array(
            "alert"          => $_str_alert,
            "status"         => substr($_str_alert, 0, 1),
        );

        $this->obj_tpl->tplDisplay("alert.tpl", $arr_data);
    }
}
