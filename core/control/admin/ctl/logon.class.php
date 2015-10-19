<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "http.func.php"); //载入 http
include_once(BG_PATH_CLASS . "sso.class.php"); //载入 SSO
include_once(BG_PATH_CLASS . "tpl_admin.class.php"); //载入模板类

/*-------------用户类-------------*/
class CONTROL_LOGON {

	private $obj_base;
	private $config;
	private $obj_sso;
	private $obj_tpl;
	private $mdl_admin;


	function __construct() { //构造函数
		$this->obj_base   = $GLOBALS["obj_base"];
		$this->config     = $this->obj_base->config;
		$this->obj_sso    = new CLASS_SSO(); //SSO
		$this->mdl_admin  = new MODEL_ADMIN(); //设置管理员对象
		$this->obj_tpl    = new CLASS_TPL(BG_PATH_TPL . "admin/" . $this->config["ui"]); //初始化视图对象
	}


	/**
	 * ctl_login function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_login() {
		$_arr_adminLogin = $this->input_login();
		if ($_arr_adminLogin["alert"] != "ok") {
			return $_arr_adminLogin;
			exit;
		}

		$_arr_ssoLogin = $this->obj_sso->sso_login($_arr_adminLogin["admin_name"], $_arr_adminLogin["admin_pass"]); //sso验证
		if ($_arr_ssoLogin["alert"] != "y010401") {
			$_arr_ssoLogin["forward"] = $_arr_adminLogin["forward"];
			return $_arr_ssoLogin;
			exit;
		}

		$_arr_ssin = fn_ssin_login($_arr_ssoLogin["user_id"]);
		if ($_arr_ssin["alert"] != "ok") {
			$_arr_ssin["forward"] = $_arr_adminLogin["forward"];
			return $_arr_ssin;
			exit;
		}

		$_arr_sync = array();

		if(defined("BG_SSO_SYNLOGON") && BG_SSO_SYNLOGON == "on") {
			$_arr_sync = $this->obj_sso->sso_sync_login($_arr_ssoLogin["user_id"]);
		}

		$_arr_tplData = array(
			"admin_id"   => $_arr_ssoLogin["user_id"],
			"forward"    => base64_decode($_arr_adminLogin["forward"]),
			"sync"       => $_arr_sync,
		);

		$this->obj_tpl->tplDisplay("login.tpl", $_arr_tplData);

		return array(
			"alert"      => "y020401",
		);
	}


	/**
	 * ctl_logon function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_logon() {
		$_str_forward     = fn_getSafe(fn_get("forward"), "txt", "");
		$_str_alert       = fn_getSafe(fn_get("alert"), "txt", "");

		$_arr_tplData = array(
			"forward"    => $_str_forward,
			"alert"      => $_str_alert,
		);

		$this->obj_tpl->tplDisplay("logon.tpl", $_arr_tplData);
		//print_r($GLOBALS["ssid"]);
	}


	/**
	 * ctl_logout function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_logout() {
		$_str_forward  = fn_getSafe(fn_get("forward"), "txt", "");
		if (!$_str_forward) {
			$_str_forward = base64_encode(BG_URL_ADMIN . "ctl.php");
		}

		fn_ssin_end();

		return array(
			"forward" => $_str_forward,
		);
	}

	/**
	 * fn_adminLogin function.
	 *
	 * @access public
	 * @return void
	 */
	private function input_login() {
		$_arr_adminLogin["forward"] = fn_getSafe(fn_post("forward"), "txt", "");
		if (!$_arr_adminLogin["forward"]) {
			$_arr_adminLogin["forward"] = base64_encode(BG_URL_ADMIN . "ctl.php");
		}

		if (!fn_seccode()) { //验证码
			return array(
				"forward"    => $_arr_adminLogin["forward"],
				"alert"  => "x030101",
			);
			exit;
		}

		if (!fn_token("chk")) { //令牌
			return array(
				"forward"    => $_arr_adminLogin["forward"],
				"alert"  => "x030102",
			);
			exit;
		}

		$_arr_adminName = validateStr(fn_post("admin_name"), 1, 30, "str", "strDigit");
		switch ($_arr_adminName["status"]) {
			case "too_short":
				return array(
					"forward"   => $_arr_adminLogin["forward"],
					"alert" => "x020201",
				);
				exit;
			break;

			case "too_long":
				return array(
					"forward"   => $_arr_adminLogin["forward"],
					"alert" => "x020202",
				);
				exit;
			break;

			case "format_err":
				return array(
					"forward"   => $_arr_adminLogin["forward"],
					"alert" => "x020203",
				);
				exit;
			break;

			case "ok":
				$_arr_adminLogin["admin_name"] = $_arr_adminName["str"];
			break;

		}

		$_arr_adminPass = validateStr(fn_post("admin_pass"), 1, 0);
		switch ($_arr_adminPass["status"]) {
			case "too_short":
				return array(
					"forward"   => $_arr_adminLogin["forward"],
					"alert" => "x020208",
				);
				exit;
			break;

			case "ok":
				$_arr_adminLogin["admin_pass"] = $_arr_adminPass["str"];
			break;

		}

		$_arr_adminLogin["alert"] = "ok";
		$_arr_adminLogin["view"]      = fn_getSafe(fn_post("view"), "txt", "");

		return $_arr_adminLogin;
	}

}
