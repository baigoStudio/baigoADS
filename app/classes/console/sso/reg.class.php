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
class Reg extends Sso {

    function __construct() { //构造函数
        parent::__construct();

        $this->urlPrefix = $this->config['base_url'] . '/reg/';
    }


    /** 注册
     * reg function.
     *
     * @access public
     * @param mixed $str_user 用户名
     * @param mixed $str_userPass 密码
     * @param string $str_userMail (default: '') Email
     * @param string $str_userNick (default: '') 昵称
     * @return 解码后数组 注册结果
     */
    function reg($arr_userSubmit = array()) {
        $_arr_crypt = array(
            'user_name' => $arr_userSubmit['user_name'],
            'user_pass' => md5($arr_userSubmit['user_pass']),
            'user_mail' => $arr_userSubmit['user_mail'],
            'user_nick' => $arr_userSubmit['user_nick'],
            'user_ip'   => $this->ip,
            'timestamp' => GK_NOW,
        );

        $_str_crypt = Json::encode($_arr_crypt);

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

        $_arr_ssoData = array_replace_recursive($this->dataCommon, $_arr_sso); //合并数组

        $_arr_get     = $this->obj_http->request($this->urlPrefix . 'reg/', $_arr_ssoData, 'post'); //提交

        //print_r($this->obj_http->getResult());

        if ($_arr_get['rcode'] != 'y010101') {
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

        //print_r($_arr_decode);

        return $_arr_decode;
    }


    /** 检查用户名
     * chkname function.
     *
     * @access public
     * @param mixed $str_userName 用户名
     * @return 解码后数组 检查结果
     */
    function chkname($str_userName) {
        $_arr_crypt = array(
            'user_name' => $str_userName,
            'timestamp' => GK_NOW,
        );

        $_str_crypt = Json::encode($_arr_crypt);

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

        $_arr_get     = $this->obj_http->request($this->urlPrefix . 'chkname/', $_arr_ssoData, 'get'); //提交

        //print_r($this->obj_http->getResult());

        return $_arr_get;
    }


    /** 检查 Email
     * chkmail function.
     *
     * @access public
     * @param mixed $str_userMail Email
     * @param int $num_userId (default: 0) 当前用户ID（默认为0，忽略）
     * @return 解码后数组 检查结果
     */
    function chkmail($str_userMail, $num_userId = 0) {
        $_arr_crypt = array(
            'user_mail' => $str_userMail,
            'not_id'    => $num_userId,
            'timestamp' => GK_NOW,
        );

        $_str_crypt = Json::encode($_arr_crypt);

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

        $_arr_get     = $this->obj_http->request($this->urlPrefix . 'chkmail/', $_arr_ssoData, 'get'); //提交

        return $_arr_get;
    }
}
