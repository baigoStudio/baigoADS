<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Func;
use ginkgo\Arrays;
use ginkgo\Strings;
use ginkgo\Config;
use ginkgo\Loader;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------附件模型-------------*/
class Attach extends Model {

  public $imageExts;
  public $arr_box         = array('normal', 'recycle', 'reserve');

  public $urlPrefix;
  private $configUpload;

  protected function m_init() { //构造函数
    parent::m_init();

    $_arr_configImage   = Config::get('image');

    $this->imageExts    = array_keys($_arr_configImage);
    $this->configUpload = Config::get('upload', 'var_extra');

    if (Func::notEmpty($this->configUpload['ftp_host']) && Func::notEmpty($this->configUpload['url_prefix'])) {
      $this->urlPrefix = Func::fixDs($this->configUpload['url_prefix'], '/');
    } else {
      $_str_dirAttach     = str_ireplace(GK_PATH_PUBLIC, '', GK_PATH_ATTACH);
      $_str_dirAttach     = str_ireplace(DS, '/', $_str_dirAttach);
      $_str_dirAttach     = Func::fixDs($_str_dirAttach, '/');

      $this->urlPrefix = $this->obj_request->root(true) . $_str_dirAttach;
    }
  }


  public function check($mix_attach, $str_by = 'attach_id', $str_box = '') {
    $arr_select = array(
      'attach_id',
    );

    return $this->readProcess($mix_attach, $str_by, $arr_select);
  }


  public function read($mix_attach, $str_by = 'attach_id', $arr_select = array()) {
    $_arr_attachRow = $this->readProcess($mix_attach, $str_by, $arr_select);

    return $this->rowProcess($_arr_attachRow);
  }


  /**
   * read function.
   *
   * @access public
   * @param mixed $num_attachId
   * @return void
   */
  public function readProcess($mix_attach, $str_by = 'attach_id', $arr_select = array()) {
    if (Func::isEmpty($arr_select)) {
      $arr_select = array(
        'attach_id',
        'attach_name',
        'attach_note',
        'attach_time',
        'attach_ext',
        'attach_mime',
        'attach_size',
        'attach_box',
        'attach_admin_id',
      );
    }

    $_arr_where = $this->readQueryProcess($mix_attach, $str_by);

    $_arr_attachRow  = $this->where($_arr_where)->find($arr_select);

    if ($_arr_attachRow === false) {
      $_arr_attachRow          = $this->obj_request->fillParam(array(), $arr_select);
      $_arr_attachRow['msg']   = 'Image not found';
      $_arr_attachRow['rcode'] = 'x070102';
    } else {
      $_arr_attachRow['rcode'] = 'y070102';
      $_arr_attachRow['msg']   = '';
    }

    return $_arr_attachRow;
  }


  /**
   * mdl_list function.
   *
   * @access public
   * @param mixed $num_no
   * @param int $num_offset (default: 0)
   * @param string $str_year (default: '')
   * @param string $str_month (default: '')
   * @param string $str_ext (default: '')
   * @param int $num_adminId (default: 0)
   * @return void
   */
  public function lists($pagination = 0, $arr_search = array(), $arr_order = array(array('attach_id', 'DESC'))) {
    $_arr_attachSelect = array(
      'attach_id',
      'attach_name',
      'attach_note',
      'attach_time',
      'attach_ext',
      'attach_mime',
      'attach_size',
      'attach_admin_id',
      'attach_box',
    );

    $_arr_where         = $this->queryProcess($arr_search);
    $_arr_pagination    = $this->paginationProcess($pagination);
    $_arr_getData       = $this->where($_arr_where)->order($arr_order)->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_attachSelect);

    if (isset($_arr_getData['dataRows'])) {
      $_arr_eachData = &$_arr_getData['dataRows'];
    } else {
      $_arr_eachData = &$_arr_getData;
    }

    if (Func::notEmpty($_arr_eachData)) {
      foreach ($_arr_eachData as $_key=>&$_value) {
        $_value = $this->rowProcess($_value);
      }
    }

    //$_arr_mimeImage = array_flip($this->imageExts);

