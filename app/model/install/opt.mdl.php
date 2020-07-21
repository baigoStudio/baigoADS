<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\install;

use app\model\Opt as Opt_Base;
use ginkgo\Config;
use ginkgo\Html;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

/*-------------设置项模型-------------*/
class Opt extends Opt_Base {

    function __construct() { //构造函数
        parent::__construct();

        $this->configOpt = Config::get('opt', 'console');
    }

    function submit() {
        $_num_size = 1;

        if ($this->inputSubmit['install_type'] == 'manually') {
            $_arr_opt = array();

            //print_r($this->inputSubmit);

            foreach ($this->configOpt[$this->inputSubmit['act']]['lists'] as $_key=>$_value) {
                if (isset($this->inputSubmit[$_key])) {
                    $_arr_opt[$_key] = Html::decode($this->inputSubmit[$_key], 'url');
                }
            }

            $_num_size = Config::write(GK_APP_CONFIG . 'extra_' . $this->inputSubmit['act'] . GK_EXT_INC, $_arr_opt);
        }

        if ($_num_size > 0) {
            $_str_rcode = 'y030401';
            $_str_msg   = 'Set successfully';
        } else {
            $_str_rcode = 'x030401';
            $_str_msg   = 'Set failed';
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }


    function over() {
        $_arr_outPut = array(
            'prd_installed_ver'     => PRD_ADS_VER,
            'prd_installed_pub'     => PRD_ADS_PUB,
            'prd_installed_time'    => GK_NOW,
        );

        $_num_size   = Config::write(GK_APP_CONFIG . 'installed' . GK_EXT_INC, $_arr_outPut);

        if ($_num_size > 0) {
            $_str_rcode = 'y030401';
            $_str_msg   = 'Installation successful';
        } else {
            $_str_rcode = 'x030401';
            $_str_msg   = 'Installation failed';
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }


    function inputSubmit() {
        $_arr_inputParam = array(
            'install_type'  => array('str', ''),
            'act'           => array('str', ''),
            '__token__'     => array('str', ''),
        );

        $_str_act = $this->obj_request->post('act');

        foreach ($this->configOpt[$_str_act]['lists'] as $_key=>$_value) {
            $_arr_inputParam[$_key] = array('str', '');
        }

        $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

        if ($_arr_inputSubmit['install_type'] == 'full') {
            $_str_scene = 'type';
        } else {
            $_str_scene = $_str_act;
        }

        $_is_vld = $this->vld_opt->scene($_str_scene)->verify($_arr_inputSubmit);

        if ($_is_vld !== true) {
            $_arr_message = $this->vld_opt->getMessage();
            return array(
                'rcode' => 'x030201',
                'msg'   => end($_arr_message),
            );
        }

        $_arr_inputSubmit['rcode'] = 'y030201';

        $this->inputSubmit = $_arr_inputSubmit;

        return $_arr_inputSubmit;
    }


    function inputData() {
        $_arr_inputParam = array(
            'type'      => array('str', ''),
            'model'      => array('str', ''),
            '__token__' => array('str', ''),
        );

        $_arr_inputData = $this->obj_request->post($_arr_inputParam);

        $_is_vld = $this->vld_opt->scene('data')->verify($_arr_inputData);

        if ($_is_vld !== true) {
            $_arr_message = $this->vld_opt->getMessage();
            return array(
                'rcode' => 'x030201',
                'msg'   => end($_arr_message),
            );
        }

        $_arr_inputData['rcode'] = 'y030201';

        $this->inputData = $_arr_inputData;

        return $_arr_inputData;
    }
}
