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
include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_CLASS . "sso.class.php"); //载入模板类

/*-------------UC 类-------------*/
class AJAX_ADMIN {

	private $adminLogged;
	private $obj_ajax;
	private $obj_sso;
	private $mdl_admin;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_ajax       = new CLASS_AJAX();
		$this->obj_ajax->chk_install();
		$this->obj_sso        = new CLASS_SSO();
		$this->mdl_admin      = new MODEL_ADMIN();

		if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
			$this->obj_ajax->halt_alert($this->adminLogged["alert"]);
		}
	}


	/**
	 * ajax_submit function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_submit() {
		$_arr_adminSubmit = $this->mdl_admin->input_submit();

		if ($_arr_adminSubmit["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminSubmit["alert"]);
		}

		if ($_arr_adminSubmit["admin_id"] > 0) {
			if (!isset($this->adminLogged["admin_allow"]["admin"]["edit"])) {
				$this->obj_ajax->halt_alert("x020303");
			}

			if ($_arr_adminSubmit["admin_id"] == $this->adminLogged["admin_id"]) {
				$this->obj_ajax->halt_alert("x020306");
			}

			$_arr_ssoGet = $this->obj_sso->sso_get($_arr_adminSubmit["admin_id"]);
			if ($_arr_ssoGet["alert"] != "y010102") {
				$this->obj_ajax->halt_alert($_arr_ssoGet["alert"]);
			}

			$_str_adminPass  = fn_post("admin_pass");
			$_arr_ssoEdit    = $this->obj_sso->sso_edit($_arr_adminSubmit["admin_name"], "", $_str_adminPass, $_arr_adminSubmit["admin_mail"], $_arr_adminSubmit["admin_nick"]);
			$_num_adminId    = $_arr_adminSubmit["admin_id"];
		} else {
			if (!isset($this->adminLogged["admin_allow"]["admin"]["add"])) {
				$this->obj_ajax->halt_alert("x020302");
			}

			$_arr_adminPass = validateStr(fn_post("admin_pass"), 1, 0);
			switch ($_arr_adminPass["status"]) {
				case "too_short":
					$this->obj_ajax->halt_alert("x020210");
				break;

				case "ok":
					$_str_adminPass = $_arr_adminPass["str"];
				break;
			}
			$_arr_ssoReg = $this->obj_sso->sso_reg($_arr_adminSubmit["admin_name"], $_str_adminPass, $_arr_adminSubmit["admin_mail"], $_arr_adminSubmit["admin_nick"]);
			if ($_arr_ssoReg["alert"] != "y010101") {
				$this->obj_ajax->halt_alert($_arr_ssoReg["alert"]);
			}
			$_num_adminId = $_arr_ssoReg["user_id"];
		}

		$_arr_adminRow = $this->mdl_admin->mdl_submit($_num_adminId);

		if ($_arr_ssoEdit["alert"] == "y010103" || $_arr_adminRow["alert"] == "y020103") {
			$_str_alert = "y020103";
		} else {
			$_str_alert = $_arr_adminRow["alert"];
		}

		$this->obj_ajax->halt_alert($_str_alert);
	}


	/**
	 * ajax_auth function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_auth() {
		$_arr_adminSubmit = $this->mdl_admin->input_submit();

		if ($_arr_adminSubmit["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminSubmit["alert"]);
		}

		if (!isset($this->adminLogged["admin_allow"]["admin"]["add"])) {
			$this->obj_ajax->halt_alert("x020302");
		}

		$_arr_ssoGet = $this->obj_sso->sso_get($_arr_adminSubmit["admin_name"], "user_name");
		if ($_arr_ssoGet["alert"] != "y010102") {
			$this->obj_ajax->halt_alert($_arr_ssoGet["alert"]);
		}

		$_arr_adminRow = $this->mdl_admin->mdl_submit($_arr_ssoGet["user_id"]);
		if ($_arr_adminRow["alert"] == "x020101") {
			$_str_alert = "y020101";
		} else {
			$_str_alert = $_arr_adminRow["alert"];
		}

		$this->obj_ajax->halt_alert($_str_alert);
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		if (!isset($this->adminLogged["admin_allow"]["admin"]["del"])) {
			$this->obj_ajax->halt_alert("x020304");
		}

		$_arr_adminIds = $this->mdl_admin->input_ids();
		if ($_arr_adminIds["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminIds["alert"]);
		}

		$_arr_adminRow = $this->mdl_admin->mdl_del();

		$this->obj_ajax->halt_alert($_arr_adminRow["alert"]);
	}


	/**
	 * ajax_status function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_status() {
		if (!isset($this->adminLogged["admin_allow"]["admin"]["edit"])) {
			$this->obj_ajax->halt_alert("x020303");
		}

		$_arr_adminIds = $this->mdl_admin->input_ids();
		if ($_arr_adminIds["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminIds["alert"]);
		}

		$_str_adminStatus = fn_getSafe($GLOBALS["act_post"], "txt", "");
		if (!$_str_adminStatus) {
			$this->obj_ajax->halt_alert("x020213");
		}

		$_arr_adminRow = $this->mdl_admin->mdl_status($_str_adminStatus);

		$this->obj_ajax->halt_alert($_arr_adminRow["alert"]);
	}

	/**
	 * ajax_chkname function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_chkname() {
		$_str_adminName   = fn_getSafe(fn_get("admin_name"), "txt", "");
		$_arr_ssoChk      = $this->obj_sso->sso_chkname($_str_adminName);

		if ($_arr_ssoChk["alert"] != "y010205") {
			if ($_arr_ssoChk["alert"] == "x010205") {
				$_arr_ssoGet = $this->obj_sso->sso_get($_str_adminName, "user_name");
				//检验用户是否存在
				$_arr_adminRow = $this->mdl_admin->mdl_read($_arr_ssoGet["user_id"]);
				if ($_arr_adminRow["alert"] == "y020102") {
					$this->obj_ajax->halt_re("x020206");
				} else {
					$this->obj_ajax->halt_re("x020204");
				}
			} else {
				$this->obj_ajax->halt_re($_arr_ssoChk["alert"]);
			}
		}

		$arr_re = array(
			"re" => "ok"
		);

		exit(json_encode($arr_re));
	}


	function ajax_chkauth() {
		$_str_adminName   = fn_getSafe(fn_get("admin_name"), "txt", "");
		$_arr_ssoGet      = $this->obj_sso->sso_get($_str_adminName, "user_name");

		if ($_arr_ssoGet["alert"] != "y010102") {
			if ($_arr_ssoGet["alert"] == "x010102") {
				$this->obj_ajax->halt_re("x020205");
			} else {
				$this->obj_ajax->halt_re($_arr_ssoGet["alert"]);
			}
		} else {
			//检验用户是否存在
			$_arr_adminRow = $this->mdl_admin->mdl_read($_arr_ssoGet["user_id"]);
			if ($_arr_adminRow["alert"] == "y020102") {
				$this->obj_ajax->halt_re("x020206");
			}
		}

		$arr_re = array(
			"re" => "ok"
		);

		exit(json_encode($arr_re));
	}


	/**
	 * ajax_chkmail function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_chkmail() {
		$_str_adminMail   = fn_getSafe(fn_get("admin_mail"), "txt", "");
		$_num_adminId     = fn_getSafe(fn_get("admin_id"), "int", 0);
		$_arr_ssoChk      = $this->obj_sso->sso_chkmail($_str_adminMail, $_num_adminId);
		//print_r($_arr_ssoChk);

		if ($_arr_ssoChk["alert"] != "y010211") {
			$this->obj_ajax->halt_re($_arr_ssoChk["alert"]);
		}

		$arr_re = array(
			"re" => "ok"
		);

		exit(json_encode($arr_re));
	}
}
