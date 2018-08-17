<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/


//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

class CLASS_CRYPT {

    /** 加密
     * encrypt function.
     *
     * @access public
     * @param mixed $string
     * @return void
     */
    function encrypt($string) {
        $_arr_const = $this->const_check();
        if ($_arr_const['rcode'] != 'ok') {
            return $_arr_const;
        }

        $_str_encrypt   = openssl_encrypt($string, 'AES-128-CBC', BG_SSO_APPKEY, 1, BG_SSO_APPSECRET);

        $_str_encrypt   = base64_encode($_str_encrypt);

        $_str_encrypt   = str_ireplace('=', '|', $_str_encrypt);
        $_str_encrypt   = str_ireplace('/', '@', $_str_encrypt);
        $_str_encrypt   = str_ireplace('+', '_', $_str_encrypt);

        return array(
            'rcode'     => 'ok',
            'encrypt'   => $_str_encrypt,
        );
    }


    /** 解密
     * decrypt function.
     *
     * @access public
     * @param mixed $string
     * @return void
     */
    function decrypt($string) {
        $_arr_const = $this->const_check();
        if ($_arr_const['rcode'] != 'ok') {
            return $_arr_const;
        }

        $string         = str_ireplace('|', '=', $string);
        $string         = str_ireplace('@', '/', $string);
        $string         = str_ireplace('_', '+', $string);
        $string         = base64_decode($string);

        $_str_decrypt   = openssl_decrypt($string, 'AES-128-CBC', BG_SSO_APPKEY, 1, BG_SSO_APPSECRET);

        return array(
            'rcode'     => 'ok',
            'decrypt'   => $_str_decrypt,
        );
    }

    private function const_check() {
        if (!defined('BG_SSO_APPKEY')) {
            return array(
                'rcode' => 'x050214',
            );
        }

        if (strlen(BG_SSO_APPKEY) < 32) {
            return array(
                'rcode' => 'x050214',
            );
        }

        if (strlen(BG_SSO_APPKEY) > 32) {
            return array(
                'rcode' => 'x050215',
            );
        }

        if (!defined('BG_SSO_APPSECRET')) {
            return array(
                'rcode' => 'x050229',
            );
        }

        if (strlen(BG_SSO_APPSECRET) < 16) {
            return array(
                'rcode' => 'x050229',
            );
        }

        if (strlen(BG_SSO_APPSECRET) > 16) {
            return array(
                'rcode' => 'x050230',
            );
        }

        return array(
            'rcode' => 'ok',
        );
    }
}