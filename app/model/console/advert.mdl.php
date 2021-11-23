<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Advert as Advert_Base;
use ginkgo\Func;
use ginkgo\Arrays;
use ginkgo\Strings;
use ginkgo\Html;
use ginkgo\Plugin;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------应用模型-------------*/
class Advert extends Advert_Base {

  public $inputSubmit  = array();
  public $inputDelete  = array();
  public $inputStatus  = array();

  /** 提交
   * mdl_submit function.
   *
   * @access public
   * @return void
   */
  public function submit() {
    $_arr_advertData = array(
      'advert_name'        => $this->inputSubmit['advert_name'],
      'advert_posi_id'     => $this->inputSubmit['advert_posi_id'],
      'advert_attach_id'   => $this->inputSubmit['advert_attach_id'],
      'advert_content'     => $this->inputSubmit['advert_content'],
      'advert_type'        => $this->inputSubmit['advert_type'],
      'advert_url'         => $this->inputSubmit['advert_url'],
      'advert_percent'     => $this->inputSubmit['advert_percent'],
      'advert_note'        => $this->inputSubmit['advert_note'],
      'advert_status'      => $this->inputSubmit['advert_status'],
    );

    if (isset($this->inputSubmit['advert_admin_id'])) {
      $_arr_advertData['advert_admin_id'] = $this->inputSubmit['advert_admin_id'];
    }

    if (isset($this->inputSubmit['advert_begin_format'])) {
      $_arr_advertData['advert_begin'] = Strings::toTime($this->inputSubmit['advert_begin_format']);
    } else if (isset($this->inputSubmit['advert_begin'])) {
      $_arr_advertData['advert_begin'] = $this->inputSubmit['advert_begin'];
    } else {
      $_arr_advertData['advert_begin'] = GK_NOW;
    }

    switch ($_arr_advertData['advert_type']) {
      case 'date':
        $_arr_advertData['advert_opt'] = Strings::toTime($this->inputSubmit['advert_opt_time_format']);
      break;

      case 'show':
        $_arr_advertData['advert_opt'] = $this->inputSubmit['advert_opt_show'];
      break;

      case 'hit':
        $_arr_advertData['advert_opt'] = $this->inputSubmit['advert_opt_hit'];
      break;
    }

    if ($this->inputSubmit['advert_id'] > 0) {
      $_str_hook = 'edit'; //编辑文章时触发
    } else {
      $_str_hook = 'add';
    }

    $_arr_advertData      = Plugin::listen('filter_console_advert_' . $_str_hook, $_arr_advertData);

    $_mix_vld = $this->validate($_arr_advertData, '', 'submit_db');

    if ($_mix_vld !== true) {
      return array(
        'advert_id' => $this->inputSubmit['advert_id'],
        'rcode'     => 'x080201',
        'msg'       => end($_mix_vld),
      );
    }

    if ($this->inputSubmit['advert_id'] > 0) {
      $_num_advertId   = $this->inputSubmit['advert_id'];
      $_num_count      = $this->where('advert_id', '=', $_num_advertId)->update($_arr_advertData); //更新数据
      if ($_num_count > 0) {
        $_str_rcode = 'y080103'; //更新成功
        $_str_msg   = 'Update advertisement successfully';
      } else {
        $_str_rcode = 'x080103';
        $_str_msg   = 'Did not make any changes';
      }
    } else {
      $_arr_insert = array(
        'advert_time' => GK_NOW,
      );
      $_arr_data = array_replace_recursive($_arr_advertData, $_arr_insert);

      $_num_advertId = $this->insert($_arr_data); //更新数据
      if ($_num_advertId > 0) {
        $_str_rcode = 'y080101'; //更新成功
        $_str_msg   = 'Add advertisement successfully';
      } else {
        $_str_rcode = 'x080101';
        $_str_msg   = 'Add advertisement failed';
      }
    }

    return array(
      'advert_id' => $_num_advertId,
      'rcode'     => $_str_rcode, //成功
      'msg'       => $_str_msg,
    );
  }


