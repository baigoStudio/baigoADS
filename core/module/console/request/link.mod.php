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

$ctrl_link = new CONTROL_CONSOLE_REQUEST_LINK();

switch ($GLOBALS['method']) {
    case 'post':
        switch ($GLOBALS['route']['bg_act']) {
            case 'order':
                $ctrl_link->ctrl_order();
            break;

            case 'submit':
                $ctrl_link->ctrl_submit();
            break;

            case 'enable':
            case 'disable':
                $ctrl_link->ctrl_status();
            break;

            case 'del':
                $ctrl_link->ctrl_del();
            break;
        }
    break;
}
