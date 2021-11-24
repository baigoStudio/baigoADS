<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Admin as Admin_Base;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------管理员模型-------------*/
class Login extends Admin_Base {

  protected $table = 'admin';

  public $inputSubmit = array();

  public function login() {
    $_tm_timeLogin  = GK_NOW;
    $_str_adminIp   = $this->ip;

    $_arr_adminData = array(
      'admin_time_login'  => $_tm_timeLogin,
      'admin_ip'          => $_str_adminIp,
    );

    if ($this->inputSubmit['admin_access_token']) {
      $_arr_adminData['admin_access_token'] = $this->inputSubmit['admin_access_token'];
    }

    if ($this->inputSubmit['admin_access_expire']) {
      $_arr_adminData['admin_access_expire'] = $this->inputSubmit['admin_access_expire'];
    }

    if ($this->inputSubmit['admin_refresh_token']) {
      $_arr_adminData['admin_refresh_token'] = $this->inputSubmit['admin_refresh_token'];
    }

    if ($this->inputSubmit['admin_refresh_expire']) {
      $_arr_adminData['admin_refresh_expire'] = $this->inputSubmit['admin_refresh_expire'];
    }

    $_num_count = $this->where('admin_id', '=', $this->inputSubmit['admin_id'])->update($_arr_adminData); //更新数据

    if ($_num_count > 0) {
        $_str_rcode = 'y020103'; //更新成功
    } else {
      return array(
        'rcode' => 'x020103', //更新失败
      );
    }

    return array(
      'admin_id'          => $this->inputSubmit['admin_id'],
      //'admin_name'        => $arr_adminSubmit['admin_name'],
      'admin_ip'          => $_str_adminIp,
      'admin_time_login'  => $_tm_timeLogin,
      'rcode'             => $_str_rcode, //成功
    );
  }


  /** 登录验证
   * inputSubmit function.
   *
   * @access public
   * @return void
   */
  public function inputSubmit() {
    $_arr_inputParam = array(
      'admin_name'        => array('txt', ''),
      'admin_pass'        => array('txt', ''),
      'admin_remember'    => array('txt', ''),
      'captcha'           => array('txt', ''),
      '__token__'         => array('txt', ''),
    );

    $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

    $_mix_vld = $this->validate($_arr_inputSubmit, '', 'submit');

    if ($_mix_vld !== true) {
      return array(
        'rcode'     => 'x240201',
        'msg'       => end($_mix_vld),
      );
    }

    $_arr_inputSubmit['rcode'] = 'y020201';

    $this->inputSubmit = $_arr_inputSubmit;

    return $_arr_inputSubmit;
  }
}
