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
include_once(BG_PATH_CONTROL . "admin/ctl/posi.class.php"); //载入模板类

$ctl_posi = new CONTROL_POSI();

switch ($GLOBALS["act_get"]) {
	case "show":
		$arr_posiRow = $ctl_posi->ctl_show();
		if ($arr_posiRow["alert"] != "y040102") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_posiRow["alert"]);
			exit;
		}
	break;

	case "form":
		$arr_posiRow = $ctl_posi->ctl_form();
		if ($arr_posiRow["alert"] != "y040102") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_posiRow["alert"]);
			exit;
		}
	break;

	default:
		$arr_posiRow = $ctl_posi->ctl_list();
		if ($arr_posiRow["alert"] != "y040301") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_posiRow["alert"]);
			exit;
		}
	break;
}
