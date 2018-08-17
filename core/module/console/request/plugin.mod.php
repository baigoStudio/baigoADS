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

$ctrl_plugin = new CONTROL_CONSOLE_REQUEST_PLUGIN(); //初始化应用对象

switch ($GLOBALS['method']) {
    case 'post':
        switch ($GLOBALS['route']['bg_act']) {
            case 'opt':
                $ctrl_plugin->ctrl_opt(); //选项
            break;

            case 'submit':
                $ctrl_plugin->ctrl_submit(); //创建、编辑
            break;

            case 'enable':
            case 'disable':
                $ctrl_plugin->ctrl_status(); //状态
            break;

            case 'del':
                $ctrl_plugin->ctrl_del(); //删除
            break;
        }
    break;
}
