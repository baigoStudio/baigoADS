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

$ctrl_media = new CONTROL_CONSOLE_REQUEST_MEDIA();

switch ($GLOBALS['method']) {
    case 'post':
        switch ($GLOBALS['route']['bg_act']) {
            case 'normal':
            case 'recycle':
                $ctrl_media->ctrl_box();
            break;

            case 'gen':
                $ctrl_media->ctrl_gen();
            break;

            case 'empty':
                $ctrl_media->ctrl_empty();
            break;

            case 'clear':
                $ctrl_media->ctrl_clear();
            break;

            case 'submit':
                $ctrl_media->ctrl_submit();
            break;

            case 'del':
                $ctrl_media->ctrl_del();
            break;
        }
    break;

    default:
        switch ($GLOBALS['route']['bg_act']) {
            case 'list':
                $ctrl_media->ctrl_list();
            break;
        }
    break;
}
