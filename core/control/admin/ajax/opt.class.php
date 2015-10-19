<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "opt.class.php"); //载入管理帐号模型

/*-------------管理员控制器-------------*/
class AJAX_OPT {

	private $adminLogged;
	private $obj_ajax;
	private $mdl_opt;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //已登录商家信息
		$this->obj_ajax       = new CLASS_AJAX(); //初始化 AJAX 基对象
		$this->obj_ajax->chk_install(); //获取界面类型
		$this->mdl_opt        = new MODEL_OPT(); //设置管理组模型

		if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
			$this->obj_ajax->halt_alert($this->adminLogged["alert"]);
		}
	}

	function ajax_upload() {
		if (!isset($this->adminLogged["admin_allow"]["opt"]["upload"])) {
			$this->obj_ajax->halt_alert("x060301");
		}

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

		$this->obj_ajax->halt_alert("y060402");
	}

	/**
	 * ajax_sso function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_sso() {
		if (!isset($this->adminLogged["admin_allow"]["opt"]["sso"])) {
			$this->obj_ajax->halt_alert("x060301");
		}

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

		$this->obj_ajax->halt_alert("y060403");
	}


	/**
	 * ajax_base function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_base() {
		if (!isset($this->adminLogged["admin_allow"]["opt"]["base"])) {
			$this->obj_ajax->halt_alert("x060301");
		}

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

		$this->obj_ajax->halt_alert("y060401");
	}


	/**
	 * ajax_db function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_db() {
		if (!isset($this->adminLogged["admin_allow"]["opt"]["db"])) {
			$this->obj_ajax->halt_alert("x060306");
		}

		$_arr_dbconfig = $this->mdl_opt->input_dbconfig();
		if ($_arr_dbconfig["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_dbconfig["alert"]);
		}

		$_arr_return = $this->mdl_opt->mdl_dbconfig();

		if ($_arr_return["alert"] != "y060101") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		$this->obj_ajax->halt_alert("y060406");
	}

}