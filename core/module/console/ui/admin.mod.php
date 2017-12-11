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

$ctrl_admin = new CONTROL_CONSOLE_UI_ADMIN();

switch ($GLOBALS['route']['bg_act']) {
    case 'form':
        $ctrl_admin->ctrl_form();
    break;

    case 'show':
        $ctrl_admin->ctrl_show();
    break;

    case 'auth':
        $ctrl_admin->ctrl_auth();
    break;

    default:
        $ctrl_admin->ctrl_list();
    break;
}
