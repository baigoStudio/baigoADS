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
    "header"        => "Content-type: application/json; charset=utf-8",
    "db"            => true,
    "type"          => "ajax",
    "ssin_begin"    => true,
);
fn_init($arr_set);

include_once(BG_PATH_CONTROL . "admin/ajax/posi.class.php"); //载入模板类

$ajax_posi = new AJAX_POSI();

switch ($GLOBALS["act_post"]) {
    case "cache":
        $ajax_posi->ajax_cache();
    break;

    case "submit":
        $ajax_posi->ajax_submit();
    break;

    case "enable":
    case "disable":
        $ajax_posi->ajax_status();
    break;

    case "del":
        $ajax_posi->ajax_del();
    break;

    default:
        switch ($GLOBALS["act_get"]) {
            case "chkname":
                $ajax_posi->ajax_chkname();
            break;
        }
    break;
}
