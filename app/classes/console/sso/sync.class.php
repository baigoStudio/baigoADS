<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\classes\console\sso;

use app\classes\Sso;
use ginkgo\Arrays;
use ginkgo\Crypt;
use ginkgo\Sign;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------单点登录类-------------*/
class Sync extends Sso {

    function __construct() { //构造函数
        parent::__construct();

        $this->urlPrefix = $this->config['base_url'] . '/sync/';
    }


    /** 同步登录
     * sso_sync_login function.
     *
     * @access public
     * @param mixed $num_userId
     * @return void
     */
    function login($_arr_userSubmit = array()) {
        $_arr_crypt = array(
            'user_id'           => $_arr_userSubmit['user_id'],
            'user_access_token' => md5($_arr_userSubmit['user_access_token']),
            'timestamp'         => GK_NOW,
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

        $_arr_get     = $this->obj_http->request($this->urlPrefix . 'login/', $_arr_ssoData, 'post'); //提交

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
