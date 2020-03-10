<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\classes\console\sso;

use app\classes\Sso;
use ginkgo\Crypt;
use ginkgo\Sign;
use ginkgo\Json;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------单点登录类-------------*/
class Login extends Sso {

    function __construct() { //构造函数
        parent::__construct();

        $this->urlPrefix = $this->config['base_url'] . '/login/';
    }


    /** 登录
     * login function.
     *
     * @access public
     * @param mixed $str_userName 用户名
     * @param mixed $str_userPass 密码
     * @return 解码后数组 登录结果
     */
    function login($str_userName, $str_userPass) {
        $_arr_crypt = array(
            'user_name' => $str_userName,
            'user_pass' => md5($str_userPass),
            'user_ip'   => $this->ip,
            'timestamp' => GK_NOW,
        );

        $_str_crypt   = Json::encode($_arr_crypt);

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

        $_arr_get     = $this->obj_http->request($this->urlPrefix . 'login/', $_arr_ssoData, 'post'); //提交

        //print_r($this->obj_http->getResult());

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

        $_arr_decode          = $this->decode($_arr_get['code'], $_arr_get['sign']); //解码

        return $_arr_decode;
    }
}
