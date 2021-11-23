<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\classes\console\sso;

use app\classes\Sso;
use ginkgo\Arrays;
use ginkgo\Sign;
use ginkgo\Crypt;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------单点登录类-------------*/
class Base extends Sso {

  public function __construct() { //构造函数
    parent::__construct();

    $this->urlPrefix = $this->config['base_url'] . '/base/';
  }


  public function pm() {
    $_arr_crypt = array(
      'timestamp' => GK_NOW,
    );

    $_str_crypt   = Arrays::toJson($_arr_crypt);

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

    $_arr_get = $this->obj_http->request($this->urlPrefix . 'pm/', $_arr_ssoData, 'get'); //提交

    //print_r($this->obj_http->getResult());

    return $_arr_get;
  }


  public function urls() {
    $_arr_crypt = array(
      'timestamp' => GK_NOW,
    );

    $_str_crypt   = Arrays::toJson($_arr_crypt);

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

    $_arr_get = $this->obj_http->request($this->urlPrefix . 'urls/', $_arr_ssoData, 'get'); //提交

    //print_r($this->obj_http->getResult());

    return $_arr_get;
  }
}
