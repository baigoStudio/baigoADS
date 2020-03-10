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
class Advert extends Validate {

    protected $rule     = array(
        'advert_id' => array(
            'require' => true,
            'format'  => 'int',
        ),
        'advert_name' => array(
            'length' => '1,300'
        ),
        'advert_url' => array(
            'length' => '1,900'
        ),
        'advert_posi_id' => array(
            'require' => true
        ),
        'advert_note' => array(
            'max' => true
        ),
        'advert_begin_format' => array(
            'require' => true,
            'format' => 'date_time'
        ),
        'advert_begin' => array(
            'require' => true,
            'format'  => 'int'
        ),
        'advert_type' => array(
            'require' => true
        ),
        'advert_status' => array(
            'require' => true
        ),
        'advert_ids' => array(
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
            'advert_id',
            'advert_name',
            'advert_url',
            'advert_posi_id',
            'advert_note',
            'advert_begin_format',
            'advert_type',
            'advert_status',
            '__token__',
        ),
        'submit_db' => array(
            'advert_name',
            'advert_url',
            'advert_posi_id',
            'advert_note',
            'advert_begin',
            'advert_type',
            'advert_status',
        ),
        'delete' => array(
            'advert_ids',
            '__token__',
        ),
        'status' => array(
            'advert_ids',
            'act',
            '__token__',
        ),
        'common' => array(
            '__token__',
        ),
    );

    function v_init() { //构造函数

        $_arr_attrName = array(
            'advert_id'                 => $this->obj_lang->get('ID'),
            'advert_name'               => $this->obj_lang->get('Name'),
            'advert_url'                => $this->obj_lang->get('Destination URL'),
            'advert_posi_id'            => $this->obj_lang->get('Ad position'),
            'advert_note'               => $this->obj_lang->get('Note'),
            'advert_begin_format'       => $this->obj_lang->get('Effective time'),
            'advert_begin'              => $this->obj_lang->get('Effective time'),
            'advert_type'               => $this->obj_lang->get('Type'),
            'advert_opt_time_format'    => $this->obj_lang->get('Invalid time'),
            'advert_opt_show'           => $this->obj_lang->get('Display count'),
            'advert_opt_hit'            => $this->obj_lang->get('Click count'),
            'advert_status'             => $this->obj_lang->get('Status'),
            'advert_percent'            => $this->obj_lang->get('Percentage'),
            'advert_ids'                => $this->obj_lang->get('Advertisement'),
            'act'                       => $this->obj_lang->get('Action'),
            '__token__'                 => $this->obj_lang->get('Token'),
        );

        $_arr_typeMsg = array(
            'require'   => $this->obj_lang->get('{:attr} require'),
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
