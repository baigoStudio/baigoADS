<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

fn_include(BG_PATH_FUNC . 'http.func.php'); //载入 http

/*-------------单点登录类-------------*/
class CLASS_SSO {

    function __construct() { //构造函数
        $this->obj_dir  = new CLASS_DIR();
        $this->arr_data = array(
            'app_id'    => BG_SSO_APPID, //APP ID
            'app_key'   => BG_SSO_APPKEY, //APP KEY
            'time'      => time(),
        );
    }


    /** 编码
     * sso_encode function.
     *
     * @access public
     * @param mixed $_str_json
     * @return void
     */
    function sso_encode($arr_data) {
        $_arr_json    = array_merge($this->arr_data, $arr_data); //合并数组
        $_str_json    = fn_jsonEncode($_arr_json, 'encode');

        $_arr_sso = array(
            'act'   => 'encode', //方法
            'data'  => $_str_json,
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . '?mod=code', $_arr_ssoData, 'post'); //提交

        return fn_jsonDecode($_arr_get['ret'], 'no');
    }


    /** 解码
     * sso_decode function.
     *
     * @access public
     * @return void
     */
    function sso_decode($str_code) {
        $_arr_sso = array(
            'act'   => 'decode', //方法
            'code'  => $str_code, //加密串
        );

        if (isset($this->appInstall)) { //仅在安装时使用
            $_arr_ssoData     = array_merge($this->appInstall, $_arr_sso); //合并数组
            $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
            $_arr_get         = fn_http($this->sso_url . '?mod=code', $_arr_ssoData, 'post'); //提交
        } else {
            $_arr_ssoData     = array_merge($this->arr_data, $_arr_sso); //合并数组
            $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
            $_arr_get         = fn_http(BG_SSO_URL . '?mod=code', $_arr_ssoData, 'post'); //提交
        }

        return fn_jsonDecode($_arr_get['ret'], 'decode');
    }


    /** 签名
     * sso_signature function.
     *
     * @access public
     * @param mixed $tm_time
     * @return void
     */
    function sso_signature($arr_params) {
        $_arr_sso = array(
            'act'       => 'signature', //方法
            'params'    => $arr_params,
        );

        $_str_return = '';

        if (isset($this->appInstall)) { //仅在安装时使用
            $_arr_ssoData   = array_merge($this->appInstall, $_arr_sso); //合并数组
            $_arr_get       = fn_http($this->sso_url . '?mod=signature', $_arr_ssoData, 'post'); //提交
        } else {
            $_arr_ssoData   = array_merge($this->arr_data, $_arr_sso); //合并数组
            $_arr_get       = fn_http(BG_SSO_URL . '?mod=signature', $_arr_ssoData, 'post'); //提交
        }

        //print_r($_arr_get);
        //exit;

        $_arr_return = fn_jsonDecode($_arr_get['ret'], 'no');
        if (isset($_arr_return['signature']) && !fn_isEmpty($_arr_return['signature'])) {
            $_str_return = $_arr_return['signature'];
        }

        return $_str_return;
    }


    /** 验证签名
     * sso_verify function.
     *
     * @access public
     * @param mixed $tm_time
     * @param mixed $str_sign
     * @return void
     */
    function sso_verify($arr_params, $str_sign) {
        $_arr_sso = array(
            'act'       => 'verify', //方法
            'params'    => $arr_params,
            'signature' => $str_sign,
        );

        $_arr_ssoData     = array_merge($this->arr_data, $_arr_sso); //合并数组
        $_arr_get         = fn_http(BG_SSO_URL . '?mod=signature', $_arr_ssoData, 'post'); //提交

        return fn_jsonDecode($_arr_get['ret'], 'no');
    }


