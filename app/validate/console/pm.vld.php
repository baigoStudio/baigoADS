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
class Pm extends Validate {

  protected $rule = array(
    'pm_to_name' => array(
      'require' => true,
    ),
    'pm_title' => array(
      'max' => 90,
    ),
    'pm_content' => array(
      'length' => '1,900',
    ),
    'pm_ids' => array(
      'require' => true,
    ),
    'act' => array(
      'require' => true,
    ),
    '__token__' => array(
      'require' => true,
      'token'   => true,
    ),
  );

  protected $scene    = array(
    'send' => array(
      'pm_to_name',
      'pm_title',
      'pm_content',
      '__token__',
    ),
    'delete' => array(
      'pm_ids',
      '__token__',
    ),
    'status' => array(
      'pm_ids',
      'act',
      '__token__',
    ),
  );

  protected function v_init() { //构造函数

    $_arr_attrName = array(
      'pm_to_name'    => $this->obj_lang->get('Recipient'),
      'pm_title'      => $this->obj_lang->get('Title'),
      'pm_content'    => $this->obj_lang->get('Content'),
      'pm_ids'        => $this->obj_lang->get('Message'),
      'act'           => $this->obj_lang->get('Action'),
      '__token__'     => $this->obj_lang->get('Token'),
    );

    $_arr_typeMsg = array(
      'require'   => $this->obj_lang->get('{:attr} require'),
      'length'    => $this->obj_lang->get('Size of {:attr} must be {:rule}'),
      'max'       => $this->obj_lang->get('Max size of {:attr} must be {:rule}'),
      'token'     => $this->obj_lang->get('Form token is incorrect'),
    );

    $this->setAttrName($_arr_attrName);
    $this->setTypeMsg($_arr_typeMsg);
  }
}
