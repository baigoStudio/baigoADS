<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_FUNC . "init.func.php");
$arr_set = array(
    "header"        => "Content-Type: text/html; charset=utf-8",
    "db"            => true,
    "type"          => "ctl",
);
fn_init($arr_set);

include_once(BG_PATH_CONTROL . "advert/advert.class.php"); //载入应用控制器

$ctl_advert = new CONTROL_ADVERT(); //初始化应用

switch ($GLOBALS["act_get"]) {
    default:
        $arr_advertRow = $ctl_advert->ctl_url();

        if ($arr_advertRow["alert"] == "y080102") {
            header("Location: " . $arr_advertRow["advert_url"]);
        } else {
            header("Location: " . BG_URL_ADVERT . "ctl.php?mod=alert&act_get=show&alert=" . $arr_advertRow["alert"]);
        }
        exit;
    break;
}
