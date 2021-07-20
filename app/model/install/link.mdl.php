<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\install;

use app\classes\install\Model;
use ginkgo\Loader;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------链接模型-------------*/
class Link extends Model {

    private $create;

    function m_init() {
        $_mdl_link = Loader::model('Link', '', false);
        $this->arr_status = $_mdl_link->arr_status;

        $_str_status   = implode('\',\'', $this->arr_status);

        $this->create = array(
            'link_id' => array(
                'type'      => 'int(11)',
                'not_null'  => true,
                'ai'        => true,
                'comment'   => 'ID',
            ),
            'link_name' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '链接名称',
            ),
            'link_url' => array(
                'type'      => 'varchar(900)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '链接',
            ),
            'link_status' => array(
                'type'      => 'enum(\'' . $_str_status . '\')',
                'not_null'  => true,
                'default'   => $this->arr_status[0],
                'comment'   => '状态',
                'update'    => $this->arr_status[0],
            ),
            'link_order' => array(
                'type'      => 'int(11)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '排序',
            ),
            'link_blank' => array(
                'type'      => 'tinyint(1)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '窗口类型',
                'old'       => 'link_is_blank',
            ),
        );
    }



    function createTable() {
        $_num_count  = $this->create($this->create, 'link_id', '链接');

        if ($_num_count !== false) {
            $_str_rcode = 'y240105'; //更新成功
            $_str_msg   = 'Create table successfully';
        } else {
            $_str_rcode = 'x240105'; //更新成功
            $_str_msg   = 'Create table failed';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
            'msg'   => $_str_msg,
        );
    }


    function createIndex() {
        $_str_rcode       = 'y240109';
        $_str_msg         = 'Create index successfully';

        $_num_count  = $this->index('order')->create(array('link_order' , 'link_id'));

        if ($_num_count === false) {
            $_str_rcode = 'x240109';
            $_str_msg   = 'Create index failed';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
            'msg'   => $_str_msg,
        );
    }


    function alterTable() {
        $_arr_alter = $this->alterProcess($this->create);

        $_str_rcode = 'y240111';
        $_str_msg   = 'No need to update table';

        if (!Func::isEmpty($_arr_alter)) {
            $_num_count  = $this->alter($_arr_alter);

            if ($_num_count !== false) {
                $_str_rcode = 'y240106';
                $_str_msg   = 'Update table successfully';

                foreach ($this->create as $_key=>$_value) {
                    if (isset($_value['update'])) {
                        $_arr_data = array(
                            $_key => $_value['update'],
                        );
                        $this->where('LENGTH(`' . $_key . '`) < 1')->update($_arr_data);
                    }
                }
            } else {
                $_str_rcode = 'x240106';
                $_str_msg   = 'Update table failed';
            }
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }
}
