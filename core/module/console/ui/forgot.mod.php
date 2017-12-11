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

$ctrl_forgot = new CONTROL_CONSOLE_UI_FORGOT();

switch ($GLOBALS['route']['bg_act']) {
    case 'step_2':
        $ctrl_forgot->ctrl_step_2(); //登出
    break;

    default:
        $ctrl_forgot->ctrl_step_1(); //登出
    break;
}
