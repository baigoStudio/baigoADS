<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}


switch ($GLOBALS['route']['bg_act']) {
    case 'dbconfig': //数据库配置时
        $arr_set = array(
            'base'          => true, //基本设置
            'ssin'          => true, //启用会话
            'ssin_file'     => true, //由于安装时，session 数据表表尚未创建，故临时采用文件形式的 session
            'is_install'    => true,
        );
    break;

    default:
        $arr_set = array(
            'base'          => true, //基本设置
            'ssin'          => true, //启用会话
            'db'            => true, //连接数据库
            'is_install'    => true,
        );
    break;
}
$obj_runtime->run($arr_set);

$ctrl_setup = new CONTROL_INSTALL_REQUEST_SETUP(); //初始化商家

switch ($GLOBALS['method']) {
    case 'post':
        switch ($GLOBALS['route']['bg_act']) {
            case 'dbconfig':
                $ctrl_setup->ctrl_dbconfig();
            break;

            case 'auth':
                $ctrl_setup->ctrl_auth();
            break;

            case 'admin':
                $ctrl_setup->ctrl_admin();
            break;

            case 'ssoAuto':
                $ctrl_setup->ctrl_ssoAuto();
            break;

            case 'ssoAdmin':
                $ctrl_setup->ctrl_ssoAdmin();
            break;

            case 'over':
                $ctrl_setup->ctrl_over();
            break;

            case 'base':
            case 'upload':
            case 'sso':
                $ctrl_setup->ctrl_submit();
            break;
        }
    break;

    default:
        switch ($GLOBALS['route']['bg_act']) {
            case 'chkname':
                $ctrl_setup->ctrl_chkname();
            break;

            case 'chkauth':
                $ctrl_setup->ctrl_chkauth();
            break;
        }
    break;
}
