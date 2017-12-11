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

$ctrl_profile = new CONTROL_CONSOLE_UI_PROFILE(); //初始化个人资料

switch ($GLOBALS['route']['bg_act']) {
    case 'mailbox':
        $ctrl_profile->ctrl_mailbox();
    break;

    case 'qa':
        $ctrl_profile->ctrl_qa();
    break;

    case 'prefer':
        $ctrl_profile->ctrl_prefer();
    break;

    case 'pass': //修改密码
        $ctrl_profile->ctrl_pass();
    break;

    default: //修改个人资料
        $ctrl_profile->ctrl_info();
    break;
}
