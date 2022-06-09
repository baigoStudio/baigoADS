<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Attach as Attach_Base;
use ginkgo\Func;
use ginkgo\Arrays;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------附件模型-------------*/
class Attach extends Attach_Base {

  public $inputSubmit  = array();
  public $inputDelete  = array();
  public $inputBox     = array();
  public $inputReserve = array();
  public $inputUpload  = array();
  public $inputCommon  = array();
  public $inputFix     = array();
  public $inputClear   = array();

  /**
   * mdl_submit function.
   *
   * @access public
   * @param mixed $str_attachName
   * @param mixed $str_attachExt
   * @param int $num_attachSize (default: 0)
   * @param int $num_adminId (default: 0)
   * @return void
   */
  public function submit() {
    $_num_attachId = 0;

    $_arr_attachData = array();

    if (isset($this->inputSubmit['attach_id'])) {
      $_num_attachId  = $this->inputSubmit['attach_id'];
    }

    if (isset($this->inputSubmit['attach_note'])) {
      $_arr_attachData['attach_note']     = $this->inputSubmit['attach_note'];
    }

    if (isset($this->inputSubmit['attach_ext'])) {
      $_arr_attachData['attach_ext']      = $this->inputSubmit['attach_ext'];
    }

    if (isset($this->inputSubmit['attach_mime'])) {
      $_arr_attachData['attach_mime']     = $this->inputSubmit['attach_mime'];
    }

    if (isset($this->inputSubmit['attach_admin_id'])) {
      $_arr_attachData['attach_admin_id'] = $this->inputSubmit['attach_admin_id'];
    }

    if (isset($this->inputSubmit['attach_size'])) {
      $_arr_attachData['attach_size']     = $this->inputSubmit['attach_size'];
    }

    if (isset($this->inputSubmit['attach_box'])) {
      $_arr_attachData['attach_box'] = $this->inputSubmit['attach_box'];
    }

    $_arr_return    = array();
    $_arr_attachRow = array();

    if ($_num_attachId > 0) {
      $_str_vld = 'submit_edit_db';
    } else {
      $_str_vld = 'submit_add_db';

      if (isset($this->inputSubmit['attach_name'])) {
        $_arr_attachData['attach_name']     = $this->inputSubmit['attach_name'];
      }
    }

    $_mix_vld = $this->validate($_arr_attachData, '', $_str_vld);

    if ($_mix_vld !== true) {
      return array(
        'advert_id' => $this->inputSubmit['attach_id'],
        'rcode'     => 'x070201',
        'msg'       => end($_mix_vld),
      );
    }

    if ($_num_attachId > 0) {
      $_arr_return    = $this->updateProcess($_arr_attachData, $_num_attachId);
      $_arr_attachRow = $this->check($_num_attachId);
    } else {
      $_arr_attachData['attach_time'] = GK_NOW;

      $_arr_attachRow = $this->check('reserve', 'attach_box');

      if ($_arr_attachRow['rcode'] == 'x070102') {
        $_arr_return = $this->insertProcess($_arr_attachData);
      } else {
        $_arr_return = $this->updateProcess($_arr_attachData, $_arr_attachRow['attach_id']);

        if ($_arr_return['attach_id'] > 0) { //数据库插入是否成功
          $_arr_return['rcode'] = 'y070101';
          $_arr_return['msg']   = 'Add attachment successfully';
        }
      }
    }

    $_arr_attachResult = array_replace_recursive($_arr_attachRow, $_arr_attachData, $_arr_return);

    return $this->rowProcess($_arr_attachResult);
  }


  /**
   * mdl_del function.
   *
   * @access public
   * @param mixed $this->attachIds['attach_ids']
   * @param int $num_adminId (default: 0)
   * @return void
   */
  public function delete() {
    $_arr_where[] = array('attach_id', 'IN', $this->inputDelete['attach_ids'], 'attach_ids');

    if (isset($this->inputDelete['admin_id']) && $this->inputDelete['admin_id'] > 0) {
      $_arr_where[] = array('attach_admin_id', '=', $this->inputDelete['admin_id']);
    }

    $_num_count     = $this->where($_arr_where)->delete();

    //如车影响行数小于0则返回错误
    if ($_num_count > 0) {
      $_str_rcode = 'y070104';
      $_str_msg   = 'Successfully deleted {:count} attachments';
    } else {
      $_str_rcode = 'x070104';
      $_str_msg   = 'No attachment have been deleteds';
    }

    return array(
      'count' => $_num_count,
      'rcode' => $_str_rcode,
      'msg'   => $_str_msg,
    ); //成功
  }


