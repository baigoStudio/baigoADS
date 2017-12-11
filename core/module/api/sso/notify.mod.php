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
    'db'            => true,
);
$obj_runtime->run($arr_set);

$ctrl_notify = new CONTROL_API_SSO_NOTIFY();

switch ($GLOBALS['method']) {
    case 'post':
        switch ($GLOBALS['route']['bg_act']) {
            case 'test':
                $ctrl_notify->ctrl_test();
            break;
        }
    break;
}