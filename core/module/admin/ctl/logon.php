<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

if (isset($_GET["ssid"])) {
	session_id($_GET["ssid"]); //将当前的SessionId设置成客户端传递回来的SessionId
}

session_start(); //开启session
$GLOBALS["ssid"] = session_id();

include_once(BG_PATH_INC . "is_install.inc.php"); //验证是否已登录
include_once(BG_PATH_INC . "common_global.inc.php"); //载入通用
include_once(BG_PATH_FUNC . "session.func.php"); //载入商家控制器
include_once(BG_PATH_CLASS . "mysqli.class.php"); //载入数据库类
include_once(BG_PATH_CLASS . "base.class.php"); //载入基类
include_once(BG_PATH_CONTROL . "admin/ctl/logon.class.php"); //载入登录控制器

if (!defined("BG_DB_PORT")) {
	define("BG_DB_PORT", "3306");
}

$_cfg_host = array(
	"host"      => BG_DB_HOST,
	"name"      => BG_DB_NAME,
	"user"      => BG_DB_USER,
	"pass"      => BG_DB_PASS,
	"charset"   => BG_DB_CHARSET,
	"debug"     => BG_DEBUG_DB,
	"port"      => BG_DB_PORT,
);

$GLOBALS["obj_db"]      = new CLASS_MYSQLI($_cfg_host); //设置数据库对象

if (!$GLOBALS["obj_db"]->connect()) {
	header("Location: " . BG_URL_ROOT . "db_conn_err.html");
	exit;
}

if (!$GLOBALS["obj_db"]->select_db()) {
	header("Location: " . BG_URL_ROOT . "db_select_err.html");
	exit;
}

$GLOBALS["obj_base"]    = new CLASS_BASE(); //初始化基类
$ctl_logon              = new CONTROL_LOGON();

header("Content-Type: text/html; charset=utf-8");

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
