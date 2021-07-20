<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\classes\console\sso;

use app\classes\Sso;
use ginkgo\Crypt;
use ginkgo\Sign;
use ginkgo\Arrays;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------单点登录类-------------*/
class User extends Sso {

    function __construct() { //构造函数
        parent::__construct();

        $this->urlPrefix = $this->config['base_url'] . '/user/';
    }


    /** 读取用户信息
     * read function.
     *
     * @access public
     * @param mixed $num_userId ID（或用户名）
     * @return 解码后数组 用户信息
     */
    function read($num_userId) {
        $_arr_crypt = array(
            'user_id'   => $num_userId,
            'timestamp' => GK_NOW,
        );

        //print_r($_arr_crypt);

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

        $_arr_get     = $this->obj_http->request($this->urlPrefix . 'read/', $_arr_ssoData, 'get');

        //print_r($this->obj_http->getResult());

        if (!isset($_arr_get['rcode'])) {
            return array(
                'rcode' => 'x030201',
                'msg'   => 'Missing rcode',
            );
        }

        if ($_arr_get['rcode'] != 'y010102') {
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


    /** 编辑用户
     * edit function.
     *
     * @access public
     * @param mixed $num_userId 用户名
     * @param string $str_checkPass (default: 'off') 是否验证密码（默认不验证）
     * @return 解码后数组 编辑结果
     */
    function edit($num_userId, $arr_userSubmit = array()) {
        $_arr_crypt = array(
            'user_id'   => $num_userId,
            'timestamp' => GK_NOW,
        );

        if (isset($arr_userSubmit['user_pass']) && !Func::isEmpty($arr_userSubmit['user_pass'])) {
            $_arr_crypt['user_pass'] = md5($arr_userSubmit['user_pass']);
        }

        if (isset($arr_userSubmit['user_mail_new']) && !Func::isEmpty($arr_userSubmit['user_mail_new'])) {
            $_arr_crypt['user_mail_new'] = $arr_userSubmit['user_mail_new'];
        }

        if (isset($arr_userSubmit['user_nick']) && !Func::isEmpty($arr_userSubmit['user_nick'])) {
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

        $_arr_get     = $this->obj_http->request($this->urlPrefix . 'edit/', $_arr_ssoData, 'post'); //提交

        //print_r($this->obj_http->getResult());

        if (!isset($_arr_get['rcode'])) {
            return array(
                'rcode' => 'x030201',
                'msg'   => 'Missing rcode',
            );
        }

        return $_arr_get;
    }
}
