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

$ctrl_pm = new CONTROL_CONSOLE_REQUEST_PM();

switch ($GLOBALS['method']) {
    case 'post':
        switch ($GLOBALS['route']['bg_act']) {
            case 'revoke':
                $ctrl_pm->ctrl_revoke();
            break;

            case 'send':
                $ctrl_pm->ctrl_send();
            break;

            case 'read':
            case 'wait':
                $ctrl_pm->ctrl_status();
            break;

            case 'del':
                $ctrl_pm->ctrl_del();
            break;
        }
    break;
}
