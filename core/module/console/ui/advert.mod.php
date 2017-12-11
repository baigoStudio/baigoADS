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

$ctrl_advert = new CONTROL_CONSOLE_UI_ADVERT(); //初始化应用

switch ($GLOBALS['route']['bg_act']) {
    case 'show': //显示
        $ctrl_advert->ctrl_show();
    break;

    case 'form': //创建、编辑表单
        $ctrl_advert->ctrl_form();
    break;

    default: //列出
        $ctrl_advert->ctrl_list();
    break;
}
