<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "common_admin_ctl.inc.php"); //载入全局通用
include_once(BG_PATH_INC . "is_install.inc.php"); //验证是否已登录
include_once(BG_PATH_INC . "is_admin.inc.php"); //载入后台通用
include_once(BG_PATH_CONTROL . "admin/ctl/stat.class.php"); //载入模板类

$ctl_stat = new CONTROL_STAT();

switch ($GLOBALS["act_get"]) {
	case "posi":
		$arr_statRow = $ctl_stat->ctl_posi();
		if ($arr_statRow["alert"] != "y040305") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_statRow["alert"]);
			exit;
		}
	break;

	default:
		$arr_statRow = $ctl_stat->ctl_advert();
		if ($arr_statRow["alert"] != "y080305") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_statRow["alert"]);
			exit;
		}
	break;
}
