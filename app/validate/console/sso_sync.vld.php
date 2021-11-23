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
class Sso_Sync extends Validate {

  protected $rule     = array(
    'user_id' => array(
      '>' => 0,
    ),
    'timestamp' => array(
      '>' => 0,
    ),
  );

  protected function v_init() { //构造函数

    $_arr_attrName = array(
      'user_id'      => $this->obj_lang->get('User ID'),
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
