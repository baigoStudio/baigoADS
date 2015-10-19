<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "common_admin_ctl.inc.php"); //管理员通用
include_once(BG_PATH_INC . "is_install.inc.php"); //验证是否已登录
include_once(BG_PATH_INC . "is_admin.inc.php"); //验证是否已登录
include_once(BG_PATH_CONTROL . "admin/ctl/opt.class.php"); //载入设置控制器

$ctl_opt = new CONTROL_OPT(); //初始化设置对象

switch ($GLOBALS["act_get"]) {
	case "upload": //注册
		$arr_optRow = $ctl_opt->ctl_upload();
		if ($arr_optRow["alert"] != "y060302") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_optRow["alert"]);
			exit;
		}
	break;

	case "sso": //注册
		$arr_optRow = $ctl_opt->ctl_sso();
		if ($arr_optRow["alert"] != "y060303") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_optRow["alert"]);
			exit;
		}
	break;

	case "db": //数据库
		$arr_optRow = $ctl_opt->ctl_db();
		if ($arr_optRow["alert"] != "y060306") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_optRow["alert"]);
			exit;
		}
	break;

	default: //基本
		$arr_optRow = $ctl_opt->ctl_base();
		if ($arr_optRow["alert"] != "y060301") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_optRow["alert"]);
			exit;
		}
	break;
}
