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

$ctrl_forgot = new CONTROL_CONSOLE_REQUEST_FORGOT();

switch ($GLOBALS['method']) {
    case 'post':
        switch ($GLOBALS['route']['bg_act']) {
            case 'bymail':
                $ctrl_forgot->ctrl_bymail();
            break;

            case 'byqa':
                $ctrl_forgot->ctrl_byqa();
            break;
        }
    break;
}
