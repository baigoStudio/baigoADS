<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\classes\install\sso;

use app\classes\Sso;
use ginkgo\Loader;
use ginkgo\Config;
use ginkgo\Arrays;
use ginkgo\Sign;
use ginkgo\Func;
use ginkgo\File;
use ginkgo\Crypt;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------单点登录类-------------*/
class Install extends Sso {

  public function __construct() { //构造函数
    parent::__construct();

    $_str_baseUrl = Config::get('sso_url', 'install');

    $this->urlPrefix = $_str_baseUrl . '/install/';
  }


  public function security() {
    $_arr_code = array(
      'timestamp' => GK_NOW,
      'secret'    => $this->security['secret'],
    );

    $_str_code = Arrays::toJson($_arr_code);

    $_arr_data = array(
      'key'   => $this->security['key'],
      'code'  => $_str_code,
      'sign'  => Sign::make($_str_code, $this->security['key']),
    );

    $_arr_get = $this->obj_http->request($this->urlPrefix . 'security/', $_arr_data, 'post'); //提交

    //print_r($this->obj_http->getResult());

    if ($_arr_get['rcode'] != 'y030401') {
      return $_arr_get; //返回错误信息
    }

    $_arr_result  = $this->verCheck($_arr_get);

    if ($_arr_result['rcode'] != 'y030201') {
      return $_arr_result; //返回错误信息
    }

    return $_arr_get;
  }


  public function dbconfig($dbconfig) {
    $dbconfig['prefix']      = 'sso_';
    $dbconfig['timestamp']   = GK_NOW;

    $_str_crypt = Arrays::toJson($dbconfig);

    $_str_encrypt = Crypt::encrypt($_str_crypt, $this->security['key'], $this->security['secret']);

    if ($_str_encrypt === false) {
      return array(
        'msg'   => Crypt::getError(),
        'rocde' => 'x030407',
      );
    }

    $_arr_data = array(
      'key'   => $this->security['key'],
      'code'  => $_str_encrypt,
      'sign'  => Sign::make($_str_crypt, $this->security['key'] . $this->security['secret']),
    );

    $_arr_get = $this->obj_http->request($this->urlPrefix . 'dbconfig/', $_arr_data, 'post'); //提交

    //print_r($this->obj_http->getResult());

    if ($_arr_get['rcode'] != 'y030201') {
      return $_arr_get; //返回错误信息
    }

    $_arr_result  = $this->verCheck($_arr_get);

    if ($_arr_result['rcode'] != 'y030201') {
      return $_arr_result; //返回错误信息
    }

    return $_arr_get;
  }