    /** 注册
     * sso_user_reg function.
     *
     * @access public
     * @param mixed $str_user 用户名
     * @param mixed $str_userPass 密码
     * @param string $str_userMail (default: '') Email
     * @param string $str_userNick (default: '') 昵称
     * @return 解码后数组 注册结果
     */
    function sso_user_reg($arr_userSubmit = array()) {
        $_arr_sso = array(
            'act'       => 'reg',
            'user_name' => $arr_userSubmit['user_name'],
            'user_pass' => md5($arr_userSubmit['user_pass']),
            'user_mail' => $arr_userSubmit['user_mail'],
            'user_nick' => $arr_userSubmit['user_nick'],
            'user_ip'   => fn_getIp(),
        );

        if (isset($this->appInstall)) { //仅在安装时使用
            $_arr_ssoData = array_merge($this->appInstall, $_arr_sso); //合并数组
            $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
            $_arr_get     = fn_http($this->sso_url . '?mod=user', $_arr_ssoData, 'post'); //提交
        } else {
            $_arr_ssoData = array_merge($this->arr_data, $_arr_sso); //合并数组
            $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
            $_arr_get     = fn_http(BG_SSO_URL . '?mod=user', $_arr_ssoData, 'post'); //提交
        }
        $_arr_result  = $this->result_process($_arr_get);

        if ($_arr_result['rcode'] != 'y010101') {
            return $_arr_result; //返回错误信息
        }

        $_arr_decode          = $this->sso_decode($_arr_result['code']); //解码
        $_arr_decode['rcode'] = $_arr_result['rcode'];

        return $_arr_decode;
    }


    /** 登录
     * sso_user_login function.
     *
     * @access public
     * @param mixed $str_userName 用户名
     * @param mixed $str_userPass 密码
     * @return 解码后数组 登录结果
     */
    function sso_user_login($str_userName, $str_userPass) {
        $_arr_sso = array(
            'act'       => 'login',
            'user_name' => $str_userName,
            'user_pass' => md5($str_userPass),
            'user_ip'   => fn_getIp(),
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . '?mod=user', $_arr_ssoData, 'post'); //提交

        $_arr_result  = $this->result_process($_arr_get);

        if ($_arr_result['rcode'] != 'y010401') {
            return $_arr_result; //返回错误信息
        }

        $_arr_decode          = $this->sso_decode($_arr_result['code']); //解码
        $_arr_decode['rcode'] = $_arr_result['rcode'];

        return $_arr_decode;
    }


    /** 读取用户信息
     * sso_user_read function.
     *
     * @access public
     * @param mixed $str_user ID（或用户名）
     * @param string $str_by (default: 'user_id') 用何种方式读取（默认用ID）
     * @return 解码后数组 用户信息
     */
    function sso_user_read($str_user, $str_by = 'user_id') {
        $_arr_sso = array(
            'act'   => 'read',
            $str_by => $str_user,
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . '?mod=user', $_arr_ssoData, 'get'); //提交
        $_arr_result  = $this->result_process($_arr_get);

        if ($_arr_result['rcode'] != 'y010102') {
            return $_arr_result; //返回错误信息
        }

        $_arr_decode          = $this->sso_decode($_arr_result['code']); //解码
        $_arr_decode['rcode'] = $_arr_result['rcode'];

        return $_arr_decode;
    }


    /** 编辑用户
     * sso_user_edit function.
     *
     * @access public
     * @param mixed $str_user 用户名
     * @param string $str_userPass (default: '') 密码
     * @param string $str_userPassNew (default: '') 新密码
     * @param string $str_userMail (default: '') Email
     * @param string $str_userNick (default: '') 昵称
     * @param string $str_by (default: 'user_name') 用何种方式编辑（默认用用户名）
     * @param string $str_checkPass (default: 'off') 是否验证密码（默认不验证）
     * @return 解码后数组 编辑结果
     */
    function sso_user_edit($str_user, $str_by = 'user_name', $arr_userSubmit = array()) {
        $_arr_sso = array(
            'act'   => 'edit',
            $str_by => $str_user,
        );

        if (isset($arr_userSubmit['user_pass']) && !fn_isEmpty($arr_userSubmit['user_pass'])) {
            $_arr_sso['user_pass'] = md5($arr_userSubmit['user_pass']);
        }

        if (isset($arr_userSubmit['user_mail_new']) && !fn_isEmpty($arr_userSubmit['user_mail_new'])) {
            $_arr_sso['user_mail_new'] = $arr_userSubmit['user_mail_new'];
        }

        if (isset($arr_userSubmit['user_nick']) && !fn_isEmpty($arr_userSubmit['user_nick'])) {
            $_arr_sso['user_nick'] = $arr_userSubmit['user_nick'];
        }

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . '?mod=user', $_arr_ssoData, 'post'); //提交
        $_arr_result  = $this->result_process($_arr_get);

