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
class Link extends Validate {

    protected $rule     = array(
        'link_id' => array(
            'require' => true,
            'format'  => 'int',
        ),
        'link_name' => array(
            'length' => '1,300',
        ),
        'link_url' => array(
            'length'  => '1,900',
        ),
        'link_status' => array(
            'require' => true,
        ),
        'link_ids' => array(
            'require' => true,
        ),
        'act' => array(
            'require' => true,
        ),
        'link_orders' => array(
            'require' => true,
        ),
        '__token__' => array(
            'require' => true,
            'token'   => true,
        ),
    );

    protected $scene    = array(
        'submit' => array(
            'link_id',
            'link_name',
            'link_url',
            'link_status',
            '__token__',
        ),
        'submit_db' => array(
            'link_name',
            'link_url',
            'link_status',
        ),
        'status' => array(
            'link_ids',
            'act',
            '__token__',
        ),
        'delete' => array(
            'link_ids',
            '__token__',
        ),
        'order' => array(
            'link_orders',
            '__token__',
        ),
        'common' => array(
            '__token__',
        ),
    );

    function v_init() { //构造函数

        $_arr_attrName = array(
            'link_id'       => $this->obj_lang->get('ID'),
            'link_name'     => $this->obj_lang->get('Name'),
            'link_url'      => $this->obj_lang->get('Link'),
            'link_status'   => $this->obj_lang->get('Status'),
            'link_ids'      => $this->obj_lang->get('Link'),
            'act'           => $this->obj_lang->get('Action'),
            'link_orders'   => $this->obj_lang->get('Sort'),
            '__token__'     => $this->obj_lang->get('Token'),
        );

        $_arr_typeMsg = array(
            'require'   => $this->obj_lang->get('{:attr} require'),
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
