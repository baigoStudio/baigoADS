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
class Sso_Notify extends Validate {

  protected $rule     = array(
    'echostr' => array(
      'require' => true,
    ),
    'timestamp' => array(
      '>' => 0,
    ),
  );

  protected $scene    = array(
    'info' => array(
      'timestamp',
    ),
  );


  protected function v_init() { //构造函数

    $_arr_attrName = array(
      'timestamp'    => $this->obj_lang->get('Timestamp', 'console.common'),
    );

    $_arr_typeMsg = array(
      'require'   => $this->obj_lang->get('{:attr} require'),
      'gt'        => $this->obj_lang->get('{:attr} require'),
    );

    $this->setAttrName($_arr_attrName);
    $this->setTypeMsg($_arr_typeMsg);
  }
}
