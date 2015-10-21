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
include_once(BG_PATH_CLASS . "sso.class.php"); //载入 AJAX 基类
include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "opt.class.php"); //载入管理帐号模型

class AJAX_INSTALL {

	private $obj_ajax;
	private $obj_db;

	function __construct() { //构造函数
		$this->obj_ajax       = new CLASS_AJAX(); //初始化 AJAX 基对象

		if (file_exists(BG_PATH_CONFIG . "is_install.php")) {
			$this->obj_ajax->halt_alert("x030403");
		}

		$this->install_init();
		$this->mdl_opt = new MODEL_OPT();
	}


	/**
	 * install_1_do function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_dbconfig() {
		$_arr_dbconfig = $this->mdl_opt->input_dbconfig();
		if ($_arr_dbconfig["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_dbconfig["alert"]);
		}

		$_arr_return = $this->mdl_opt->mdl_dbconfig();

		if ($_arr_return["alert"] != "y060101") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		$this->obj_ajax->halt_alert("y030404");
	}


	function ajax_dbtable() {
		$this->check_db();

		$this->table_admin();
		$this->table_advert();
		$this->table_media();
		$this->table_posi();
		$this->table_stat();

		$this->obj_ajax->halt_alert("y030103");
	}


	/**
	 * install_2_do function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_base() {
		$this->check_db();

		$_num_countSrc = 0;

		foreach ($this->obj_ajax->opt["base"] as $_key=>$_value) {
			if ($_value["min"] > 0) {
				$_num_countSrc++;
			}
		}

		$_arr_const = $this->mdl_opt->input_const("base");

		$_num_countInput = count(array_filter($_arr_const));

		if ($_num_countInput < $_num_countSrc) {
			$this->obj_ajax->halt_alert("x030212");
		}

		$_arr_return = $this->mdl_opt->mdl_const("base");

		if ($_arr_return["alert"] != "y060101") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		$this->obj_ajax->halt_alert("y030405");
	}


	/**
	 * install_3_do function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_upload() {
		$this->check_db();

		$_num_countSrc = 0;

		foreach ($this->obj_ajax->opt["upload"] as $_key=>$_value) {
			if ($_value["min"] > 0) {
				$_num_countSrc++;
			}
		}

		$_arr_const = $this->mdl_opt->input_const("upload");

		$_num_countInput = count(array_filter($_arr_const));

		if ($_num_countInput < $_num_countSrc) {
			$this->obj_ajax->halt_alert("x030212");
		}

		$_arr_return = $this->mdl_opt->mdl_const("upload");

		if ($_arr_return["alert"] != "y060101") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		$this->obj_ajax->halt_alert("y030409");
	}


	function ajax_sso() {
		$this->check_db();

		$_num_countSrc = 0;

		foreach ($this->obj_ajax->opt["sso"] as $_key=>$_value) {
			if ($_value["min"] > 0) {
				$_num_countSrc++;
			}
		}

		$_arr_const = $this->mdl_opt->input_const("sso");

		$_num_countInput = count(array_filter($_arr_const));

		if ($_num_countInput < $_num_countSrc) {
			$this->obj_ajax->halt_alert("x030212");
		}

		$_arr_return = $this->mdl_opt->mdl_const("sso");

		if ($_arr_return["alert"] != "y060101") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		$this->obj_ajax->halt_alert("y030408");
	}


	function ajax_admin() {
		$this->check_db();

		include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型
		$_mdl_admin  = new MODEL_ADMIN();

		$_arr_adminSubmit = $_mdl_admin->input_submit();

		if ($_arr_adminSubmit["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminSubmit["alert"]);
		}

		$_arr_adminInput = $this->input_admin();

		if ($_arr_adminInput["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminInput["alert"]);
		}

		$_obj_sso = new CLASS_SSO();

		$_arr_ssoReg = $_obj_sso->sso_reg($_arr_adminSubmit["admin_name"], $this->adminSubmit["admin_pass"], $_arr_adminSubmit["admin_mail"], $_arr_adminSubmit["admin_nick"]);
		if ($_arr_ssoReg["alert"] != "y010101") {
			$this->obj_ajax->halt_alert($_arr_ssoReg["alert"]);
		}

		$_mdl_admin->mdl_submit($_arr_ssoReg["user_id"]);

		$this->obj_ajax->halt_alert("y030407");
	}


	function ajax_auth() {
		$this->check_db();

		include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型
		$_mdl_admin  = new MODEL_ADMIN(); //设置管理组模型

		$_arr_adminSubmit = $_mdl_admin->input_submit();
		if ($_arr_adminSubmit["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminSubmit["alert"]);
		}

		$_obj_sso = new CLASS_SSO();

		$_arr_ssoGet = $_obj_sso->sso_get($_arr_adminSubmit["admin_name"], "user_name");
		if ($_arr_ssoGet["alert"] != "y010102") {
			if ($_arr_ssoGet["alert"] == "x010102") {
				$this->obj_ajax->halt_alert("x020205");
			} else {
				$this->obj_ajax->halt_alert($_arr_ssoGet["alert"]);
			}
		} else {
			//检验用户是否存在
			$_arr_adminRow = $_mdl_admin->mdl_read($_arr_ssoGet["user_id"]);
			if ($_arr_adminRow["alert"] == "y020102") {
				$this->obj_ajax->halt_alert("x020214");
			}
		}

		$_mdl_admin->mdl_submit($_arr_ssoGet["user_id"]);

		$this->obj_ajax->halt_alert("y030409");
	}


	function ajax_ssoAuto() {
		$this->check_db();

		if (!file_exists(BG_PATH_SSO . "api/api.php")) {
			$this->obj_ajax->halt_alert("x030420");
		}

		$_obj_sso = new CLASS_SSO();

		$_arr_return = $_obj_sso->sso_install();
		if ($_arr_return["alert"] != "y030103") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		$this->obj_ajax->halt_alert("y030410");
	}


	function ajax_ssoAdmin() {
		$this->check_db();

		if (!file_exists(BG_PATH_SSO . "api/api.php")) {
			$this->obj_ajax->halt_alert("x030420");
		}

		include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型
		$_mdl_admin  = new MODEL_ADMIN(); //设置管理组模型

		$_arr_adminSubmit = $_mdl_admin->input_submit();
		if ($_arr_adminSubmit["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminSubmit["alert"]);
		}

		$_arr_adminInput = $this->input_admin();

		if ($_arr_adminInput["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminInput["alert"]);
		}

		$_obj_sso = new CLASS_SSO();

		$_arr_return = $_obj_sso->sso_admin($_arr_adminSubmit["admin_name"], $this->adminSubmit["admin_pass"]);
		if ($_arr_return["alert"] != "y030408") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		$_arr_ssoReg = $_obj_sso->sso_reg($_arr_adminSubmit["admin_name"], $this->adminSubmit["admin_pass"], $_arr_adminSubmit["admin_mail"], $_arr_adminSubmit["admin_nick"]);
		if ($_arr_ssoReg["alert"] != "y010101") {
			$this->obj_ajax->halt_alert($_arr_ssoReg["alert"]);
		}

		$_mdl_admin->mdl_submit($_arr_ssoReg["user_id"]);

		$this->obj_ajax->halt_alert("y030408");
	}


	function ajax_over() {
		$this->check_db();

		$_arr_return = $this->mdl_opt->mdl_over();

		if ($_arr_return["alert"] != "y060101") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		$this->obj_ajax->halt_alert("y030411");
	}


	function ajax_chkname() {
		$this->check_db();

		include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型
		$_mdl_admin   = new MODEL_ADMIN(); //设置管理组模型
		$_obj_sso     = new CLASS_SSO();

		$_str_adminName   = fn_getSafe(fn_get("admin_name"), "txt", "");
		$_arr_ssoGet      = $_obj_sso->sso_get($_str_adminName, "user_name");

		if ($_arr_ssoGet["alert"] == "y010102") {
			$_arr_adminRow = $_mdl_admin->mdl_read($_arr_ssoGet["user_id"]);
			if ($_arr_adminRow["alert"] == "y020102") {
				$this->obj_ajax->halt_re("x020214");
			} else {
				$this->obj_ajax->halt_re("x020204");
			}
		}

		$arr_re = array(
			"re" => "ok"
		);

		exit(json_encode($arr_re));
	}


	function ajax_chkauth() {
		$this->check_db();

		include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型
		$_mdl_admin   = new MODEL_ADMIN(); //设置管理组模型
		$_obj_sso     = new CLASS_SSO();

		$_str_adminName   = fn_getSafe(fn_get("admin_name"), "txt", "");
		$_arr_ssoGet      = $_obj_sso->sso_get($_str_adminName, "user_name");

		if ($_arr_ssoGet["alert"] == "y010102") {
			//检验用户是否存在
			$_arr_adminRow = $_mdl_admin->mdl_read($_arr_ssoGet["user_id"]);
			if ($_arr_adminRow["alert"] == "y020102") {
				$this->obj_ajax->halt_re("x020214");
			}
		} else {
			if ($_arr_ssoGet["alert"] == "x010102") {
				$this->obj_ajax->halt_re("x020205");
			} else {
				$this->obj_ajax->halt_re($_arr_ssoGet["alert"]);
			}
		}

		$arr_re = array(
			"re" => "ok"
		);

		exit(json_encode($arr_re));
	}


	private function table_admin() {
		include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型
		$_mdl_admin       = new MODEL_ADMIN();
		$_arr_adminRow    = $_mdl_admin->mdl_create_table();

		if ($_arr_adminRow["alert"] != "y020105") {
			$this->obj_ajax->halt_alert($_arr_adminRow["alert"]);
		}
	}


	private function table_advert() {
		include_once(BG_PATH_MODEL . "advert.class.php"); //载入管理帐号模型
		$_mdl_advert       = new MODEL_ADVERT();
		$_arr_advertRow    = $_mdl_advert->mdl_create_table();

		if ($_arr_advertRow["alert"] != "y080105") {
			$this->obj_ajax->halt_alert($_arr_advertRow["alert"]);
		}
	}


	private function table_media() {
		include_once(BG_PATH_MODEL . "media.class.php"); //载入管理帐号模型
		$_mdl_media       = new MODEL_MEDIA();
		$_arr_mediaRow    = $_mdl_media->mdl_create_table();

		if ($_arr_mediaRow["alert"] != "y070105") {
			$this->obj_ajax->halt_alert($_arr_mediaRow["alert"]);
		}
	}


	private function table_posi() {
		include_once(BG_PATH_MODEL . "posi.class.php"); //载入管理帐号模型
		$_mdl_posi       = new MODEL_POSI();
		$_arr_posiRow    = $_mdl_posi->mdl_create_table();

		if ($_arr_posiRow["alert"] != "y040105") {
			$this->obj_ajax->halt_alert($_arr_posiRow["alert"]);
		}
	}


	private function table_stat() {
		include_once(BG_PATH_MODEL . "stat.class.php"); //载入管理帐号模型
		$_mdl_stat       = new MODEL_STAT();
		$_arr_statRow    = $_mdl_stat->mdl_create_table();

		if ($_arr_statRow["alert"] != "y090105") {
			$this->obj_ajax->halt_alert($_arr_statRow["alert"]);
		}
	}


	private function input_admin() {
		$_arr_adminPass = validateStr(fn_post("admin_pass"), 1, 0);
		switch ($_arr_adminPass["status"]) {
			case "too_short":
				return array(
					"alert" => "x020210",
				);
				exit;
			break;

			case "ok":
				$this->adminSubmit["admin_pass"] = $_arr_adminPass["str"];
			break;
		}

		$_arr_adminPassConfirm = validateStr(fn_post("admin_pass_confirm"), 1, 0);
		switch ($_arr_adminPassConfirm["status"]) {
			case "too_short":
				return array(
					"alert" => "x020215",
				);
				exit;
			break;

			case "ok":
				$this->adminSubmit["admin_pass_confirm"] = $_arr_adminPassConfirm["str"];
			break;
		}

		if ($this->adminSubmit["admin_pass"] != $this->adminSubmit["admin_pass_confirm"]) {
			return array(
				"alert" => "x020211",
			);
			exit;
		}

		$this->adminSubmit["alert"]       = "ok";

		return $this->adminSubmit;
	}


	private function input_auth() {
		$_arr_adminPass = validateStr(fn_post("admin_pass"), 1, 0);
		switch ($_arr_adminPass["status"]) {
			case "too_short":
				return array(
					"alert" => "x020210",
				);
				exit;
			break;

			case "ok":
				$this->adminAuth["admin_pass"] = $_arr_adminPass["str"];
			break;
		}

		$this->adminAuth["alert"]         = "ok";

		return $this->adminAuth;
	}


	private function check_db() {
		if (!fn_token("chk")) { //令牌
			$this->obj_ajax->halt_alert("x030102");
		}

		if (strlen(BG_DB_HOST) < 1 || strlen(BG_DB_NAME) < 1 || strlen(BG_DB_USER) < 1 || strlen(BG_DB_PASS) < 1 || strlen(BG_DB_CHARSET) < 1) {
			$this->obj_ajax->halt_alert("x030404");
		} else {
			if (!defined("BG_DB_PORT")) {
				define("BG_DB_PORT", "3306");
			}

			$_cfg_host = array(
				"host"      => BG_DB_HOST,
				"name"      => BG_DB_NAME,
				"user"      => BG_DB_USER,
				"pass"      => BG_DB_PASS,
				"charset"   => BG_DB_CHARSET,
				"debug"     => BG_DEBUG_DB,
				"port"      => BG_DB_PORT,
			);

			$GLOBALS["obj_db"]   = new CLASS_MYSQLI($_cfg_host); //设置数据库对象
			$this->obj_db        = $GLOBALS["obj_db"];

			if (!$this->obj_db->connect()) {
				$this->obj_ajax->halt_alert("x030111");
			}

			if (!$this->obj_db->select_db()) {
				$this->obj_ajax->halt_alert("x030112");
			}
		}
	}

	private function install_init() {
		$_arr_extRow     = get_loaded_extensions();
		$_num_errCount   = 0;

		foreach ($this->obj_ajax->type["ext"] as $_key=>$_value) {
			if (!in_array($_key, $_arr_extRow)) {
				$_num_errCount++;
			}
		}

		if ($_num_errCount > 0) {
			$this->obj_ajax->halt_alert("x030417");
		}
	}

}
