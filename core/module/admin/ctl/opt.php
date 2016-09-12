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
include_once(BG_PATH_CONTROL . "admin/ctl/opt.class.php"); //载入设置控制器

$ctl_opt = new CONTROL_OPT(); //初始化设置对象

switch ($GLOBALS["act_get"]) {
    case "chkver":
        $arr_optRow = $ctl_opt->ctl_chkver(); //数据库
        if ($arr_optRow["alert"] != "y060301") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_optRow["alert"]);
            exit;
        }
    break;

    case "dbconfig":
        $arr_optRow = $ctl_opt->ctl_dbconfig();
        if ($arr_optRow["alert"] != "y060301") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_optRow["alert"]);
            exit;
        }
    break;

    default:
        $arr_optRow = $ctl_opt->ctl_form();
        if ($arr_optRow["alert"] != "y060301") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_optRow["alert"]);
            exit;
        }
    break;
}
