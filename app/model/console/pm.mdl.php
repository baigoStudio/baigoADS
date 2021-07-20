<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/
namespace app\model\console;

use ginkgo\Func;
use ginkgo\Arrays;
use app\model\Pm as Pm_Base;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------短消息模型-------------*/
class Pm extends Pm_Base {

    public $inputSend;
    public $inputDelete;
    public $inputStatus;

    /** 发送表单验证
     * inputSend function.
     *
     * @access public
     * @return void
     */
    function inputSend() {
        $_arr_inputParam = array(
            'pm_to_name'    => array('str', ''),
            'pm_title'      => array('str', ''),
            'pm_content'    => array('str', ''),
            '__token__'     => array('str', ''),
        );

        $_arr_inputSend = $this->obj_request->post($_arr_inputParam);

        $_is_vld = $this->vld_pm->scene('send')->verify($_arr_inputSend);

        if ($_is_vld !== true) {
            $_arr_message = $this->vld_pm->getMessage();
            return array(
                'rcode' => 'x110201',
                'msg'   => end($_arr_message),
            );
        }

        $_arr_inputSend['rcode'] = 'y110201';

        $this->inputSend = $_arr_inputSend;

        return $_arr_inputSend;
    }


    /** 选择短消息
     * inputDelete function.
     *
     * @access public
     * @return void
     */
    function inputDelete() {
        $_arr_inputParam = array(
            'pm_ids'    => array('arr', array()),
            '__token__' => array('str', ''),
        );

        $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

        $_arr_inputDelete['pm_ids'] = Arrays::filter($_arr_inputDelete['pm_ids']);

        $_is_vld = $this->vld_pm->scene('delete')->verify($_arr_inputDelete);

        if ($_is_vld !== true) {
            $_arr_message = $this->vld_pm->getMessage();
            return array(
                'rcode' => 'x110201',
                'msg'   => end($_arr_message),
            );
        }

        $_arr_inputDelete['rcode'] = 'y110201';

        $this->inputDelete = $_arr_inputDelete;

        return $_arr_inputDelete;
    }


    function inputStatus() {
        $_arr_inputParam = array(
            'pm_ids'    => array('arr', array()),
            'act'       => array('str', ''),
            '__token__' => array('str', ''),
        );

        $_arr_inputStatus = $this->obj_request->post($_arr_inputParam);

        $_arr_inputStatus['pm_ids'] = Arrays::filter($_arr_inputStatus['pm_ids']);

        $_is_vld = $this->vld_pm->scene('status')->verify($_arr_inputStatus);

        if ($_is_vld !== true) {
            $_arr_message = $this->vld_pm->getMessage();
            return array(
                'rcode' => 'x110201',
                'msg'   => end($_arr_message),
            );
        }

        $_arr_inputStatus['rcode'] = 'y110201';

        $this->inputStatus = $_arr_inputStatus;

        return $_arr_inputStatus;
    }
}
