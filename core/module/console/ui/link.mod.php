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

$ctrl_link = new CONTROL_CONSOLE_UI_LINK(); //初始化设置对象

switch ($GLOBALS['route']['bg_act']) {
    case 'order':
        $ctrl_link->ctrl_order();
    break;

    case 'form':
        $ctrl_link->ctrl_form();
    break;

    default:
        $ctrl_link->ctrl_list();
    break;
}
