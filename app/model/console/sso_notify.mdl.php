<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use ginkgo\Loader;
use ginkgo\Request;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------应用模型-------------*/
class Sso_Notify {

    function __construct() { //构造函数
        $this->obj_request  = Request::instance();
        $this->vld_notify   = Loader::validate('Sso_Notify');
    }


    function inputInfo($arr_data) {
        $_arr_inputParam = array(
            'timestamp'     => array('int', 0),
        );

        $_arr_inputInfo  = $this->obj_request->fillParam($arr_data, $_arr_inputParam);

        $_is_vld = $this->vld_notify->scene('info')->verify($_arr_inputInfo);

        if ($_is_vld !== true) {
            $_arr_message = $this->vld_notify->getMessage();
            return array(
                'rcode' => 'x100201',
                'msg'   => end($_arr_message),
            );
        }

        $_arr_inputInfo['rcode'] = 'y100201';

        $this->inputInfo  = $_arr_inputInfo;

        return $_arr_inputInfo;
    }


    function inputTest($arr_data) {
        $_arr_inputParam = array(
            'echostr'   => array('str', ''),
            'timestamp' => array('int', 0),
        );

        $_arr_inputTest  = $this->obj_request->fillParam($arr_data, $_arr_inputParam);

        $_is_vld = $this->vld_notify->verify($_arr_inputTest);

        if ($_is_vld !== true) {
            $_arr_message = $this->vld_notify->getMessage();
            return array(
                'rcode' => 'x100201',
                'msg'   => end($_arr_message),
            );
        }


        $_arr_inputTest['rcode'] = 'y100201';

        $this->inputTest  = $_arr_inputTest;

        return $_arr_inputTest;
    }
}
