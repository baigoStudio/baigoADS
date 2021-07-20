<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\validate\install;

use app\validate\Opt as Opt_Base;
use ginkgo\Config;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------设置项模型-------------*/
class Opt extends Opt_Base {

    function v_init() { //构造函数
        parent::v_init();

        $this->configSso = Config::get('sso', 'console.opt');

        $_arr_rule = array(
            'install_type' => array(
                'require' => true,
            ),
        );

        $_arr_scene = array(
            'type' => array(
                'install_type',
                '__token__',
            ),
            'sso' => array(
                'install_type',
                '__token__',
            ),
        );

        foreach ($this->configSso['lists'] as $_key=>$_value) {
            $_arr_rule[$_key]['require'] = $_value['require'];

            if (isset($_value['format'])) {
                $_arr_rule[$_key]['format'] = $_value['format'];
            }

            $_arr_scene['sso'][] = $_key;
            $_arr_attrName[$_key]  = $this->obj_lang->get($_value['title']);
        }

        //print_r($_arr_scene);

        $this->rule($_arr_rule);
        $this->setScene($_arr_scene);
        $this->setAttrName($_arr_attrName);
    }
}
