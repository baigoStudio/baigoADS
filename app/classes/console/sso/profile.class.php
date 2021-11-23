<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\classes\console\sso;

use app\classes\Sso;
use ginkgo\Func;
use ginkgo\Arrays;
use ginkgo\Sign;
use ginkgo\Crypt;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------单点登录类-------------*/
class Profile extends Sso {

  public function __construct() { //构造函数
    parent::__construct();

    $this->urlPrefix = $this->config['base_url'] . '/profile/';
  }


  public function info($num_userId, $arr_userSubmit = array()) {
    $_arr_crypt = array(
      'user_id'   => $num_userId,
      'user_pass' => md5($arr_userSubmit['user_pass']),
      'timestamp' => GK_NOW,
    );

    if (isset($arr_userSubmit['user_nick']) && Func::notEmpty($arr_userSubmit['user_nick'])) {
      $_arr_crypt['user_nick'] = $arr_userSubmit['user_nick'];
    }

    $_str_crypt = Arrays::toJson($_arr_crypt);

    $_str_encrypt = Crypt::encrypt($_str_crypt, $this->config['app_key'], $this->config['app_secret']);

    if ($_str_encrypt === false) {
      return array(
        'error' => Crypt::getError(),
      );
    }

    $_arr_sso = array(
      'code'  => $_str_encrypt,
      'sign'  => Sign::make($_str_crypt, $this->config['app_key'] . $this->config['app_secret']),
    );

    $_arr_ssoData = array_replace_recursive($this->dataCommon, $_arr_sso);

    $_arr_get     = $this->obj_http->request($this->urlPrefix . 'info/', $_arr_ssoData, 'post'); //提交

    if (!isset($_arr_get['rcode'])) {
      return array(
        'rcode' => 'x030201',
        'msg'   => 'Missing rcode',
      );
    }

    return $_arr_get;
  }


  public function pass($num_userId, $arr_userSubmit = array()) {
    $_arr_crypt = array(
      'user_id'       => $num_userId,
      'user_pass'     => md5($arr_userSubmit['user_pass']),
      'user_pass_new' => md5($arr_userSubmit['user_pass_new']),
      'timestamp'     => GK_NOW,
    );

    $_str_crypt = Arrays::toJson($_arr_crypt);

    $_str_encrypt = Crypt::encrypt($_str_crypt, $this->config['app_key'], $this->config['app_secret']);

    if ($_str_encrypt === false) {
      return array(
        'error' => Crypt::getError(),
      );
    }

    $_arr_sso = array(
      'code'  => $_str_encrypt,
      'sign'  => Sign::make($_str_crypt, $this->config['app_key'] . $this->config['app_secret']),
    );

    $_arr_ssoData = array_replace_recursive($this->dataCommon, $_arr_sso);

    $_arr_get     = $this->obj_http->request($this->urlPrefix . 'pass/', $_arr_ssoData, 'post'); //提交

    if (!isset($_arr_get['rcode'])) {
      return array(
        'rcode' => 'x030201',
        'msg'   => 'Missing rcode',
      );
    }

    return $_arr_get;
  }


  public function secqa($num_userId, $arr_userSubmit = array()) {
    $_arr_crypt = array(
      'user_id'       => $num_userId,
      'user_pass'     => md5($arr_userSubmit['user_pass']),
      'user_sec_ques' => $arr_userSubmit['user_sec_ques'],
      'user_sec_answ' => md5(Arrays::toJson($arr_userSubmit['user_sec_answ'])),
      'timestamp'     => GK_NOW,
    );

    $_str_crypt = Arrays::toJson($_arr_crypt);

    $_str_encrypt = Crypt::encrypt($_str_crypt, $this->config['app_key'], $this->config['app_secret']);

    if ($_str_encrypt === false) {
      return array(
        'error' => Crypt::getError(),
      );
    }

    $_arr_sso = array(
      'code'  => $_str_encrypt,
      'sign'  => Sign::make($_str_crypt, $this->config['app_key'] . $this->config['app_secret']),
    );

    $_arr_ssoData = array_replace_recursive($this->dataCommon, $_arr_sso);

    $_arr_get     = $this->obj_http->request($this->urlPrefix . 'secqa/', $_arr_ssoData, 'post'); //提交

    //print_r($this->obj_http->getResult());

    if (!isset($_arr_get['rcode'])) {
      return array(
        'rcode' => 'x030201',
        'msg'   => 'Missing rcode',
      );
    }

    return $_arr_get;
  }


  public function mailbox($num_userId, $arr_userSubmit = array()) {
    $_arr_crypt = array(
      'user_id'       => $num_userId,
      'user_pass'     => md5($arr_userSubmit['user_pass']),
      'user_mail_new' => $arr_userSubmit['user_mail_new'],
      'timestamp'     => GK_NOW,
    );

    $_str_crypt = Arrays::toJson($_arr_crypt);

    $_str_encrypt = Crypt::encrypt($_str_crypt, $this->config['app_key'], $this->config['app_secret']);

    if ($_str_encrypt === false) {
      return array(
        'error' => Crypt::getError(),
      );
    }

    $_arr_sso = array(
      'code'  => $_str_encrypt,
      'sign'  => Sign::make($_str_crypt, $this->config['app_key'] . $this->config['app_secret']),
    );

    $_arr_ssoData = array_replace_recursive($this->dataCommon, $_arr_sso);

    $_arr_get     = $this->obj_http->request($this->urlPrefix . 'mailbox/', $_arr_ssoData, 'post'); //提交

    if (!isset($_arr_get['rcode'])) {
      return array(
        'rcode' => 'x030201',
        'msg'   => 'Missing rcode',
      );
    }

    return $_arr_get;
  }


  public function tokenRefresh($num_userId, $str_refreshToken = '') {
    $_arr_crypt = array(
      'user_id'               => $num_userId,
      'user_refresh_token'    => md5($str_refreshToken),
      'timestamp'             => GK_NOW,
    );

    $_str_crypt = Arrays::toJson($_arr_crypt);

    $_str_encrypt = Crypt::encrypt($_str_crypt, $this->config['app_key'], $this->config['app_secret']);

    if ($_str_encrypt === false) {
      return array(
        'error' => Crypt::getError(),
      );
    }

    $_arr_sso = array(
      'code'  => $_str_encrypt,
      'sign'  => Sign::make($_str_crypt, $this->config['app_key'] . $this->config['app_secret']),
    );

    $_arr_ssoData = array_replace_recursive($this->dataCommon, $_arr_sso);

    $_arr_get     = $this->obj_http->request($this->urlPrefix . 'token/', $_arr_ssoData, 'post'); //提交

    //print_r($this->obj_http->getResult());

    if (!isset($_arr_get['rcode'])) {
      return array(
        'rcode' => 'x030201',
        'msg'   => 'Missing rcode',
      );
    }

    if ($_arr_get['rcode'] != 'y010103') {
      return $_arr_get;
    }

    $_arr_result  = $this->resultCheck($_arr_get);

    if ($_arr_result['rcode'] != 'y030201') {
      return $_arr_result; //返回错误信息
    }

    $_arr_result  = $this->verCheck($_arr_get);

    if ($_arr_result['rcode'] != 'y030201') {
      return $_arr_result; //返回错误信息
    }

    $_arr_decode = $this->decode($_arr_get['code'], $_arr_get['sign']); //解码

    return $_arr_decode;
  }
}
