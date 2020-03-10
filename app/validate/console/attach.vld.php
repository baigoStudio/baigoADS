<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\validate\console;

use ginkgo\Validate;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

/*-------------管理员模型-------------*/
class Attach extends Validate {

    protected $rule     = array(
        'attach_id' => array(
            'require'   => true,
            'format'    => 'int',
        ),
        'attach_name' => array(
            'length'   => '1,1000',
        ),
        'attach_ext' => array(
            'length'   => '1,5',
        ),
        'attach_mime' => array(
            'length'   => '1,100',
        ),
        'attach_ids' => array(
            'require' => true,
        ),
        'act' => array(
            'require' => true,
        ),
        'max_id' => array(
            'require' => true,
            'format'  => 'int',
        ),
        '__token__' => array(
            'require' => true,
            'token'   => true,
        ),
    );

    protected $scene    = array(
        'submit_db' => array(
            'attach_name',
            'attach_ext',
            'attach_mime',
        ),
        'move' => array(
            'attach_ids',
            'cate_id' => array(
                '>' => 0,
            ),
            '__token__',
        ),
        'regen' => array(
            'thumb_id' => array(
                '>' => 0,
            ),
            '__token__',
        ),
        'clear' => array(
            'max_id',
            '__token__',
        ),
        'fix' => array(
            'attach_id' => array(
                '>' => 0,
            ),
            '__token__',
        ),
        'delete' => array(
            'attach_ids',
            '__token__',
        ),
        'status' => array(
            'attach_ids',
            'act',
            '__token__',
        ),
        'common' => array(
            '__token__',
        ),
    );

    function v_init() { //构造函数

        $_arr_attrName = array(
            'attach_id'     => $this->obj_lang->get('ID'),
            'attach_name'   => $this->obj_lang->get('Original name'),
            'attach_ext'    => $this->obj_lang->get('Extension'),
            'attach_mime'   => $this->obj_lang->get('MIME'),
            'attach_ids'    => $this->obj_lang->get('Attachment'),
            'act'           => $this->obj_lang->get('Action'),
            'max_id'        => $this->obj_lang->get('Max ID'),
            '__token__'     => $this->obj_lang->get('Token'),
        );

        $_arr_typeMsg = array(
            'require'   => $this->obj_lang->get('{:attr} require'),
            'gt'        => $this->obj_lang->get('{:attr} require'),
            'length'    => $this->obj_lang->get('Size of {:attr} must be {:rule}'),
            'token'     => $this->obj_lang->get('Form token is incorrect'),
        );

        $_arr_formatMsg = array(
            'int' => $this->obj_lang->get('{:attr} must be integer'),
        );

        $this->setAttrName($_arr_attrName);
        $this->setTypeMsg($_arr_typeMsg);
        $this->setFormatMsg($_arr_formatMsg);
    }
}
