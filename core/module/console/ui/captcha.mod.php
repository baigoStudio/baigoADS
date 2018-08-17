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
    'ssin'          => true,
    'db'            => true,
);
$obj_runtime->run($arr_set);

$ctrl_captcha = new CONTROL_CONSOLE_UI_CAPTCHA(); //初始化验证对象

switch ($GLOBALS['route']['bg_act']) {
    case 'make':
        $ctrl_captcha->ctrl_make(); //生成验证码
    break;
}
