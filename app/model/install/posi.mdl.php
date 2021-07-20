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

/*-------------广告位类-------------*/
class Posi extends Model {

    private $create;

    function m_init() { //构造函数
        $this->mdl_posiBase     = Loader::model('Posi', '', false);
        $this->arr_status       = $this->mdl_posiBase->arr_status;
        $this->arr_isPercent    = $this->mdl_posiBase->arr_isPercent;

        $_str_status            = implode('\',\'', $this->arr_status);
        $_str_isPercent         = implode('\',\'', $this->arr_isPercent);

        $this->create = array(
            'posi_id' => array(
                'type'      => 'int(11)',
                'not_null'  => true,
                'ai'        => true,
                'comment'   => 'ID',
            ),
            'posi_name' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '名称',
            ),
            'posi_count' => array(
                'type'      => 'tinyint(4)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '广告数',
            ),
            'posi_status' => array(
                'type'      => 'enum(\'' . $_str_status . '\')',
                'not_null'  => true,
                'default'   => $this->arr_status[0],
                'comment'   => '状态',
                'update'    => $this->arr_status[0],
            ),
            'posi_is_percent' => array(
                'type'      => 'enum(\'' . $_str_isPercent . '\')',
                'not_null'  => true,
                'default'   => $this->arr_isPercent[0],
                'comment'   => '允许按几率展现',
                'update'    => $this->arr_isPercent[0],
            ),
            'posi_script' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '脚本',
            ),
            'posi_box_perfix' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '容器前缀',
                'old'       => 'posi_selector',
            ),
            'posi_loading' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => 'Loading 消息',
            ),
            'posi_close' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '关闭文本',
            ),
            'posi_opts' => array(
                'type'      => 'text',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '选项',
            ),
            'posi_note' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '备注',
            ),
        );
    }


    /** 创建表
     * mdl_create function.
     *
     * @access public
     * @return void
     */
    function createTable() {
        $_num_count  = $this->create($this->create, 'posi_id', '广告位');

        if ($_num_count !== false) {
            $_str_rcode = 'y040105'; //更新成功
            $_str_msg   = 'Create table successfully';
        } else {
            $_str_rcode = 'x040105'; //更新失败
            $_str_msg   = 'Create table failed';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
            'msg'   => $_str_msg,
        );
    }


    function alterTable() {
        $_arr_alter = $this->alterProcess($this->create);

        $_str_rcode = 'y040111';
        $_str_msg   = 'No need to update table';

        if (!Func::isEmpty($_arr_alter)) {
            $_num_count  = $this->alter($_arr_alter);

            if ($_num_count !== false) {
                $_str_rcode = 'y040106';
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
                $_str_rcode = 'x040106';
                $_str_msg   = 'Update table failed';
            }
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }

}
