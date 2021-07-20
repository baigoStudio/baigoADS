<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Admin as Admin_Base;
use ginkgo\Config;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------应用模型-------------*/
class Sso_Sync extends Admin_Base {

    protected $table = 'admin';

    function inputSync($arr_data) {
        $_arr_configSso = Config::get('sso', 'var_extra');

        $_arr_inputParam = array(
            'app_id'                => array('int', 0),
            'app_key'               => array('str', ''),
            'user_id'               => array('int', 0),
            'user_name'             => array('str', ''),
            'user_mail'             => array('str', ''),
            'user_access_token'     => array('str', ''),
            'user_access_expire'    => array('int', 0),
            'user_refresh_token'    => array('str', ''),
            'user_refresh_expire'   => array('int', 0),
            'timestamp'             => array('int', 0),
        );

        $_arr_inputSync  = $this->obj_request->fillParam($arr_data, $_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputSync);

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x100201',
                'msg'   => end($_mix_vld),
            );
        }

        if ($_arr_inputSync['app_id'] != $_arr_configSso['app_id']) {
            return array(
                'rcode' => 'x100201',
                'msg'   => 'App ID is incorrect',
            );
        }

        if ($_arr_inputSync['app_key'] != $_arr_configSso['app_key']) {
            return array(
                'rcode' => 'x100201',
                'msg'   => 'App Key is incorrect',
            );
        }

        $_arr_inputSync['rcode'] = 'y100201';

        $this->inputSync  = $_arr_inputSync;

        return $_arr_inputSync;
    }
}
