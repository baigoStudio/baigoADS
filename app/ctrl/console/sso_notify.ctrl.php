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

class Sso_Notify extends Ctrl_Sso {

  protected function c_init($param = array()) { //构造函数
    parent::c_init();

    $this->mdl_notify   = Loader::model('Sso_Notify');
  }


  public function index() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    $_mixt_return = array();

    switch ($this->inputRoute['a']) {
        case 'test':
          $_mixt_return = $this->test();
        break;

        case 'info':
          $_mixt_return = $this->info();
        break;

        default:
        break;
    }

    return $this->json($_mixt_return);
  }


  private function info() {
    $_arr_inputInfo = $this->mdl_notify->inputInfo($this->decryptRow);

    if ($_arr_inputInfo['rcode'] != 'y100201') {
      return $_arr_inputInfo;
    }

    $_arr_return = array(
      'msg' => 'success',
    );

    return $_arr_return;
  }


  private function test() {
    $_arr_inputTest = $this->mdl_notify->inputTest($this->decryptRow);

    if ($_arr_inputTest['rcode'] != 'y100201') {
      return $_arr_inputTest;
    }

    //print_r($_arr_inputTest);

    return $_arr_inputTest;
  }
}
