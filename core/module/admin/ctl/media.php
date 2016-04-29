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
include_once(BG_PATH_CONTROL . "admin/ctl/media.class.php"); //载入模板类

$ctl_media = new CONTROL_MEDIA(); //初始化设置对象

switch ($GLOBALS["act_get"]) {
    case "form":
        $arr_mediaRow = $ctl_media->ctl_form();
        if ($arr_mediaRow["alert"] != "y070302") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_mediaRow["alert"] . $_url_media);
            exit;
        }
    break;

    default:
        $arr_mediaRow = $ctl_media->ctl_list();
        if ($arr_mediaRow["alert"] != "y070301") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_mediaRow["alert"] . $_url_media);
            exit;
        }
    break;
}
