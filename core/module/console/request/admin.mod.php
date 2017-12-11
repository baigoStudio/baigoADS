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

$ctrl_admin = new CONTROL_CONSOLE_REQUEST_ADMIN(); //初始化应用对象

switch ($GLOBALS['method']) {
    case 'post':
        switch ($GLOBALS['route']['bg_act']) {
            case 'toGroup':
                $ctrl_admin->ctrl_toGroup();
            break;

            case 'submit':
                $ctrl_admin->ctrl_submit();
            break;

            case 'auth':
                $ctrl_admin->ctrl_auth();
            break;

            case 'enable':
            case 'disable':
                $ctrl_admin->ctrl_status();
            break;

            case 'del':
                $ctrl_admin->ctrl_del();
            break;
        }
    break;

    default:
        switch ($GLOBALS['route']['bg_act']) {
            case 'chkname':
                $ctrl_admin->ctrl_chkname();
            break;

            case 'chkauth':
                $ctrl_admin->ctrl_chkauth();
            break;

            case 'chkmail':
                $ctrl_admin->ctrl_chkmail();
            break;
        }
    break;
}