  public function getStatus() {
    $_arr_crypt = array(
      'timestamp' => GK_NOW,
    );

    $_str_crypt = Arrays::toJson($_arr_crypt);

    $_str_encrypt = Crypt::encrypt($_str_crypt, $this->security['key'], $this->security['secret']);

    if ($_str_encrypt === false) {
      return array(
        'msg'   => Crypt::getError(),
        'rocde' => 'x030407',
      );
    }

    $_arr_data = array(
      'key'   => $this->security['key'],
      'code'  => $_str_encrypt,
      'sign'  => Sign::make($_str_crypt, $this->security['key'] . $this->security['secret']),
    );

    $_arr_get = $this->obj_http->request($this->urlPrefix . 'get_status/', $_arr_data, 'get'); //提交

    //print_r($this->obj_http->getResult());

    if ($_arr_get['rcode'] != 'y030402') {
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

    $_arr_decode['rcode'] = 'y030402';

    return $_arr_decode;
  }


  public function data() {
    $_arr_crypt = array(
      'timestamp' => GK_NOW,
    );

    $_str_crypt = Arrays::toJson($_arr_crypt);

    $_str_encrypt = Crypt::encrypt($_str_crypt, $this->security['key'], $this->security['secret']);

    if ($_str_encrypt === false) {
      return array(
        'msg'   => Crypt::getError(),
        'rocde' => 'x030407',
      );
    }

    $_arr_data = array(
      'key'   => $this->security['key'],
      'code'  => $_str_encrypt,
      'sign'  => Sign::make($_str_crypt, $this->security['key'] . $this->security['secret']),
    );

    $_arr_get = $this->obj_http->request($this->urlPrefix . 'data/', $_arr_data, 'post'); //提交

    //print_r($this->obj_http->getResult());

    if ($_arr_get['rcode'] != 'y030401') {
      return $_arr_get; //返回错误信息
    }

    $_arr_result  = $this->verCheck($_arr_get);

    if ($_arr_result['rcode'] != 'y030201') {
      return $_arr_result; //返回错误信息
    }

    return $_arr_get;
  }


  public function admin($str_adminName, $str_adminPass, $str_adminMail = '') {
    $_arr_crypt = array(
      'admin_name'    => $str_adminName,
      'admin_pass'    => md5($str_adminPass),
      'admin_mail'    => $str_adminMail,
      'timestamp'     => GK_NOW,
    );

    $_str_crypt = Arrays::toJson($_arr_crypt);

    $_str_encrypt = Crypt::encrypt($_str_crypt, $this->security['key'], $this->security['secret']);

    if ($_str_encrypt === false) {
      return array(
        'msg'   => Crypt::getError(),
        'rocde' => 'x030407',
      );
    }

    $_arr_data = array(
      'key'   => $this->security['key'],
      'code'  => $_str_encrypt,
      'sign'  => Sign::make($_str_crypt, $this->security['key'] . $this->security['secret']),
    );

    $_arr_get = $this->obj_http->request($this->urlPrefix . 'admin/', $_arr_data, 'post'); //提交

    //print_r($this->obj_http->getResult());

    if ($_arr_get['rcode'] != 'y020101') {
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


  public function over() {
    $_arr_crypt = array(
      'app_name'          => 'baigo ADS',
      'app_url_notify'    => $this->obj_request->baseUrl(true) . 'sso/notify',
      'app_url_sync'      => $this->obj_request->baseUrl(true) . 'sso/sync',
      'timestamp'         => GK_NOW,
    );

    $_str_crypt = Arrays::toJson($_arr_crypt);

    $_str_encrypt = Crypt::encrypt($_str_crypt, $this->security['key'], $this->security['secret']);

    if ($_str_encrypt === false) {
      return array(
        'msg'   => Crypt::getError(),
        'rocde' => 'x030407',
      );
    }

    $_arr_data = array(
      'key'   => $this->security['key'],
      'code'  => $_str_encrypt,
      'sign'  => Sign::make($_str_crypt, $this->security['key'] . $this->security['secret']),
    );

    $_arr_get = $this->obj_http->request($this->urlPrefix . 'over/', $_arr_data, 'post'); //提交

    if ($_arr_get['rcode'] != 'y050101') {
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


  public function decode($str_code, $str_sign) {
    $_arr_return = array();

    //解码
    $_str_decrypt = Crypt::decrypt($str_code, $this->security['key'], $this->security['secret']);

    if ($_str_decrypt === false) {
      return array(
        'msg'   => Crypt::getError(),
        'rocde' => 'x030408',
      );
    }

    //验证签名
    if (!Sign::check($_str_decrypt, $str_sign, $this->security['key'] . $this->security['secret'])) {
      return array(
        'rcode' => 'x030406',
        'msg'   => 'Signature is incorrect',
      );
    }

    $_arr_return = Arrays::fromJson($_str_decrypt);

    if (!isset($_arr_return['timestamp'])) {
      return array(
        'rcode' => 'x030201',
        'msg'   => 'Missing timestamp',
      );
    }

    return $_arr_return;
  }


  private function chkInstall($arr_get) {
    if (!isset($arr_get['rcode'])) {
      return array(
        'rcode' => 'x030201',
        'msg'   => 'Missing return code',
      );
    }

    if ($arr_get['rcode'] != 'y030402') {
      return array(
        'rcode' => 'x030201',
        'msg'   => 'Missing return code',
      );
    }

    return array(
      'rcode' => 'y030201',
      'msg'   => $arr_get['msg'],
    );
  }


  public function securityProcess() {
    $_str_path = GK_PATH_TEMP . 'security' . GK_EXT_INC;

    $_arr_outPut = array(
      'key'       => Func::rand(),
      'secret'    => Func::rand(16),
    );

    if (File::fileHas($_str_path)) {
      $_arr_security  = Loader::load($_str_path);

      if (!isset($_arr_security['key']) || !isset($_arr_security['secret'])) {
        $_num_size   = Config::Write($_str_path, $_arr_outPut);

        $_arr_security  = Loader::load($_str_path);

        if (!isset($_arr_security['key']) || !isset($_arr_security['secret'])) {
          return array(
            'rcode' => 'x030204',
            'msg'   => 'Installation type is not set',
          );
        }
      }

      $this->security = $_arr_security;
    } else {
      $_num_size   = Config::Write($_str_path, $_arr_outPut);
    }

    return true;
  }
}