  /**
   * mdl_ext function.
   *
   * @access public
   * @param mixed $num_no
   * @return void
   */
  public function ext() {
    $_arr_attachSelect = array(
      'DISTINCT `attach_ext`',
    );

    return $this->where('LENGTH(`attach_ext`)', '>', 0, 'attach_ext')->limit(100)->select($_arr_attachSelect);
  }


  /**
   * mdl_year function.
   *
   * @access public
   * @param mixed $num_no
   * @return void
   */
  public function year() {
    $_arr_attachSelect = array(
      'DISTINCT FROM_UNIXTIME(`attach_time`, \'%Y\') AS `attach_year`',
    );

    return $this->where('attach_time', '>', 0)->order('attach_time', 'ASC')->select($_arr_attachSelect);
  }



  public function box() {
    $_arr_attachData = array(
      'attach_box' => $this->inputBox['act'],
    );

    $_num_count = $this->where('attach_id', 'IN', $this->inputBox['attach_ids'], 'attach_ids')->update($_arr_attachData);

    if ($_num_count > 0) {
      $_str_rcode = 'y070103';
      $_str_msg   = 'Successfully updated {:count} attachments';
    } else {
      $_str_rcode = 'x070103';
      $_str_msg   = 'Did not make any changes';
    }

    return array(
      'count' => $_num_count,
      'rcode' => $_str_rcode,
      'msg'   => $_str_msg,
    );
  }


  public function reserve() {
    $_arr_attachUpdate = array(
      'attach_box' => 'reserve',
    );

    $_num_count = $this->where('attach_id', '=', $this->inputReserve['attach_id'])->update($_arr_attachData);

    //如影响行数大于0则返回成功
    if ($_num_count > 0) {
      $_str_rcode = 'y070103'; //成功
    } else {
      $_str_rcode = 'x070103'; //失败
    }

    return array(
      'rcode' => $_str_rcode,
    );
  }


  public function inputUpload() {
    $_arr_inputParam = array(
      '__token__'         => array('txt', ''),
    );

    $_arr_inputUpload = $this->obj_request->post($_arr_inputParam);

    $_mix_vld = $this->validate($_arr_inputUpload, '', 'common');

    if ($_mix_vld !== true) {
      return array(
        'rcode'     => 'x070201',
        'msg'       => end($_mix_vld),
      );
    }

    $_arr_inputUpload['rcode'] = 'y070201';

    $this->inputUpload = $_arr_inputUpload;

    return $_arr_inputUpload;
  }


  public function inputCommon() {
    $_arr_inputParam = array(
      '__token__' => array('txt', ''),
    );

    $_arr_inputCommon = $this->obj_request->post($_arr_inputParam);

    $_mix_vld = $this->validate($_arr_inputCommon, '', 'common');

    if ($_mix_vld !== true) {
      return array(
        'rcode'     => 'x070201',
        'msg'       => end($_mix_vld),
      );
    }

    $_arr_inputCommon['rcode'] = 'y070201';

    $this->inputCommon = $_arr_inputCommon;

    return $_arr_inputCommon;
  }


  public function inputSubmit() {
    $_arr_inputParam = array(
      'attach_id'         => array('int', 0),
      'attach_name'       => array('str', ''),
      'attach_note'       => array('str', ''),
      'attach_ext'        => array('str', ''),
      'attach_mime'       => array('str', ''),
      'attach_box'        => array('str', ''),
      '__token__'         => array('str', ''),
    );

    $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

    if ($_arr_inputSubmit['attach_id'] > 0) {
      $_arr_attachRow = $this->check($_arr_inputSubmit['attach_id']);

      if ($_arr_attachRow['rcode'] != 'y070102') {
        return $_arr_attachRow;
      }

      $_str_vld = 'submit_edit';
    } else {
      $_str_vld = 'submit_add';
    }

    $_mix_vld = $this->validate($_arr_inputSubmit, '', $_str_vld);

    if ($_mix_vld !== true) {
      return array (
        'rcode' => 'x070201',
        'msg'   => end($_mix_vld),
      );
    }

    $_arr_inputSubmit['rcode'] = 'y070201';

    $this->inputSubmit = $_arr_inputSubmit;

    return $_arr_inputSubmit;
  }


