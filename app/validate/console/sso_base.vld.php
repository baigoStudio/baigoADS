<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\validate\console;

use ginkgo\Validate;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------管理员模型-------------*/
class Sso_Base extends Validate {

    protected $rule     = array(
        'app_id'  => array(
            '>' => 0,
        ),
        'app_key' => array(
            'require' => true,
        ),
        'sign' => array(
            'require' => true,
        ),
        'code' => array(
            'require' => true,
        ),
    );

    protected $scene    = array(
        'common' => array(
            'sign',
            'code',
        ),
    );


    function v_init() { //构造函数

        $_arr_attrName = array(
            'app_id'    => $this->obj_lang->get('App ID', 'console.common'),
            'app_key'   => $this->obj_lang->get('App Key', 'console.common'),
            'sign'      => $this->obj_lang->get('Signature', 'console.common'),
            'code'      => $this->obj_lang->get('Encrypted code', 'console.common'),
        );

        $_arr_typeMsg = array(
            'require'   => $this->obj_lang->get('{:attr} require', 'console.common'),
            'gt'        => $this->obj_lang->get('{:attr} require', 'console.common'),
        );

        $this->setAttrName($_arr_attrName);
        $this->setTypeMsg($_arr_typeMsg);
    }
}
