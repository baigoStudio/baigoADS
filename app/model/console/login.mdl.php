<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Admin as Admin_Base;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------管理员模型-------------*/
class Login extends Admin_Base {

    protected $table = 'admin';
    public $inputSubmit = array();

    /** 登录验证
     * inputSubmit function.
     *
     * @access public
     * @return void
     */
    function inputSubmit() {
        $_arr_inputParam = array(
            'admin_name'        => array('txt', ''),
            'admin_pass'        => array('txt', ''),
            'admin_remember'    => array('txt', ''),
            'captcha'           => array('txt', ''),
            '__token__'         => array('txt', ''),
        );

        $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputSubmit, '', 'submit');

        if ($_mix_vld !== true) {
            return array(
                'rcode'     => 'x240201',
                'msg'       => end($_mix_vld),
            );
        }

        $_arr_inputSubmit['rcode'] = 'y020201';

        $this->inputSubmit = $_arr_inputSubmit;

        return $_arr_inputSubmit;
    }
}