    return $_arr_getData;
  }


  /**
   * mdl_count function.
   *
   * @access public
   * @param string $str_year (default: '')
   * @param string $str_month (default: '')
   * @param string $str_ext (default: '')
   * @param int $num_adminId (default: 0)
   * @return void
   */
  public function counts($arr_search = array()) {
    $_arr_where    = $this->queryProcess($arr_search);

    return $this->where($_arr_where)->count();
  }


  public function nameProcess($arr_attachRow, $ds = '/') {
    $_str_return = date('Y', $arr_attachRow['attach_time']) . $ds . date('m', $arr_attachRow['attach_time']) . $ds . $arr_attachRow['attach_id'];

    return $_str_return . '.' . $arr_attachRow['attach_ext'];
  }


  protected function queryProcess($arr_search = array()) {
    $_arr_where = array();

    if (isset($arr_search['key']) && Func::notEmpty($arr_search['key'])) {
      $_arr_where[] = array('attach_name|attach_note|attach_id', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
    }

    if (isset($arr_search['year']) && Func::notEmpty($arr_search['year'])) {
      $_arr_where[] = array('FROM_UNIXTIME(`attach_time`, \'%Y\')', '=', $arr_search['year'], 'year');
    }

    if (isset($arr_search['month']) && Func::notEmpty($arr_search['month'])) {
      $_arr_where[] = array('FROM_UNIXTIME(`attach_time`, \'%m\')', '=', $arr_search['month'], 'month');
    }

    if (isset($arr_search['ext']) && Func::notEmpty($arr_search['ext'])) {
      $_arr_where[] = array('attach_ext', '=', $arr_search['ext']);
    }

    if (isset($arr_search['box']) && Func::notEmpty($arr_search['box'])) {
      $_arr_where[] = array('attach_box', '=', $arr_search['box']);
    }

    if (isset($arr_search['attach_ids']) && Func::notEmpty($arr_search['attach_ids'])) {
      $arr_search['attach_ids'] = Arrays::unique($arr_search['attach_ids']);

      if (Func::notEmpty($arr_search['attach_ids'])) {
        $_arr_where[] = array('attach_id', 'IN', $arr_search['attach_ids'], 'attach_ids');
      }
    }

    if (isset($arr_search['admin_id']) && $arr_search['admin_id'] > 0) {
      $_arr_where[] = array('attach_admin_id', '=', $arr_search['admin_id']);
    }

    if (isset($arr_search['min_id']) && $arr_search['min_id'] > 0) {
      $_arr_where[] = array('attach_id', '>', $arr_search['min_id'], 'min_id');
    }

    if (isset($arr_search['max_id']) && $arr_search['max_id'] > 0) {
      $_arr_where[] = array('attach_id', '<', $arr_search['max_id'], 'max_id');
    }

    return $_arr_where;
  }

  protected function readQueryProcess($mix_attach, $str_by = 'attach_id', $str_box = '') {
    $_arr_where[] = array($str_by, '=', $mix_attach);

    if (Func::notEmpty($str_box)) {
      $_arr_where[] = array('attach_box', '=', $str_box);
    }

    return $_arr_where;
  }

  protected function rowProcess($arr_attachRow = array()) {
    if (isset($arr_attachRow['attach_ext'])) {
      if (in_array($arr_attachRow['attach_ext'], $this->imageExts)) {
        $arr_attachRow['attach_type'] = 'image';
      } else {
        $arr_attachRow['attach_type'] = 'file';
      }
    } else {
      $arr_attachRow['attach_type'] = 'file';
    }

    if (!isset($arr_attachRow['attach_time'])) {
      $arr_attachRow['attach_time'] = GK_NOW;
    }

    if (!isset($arr_attachRow['attach_size'])) {
      $arr_attachRow['attach_size'] = 0;
    }

    $arr_attachRow['attach_time'] = (int)$arr_attachRow['attach_time'];

    $_str_attachNameUrl                 = $this->nameProcess($arr_attachRow);
    $arr_attachRow['attach_url_name']   = $_str_attachNameUrl;
    $arr_attachRow['attach_url']        = $this->urlPrefix . $_str_attachNameUrl;

    $arr_attachRow['attach_time_format'] = $this->dateFormat($arr_attachRow['attach_time']);
    $arr_attachRow['attach_size_format'] = Strings::sizeFormat($arr_attachRow['attach_size']);

    return $arr_attachRow;
  }
}
