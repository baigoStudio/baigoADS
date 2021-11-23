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

/*-------------应用模型-------------*/
class Advert extends Model {

  protected $pk = 'advert_id';
  protected $comment = '广告';

  public $arr_status = array();
  public $arr_type   = array();

  protected function m_init() { //构造函数
    $this->mdl_advertBase   = Loader::model('Advert', '', false);
    $this->arr_status       = $this->mdl_advertBase->arr_status;
    $this->arr_type         = $this->mdl_advertBase->arr_type;

    $_str_status            = implode('\',\'', $this->arr_status);
    $_str_type              = implode('\',\'', $this->arr_type);

    $this->create = array(
      'advert_id' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'ai'        => true,
        'comment'   => 'ID',
      ),
      'advert_name' => array(
        'type'      => 'varchar(300)',
        'not_null'  => true,
        'default'   => '',
        'comment'   => '广告名称',
      ),
      'advert_posi_id' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '广告位 ID',
      ),
      'advert_attach_id' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '广告图片 ID',
        'old'       => 'advert_media_id',
      ),
      'advert_count_show' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '展示数',
      ),
      'advert_count_hit' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '点击数',
      ),
      'advert_type' => array(
        'type'      => 'enum(\'' . $_str_type . '\')',
        'not_null'  => true,
        'default'   => $this->arr_type[0],
        'comment'   => '投放类型',
        'update'    => $this->arr_type[0],
        'old'       => 'advert_put_type',
      ),
      'advert_status' => array(
        'type'      => 'enum(\'' . $_str_status . '\')',
        'not_null'  => true,
        'default'   => $this->arr_status[0],
        'comment'   => '状态',
        'update'    => $this->arr_status[0],
      ),
      'advert_opt' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '投放条件',
        'old'       => 'advert_put_opt',
      ),
      'advert_url' => array(
        'type'      => 'varchar(3000)',
        'not_null'  => true,
        'default'   => '',
        'comment'   => '链接地址',
      ),
      'advert_percent' => array(
        'type'      => 'tinyint(4)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '展现几率',
      ),
      'advert_content' => array(
        'type'      => 'text',
        'not_null'  => true,
        'default'   => '',
        'comment'   => '文字内容',
      ),
      'advert_begin' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '生效时间',
      ),
      'advert_note' => array(
        'type'      => 'varchar(300)',
        'not_null'  => true,
        'default'   => '',
        'comment'   => '备注',
      ),
      'advert_time' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '创建时间',
      ),
      'advert_admin_id' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '管理员 ID',
      ),
      'advert_approve_id' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '审核人 ID',
      ),
    );
  }


  /** 创建表
   * mdl_create function.
   *
   * @access public
   * @return void
   */
  public function createTable() {
    $_num_count  = $this->create();

    if ($_num_count !== false) {
      $_str_rcode = 'y080105'; //更新成功
      $_str_msg   = 'Create table successfully';
    } else {
      $_str_rcode = 'x080105'; //更新成功
      $_str_msg   = 'Create table failed';
    }

    return array(
      'rcode' => $_str_rcode, //更新成功
      'msg'   => $_str_msg,
    );
  }


  public function alterTable() {
    $_str_rcode = 'y080111';
    $_str_msg   = 'No need to update table';

    $_num_count  = $this->alter();

    if ($_num_count === false) {
      $_str_rcode = 'x080106';
      $_str_msg   = 'Update table failed';
    } else ($_num_count > 0) {
      $_str_rcode = 'y080106';
      $_str_msg   = 'Update table successfully';
    }

    return array(
      'rcode' => $_str_rcode,
      'msg'   => $_str_msg,
    );
  }
}
