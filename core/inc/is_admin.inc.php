<?php
/*-----------------------------------------------------------------

！！！！警告！！！！
以下为系统文件，请勿修改

-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

if ($GLOBALS["adminLogged"]["alert"] != "y020102") {
    if ($GLOBALS["view"]) {
        $_str_location = "Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $GLOBALS["adminLogged"]["alert"] . "&view=" . $GLOBALS["view"];
    } else {
        if (fn_server("REQUEST_URI")) {
            $_str_forward = fn_forward(fn_server("REQUEST_URI"));
        } else {
            $_str_forward = fn_forward(BG_URL_ADMIN . "ctl.php");
        }
        $_str_location = "Location: " . BG_URL_ADMIN . "ctl.php?mod=logon&forward=" . $_str_forward;
    }
    header($_str_location);  //未登录就跳转至登录界面
    exit;
}
