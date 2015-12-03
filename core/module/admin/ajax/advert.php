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

include_once(BG_PATH_CONTROL . "admin/ajax/advert.class.php"); //载入应用 ajax 控制器

$ajax_advert = new AJAX_ADVERT(); //初始化应用对象

switch ($GLOBALS["act_post"]) {
	case "submit":
		$ajax_advert->ajax_submit(); //创建、编辑
	break;

	case "enable":
	case "disable":
		$ajax_advert->ajax_status(); //状态
	break;

	case "del":
		$ajax_advert->ajax_del(); //删除
	break;
}
