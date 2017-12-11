<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}


$arr_set = array(
    'base'          => true,
    'ssin'          => true,
    'db'            => true,
);
$obj_runtime->run($arr_set);

$ctrl_token = new CONTROL_CONSOLE_REQUEST_TOKEN();

switch ($GLOBALS['route']['bg_act']) {
    case 'make':
        $ctrl_token->ctrl_make(); //滚动令牌
    break;
}
