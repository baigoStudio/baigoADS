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

include_once(BG_PATH_CONTROL . "api/notice.class.php"); //载入文章类

$notice_notice = new NOTICE_NOTICE();

switch ($GLOBALS["act_post"]) {
	default:
		switch ($GLOBALS["act_get"]) {
			case "test":
				$notice_notice->notice_test();
			break;
		}
	break;
}