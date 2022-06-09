<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Func;
use ginkgo\Arrays;
use ginkgo\Config;
use ginkgo\Html;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------应用模型-------------*/
class Advert extends Model {

  public $arr_status  = array('enable', 'disabled', 'wait');
  public $arr_type    = array('date', 'show', 'hit', 'none', 'backup');

  public $urlPrefix;

  protected function m_init() { //构造函数
    parent::m_init();

    $_arr_configRoute   = Config::get('route', 'index');

    if (!isset($_arr_configRoute['advert'])) {
      $_arr_configRoute['advert'] = '';
    }

    $this->urlPrefix    = $this->obj_request->baseUrl(true) . $_arr_configRoute['advert'] . '/';
  }


  public function check($mix_advert, $str_by = 'advert_id', $num_notId = 0) {
    $_arr_advertSelect = array(
      'advert_id',
    );

    return $this->readProcess($mix_advert, $str_by = 'advert_id', $num_notId, $_arr_advertSelect);
  }


  /** 读取
   * mdl_read function.
   *
   * @access public
   * @param mixed $mix_advert
   * @param string $str_by (default: 'advert_id')
   * @param int $num_notId (default: 0)
   * @return void
   */
  public function read($mix_advert, $str_by = 'advert_id', $num_notId = 0, $arr_select = array()) {
    $_arr_advertRow = $this->readProcess($mix_advert, $str_by = 'advert_id', $num_notId, $arr_select);

    return $this->rowProcess($_arr_advertRow);
  }


  public function readProcess($mix_advert, $str_by = 'advert_id', $num_notId = 0, $arr_select = array()) {
    if (Func::isEmpty($arr_select)) {
      $arr_select = array(
        'advert_id',
        'advert_name',
        'advert_posi_id',
        'advert_attach_id',
        'advert_count_show',
        'advert_count_hit',
        'advert_type',
        'advert_opt',
        'advert_url',
        'advert_percent',
        'advert_content',
        'advert_status',
        'advert_begin',
        'advert_note',
        'advert_time',
        'advert_admin_id',
        'advert_approve_id',
      );
    }

    $_arr_where = $this->readQueryProcess($mix_advert, $str_by, $num_notId);

    $_arr_advertRow = $this->where($_arr_where)->find($arr_select); //检查本地表是否存在记录

    if ($_arr_advertRow === false) {
      $_arr_advertRow          = $this->obj_request->fillParam(array(), $arr_select);
      $_arr_advertRow['msg']   = 'Advertisement not found';
      $_arr_advertRow['rcode'] = 'x080102';
    } else {
      $_arr_advertRow['rcode'] = 'y080102';
      $_arr_advertRow['msg']   = '';
    }

    return $_arr_advertRow;
  }


  public function sum($arr_search) {
    $_arr_where   = $this->queryProcess($arr_search);

    return $this->where($_arr_where)->sum('advert_percent');
  }


  /** 列出
   * mdl_list function.
   *
   * @access public
   * @param mixed $num_no
   * @param int $num_offset (default: 0)
   * @param string $str_key (default: '')
   * @param string $str_status (default: '')
   * @param string $str_sync (default: '')
   * @return void
   */
  public function lists($pagination = 0, $arr_search = array()) {
    $_arr_advertSelect = array(
      'advert_id',
      'advert_name',
      'advert_posi_id',
      'advert_attach_id',
      'advert_count_show',
      'advert_count_hit',
      'advert_type',
      'advert_opt',
      'advert_url',
      'advert_percent',
      'advert_content',
      'advert_status',
      'advert_begin',
      'advert_note',
      'advert_time',
      'advert_admin_id',
      'advert_approve_id',
    );

    $_arr_where         = $this->queryProcess($arr_search);
    $_arr_pagination    = $this->paginationProcess($pagination);
    $_arr_getData       = $this->where($_arr_where)->order('advert_id', 'DESC')->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_advertSelect);

    return $_arr_getData;
  }


  /** 计数
   * mdl_count function.
   *
   * @access public
   * @param string $str_key (default: '')
   * @param string $str_status (default: '')
   * @param string $str_sync (default: '')
   * @return void
   */
  public function counts($arr_search = array()) {
    $_arr_where = $this->queryProcess($arr_search);

    $_num_advertCount = $this->where($_arr_where)->count();

    return $_num_advertCount;
  }


  public function listsRand($arr_adverts) {
    $_arr_return = '';

    //概率数组的总概率精度
    $_num_percentSum = array_sum($arr_adverts);

    //概率数组循环
    foreach ($arr_adverts as $_key=>$_value) {
      $_num_rand = mt_rand(1, $_num_percentSum);
      if ($_num_rand <= $_value) {
        $_arr_return = $_key;
        break;
      } else {
        $_num_percentSum -= $_value;
      }
    }

    unset($arr_adverts);

    return $_arr_return;
  }


  protected function queryProcess($arr_search = array()) {
    $_arr_where = array();

    if (isset($arr_search['key']) && Func::notEmpty($arr_search['key'])) {
      $_arr_where[] = array('advert_name|advert_note', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
    }

    if (isset($arr_search['status']) && Func::notEmpty($arr_search['status'])) {
      $_arr_where[] = array('advert_status', '=', $arr_search['status']);
    }

    if (isset($arr_search['type']) && Func::notEmpty($arr_search['type'])) {
      $_arr_where[] = array('advert_type', '=', $arr_search['type']);
    }

    if (isset($arr_search['posi_id']) && $arr_search['posi_id'] > 0) {
      $_arr_where[] = array('advert_posi_id', '=', $arr_search['posi_id']);
    }

    if (isset($arr_search['not_ids']) && Func::notEmpty($arr_search['not_ids'])) {
      $arr_search['not_ids'] = Arrays::unique($arr_search['not_ids']);

      if (Func::notEmpty($arr_search['not_ids'])) {
        $_arr_where[] = array('advert_id', 'NOT IN', $arr_search['not_ids'], 'not_ids');
      }
    }

    return $_arr_where;
  }


  protected function readQueryProcess($mix_advert, $str_by = 'advert_id', $num_notId = 0) {
    $_arr_where[] = array($str_by, '=', $mix_advert);

    if ($num_notId > 0) {
      $_arr_where[] = array('advert_id', '<>', $num_notId);
    }

    return $_arr_where;
  }


  protected function rowProcess($arr_advertRow = array()) {
    if (!isset($arr_advertRow['advert_time']) || $arr_advertRow['advert_time'] < 1) {
      $arr_advertRow['advert_time'] = GK_NOW;
    }

    if (!isset($arr_advertRow['advert_begin']) || $arr_advertRow['advert_begin'] < 1) {
      $arr_advertRow['advert_begin'] = GK_NOW;
    }

    if (!isset($arr_advertRow['advert_opt'])) {
      $arr_advertRow['advert_opt'] = 0;
    }

    if (!isset($arr_advertRow['advert_url'])) {
      $arr_advertRow['advert_url'] = '';
    }

    $arr_advertRow['advert_opt_time_format']    = $this->dateFormat($arr_advertRow['advert_opt']);
    $arr_advertRow['advert_begin_format']       = $this->dateFormat($arr_advertRow['advert_begin']);

    $arr_advertRow['advert_href']               = $this->urlPrefix . $arr_advertRow['advert_id'];

    $arr_advertRow['advert_url']                = rawurldecode(Html::decode($arr_advertRow['advert_url'], 'url'));

    return $arr_advertRow;
  }
}
