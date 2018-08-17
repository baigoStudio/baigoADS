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

$ctrl_plugin = new CONTROL_CONSOLE_UI_PLUGIN(); //初始化插件

switch ($GLOBALS['route']['bg_act']) {
    case 'opt': //选项
        $ctrl_plugin->ctrl_opt();
    break;

    case 'show': //显示
        $ctrl_plugin->ctrl_show();
    break;

    case 'form': //安装
        $ctrl_plugin->ctrl_form();
    break;

    default: //列出
        $ctrl_plugin->ctrl_list();
    break;
}
