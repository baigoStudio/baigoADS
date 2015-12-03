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

include_once(BG_PATH_CONTROL . "api/advert.class.php"); //载入应用控制器

$api_advert = new API_ADVERT(); //初始化应用

switch ($GLOBALS["act_get"]) {
	default:
		$api_advert->api_list();
	break;
}
