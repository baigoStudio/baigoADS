<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_FUNC . "init.func.php");
$arr_set = array(
    "base"          => true,
    "ssin"          => true,
    "header"        => "Content-type: application/json; charset=utf-8",
    "db"            => true,
    "type"          => "ajax",
);
fn_init($arr_set);

include_once(BG_PATH_FUNC . "session.func.php"); //载入 session 函数
include_once(BG_PATH_CONTROL . "api/sync.class.php"); //载入文章类

$api_sync = new API_SYNC();

switch ($GLOBALS["act_get"]) {
    case "login":
        $api_sync->api_login();
    break;

    case "logout":
        $api_sync->api_logout();
    break;
}
