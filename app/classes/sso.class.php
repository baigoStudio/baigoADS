<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\classes;

use ginkgo\Sign;
use ginkgo\Crypt;
use ginkgo\Arrays;
use ginkgo\Config;
use ginkgo\Http;
use ginkgo\Request;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------单点登录类-------------*/
abstract class Sso {

  protected $dataCommon;
  protected $configSso;
  protected $obj_request;

  public function __construct() { //构造函数
    $_arr_config  = Config::get();

    $this->config       = Config::get('sso', 'var_extra');

    $this->dataCommon = array(
      'app_id'    => Config::get('app_id', 'var_extra.sso'), //APP ID
      'app_key'   => Config::get('app_key', 'var_extra.sso'), //APP KEY
    );

    $this->obj_http     = Http::instance();

    //print_r($this->obj_http);

    $this->obj_request  = Request::instance();
    $this->ip           = $this->obj_request->ip();
  }


  /** 解码
   * decode function.
   *
   * @access public
   * @return void
   */
  protected function decode($str_code, $str_sign) {
    $_arr_return = array();

    //解码
    $_str_decrypt = Crypt::decrypt($str_code, $this->config['app_key'], $this->config['app_secret']);

    if ($_str_decrypt === false) {
      return Crypt::getError();
    }

    //验证签名
    if (!Sign::check($_str_decrypt, $str_sign, $this->config['app_key'] . $this->config['app_secret'])) {
      return array(
        'rcode' => 'x050403',
        'msg'   => 'Signature is incorrect',
      );
    }

    $_arr_return = Arrays::fromJson($_str_decrypt);

    if (!isset($_arr_return['timestamp'])) {
      return array(
        'rcode' => 'x050201',
        'msg'   => 'Missing timestamp',
      );
    }


    return $_arr_return;
  }


  /**
   * resultCheck function.
   *
   * @access private
   * @return void
   */
  protected function resultCheck($arr_get) {
    //print_r($arr_get);
    //exit;

    if (!isset($arr_get['code'])) {
      return array(
        'rcode' => 'x030201',
        'msg'   => 'Missing encryption code',
      );
    }

    if (!isset($arr_get['sign'])) {
      return array(
        'rcode' => 'x030201',
        'msg'   => 'Missing signature',
      );
    }

    if (!isset($arr_get['msg'])) {
      $arr_get['msg'] = '';
    }

    return array(
      'rcode' => 'y030201',
      'msg'   => $arr_get['msg'],
    );
  }


  protected function verCheck($arr_get) {
    if (!isset($arr_get['prd_sso_ver']) || !isset($arr_get['prd_sso_pub'])) {
      return array(
        'rcode' => 'x030201',
        'msg'   => 'Missing version information',
      );
    }

    if ($arr_get['prd_sso_pub'] < 20200305) {
      return array(
        'rcode' => 'x030201',
        'msg'   => 'SSO version must be above 4.0!',
      );
    }

    if (!isset($arr_get['msg'])) {
      $arr_get['msg'] = '';
    }

    return array(
      'rcode' => 'y030201',
      'msg'   => $arr_get['msg'],
    );
  }
}
