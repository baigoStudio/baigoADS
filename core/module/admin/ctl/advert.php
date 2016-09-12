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
    "header"        => "Content-Type: text/html; charset=utf-8",
    "db"            => true,
    "type"          => "ctl",
    "ssin_begin"    => true,
);
fn_init($arr_set);

include_once(BG_PATH_INC . "is_install.inc.php"); //验证是否已登录
include_once(BG_PATH_INC . "is_admin.inc.php"); //验证是否已登录
include_once(BG_PATH_CONTROL . "admin/ctl/advert.class.php"); //载入应用控制器

$ctl_advert = new CONTROL_ADVERT(); //初始化应用

switch ($GLOBALS["act_get"]) {
    case "show": //显示
        $arr_advertRow = $ctl_advert->ctl_show();
        if ($arr_advertRow["alert"] != "y080102") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_advertRow["alert"]);
            exit;
        }
    break;

    case "form": //创建、编辑表单
        $arr_advertRow = $ctl_advert->ctl_form();
        if ($arr_advertRow["alert"] != "y080102") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_advertRow["alert"]);
            exit;
        }
    break;

    default: //列出
        $arr_advertRow = $ctl_advert->ctl_list();
        if ($arr_advertRow["alert"] != "y080302") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_advertRow["alert"]);
            exit;
        }
    break;
}
