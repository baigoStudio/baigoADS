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
    'db'            => true,
);
$obj_runtime->run($arr_set);

$ctrl_advert = new CONTROL_API_API_ADVERT(); //初始化应用

switch ($GLOBALS['route']['bg_act']) {
    default:
        $ctrl_advert->ctrl_list();
    break;
}
