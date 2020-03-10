<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

class Token extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->obj_pm       = Loader::classes('Pm', 'sso');
        $this->obj_profile  = Loader::classes('Profile', 'sso');
        $this->mdl_profile  = Loader::model('Profile');
    }


    function make() {
        $_arr_return = array();

        $_num_pmCount = '';

        if ($this->adminLogged['rcode'] == 'y020102') {
            //$_str_token  = fn_token(); //生成令牌
            if ($this->adminLogged['admin_access_expire'] <= GK_NOW - GK_MINUTE && $this->adminLogged['admin_refresh_expire'] > GK_NOW) { //过期时间小于1分钟，则刷新口令
                $this->tokenProcess();
            }

            $_arr_pmCount   = $this->obj_pm->check($this->adminLogged['admin_id'], 'user_id', $this->adminLogged['admin_access_token']);
            if ($_arr_pmCount['rcode'] == 'y110102') {
                $_num_pmCount = $_arr_pmCount['pm_count'];
            } else {
                $this->tokenProcess();
            }

            $_str_rcode  = 'y020102';
            $_str_msg    = 'ok';
        } else { //未登录，抛出错误信息
            $_str_rcode  = 'x020405';
            $_str_msg    = 'The login timeout, please login again!';
        }

        $_arr_return = array(
            'pm_count'  => $_num_pmCount,
            'rcode'     => $_str_rcode,
            'msg'       => $this->obj_lang->get($_str_msg, 'console.common'),
        );

        return $this->json($_arr_return);
    }


    private function tokenProcess() {
        $_arr_userRefresh = $this->obj_profile->tokenRefresh($this->adminLogged['admin_id'], 'user_id', $this->adminLogged['admin_refresh_token']); //过期时间小于1分钟，则刷新口令

        //print_r($_arr_userRefresh);

        if ($_arr_userRefresh['rcode'] == 'y010103') { //刷新成功则更新数据库
            $this->mdl_profile->tokenRefresh($this->adminLogged['admin_id'], $_arr_userRefresh['user_access_token'], $_arr_userRefresh['user_access_expire']);

            $this->adminLogged['admin_access_token'] = $_arr_userRefresh['user_access_token']; //用新口令检查短信
        }
    }
}