  public function inputFix() {
    $_arr_inputParam = array(
      'attach_id'         => array('int', 0),
      '__token__'         => array('txt', ''),
    );

    $_arr_inputFix = $this->obj_request->post($_arr_inputParam);

    $_mix_vld = $this->validate($_arr_inputFix, '', 'fix');

    if ($_mix_vld !== true) {
      return array(
        'rcode'     => 'x070201',
        'msg'       => end($_mix_vld),
      );
    }

    $_arr_inputFix['rcode'] = 'y070201';

    $this->inputFix = $_arr_inputFix;

    return $_arr_inputFix;
  }


  public function inputClear() {
    $_arr_inputParam = array(
      'max_id'    => array('int', 0),
      '__token__' => array('txt', ''),
    );

    $_arr_inputClear = $this->obj_request->post($_arr_inputParam);

    $_mix_vld = $this->validate($_arr_inputClear, '', 'clear');

    if ($_mix_vld !== true) {
      return array(
        'rcode'     => 'x070201',
        'msg'       => end($_mix_vld),
      );
    }

    $_arr_inputClear['rcode'] = 'y070201';

    $this->inputClear = $_arr_inputClear;

    return $_arr_inputClear;
  }


  public function inputBox() {
    $_arr_inputParam = array(
      'attach_ids' => array('arr', array()),
      'act'        => array('txt', ''),
      '__token__'  => array('txt', ''),
    );

    $_arr_inputBox = $this->obj_request->post($_arr_inputParam);

    //print_r($_arr_inputBox);

    $_arr_inputBox['attach_ids'] = Arrays::unique($_arr_inputBox['attach_ids']);

    $_mix_vld = $this->validate($_arr_inputBox, '', 'status');

    if ($_mix_vld !== true) {
      return array(
        'rcode'     => 'x070201',
        'msg'       => end($_mix_vld),
      );
    }

    $_arr_inputBox['rcode'] = 'y070201';

    $this->inputBox = $_arr_inputBox;

    return $_arr_inputBox;
  }


  public function inputDelete() {
    $_arr_inputParam = array(
      'attach_ids' => array('arr', array()),
      '__token__'  => array('txt', ''),
    );

    $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

    //print_r($_arr_inputDelete);

    $_arr_inputDelete['attach_ids'] = Arrays::unique($_arr_inputDelete['attach_ids']);

    $_mix_vld = $this->validate($_arr_inputDelete, '', 'delete');

    if ($_mix_vld !== true) {
      return array(
        'rcode'     => 'x070201',
        'msg'       => end($_mix_vld),
      );
    }

    $_arr_inputDelete['rcode'] = 'y070201';

    $this->inputDelete = $_arr_inputDelete;

    return $_arr_inputDelete;
  }


  protected function rowProcess($arr_attachRow = array()) {
    $arr_attachRow = parent::rowProcess($arr_attachRow);
    $_str_attachNamePath                = $this->nameProcess($arr_attachRow, DS);
    $arr_attachRow['attach_path_name']  = $_str_attachNamePath;
    $arr_attachRow['attach_path']       = GK_PATH_ATTACH . $_str_attachNamePath;

    return $arr_attachRow;
  }


  private function insertProcess($arr_attachData) {
    $_num_attachId = $this->insert($arr_attachData);

    //print_r($_num_attachId);

    if ($_num_attachId > 0) { //数据库插入是否成功
      $_str_rcode = 'y070101';
      $_str_msg   = 'Add attachment successfully';
    } else {
      $_str_rcode = 'x070101';
      $_str_msg   = 'Add attachment failed';
    }

    return array(
      'attach_id' => $_num_attachId,
      'rcode'     => $_str_rcode,
      'msg'       => $_str_msg,
    );
  }


  private function updateProcess($arr_attachData, $num_attachId) {
    $_num_count = $this->where('attach_id', '=', $num_attachId)->update($arr_attachData);

    if ($_num_count > 0) {
      $_str_rcode = 'y070103'; //更新成功
      $_str_msg   = 'Update attachment successfully';
    } else {
      $_str_rcode = 'x070103';
      $_str_msg   = 'Did not make any changes';
    }

    return array(
      'attach_id' => $num_attachId,
      'count'     => $_num_count,
      'rcode'     => $_str_rcode,
      'msg'       => $_str_msg,
    );
  }
}
