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
fn_include(true, true, "Content-type: application/json; charset=utf-8", true, "ajax");

include_once(BG_PATH_FUNC . "session.func.php"); //载入 session 函数
include_once(BG_PATH_CONTROL . "api/sync.class.php"); //载入文章类

$notice_sync = new NOTICE_SYNC();

switch ($GLOBALS["act_post"]) {
	case "login":
		$notice_sync->notice_login();
	break;

	case "logout":
		$notice_sync->notice_logout();
	break;
}
