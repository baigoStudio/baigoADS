<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

class CONTROL_CONSOLE_REQUEST_CAPTCHA {

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->dspType = 'result';
        $this->general_console->chk_install();
        $this->obj_tpl      = $this->general_console->obj_tpl;
    }


    /**
     * ajax_check function.
     *
     * @access public
     * @return void
     */
    function ctrl_check() {
        $_str_captcha = fn_getSafe(fn_get('captcha'), 'txt', '');
        if (strtolower($_str_captcha) != fn_session('captcha')) {
            $_arr_tplData = array(
                'rcode' => 'x030205',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_tplData = array(
            'msg'   => 'ok',
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }
}