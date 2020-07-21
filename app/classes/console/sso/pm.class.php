<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\classes\console\sso;

use app\classes\Sso;
use ginkgo\Json;
use ginkgo\Crypt;
use ginkgo\Sign;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------单点登录类-------------*/
class Pm extends Sso {

    function __construct() { //构造函数
        parent::__construct();

        $this->urlPrefix = $this->config['base_url'] . '/pm/';
    }


    function send($str_user, $str_by = 'user_id', $_arr_pmSubmit = array()) {
        $_arr_crypt = array(
            $str_by             => $str_user,
            'user_access_token' => md5($_arr_pmSubmit['user_access_token']),
            'pm_to_name'        => $_arr_pmSubmit['pm_to_name'],
            'pm_title'          => $_arr_pmSubmit['pm_title'],
            'pm_content'        => $_arr_pmSubmit['pm_content'],
            'timestamp'         => GK_NOW,
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

        $_arr_get     = $this->obj_http->request($this->urlPrefix . 'send/', $_arr_ssoData, 'post'); //提交

        //print_r($this->obj_http->getResult());

        if (!isset($_arr_get['rcode'])) {
            return array(
                'rcode' => 'x030201',
                'msg'   => 'Missing rcode',
            );
        }

        return $_arr_get;
    }


    function status($str_user, $str_by = 'user_id', $_arr_pmSubmit = array()) {
        $_arr_crypt = array(
            $str_by             => $str_user,
            'user_access_token' => md5($_arr_pmSubmit['user_access_token']),
            'pm_ids'            => $_arr_pmSubmit['pm_ids'],
            'pm_status'         => $_arr_pmSubmit['pm_status'],
            'timestamp'         => GK_NOW,
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

        $_arr_get     = $this->obj_http->request($this->urlPrefix . 'status/', $_arr_ssoData, 'post'); //提交

        if (!isset($_arr_get['rcode'])) {
            return array(
                'rcode' => 'x030201',
                'msg'   => 'Missing rcode',
            );
        }

        return $_arr_get;
    }


    function revoke($str_user, $str_by = 'user_id', $_arr_pmSubmit = array()) {
        $_arr_crypt = array(
            $str_by             => $str_user,
            'user_access_token' => md5($_arr_pmSubmit['user_access_token']),
            'pm_ids'            => $_arr_pmSubmit['pm_ids'],
            'timestamp'         => GK_NOW,
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

        $_arr_get     = $this->obj_http->request($this->urlPrefix . 'revoke/', $_arr_ssoData, 'post'); //提交

        //print_r($this->obj_http->getResult());

        if (!isset($_arr_get['rcode'])) {
            return array(
                'rcode' => 'x030201',
                'msg'   => 'Missing rcode',
            );
        }

        return $_arr_get;
    }


    function delete($str_user, $str_by = 'user_id', $_arr_pmSubmit = array()) {
        $_arr_crypt = array(
            $str_by             => $str_user,
            'user_access_token' => md5($_arr_pmSubmit['user_access_token']),
            'pm_ids'            => $_arr_pmSubmit['pm_ids'],
            'timestamp'         => GK_NOW,
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

        $_arr_get     = $this->obj_http->request($this->urlPrefix . 'delete/', $_arr_ssoData, 'post'); //提交

        //print_r($this->obj_http->getResult());

        if (!isset($_arr_get['rcode'])) {
            return array(
                'rcode' => 'x030201',
                'msg'   => 'Missing rcode',
            );
        }

        return $_arr_get;
    }


    function read($str_user, $str_by = 'user_id', $_arr_pmSubmit = array()) {
        $_arr_crypt = array(
            $str_by             => $str_user,
            'user_access_token' => md5($_arr_pmSubmit['user_access_token']),
            'pm_id'             => $_arr_pmSubmit['pm_id'],
            'timestamp'         => GK_NOW,
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

        $_arr_get     = $this->obj_http->request($this->urlPrefix . 'read/', $_arr_ssoData, 'get'); //提交

        if (!isset($_arr_get['rcode'])) {
            return array(
                'rcode' => 'x030201',
                'msg'   => 'Missing rcode',
            );
        }

        if ($_arr_get['rcode'] != 'y110102') {
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


    function lists($str_user, $str_by = 'user_id', $_arr_pmSubmit = array()) {
        $_arr_crypt = array(
            $str_by             => $str_user,
            'user_access_token' => md5($_arr_pmSubmit['user_access_token']),
            'pm_type'           => $_arr_pmSubmit['pm_type'],
            'pm_status'         => $_arr_pmSubmit['pm_status'],
            'key'               => $_arr_pmSubmit['key'],
            'page'              => $_arr_pmSubmit['page'],
            'timestamp'         => GK_NOW,
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

        $_arr_get     = $this->obj_http->request($this->urlPrefix . 'lists/', $_arr_ssoData, 'get'); //提交

        //print_r($this->obj_http->getResult());

        if (!isset($_arr_get['rcode'])) {
            return array(
                'rcode' => 'x030201',
                'msg'   => 'Missing rcode',
            );
        }

        if ($_arr_get['rcode'] != 'y110102') {
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


    function check($str_user, $str_by = 'user_id', $str_accessToken = '') {
        $_arr_crypt = array(
            $str_by             => $str_user,
            'user_access_token' => md5($str_accessToken),
            'timestamp'         => GK_NOW,
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

        $_arr_get     = $this->obj_http->request($this->urlPrefix . 'check/', $_arr_ssoData, 'get'); //提交

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
