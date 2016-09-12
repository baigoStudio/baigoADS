<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_FUNC . "init.func.php");
$arr_set = array(
    "base"          => true,
    "ssin"          => true,
    "header"        => "Content-type: application/json; charset=utf-8",
    "db"            => true,
    "type"          => "ajax",
    "ssin_begin"    => true,
);
fn_init($arr_set);

include_once(BG_PATH_CONTROL . "admin/ajax/admin.class.php"); //载入登录控制器

$ajax_admin = new AJAX_ADMIN();

switch ($GLOBALS["act_post"]) {
    case "toGroup":
        $ajax_admin->ajax_toGroup();
    break;

    case "submit":
        $ajax_admin->ajax_submit();
    break;

    case "auth":
        $ajax_admin->ajax_auth();
    break;

    case "enable":
    case "disable":
        $ajax_admin->ajax_status();
    break;

    case "del":
        $ajax_admin->ajax_del();
    break;

    default:
        switch ($GLOBALS["act_get"]) {
            case "chkname":
                $ajax_admin->ajax_chkname();
            break;

            case "chkauth":
                $ajax_admin->ajax_chkauth();
            break;

            case "chkmail":
                $ajax_admin->ajax_chkmail();
            break;
        }
    break;
}
