<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use ginkgo\Loader;
use ginkgo\Request;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

/*-------------应用模型-------------*/
class Sso_Base {

    function __construct() { //构造函数
        $this->obj_request  = Request::instance();
        $this->vld_base     = Loader::validate('Sso_Base');
    }


    function inputRoute() {
        $_arr_inputParam = array(
            'm' => array('str', ''),
            'c' => array('str', ''),
            'a' => array('str', ''),
        );

        $this->inputRoute = $this->obj_request->get($_arr_inputParam);

        return $this->inputRoute;
    }


    /** 表单验证
     * inputSubmit function.
     *
     * @access public
     * @return void
     */
    function inputCommon($scene = '') {
        $_arr_inputParam = array(
            'app_id'    => array('int', 0),
            'app_key'   => array('str', ''),
            'sign'      => array('str', ''),
            'code'      => array('str', ''),
        );

        $_arr_inputCommon = $this->obj_request->request($_arr_inputParam);

        $_is_vld = $this->vld_base->scene($scene)->verify($_arr_inputCommon);

        if ($_is_vld !== true) {
            $_arr_message = $this->vld_base->getMessage();
            return array(
                'rcode' => 'x100201',
                'msg'   => end($_arr_message),
            );
        }

        $_arr_inputCommon['rcode'] = 'y100201';

        $this->inputCommon = $_arr_inputCommon;

        return $_arr_inputCommon;
    }
}
