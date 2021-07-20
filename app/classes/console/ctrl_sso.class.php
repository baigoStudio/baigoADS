<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\classes\console;

use ginkgo\Loader;
use ginkgo\Crypt;
use ginkgo\Sign;
use ginkgo\Arrays;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}


/*-------------安装通用控制器-------------*/
class Ctrl_Sso extends Ctrl {

    protected $inputRoute;

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_base     = Loader::model('Sso_Base');
    }


    protected function init($is_notify = true) {
        $_arr_chkResult = $this->chkInput($is_notify);

        if (!Func::isEmpty($_arr_chkResult['rcode'])) {
            return $_arr_chkResult;
        }

        $this->inputRoute  = $this->mdl_base->inputRoute();

        //$this->generalData = array_replace_recursive($this->generalData, $_arr_data);

        return true;
    }


    protected function chkInput($is_notify = true) {
        $_str_rcode = '';
        $_str_msg   = '';

        $_arr_ssoVar        = $this->config['var_extra']['sso'];

        if ($is_notify) {
            $_str_scene = '';
        } else {
            $_str_scene = 'common';
        }

        $_arr_inputCommon   = $this->mdl_base->inputCommon($_str_scene);

        if ($_arr_inputCommon['rcode'] != 'y100201') {
            return array(
                'rcode' => $_arr_inputCommon['rcode'],
                'msg'   => $this->obj_lang->get($_arr_inputCommon['msg'], 'console.common'),
            );
        }

        if ($is_notify && $_arr_inputCommon['app_id'] != $_arr_ssoVar['app_id']) {
            return array(
                'rcode' => 'x100201',
                'msg'   => $this->obj_lang->get('App ID is incorrect', 'console.common'),
            );
        }

        if ($is_notify && $_arr_inputCommon['app_key'] != $_arr_ssoVar['app_key']) {
            return array(
                'rcode' => 'x100201',
                'msg'   => $this->obj_lang->get('App Key is incorrect', 'console.common'),
            );
        }

        $_str_decrypt = Crypt::decrypt($_arr_inputCommon['code'], $_arr_ssoVar['app_key'], $_arr_ssoVar['app_secret']);  //解密数据

        if ($_str_decrypt === false) {
            $_str_error = Crypt::getError();

            return array(
                'rcode' => 'x100403',
                'msg'   => $this->obj_lang->get($_str_error, 'console.common'),
            );
        }

        if (!Sign::check($_str_decrypt, $_arr_inputCommon['sign'], $_arr_ssoVar['app_key'] . $_arr_ssoVar['app_secret'])) {
            return array(
                'rcode' => 'x100401',
                'msg'   => $this->obj_lang->get('Signature is incorrect', 'console.common'),
            );
        }

        $_arr_decryptRow = Arrays::fromJson($_str_decrypt);

        $this->decryptRow = $_arr_decryptRow;

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $this->obj_lang->get($_str_msg, 'console.common'),
        );
    }
}
