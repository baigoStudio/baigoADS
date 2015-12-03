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
fn_include(true, true, "Content-type: application/json; charset=utf-8", true, "ajax", true);

include_once(BG_PATH_CONTROL . "admin/ajax/media.class.php"); //载入登录控制器

$ajax_media = new AJAX_MEDIA();

switch ($GLOBALS["act_post"]) {
	case "normal":
	case "recycle":
		$ajax_media->ajax_box();
	break;

	case "gen":
		$ajax_media->ajax_gen();
	break;

	case "empty":
		$ajax_media->ajax_empty();
	break;

	case "clear":
		$ajax_media->ajax_clear();
	break;

	case "submit":
		$ajax_media->ajax_submit();
	break;

	case "del":
		$ajax_media->ajax_del();
	break;

	default:
		switch ($GLOBALS["act_get"]) {
			case "list":
				$ajax_media->ajax_list();
			break;
		}
	break;
}
