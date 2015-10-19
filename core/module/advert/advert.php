<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "common_api.inc.php"); //验证是否已登录
include_once(BG_PATH_CONTROL . "advert/advert.class.php"); //载入应用控制器

$ctl_advert = new CONTROL_ADVERT(); //初始化应用

switch ($GLOBALS["act_get"]) {
	case "url":
		$ctl_advert->ctl_url();
	break;

	default:
		$ctl_advert->ctl_list();
	break;
}
