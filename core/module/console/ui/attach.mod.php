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

$ctrl_attach = new CONTROL_CONSOLE_UI_ATTACH(); //初始化设置对象

switch ($GLOBALS['route']['bg_act']) {
    case 'form':
        $ctrl_attach->ctrl_form();
    break;

    default:
        $ctrl_attach->ctrl_list();
    break;
}
