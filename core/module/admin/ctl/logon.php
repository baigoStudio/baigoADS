<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "include.func.php");
fn_include(true, true, "Content-Type: text/html; charset=utf-8", true, "ctl");

include_once(BG_PATH_INC . "is_install.inc.php"); //验证是否已登录
include_once(BG_PATH_FUNC . "session.func.php"); //载入 session 函数
include_once(BG_PATH_CONTROL . "admin/ctl/logon.class.php"); //载入登录控制器

$ctl_logon = new CONTROL_LOGON();

switch ($GLOBALS["act_post"]) {
	case "login":
		$arr_logonRow = $ctl_logon->ctl_login();

		if ($arr_logonRow["alert"] != "y020401") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=logon&forward=" . $arr_logonRow["forward"] . "&alert=" . $arr_logonRow["alert"] . $_url_attach);
		/*} else {
			header("Location: " . base64_decode($arr_logonRow["forward"]));*/
		}
		exit;
	break;

	default:
		switch ($GLOBALS["act_get"]) {
			case "logout":
				$arr_logonRow = $ctl_logon->ctl_logout();
				header("Location: " . base64_decode($arr_logonRow["forward"]));
				exit;
			break;

			default:
				$arr_logonRow = $ctl_logon->ctl_logon();
			break;
		}
	break;
}
