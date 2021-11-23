<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl_Sso;
use ginkgo\Loader;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Sso_Sync extends Ctrl_Sso {

  protected function c_init($param = array()) { //构造函数
    parent::c_init();

    $this->mdl_sync   = Loader::model('Sso_Sync');
  }


  public function index() {
    $_mix_init = $this->init(false);

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_mixt_return = array(
      'msg'   => 'error',
      'rcode' => 'x',
    );

    switch ($this->inputRoute['a']) {
      case 'login':
        $_mixt_return = $this->login();
      break;

      case 'logout':
        $_mixt_return = $this->logout();
      break;
    }

    return $this->fetchJsonp($_mixt_return['msg'], $_mixt_return['rcode']);
  }


  private function login() {
    $_arr_inputSync = $this->mdl_sync->inputSync($this->decryptRow);

    if ($_arr_inputSync['rcode'] != 'y100201') {
      return $_arr_inputSync;
    }

    $_arr_adminRow = $this->mdl_sync->read($_arr_inputSync['user_id']);
    if ($_arr_adminRow['rcode'] != 'y020102') {
      return $_arr_adminRow;
    }

    if ($_arr_adminRow['admin_status'] != 'enable') {
      return array(
        'msg'   => 'Administrator is disabled',
        'rcode' => 'x020402',
      );
    }

    $_arr_adminRow['admin_access_token']    = $_arr_inputSync['user_access_token'];
    $_arr_adminRow['admin_access_expire']   = $_arr_inputSync['user_access_expire'];
    $_arr_adminRow['admin_refresh_token']   = $_arr_inputSync['user_refresh_token'];
    $_arr_adminRow['admin_refresh_expire']  = $_arr_inputSync['user_refresh_expire'];

    $_arr_ssinRresult = $this->sessionLogin($_arr_adminRow, 'remember', 'sync');

    if ($_arr_ssinRresult['rcode'] != 'y020401') {
      return $_arr_ssinRresult;
    }

    return array(
      'msg'   => 'success',
      'rcode' => 'y',
    );
  }


  private function logout() {
    $_arr_inputSync = $this->mdl_sync->inputSync($this->decryptRow);

    if ($_arr_inputSync['rcode'] != 'y100201') {
      return array(
        'msg'   => $_arr_inputSync['msg'],
        'rcode' => $_arr_inputSync['rcode'],
      );
    }

    return array(
      'msg'   => 'success',
      'rcode' => 'y',
    );
  }
}
