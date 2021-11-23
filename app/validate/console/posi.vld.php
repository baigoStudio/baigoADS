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
class Posi extends Validate {

  protected $rule     = array(
    'posi_id' => array(
      'require' => true,
      'format'  => 'int',
    ),
    'posi_name' => array(
      'length' => '1,300',
    ),
    'posi_count' => array(
      'require' => true,
      'format'  => 'int',
    ),
    'posi_note' => array(
      'max'  => 300,
    ),
    'posi_status' => array(
      'require' => true,
    ),
    'posi_script' => array(
      'length' => '1,300',
    ),
    'posi_box_perfix' => array(
      'length' => '0,300',
    ),
    'posi_loading' => array(
      'length' => '0,300',
    ),
    'posi_close' => array(
      'length' => '0,300',
    ),
    'posi_is_percent' => array(
      'require' => true,
    ),
    'posi_ids' => array(
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
    'submit' => array(
      'posi_id',
      'posi_name',
      'posi_count',
      'posi_note',
      'posi_status',
      'posi_script',
      'posi_box_perfix',
      'posi_loading',
      'posi_close',
      'posi_is_percent',
      '__token__',
    ),
    'submit_db' => array(
      'posi_name',
      'posi_count',
      'posi_note',
      'posi_status',
      'posi_script',
      'posi_box_perfix',
      'posi_loading',
      'posi_close',
      'posi_is_percent',
    ),
    'opts' => array(
      'posi_id' => array(
        '>' => 0,
      ),
      '__token__',
    ),
    'duplicate' => array(
      'posi_id' => array(
        '>' => 0,
      ),
      '__token__',
    ),
    'status' => array(
      'posi_ids',
      'act',
      '__token__',
    ),
    'delete' => array(
      'posi_ids',
      '__token__',
    ),
    'common' => array(
      '__token__',
    ),
  );


  protected function v_init() { //构造函数

    $_arr_attrName = array(
      'posi_id'           => $this->obj_lang->get('ID'),
      'posi_name'         => $this->obj_lang->get('Name'),
      'posi_note'         => $this->obj_lang->get('Note'),
      'posi_status'       => $this->obj_lang->get('Status'),
      'posi_script'       => $this->obj_lang->get('Ad script'),
      'posi_box_perfix'   => $this->obj_lang->get('Ad container perfix'),
      'posi_loading'      => $this->obj_lang->get('Text of loading'),
      'posi_close'        => $this->obj_lang->get('Text of close'),
      'posi_is_percent'   => $this->obj_lang->get('By percentage'),
      'posi_ids'          => $this->obj_lang->get('Position'),
      'act'               => $this->obj_lang->get('Action'),
      '__token__'         => $this->obj_lang->get('Token'),
    );

    $_arr_typeMsg = array(
      'require'   => $this->obj_lang->get('{:attr} require'),
      'gt'        => $this->obj_lang->get('{:attr} require'),
      'length'    => $this->obj_lang->get('Size of {:attr} must be {:rule}'),
      'max'       => $this->obj_lang->get('Max size of {:attr} must be {:rule}'),
      'token'     => $this->obj_lang->get('Form token error'),
    );

    $_arr_formatMsg = array(
      'int' => $this->obj_lang->get('{:attr} must be integer'),
    );

    $this->setAttrName($_arr_attrName);
    $this->setTypeMsg($_arr_typeMsg);
    $this->setFormatMsg($_arr_formatMsg);
  }
}