        return $_arr_result;
    }


    /** 检查用户名
     * sso_user_chkname function.
     *
     * @access public
     * @param mixed $str_userName 用户名
     * @return 解码后数组 检查结果
     */
    function sso_user_chkname($str_userName) {
        $_arr_sso = array(
            'act'       => 'chkname',
            'user_name' => $str_userName,
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . '?mod=user', $_arr_ssoData, 'get'); //提交
        $_arr_result  = $this->result_process($_arr_get);

        return $_arr_result;
    }


    /** 检查 Email
     * sso_user_chkmail function.
     *
     * @access public
     * @param mixed $str_userMail Email
     * @param int $num_userId (default: 0) 当前用户ID（默认为0，忽略）
     * @return 解码后数组 检查结果
     */
    function sso_user_chkmail($str_userMail, $num_userId = 0) {
        $_arr_sso = array(
            'act'       => 'chkmail',
            'user_mail' => $str_userMail,
            'not_id'    => $num_userId,
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . '?mod=user', $_arr_ssoData, 'get'); //提交
        $_arr_result  = $this->result_process($_arr_get);

        return $_arr_result;
    }



    function sso_profile_info($str_user, $str_by = 'user_name', $arr_userSubmit = array()) {
        $_arr_sso = array(
            'act'       => 'info',
            $str_by     => $str_user,
            'user_pass' => md5($arr_userSubmit['user_pass']),
        );

        if (isset($arr_userSubmit['user_nick']) && !fn_isEmpty($arr_userSubmit['user_nick'])) {
            $_arr_sso['user_nick'] = $arr_userSubmit['user_nick'];
        }

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . '?mod=profile', $_arr_ssoData, 'post'); //提交
        $_arr_result  = $this->result_process($_arr_get);

        return $_arr_result;
    }


    function sso_profile_pass($str_user, $str_by = 'user_name', $arr_userSubmit = array()) {
        $_arr_sso = array(
            'act'                   => 'pass',
            $str_by                 => $str_user,
            'user_pass'             => md5($arr_userSubmit['user_pass']),
            'user_pass_new'         => md5($arr_userSubmit['user_pass_new']),
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . '?mod=profile', $_arr_ssoData, 'post'); //提交
        $_arr_result  = $this->result_process($_arr_get);

        return $_arr_result;
    }


    function sso_profile_qa($str_user, $str_by = 'user_name', $arr_userSubmit = array()) {
        $_arr_sso = array(
            'act'       => 'qa',
            $str_by     => $str_user,
            'user_pass' => md5($arr_userSubmit['user_pass']),
        );

        for ($_iii = 1; $_iii <= 3; $_iii++) {
            $_arr_sso['user_sec_ques_' . $_iii] = $arr_userSubmit['user_sec_ques_' . $_iii];
            $_arr_sso['user_sec_answ_' . $_iii] = md5($arr_userSubmit['user_sec_answ_' . $_iii]);
        }

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . '?mod=profile', $_arr_ssoData, 'post'); //提交
        $_arr_result  = $this->result_process($_arr_get);

        return $_arr_result; //返回错误信息
    }


    function sso_profile_mailbox($str_user, $str_by = 'user_name', $arr_userSubmit = array()) {
        $_arr_sso = array(
            'act'           => 'mailbox',
            $str_by         => $str_user,
            'user_pass'     => md5($arr_userSubmit['user_pass']),
            'user_mail_new' => $arr_userSubmit['user_mail_new'],
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . '?mod=profile', $_arr_ssoData, 'post'); //提交


        $_arr_result  = $this->result_process($_arr_get);

        return $_arr_result; //返回错误信息
    }


    function sso_profile_token($str_user, $str_by = 'user_name', $str_refreshToken) {
        $_arr_sso = array(
            'act'                   => 'token',
            $str_by                 => $str_user,
            'user_refresh_token'    => md5($str_refreshToken),
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . '?mod=profile', $_arr_ssoData, 'post'); //提交
        $_arr_result  = $this->result_process($_arr_get);

        if ($_arr_result['rcode'] != 'y010411') {
            return $_arr_result; //返回错误信息
        }

        $_arr_decode          = $this->sso_decode($_arr_result['code']); //解码
        $_arr_decode['rcode'] = $_arr_result['rcode'];

        return $_arr_decode;
    }


    function sso_forgot_bymail($str_userName) {
        $_arr_sso = array(
            'act'       => 'bymail',
            'user_name' => $str_userName,
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . '?mod=forgot', $_arr_ssoData, 'post'); //提交

        $_arr_result  = $this->result_process($_arr_get);

        return $_arr_result;
    }


    function sso_forgot_byqa($arr_userSubmit = array()) {
        $_arr_sso = array(
            'act'               => 'byqa',
            'user_name'         => $arr_userSubmit['user_name'],
            'user_pass_new'     => md5($arr_userSubmit['user_pass_new']),
            'user_pass_confirm' => md5($arr_userSubmit['user_pass_confirm']),
        );

        for ($_iii = 1; $_iii <= 3; $_iii++) {
            $_arr_sso['user_sec_answ_' . $_iii] = md5($arr_userSubmit['user_sec_answ_' . $_iii]);
        }

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . '?mod=forgot', $_arr_ssoData, 'post'); //提交

        $_arr_result  = $this->result_process($_arr_get);

        return $_arr_result;
    }


    /** 同步登录
     * sso_sync_login function.
     *
     * @access public
     * @param mixed $num_userId
     * @return void
     */
    function sso_sync_login($_arr_userSubmit = array()) {
        $_arr_sso = array(
            'act'               => 'login',
            'user_id'           => $_arr_userSubmit['user_id'],
            'user_access_token' => md5($_arr_userSubmit['user_access_token']),
        );

        $_arr_ssoData   = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get       = fn_http(BG_SSO_URL . '?mod=sync', $_arr_ssoData, 'post'); //提交
        $_arr_result    = $this->result_process($_arr_get);

        if (isset($_arr_result['urlRows']) && !fn_isEmpty($_arr_result['urlRows'])) {
            foreach ($_arr_result['urlRows'] as $_key=>$_value) {
                $_arr_result['urlRows'][$_key] = fn_htmlcode($_value, 'decode', 'url');
            }
        }

        return $_arr_result;
    }


    function sso_pm_send($str_user, $str_by = 'user_id', $_arr_pmSubmit = array()) {
        $_arr_sso = array(
            'act'               => 'send',
            $str_by             => $str_user,
            'user_access_token' => md5($_arr_pmSubmit['user_access_token']),
            'pm_to'             => $_arr_pmSubmit['pm_to'],
            'pm_title'          => $_arr_pmSubmit['pm_title'],
            'pm_content'        => $_arr_pmSubmit['pm_content'],
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . '?mod=pm', $_arr_ssoData, 'post'); //提交

        $_arr_result  = $this->result_process($_arr_get);

        return $_arr_result;
    }


    function sso_pm_status($str_user, $str_by = 'user_id', $_arr_pmSubmit = array()) {
        $_arr_sso = array(
            'act'               => 'status',
            $str_by             => $str_user,
            'user_access_token' => md5($_arr_pmSubmit['user_access_token']),
            'pm_ids'            => implode('|', $_arr_pmSubmit['pm_ids']),
            'pm_status'         => $_arr_pmSubmit['pm_status'],
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . '?mod=pm', $_arr_ssoData, 'post'); //提交

        $_arr_result  = $this->result_process($_arr_get);

        return $_arr_result;
    }


    function sso_pm_revoke($str_user, $str_by = 'user_id', $_arr_pmSubmit = array()) {
        $_arr_sso = array(
            'act'               => 'revoke',
            $str_by             => $str_user,
            'user_access_token' => md5($_arr_pmSubmit['user_access_token']),
            'pm_ids'            => implode('|', $_arr_pmSubmit['pm_ids']),
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . '?mod=pm', $_arr_ssoData, 'post'); //提交

        $_arr_result  = $this->result_process($_arr_get);

        return $_arr_result;
    }


    function sso_pm_del($str_user, $str_by = 'user_id', $_arr_pmSubmit = array()) {
        $_arr_sso = array(
            'act'               => 'del',
            $str_by             => $str_user,
            'user_access_token' => md5($_arr_pmSubmit['user_access_token']),
            'pm_ids'            => implode('|', $_arr_pmSubmit['pm_ids']),
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . '?mod=pm', $_arr_ssoData, 'post'); //提交

        $_arr_result  = $this->result_process($_arr_get);

        return $_arr_result;
    }


    function sso_pm_read($str_user, $str_by = 'user_id', $_arr_pmSubmit = array()) {
        $_arr_sso = array(
            'act'               => 'read',
            $str_by             => $str_user,
            'user_access_token' => md5($_arr_pmSubmit['user_access_token']),
            'pm_id'             => $_arr_pmSubmit['pm_id'],
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . '?mod=pm', $_arr_ssoData, 'get'); //提交

        $_arr_result  = $this->result_process($_arr_get);

        if ($_arr_result['rcode'] != 'y110102') {
            return $_arr_result; //返回错误信息
        }

        $_arr_decode          = $this->sso_decode($_arr_result['code']); //解码
        $_arr_decode['rcode'] = $_arr_result['rcode'];

        return $_arr_decode;
    }


    function sso_pm_list($str_user, $str_by = 'user_id', $_arr_pmSubmit = array()) {
        $_arr_sso = array(
            'act'               => 'list',
            $str_by             => $str_user,
            'user_access_token' => md5($_arr_pmSubmit['user_access_token']),
            'pm_type'           => $_arr_pmSubmit['pm_type'],
            'pm_status'         => $_arr_pmSubmit['pm_status'],
            'key'               => $_arr_pmSubmit['key'],
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . '?mod=pm', $_arr_ssoData, 'get'); //提交

        //print_r($_arr_get);

        $_arr_result  = $this->result_process($_arr_get);

        if ($_arr_result['rcode'] != 'y110402') {
            return $_arr_result; //返回错误信息
        }

        $_arr_decode          = $this->sso_decode($_arr_result['code']); //解码
        $_arr_decode['rcode'] = $_arr_result['rcode'];

        return $_arr_decode;
    }


    function sso_pm_check($str_user, $str_by = 'user_id', $str_accessToken) {
        $_arr_sso = array(
            'act'               => 'check',
            $str_by             => $str_user,
            'user_access_token' => md5($str_accessToken),
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData['signature'] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . '?mod=pm', $_arr_ssoData, 'get'); //提交

        $_arr_result  = $this->result_process($_arr_get);

        return $_arr_result;
    }


    function sso_setup() {
        $_arr_ssoData = array(
            'act'           => 'dbconfig',
            'db_host'       => BG_DB_HOST,
            'db_port'       => BG_DB_PORT,
            'db_name'       => BG_DB_NAME,
            'db_user'       => BG_DB_USER,
            'db_pass'       => BG_DB_PASS,
            'db_charset'    => BG_DB_CHARSET,
            'db_table'      => 'sso_',
        );
        $_arr_get     = fn_http(BG_SITE_URL . BG_URL_SSO . 'api/api.php?mod=setup', $_arr_ssoData, 'post'); //提交
        $_arr_result  = $this->result_process($_arr_get);
        if ($_arr_result['rcode'] != 'y030404') {
            return $_arr_result;
        }

        $_arr_ssoData = array(
            'act'   => 'dbtable',
        );
        $_arr_get     = fn_http(BG_SITE_URL . BG_URL_SSO . 'api/api.php?mod=setup', $_arr_ssoData, 'post'); //提交
        //print_r($_arr_get);
        $_arr_result  = $this->result_process($_arr_get);
        if ($_arr_result['rcode'] != 'y030108') {
            return $_arr_result;
        }

        return $_arr_result;
    }


    /** 管理员
     * sso_admin function.
     *
     * @access public
     * @param mixed $str_adminName
     * @param mixed $str_adminPass
     * @return void
     */
    function sso_admin($str_adminName, $str_adminPass) {
        $_arr_sso = array(
            'act'           => 'admin',
            'admin_name'    => $str_adminName,
            'admin_pass'    => md5($str_adminPass),
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso); //合并数组
        $_arr_get     = fn_http(BG_SITE_URL . BG_URL_SSO . 'api/api.php?mod=setup', $_arr_ssoData, 'post'); //提交
        $_arr_resultAdmin  = $this->result_process($_arr_get);
        if ($_arr_resultAdmin['rcode'] != 'y010101') {
            return $_arr_resultAdmin;
        }

        $_arr_ssoData = array(
            'act'               => 'over',
            'app_name'          => 'baigo ADS',
            'app_url_notify'    => BG_SITE_URL . BG_URL_API . 'sso.php?mod=notify',
            'app_url_sync'      => BG_SITE_URL . BG_URL_API . 'sso.php?mod=sync',
        );
        $_arr_get     = fn_http(BG_SITE_URL . BG_URL_SSO . 'api/api.php?mod=setup', $_arr_ssoData, 'post'); //提交
        $_arr_resultApp  = $this->result_process($_arr_get);
        if ($_arr_resultApp['rcode'] != 'y030408') {
            return $_arr_resultApp;
        }

        $this->sso_url = $_arr_resultApp['sso_url'];

        $this->appInstall = array(
            'app_id'     => $_arr_resultApp['app_id'],
            'app_key'    => $_arr_resultApp['app_key'],
            'time'       => time(),
        );

        $_str_outPut = '<?php' . PHP_EOL;
        $_str_outPut .= 'define(\'BG_SSO_URL\', \'' . $_arr_resultApp['sso_url'] . '\');' . PHP_EOL;
        $_str_outPut .= 'define(\'BG_SSO_APPID\', ' . $_arr_resultApp['app_id'] . ');' . PHP_EOL;
        $_str_outPut .= 'define(\'BG_SSO_APPKEY\', \'' . $_arr_resultApp['app_key'] . '\');' . PHP_EOL;
        $_str_outPut .= 'define(\'BG_SSO_SYNC\', \'on\');' . PHP_EOL;

        $_num_size = $this->obj_dir->put_file(BG_PATH_CONFIG . 'opt_sso.inc.php', $_str_outPut);

        if ($_num_size > 0) {
            $_str_rcode = 'y060101';
        } else {
            $_str_rcode = 'x060101';
        }

        $_arr_resultAdmin['rcode'] = $_str_rcode;

        return $_arr_resultAdmin;
    }

    /**
     * result_process function.
     *
     * @access private
     * @return void
     */
    private function result_process($arr_get) {
        //print_r($arr_get);
        //exit;
        if (!isset($arr_get['ret'])) {
            $_arr_result = array(
                'rcode' => 'x030208'
            );
            return $_arr_result;
        }

        $_arr_result = json_decode($arr_get['ret'], true);
        if (!isset($_arr_result['rcode'])) {
            $_arr_result = array(
                'rcode' => 'x030209'
            );
            return $_arr_result;
        }

        if (!isset($_arr_result['prd_sso_pub']) || $_arr_result['prd_sso_pub'] < 20170117) {
            $_arr_result = array(
                'rcode' => 'x030211'
            );
            return $_arr_result;
        }

        $_arr_result['rcode'] = str_ireplace('x020204', 'x020206', $_arr_result['rcode']); //SSO 管理员已存在
        $_arr_result['rcode'] = str_ireplace('x030403', 'x030408', $_arr_result['rcode']); //SSO 已安装
        $_arr_result['rcode'] = str_ireplace('x030404', 'x030419', $_arr_result['rcode']); //SSO 数据库未正确设置
        $_arr_result['rcode'] = str_ireplace('x030410', 'x030413', $_arr_result['rcode']); //SSO 需要执行安装程序
        $_arr_result['rcode'] = str_ireplace('x030411', 'x030414', $_arr_result['rcode']); //SSO 需要执行升级程序

        return $_arr_result;
    }
}
