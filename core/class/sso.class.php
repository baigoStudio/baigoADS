<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

/*-------------单点登录类-------------*/
class CLASS_SSO {

    private $arr_data;

    function __construct() { //构造函数
        $this->obj_dir  = new CLASS_DIR();
        $this->arr_data = array(
            "app_id"    => BG_SSO_APPID, //APP ID
            "app_key"   => BG_SSO_APPKEY, //APP KEY
            "time"      => time(),
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
        $_str_json    = fn_jsonEncode($_arr_json, "encode");

        $_arr_sso = array(
            "act_post"   => "encode", //方法
            "data"       => $_str_json,
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData["signature"] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . "?mod=code", $_arr_ssoData, "post"); //提交

        return fn_jsonDecode($_arr_get["ret"], "no");
    }


    /** 解码
     * sso_decode function.
     *
     * @access public
     * @return void
     */
    function sso_decode($str_code) {
        $_arr_sso = array(
            "act_post"   => "decode", //方法
            "code"       => $str_code, //加密串
        );

        if (isset($this->appInstall)) { //仅在安装时使用
            $_arr_ssoData     = array_merge($this->appInstall, $_arr_sso); //合并数组
            $_arr_ssoData["signature"] = $this->sso_signature($_arr_ssoData);
            $_arr_get         = fn_http($this->sso_url . "?mod=code", $_arr_ssoData, "post"); //提交
        } else {
            $_arr_ssoData     = array_merge($this->arr_data, $_arr_sso); //合并数组
            $_arr_ssoData["signature"] = $this->sso_signature($_arr_ssoData);
            $_arr_get         = fn_http(BG_SSO_URL . "?mod=code", $_arr_ssoData, "post"); //提交
        }

        return fn_jsonDecode($_arr_get["ret"], "decode");
    }


    /** 签名
     * sso_signature function.
     *
     * @access public
     * @param mixed $tm_time
     * @param mixed $str_rand
     * @return void
     */
    function sso_signature($arr_params) {
        $_arr_sso = array(
            "act_post"  => "signature", //方法
            "params"    => $arr_params,
        );

        $_str_return    = "";

        $_arr_ssoData   = array_merge($this->arr_data, $_arr_sso); //合并数组
        $_arr_get       = fn_http(BG_SSO_URL . "?mod=signature", $_arr_ssoData, "post"); //提交

        $_arr_return = fn_jsonDecode($_arr_get["ret"], "no");
        if (!fn_isEmpty($_arr_return["signature"])) {
            $_str_return = $_arr_return["signature"];
        }

        return $_str_return;
    }


    /** 验证签名
     * sso_verify function.
     *
     * @access public
     * @param mixed $tm_time
     * @param mixed $str_rand
     * @param mixed $str_sign
     * @return void
     */
    function sso_verify($arr_params, $str_sign) {
        $_arr_sso = array(
            "act_post"  => "verify", //方法
            "params"    => $arr_params,
            "signature" => $str_sign,
        );

        $_arr_ssoData     = array_merge($this->arr_data, $_arr_sso); //合并数组
        $_arr_get         = fn_http(BG_SSO_URL . "?mod=signature", $_arr_ssoData, "post"); //提交

        return fn_jsonDecode($_arr_get["ret"], "no");
    }


    /** 注册
     * sso_reg function.
     *
     * @access public
     * @param mixed $str_userName 用户名
     * @param mixed $str_userPass 密码
     * @param string $str_userMail (default: "") Email
     * @param string $str_userNick (default: "") 昵称
     * @return 解码后数组 注册结果
     */
    function sso_reg($str_userName, $str_userPass, $str_userMail = "", $str_userNick = "") {
        $_arr_sso = array(
            "act_post"   => "reg",
            "user_name"  => $str_userName,
            "user_pass"  => md5($str_userPass),
            "user_mail"  => $str_userMail,
            "user_nick"  => $str_userNick,
        );

        if (isset($this->appInstall)) { //仅在安装时使用
            $_arr_ssoData = array_merge($this->appInstall, $_arr_sso); //合并数组
            $_arr_ssoData["signature"] = $this->sso_signature($_arr_ssoData);
            $_arr_get     = fn_http($this->sso_url . "?mod=user", $_arr_ssoData, "post"); //提交
        } else {
            $_arr_ssoData = array_merge($this->arr_data, $_arr_sso); //合并数组
            $_arr_ssoData["signature"] = $this->sso_signature($_arr_ssoData);
            $_arr_get     = fn_http(BG_SSO_URL . "?mod=user", $_arr_ssoData, "post"); //提交
        }

        $_arr_result  = $this->result_process($_arr_get);

        if ($_arr_result["alert"] != "y010101") {
            return $_arr_result; //返回错误信息
        }

        $_arr_decode          = $this->sso_decode($_arr_result["code"]); //解码
        $_arr_decode["alert"] = $_arr_result["alert"];

        return $_arr_decode;
    }


    /** 登录
     * sso_login function.
     *
     * @access public
     * @param mixed $str_userName 用户名
     * @param mixed $str_userPass 密码
     * @return 解码后数组 登录结果
     */
    function sso_login($str_userName, $str_userPass) {
        $_arr_sso = array(
            "act_post"   => "login",
            "user_name"  => $str_userName,
            "user_pass"  => md5($str_userPass),
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData["signature"] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . "?mod=user", $_arr_ssoData, "post"); //提交
        $_arr_result  = $this->result_process($_arr_get);

        if ($_arr_result["alert"] != "y010401") {
            return $_arr_result; //返回错误信息
        }

        $_arr_decode          = $this->sso_decode($_arr_result["code"]); //解码
        $_arr_decode["alert"] = $_arr_result["alert"];

        return $_arr_decode;
    }


    /** 同步登录
     * sso_sync_login function.
     *
     * @access public
     * @param mixed $num_userId
     * @return void
     */
    function sso_sync_login($num_userId) {
        $_arr_sso = array(
            "act_post"  => "login",
            "user_id"   => $num_userId,
        );

        $_arr_ssoData   = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData["signature"] = $this->sso_signature($_arr_ssoData);
        $_arr_get       = fn_http(BG_SSO_URL . "?mod=sync", $_arr_ssoData, "post"); //提交
        $_arr_result    = $this->result_process($_arr_get);

        if ($_arr_result["urlRows"]) {
            foreach ($_arr_result["urlRows"] as $_key=>$_value) {
                $_arr_result["urlRows"][$_key] = urldecode($_value);
            }
        }

        return $_arr_result;
    }


    /** 读取用户信息
     * sso_get function.
     *
     * @access public
     * @param mixed $str_user ID（或用户名）
     * @param string $str_userBy (default: "user_id") 用何种方式读取（默认用ID）
     * @return 解码后数组 用户信息
     */
    function sso_read($str_user, $str_userBy = "user_id") {
        $_arr_sso = array(
            "act_get"    => "read",
            $str_userBy  => $str_user,
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData["signature"] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . "?mod=user", $_arr_ssoData, "get"); //提交
        $_arr_result  = $this->result_process($_arr_get);

        if ($_arr_result["alert"] != "y010102") {
            return $_arr_result; //返回错误信息
        }

        $_arr_decode          = $this->sso_decode($_arr_result["code"]); //解码
        $_arr_decode["alert"] = $_arr_result["alert"];

        return $_arr_decode;
    }


    /** 编辑用户
     * sso_edit function.
     *
     * @access public
     * @param mixed $str_userName 用户名
     * @param string $str_userPass (default: "") 密码
     * @param string $str_userPassNew (default: "") 新密码
     * @param string $str_userMail (default: "") Email
     * @param string $str_userNick (default: "") 昵称
     * @param string $str_userBy (default: "user_name") 用何种方式编辑（默认用用户名）
     * @param string $str_checkPass (default: "off") 是否验证密码（默认不验证）
     * @return 解码后数组 编辑结果
     */
    function sso_edit($str_userName, $str_userPass = "", $str_userPassNew = "", $str_userMail = "", $str_userNick = "", $str_userBy = "user_name", $str_checkPass = false) {
        if ($str_userPassNew) {
            $_str_userPassNew = md5($str_userPassNew);
        } else {
            $_str_userPassNew = "";
        }

        $_arr_sso = array(
            "act_post"           => "edit",
            $str_userBy          => $str_userName,
            "user_check_pass"    => $str_checkPass,
            "user_pass"          => md5($str_userPass),
            "user_pass_new"      => $_str_userPassNew,
            "user_mail"          => $str_userMail,
            "user_nick"          => $str_userNick,
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData["signature"] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . "?mod=user", $_arr_ssoData, "post"); //提交
        $_arr_result  = $this->result_process($_arr_get);

        if ($_arr_result["alert"] != "y010103") {
            return $_arr_result; //返回错误信息
        }

        $_arr_decode          = $this->sso_decode($_arr_result["code"]); //解码
        $_arr_decode["alert"] = $_arr_result["alert"];

        return $_arr_decode;
    }


    /** 检查用户名
     * sso_chkname function.
     *
     * @access public
     * @param mixed $str_userName 用户名
     * @return 解码后数组 检查结果
     */
    function sso_chkname($str_userName) {
        $_arr_sso = array(
            "act_get"    => "chkname",
            "user_name"  => $str_userName,
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData["signature"] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . "?mod=user", $_arr_ssoData, "get"); //提交
        $_arr_result  = $this->result_process($_arr_get);

        if ($_arr_result["alert"] != "y010205") {
            return $_arr_result; //返回错误信息
        }

        //$this->sso_decode();
        $_arr_decode["alert"] = $_arr_result["alert"];

        return $_arr_decode;
    }


    /** 检查 Email
     * sso_chkmail function.
     *
     * @access public
     * @param mixed $str_userMail Email
     * @param int $num_userId (default: 0) 当前用户ID（默认为0，忽略）
     * @return 解码后数组 检查结果
     */
    function sso_chkmail($str_userMail, $num_userId = 0) {
        $_arr_sso = array(
            "act_get"    => "chkmail",
            "user_mail"  => $str_userMail,
            "user_id"    => $num_userId,
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData["signature"] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . "?mod=user", $_arr_ssoData, "get"); //提交
        $_arr_result  = $this->result_process($_arr_get);

        if ($_arr_result["alert"] != "y010211") {
            return $_arr_result; //返回错误信息
        }

        //$this->sso_decode();
        $_arr_decode["alert"] = $_arr_result["alert"];

        return $_arr_decode;
    }


    function sso_pm_send($str_user, $str_userBy = "user_id", $str_accessToken, $str_pmTo, $str_pmTitle, $str_pmContent) {
        $_arr_sso = array(
            "act_post"          => "send",
            $str_userBy         => $str_user,
            "user_access_token" => md5($str_accessToken),
            "pm_to"             => $str_pmTo,
            "pm_title"          => $str_pmTitle,
            "pm_content"        => $str_pmContent,
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData["signature"] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . "?mod=pm", $_arr_ssoData, "post"); //提交

        $_arr_result  = $this->result_process($_arr_get);

        return $_arr_result;
    }


    function sso_pm_status($str_user, $str_userBy = "user_id", $str_accessToken, $arr_pmIds, $str_status) {
        $_arr_sso = array(
            "act_post"          => "status",
            $str_userBy         => $str_user,
            "user_access_token" => md5($str_accessToken),
            "pm_ids"            => implode("|", $arr_pmIds),
            "pm_status"         => $str_status,
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData["signature"] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . "?mod=pm", $_arr_ssoData, "post"); //提交

        $_arr_result  = $this->result_process($_arr_get);

        return $_arr_result;
    }


    function sso_pm_revoke($str_user, $str_userBy = "user_id", $str_accessToken, $arr_pmIds) {
        $_arr_sso = array(
            "act_post"          => "revoke",
            $str_userBy         => $str_user,
            "user_access_token" => md5($str_accessToken),
            "pm_ids"            => implode("|", $arr_pmIds),
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData["signature"] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . "?mod=pm", $_arr_ssoData, "post"); //提交

        $_arr_result  = $this->result_process($_arr_get);

        return $_arr_result;
    }


    function sso_pm_del($str_user, $str_userBy = "user_id", $str_accessToken, $arr_pmIds) {
        $_arr_sso = array(
            "act_post"          => "del",
            $str_userBy         => $str_user,
            "user_access_token" => md5($str_accessToken),
            "pm_ids"            => implode("|", $arr_pmIds),
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData["signature"] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . "?mod=pm", $_arr_ssoData, "post"); //提交

        $_arr_result  = $this->result_process($_arr_get);

        return $_arr_result;
    }


    function sso_pm_read($str_user, $str_userBy = "user_id", $str_accessToken, $num_pmId) {
        $_arr_sso = array(
            "act_get"           => "read",
            $str_userBy         => $str_user,
            "user_access_token" => md5($str_accessToken),
            "pm_id"             => $num_pmId,
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData["signature"] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . "?mod=pm", $_arr_ssoData, "get"); //提交

        $_arr_result  = $this->result_process($_arr_get);

        if ($_arr_result["alert"] != "y110102") {
            return $_arr_result; //返回错误信息
        }

        $_arr_decode          = $this->sso_decode($_arr_result["code"]); //解码
        $_arr_decode["alert"] = $_arr_result["alert"];

        return $_arr_decode;
    }


    function sso_pm_list($str_user, $str_userBy = "user_id", $str_accessToken, $str_pmType = "in", $str_pmStatus = "", $str_key = "") {
        $_arr_sso = array(
            "act_get"           => "list",
            $str_userBy         => $str_user,
            "user_access_token" => md5($str_accessToken),
            "pm_type"           => $str_pmType,
            "pm_status"         => $str_pmStatus,
            "key"               => $str_key,
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData["signature"] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . "?mod=pm", $_arr_ssoData, "get"); //提交

        $_arr_result  = $this->result_process($_arr_get);

        if ($_arr_result["alert"] != "y110402") {
            return $_arr_result; //返回错误信息
        }

        $_arr_decode          = $this->sso_decode($_arr_result["code"]); //解码
        $_arr_decode["alert"] = $_arr_result["alert"];

        return $_arr_decode;
    }


    function sso_pm_check($str_user, $str_userBy = "user_id", $str_accessToken) {
        $_arr_sso = array(
            "act_get"           => "check",
            $str_userBy         => $str_user,
            "user_access_token" => md5($str_accessToken),
        );

        $_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
        $_arr_ssoData["signature"] = $this->sso_signature($_arr_ssoData);
        $_arr_get     = fn_http(BG_SSO_URL . "?mod=pm", $_arr_ssoData, "get"); //提交

        $_arr_result  = $this->result_process($_arr_get);

        return $_arr_result;
    }


    function sso_install() {
        $_arr_ssoData = array(
            "act_post"   => "dbconfig",
            "db_host"    => BG_DB_HOST,
            "db_port"    => BG_DB_PORT,
            "db_name"    => BG_DB_NAME,
            "db_user"    => BG_DB_USER,
            "db_pass"    => BG_DB_PASS,
            "db_charset" => BG_DB_CHARSET,
            "db_table"   => "sso_",
        );
        $_arr_get     = fn_http(BG_SITE_URL . BG_URL_SSO . "api/api.php?mod=install", $_arr_ssoData, "post"); //提交
        $_arr_result  = $this->result_process($_arr_get);
        if ($_arr_result["alert"] != "y030404") {
            return $_arr_result;
        }

        $_arr_ssoData = array(
            "act_post"   => "dbtable",
        );
        $_arr_get     = fn_http(BG_SITE_URL . BG_URL_SSO . "api/api.php?mod=install", $_arr_ssoData, "post"); //提交
        $_arr_result  = $this->result_process($_arr_get);
        if ($_arr_result["alert"] != "y030108") {
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
        $_arr_ssoData = array(
            "act_post"   => "admin",
            "admin_name" => $str_adminName,
            "admin_pass" => md5($str_adminPass),
        );

        //$_arr_ssoData = array_merge($this->arr_data, $_arr_sso); //合并数组
        $_arr_get     = fn_http(BG_SITE_URL . BG_URL_SSO . "api/api.php?mod=install", $_arr_ssoData, "post"); //提交
        $_arr_result  = $this->result_process($_arr_get);
        if ($_arr_result["alert"] != "y020101") {
            return $_arr_result;
        }

        $_arr_ssoData = array(
            "act_post"          => "over",
            "app_name"          => "baigo ADS",
            "app_url_notify"    => BG_SITE_URL . BG_URL_API . "sso.php?mod=notify",
            "app_url_sync"      => BG_SITE_URL . BG_URL_API . "sso.php?mod=sync",
        );
        $_arr_get     = fn_http(BG_SITE_URL . BG_URL_SSO . "api/api.php?mod=install", $_arr_ssoData, "post"); //提交
        $_arr_result  = $this->result_process($_arr_get);
        if ($_arr_result["alert"] != "y030408") {
            return $_arr_result;
        }

        $this->sso_url = $_arr_result["sso_url"];

        $this->appInstall = array(
            "app_id"     => $_arr_result["app_id"],
            "app_key"    => $_arr_result["app_key"],
            "time"       => time(),
        );

        $_str_content = "<?php" . PHP_EOL;
        $_str_content .= "define(\"BG_SSO_URL\", \"" . $_arr_result["sso_url"] . "\");" . PHP_EOL;
        $_str_content .= "define(\"BG_SSO_APPID\", " . $_arr_result["app_id"] . ");" . PHP_EOL;
        $_str_content .= "define(\"BG_SSO_APPKEY\", \"" . $_arr_result["app_key"] . "\");" . PHP_EOL;
        $_str_content .= "define(\"BG_SSO_SYNC\", \"on\");" . PHP_EOL;

        $_num_size = $this->obj_dir->put_file(BG_PATH_CONFIG . "opt_sso.inc.php", $_str_content);

        if ($_num_size > 0) {
            $_str_alert = "y060101";
        } else {
            $_str_alert = "x060101";
        }

        $_arr_return = array(
            "alert" => $_str_alert,
        );
        return $_arr_result;
    }


    /**
     * result_process function.
     *
     * @access private
     * @return void
     */
    private function result_process($arr_get) {
        //print_r($arr_get);
        if (!isset($arr_get["ret"])) {
            $_arr_result = array(
                "alert" => "x030110"
            );
            return $_arr_result;
        }

        $_arr_result = fn_jsonDecode($arr_get["ret"], "no");
        if (!isset($_arr_result["alert"])) {
            $_arr_result = array(
                "alert" => "x030110"
            );
            return $_arr_result;
        }

        if (!isset($_arr_result["prd_sso_pub"]) || $_arr_result["prd_sso_pub"] < 20160906) {
            $_arr_result = array(
                "alert" => "x030113"
            );
            return $_arr_result;
        }

        $_arr_result["alert"] = str_ireplace("x020204", "x020206", $_arr_result["alert"]); //SSO 管理员已存在
        $_arr_result["alert"] = str_ireplace("x030403", "x030408", $_arr_result["alert"]); //SSO 已安装
        $_arr_result["alert"] = str_ireplace("x030404", "x030419", $_arr_result["alert"]); //SSO 数据库未正确设置
        $_arr_result["alert"] = str_ireplace("x030410", "x030413", $_arr_result["alert"]); //SSO 需要执行安装程序
        $_arr_result["alert"] = str_ireplace("x030411", "x030414", $_arr_result["alert"]); //SSO 需要执行升级程序

        return $_arr_result;
    }
}
