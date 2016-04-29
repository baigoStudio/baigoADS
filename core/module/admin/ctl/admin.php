<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_FUNC . "init.func.php");
$arr_set = array(
    "base"          => true,
    "ssin"          => true,
    "header"        => "Content-Type: text/html; charset=utf-8",
    "db"            => true,
    "type"          => "ctl",
    "ssin_begin"    => true,
);
fn_init($arr_set);

include_once(BG_PATH_INC . "is_install.inc.php"); //验证是否已登录
include_once(BG_PATH_INC . "is_admin.inc.php"); //载入后台通用
include_once(BG_PATH_CONTROL . "admin/ctl/admin.class.php"); //载入用户类

$ctl_admin = new CONTROL_ADMIN();

switch ($GLOBALS["act_get"]) {
    case "toGroup":
        $arr_adminRow = $ctl_admin->ctl_toGroup();
        if ($arr_adminRow["alert"] != "y020302") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_adminRow["alert"] . $_url_attach);
            exit;
        }
    break;

    case "form":
        $arr_adminRow = $ctl_admin->ctl_form();
        if ($arr_adminRow["alert"] != "y020302") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_adminRow["alert"]);
            exit;
        }
    break;

    case "show":
        $arr_adminRow = $ctl_admin->ctl_show();
        if ($arr_adminRow["alert"] != "y020302") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_adminRow["alert"]);
            exit;
        }
    break;

    case "auth":
        $arr_adminRow = $ctl_admin->ctl_auth();
        if ($arr_adminRow["alert"] != "y020302") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_adminRow["alert"]);
            exit;
        }
    break;

    default:
        $arr_adminRow = $ctl_admin->ctl_list();
        if ($arr_adminRow["alert"] != "y020301") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_adminRow["alert"]);
            exit;
        }
    break;
}
