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
fn_include(true, true, "Content-type: application/json; charset=utf-8");

include_once(BG_PATH_CLASS . "mysqli.class.php"); //载入数据库类
include_once(BG_PATH_CONTROL . "install/ajax/upgrade.class.php"); //载入栏目控制器

$ajax_upgrade           = new AJAX_UPGRADE(); //初始化商家

switch ($GLOBALS["act_post"]) {
	case "dbconfig":
		$ajax_upgrade->ajax_dbconfig();
	break;

	case "over":
		$ajax_upgrade->ajax_over();
	break;
	case "sso":
	case "upload":
	case "base":
		$ajax_upgrade->ajax_submit();
	break;
}
