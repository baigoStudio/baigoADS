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

$ctrl_posi = new CONTROL_CONSOLE_REQUEST_POSI();

switch ($GLOBALS['method']) {
    case 'post':
        switch ($GLOBALS['route']['bg_act']) {
            case 'cache':
                $ctrl_posi->ctrl_cache();
            break;

            case 'submit':
                $ctrl_posi->ctrl_submit();
            break;

            case 'enable':
            case 'disable':
                $ctrl_posi->ctrl_status();
            break;

            case 'del':
                $ctrl_posi->ctrl_del();
            break;
        }
    break;

    default:
        switch ($GLOBALS['route']['bg_act']) {
            case 'chkname':
                $ctrl_posi->ctrl_chkname();
            break;
        }
    break;
}