  /** 更改状态
   * mdl_status function.
   *
   * @access public
   * @param mixed $str_status
   * @return void
   */
  public function status() {
    $_arr_advertUpdate = array(
      'advert_status'     => $this->inputStatus['act'],
      'advert_approve_id' => $this->inputStatus['advert_approve_id'],
    );

    $_num_count = $this->where('advert_id', 'IN', $this->inputStatus['advert_ids'], 'advert_ids')->update($_arr_advertUpdate); //删除数据

    //如影响行数大于0则返回成功
    if ($_num_count > 0) {
      $_str_rcode = 'y080103'; //成功
      $_str_msg   = 'Successfully updated {:count} advertisements';
    } else {
      $_str_rcode = 'x080103'; //失败
      $_str_msg   = 'Did not make any changes';
    }

    return array(
      'rcode' => $_str_rcode,
      'count' => $_num_count,
      'msg'   => $_str_msg,
    );
  }


  /** 删除
   * mdl_del function.
   *
   * @access public
   * @return void
   */
  public function delete() {
    $_num_count = $this->where('advert_id', 'IN', $this->inputDelete['advert_ids'], 'advert_ids')->delete(); //删除数据

    //如车影响行数小于0则返回错误
    if ($_num_count > 0) {
      $_str_rcode = 'y080104'; //成功
      $_str_msg   = 'Successfully deleted {:count} advertisements';
    } else {
      $_str_rcode = 'x080104'; //失败
      $_str_msg   = 'No advertisement have been deleted';
    }

    return array(
      'rcode' => $_str_rcode,
      'count' => $_num_count,
      'msg'   => $_str_msg,
    );
  }


  public function inputSubmit() {
    $_arr_inputParam = array(
      'advert_id'                 => array('int', 0),
      'advert_name'               => array('txt', ''),
      'advert_posi_id'            => array('int', 0),
      'advert_attach_id'          => array('int', 0),
      'advert_content'            => array('txt', ''),
      'advert_type'               => array('txt', ''),
      'advert_status'             => array('txt', ''),
      'advert_opt_time_format'    => array('txt', ''),
      'advert_opt_show'           => array('int', 0),
      'advert_opt_hit'            => array('int', 0),
      'advert_url'                => array('txt', ''),
      'advert_percent'            => array('txt', ''),
      'advert_begin_format'       => array('txt', ''),
      'advert_note'               => array('txt', ''),
      '__token__'                 => array('txt', ''),
    );

    $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

    $_arr_inputSubmit['advert_opt_time_format']   = Html::decode($_arr_inputSubmit['advert_opt_time_format'], 'date_time');
    $_arr_inputSubmit['advert_begin_format']      = Html::decode($_arr_inputSubmit['advert_begin_format'], 'date_time');

    $_mix_vld = $this->validate($_arr_inputSubmit, '', 'submit');

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x080201',
        'msg'   => end($_mix_vld),
      );
    }

    if ($_arr_inputSubmit['advert_id'] > 0) {
      $_arr_advertRow = $this->check($_arr_inputSubmit['advert_id']);

      if ($_arr_advertRow['rcode'] != 'y080102') {
        return $_arr_advertRow;
      }
    }

    $_arr_inputSubmit['rcode'] = 'y080201';

    $this->inputSubmit = $_arr_inputSubmit;

    return $_arr_inputSubmit;
  }

  /** 选择 advert
   * input_ids function.
   *
   * @access public
   * @return void
   */
  public function inputStatus() {
    $_arr_inputParam = array(
      'advert_ids'    => array('arr', array()),
      'act'           => array('txt', ''),
      '__token__'     => array('txt', ''),
    );

    $_arr_inputStatus = $this->obj_request->post($_arr_inputParam);

    //print_r($_arr_inputStatus);

    $_arr_inputStatus['advert_ids'] = Arrays::filter($_arr_inputStatus['advert_ids']);

    $_mix_vld = $this->validate($_arr_inputStatus, '', 'status');

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x080201',
        'msg'   => end($_mix_vld),
      );
    }

    $_arr_inputStatus['rcode'] = 'y080201';

    $this->inputStatus = $_arr_inputStatus;

    return $_arr_inputStatus;
  }


  public function inputDelete() {
    $_arr_inputParam = array(
      'advert_ids'    => array('arr', array()),
      '__token__'     => array('txt', ''),
    );

    $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

    $_arr_inputDelete['advert_ids'] = Arrays::filter($_arr_inputDelete['advert_ids']);

    $_mix_vld = $this->validate($_arr_inputDelete, '', 'delete');

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x080201',
        'msg'   => end($_mix_vld),
      );
    }

    $_arr_inputDelete['rcode'] = 'y080201';

    $this->inputDelete = $_arr_inputDelete;

    return $_arr_inputDelete;
  }
}
