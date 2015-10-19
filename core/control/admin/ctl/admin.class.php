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
include_once(BG_PATH_CLASS . "tpl.class.php"); //载入模板类
include_once(BG_PATH_CLASS . "sso.class.php");

/*-------------管理员控制器-------------*/
class CONTROL_ADMIN {

	private $obj_base;
	private $config;
	private $adminLogged;
	private $obj_tpl;
	private $obj_sso;
	private $mdl_admin;
	private $tplData;

	function __construct() { //构造函数
		$this->obj_base       = $GLOBALS["obj_base"];
		$this->config         = $this->obj_base->config;
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_TPL . "admin/" . $this->config["ui"]); //初始化视图对象
		$this->obj_sso        = new CLASS_SSO(); //初始化单点登录
		$this->mdl_admin      = new MODEL_ADMIN(); //设置管理员对象
		$this->tplData = array(
			"adminLogged" => $this->adminLogged
		);
	}


	/** 管理员表单
	 * ctl_form function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_form() {
		$_num_adminId = fn_getSafe(fn_get("admin_id"), "int", 0);

		if ($_num_adminId > 0) {
			if (!isset($this->adminLogged["admin_allow"]["admin"]["edit"])) {
				return array(
					"alert" => "x020303",
				);
				exit;
			}
			if ($_num_adminId == $this->adminLogged["admin_id"]) {
				return array(
					"alert" => "x020306",
				);
				exit;
			}
			$_arr_ssoRow = $this->obj_sso->sso_get($_num_adminId);
			if ($_arr_ssoRow["alert"] != "y010102") { //SSO 中不存在该用户
				return $_arr_ssoRow;
				exit;
			}
			$_arr_adminRow = $this->mdl_admin->mdl_read($_num_adminId);
			if ($_arr_adminRow["alert"] != "y020102") { //不存在该管理员
				return $_arr_adminRow;
				exit;
			}
		} else {
			if (!isset($this->adminLogged["admin_allow"]["admin"]["add"])) {
				return array(
					"alert" => "x020302",
				);
				exit;
			}
			$_arr_adminRow = array(
				"admin_id"      => 0,
				"admin_note"    => "",
				"admin_status"  => "enable",
			);
			$_arr_ssoRow = array(
				"user_mail" => "",
				"user_nick" => "",
			);
		}

		$_arr_tpl = array(
			"ssoRow"     => $_arr_ssoRow,
			"adminRow"   => $_arr_adminRow, //管理员信息
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("admin_form.tpl", $_arr_tplData);

		return array(
			"alert" => "y020302",
		);
	}


	/** 显示管理员信息表单
	 * ctl_show function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_show() {
		if (!isset($this->adminLogged["admin_allow"]["admin"]["browse"])) {
			return array(
				"alert" => "x020301",
			);
			exit;
		}

		$_num_adminId = fn_getSafe(fn_get("admin_id"), "int", 0);

		$_arr_ssoRow = $this->obj_sso->sso_get($_num_adminId);
		if ($_arr_ssoRow["alert"] != "y010102") {
			return $_arr_ssoRow;
			exit;
		}
		$_arr_adminRow = $this->mdl_admin->mdl_read($_num_adminId);
		if ($_arr_adminRow["alert"] != "y020102") {
			return $_arr_adminRow;
			exit;
		}

		$_arr_tpl = array(
			"ssoRow"     => $_arr_ssoRow,
			"adminRow"   => $_arr_adminRow, //管理员信息
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("admin_show.tpl", $_arr_tplData);

		return array(
			"alert" => "y020302",
		);
	}


	/** 将用户授权为管理员表单
	 * ctl_auth function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_auth() {

		if (!isset($this->adminLogged["admin_allow"]["admin"]["add"])) {
			return array(
				"alert" => "x020302",
			);
			exit;
		}
		$_arr_adminRow["admin_status"] = "enable";

		$_arr_tpl = array(
			"adminRow"   => $_arr_adminRow, //管理员信息
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("admin_auth.tpl", $_arr_tplData);

		return array(
			"alert" => "y020302",
		);
	}


	/** 列出管理员
	 * ctl_list function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_list() {
		if (!isset($this->adminLogged["admin_allow"]["admin"]["browse"])) {
			return array(
				"alert" => "x020301",
			);
			exit;
		}

		//print_r($this->adminLogged);
		$_str_key     = fn_getSafe(fn_get("key"), "txt", "");
		$_str_status  = fn_getSafe(fn_get("status"), "txt", "");

		$_arr_search = array(
			"act_get"    => $GLOBALS["act_get"],
			"key"        => $_str_key,
			"status"     => $_str_status,
		);

		$_num_adminCount  = $this->mdl_admin->mdl_count($_str_key, $_str_status);
		$_arr_page        = fn_page($_num_adminCount); //取得分页数据
		$_str_query       = http_build_query($_arr_search);
		$_arr_adminRows   = $this->mdl_admin->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_str_key, $_str_status);

		$_arr_tpl = array(
			"query"      => $_str_query,
			"pageRow"    => $_arr_page,
			"search"     => $_arr_search,
			"adminRows"  => $_arr_adminRows,
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("admin_list.tpl", $_arr_tplData);

		return array(
			"alert" => "y020301",
		);
	}
}
