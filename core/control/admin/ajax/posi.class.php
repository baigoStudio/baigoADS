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
include_once(BG_PATH_MODEL . "posi.class.php");

/*-------------用户类-------------*/
class AJAX_POSI {

	private $adminLogged;
	private $mdl_posi;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_ajax       = new CLASS_AJAX();
		$this->obj_ajax->chk_install();
		$this->mdl_posi      = new MODEL_POSI();

		if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
			$this->obj_ajax->halt_alert($this->adminLogged["alert"]);
		}
	}

	function ajax_cache() {
		$_arr_posiRow = $this->mdl_posi->mdl_cache();

		$this->obj_ajax->halt_alert($_arr_posiRow["alert"]);
	}

	/**
	 * ajax_submit function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_submit() {
		$_arr_posiSubmit = $this->mdl_posi->input_submit();
		if ($_arr_posiSubmit["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_posiSubmit["alert"]);
		}

		if ($_arr_posiSubmit["posi_id"] > 0) {
			if (!isset($this->adminLogged["admin_allow"]["posi"]["edit"])) {
				$this->obj_ajax->halt_alert("x040303");
			}
		} else {
			if (!isset($this->adminLogged["admin_allow"]["posi"]["add"])) {
				$this->obj_ajax->halt_alert("x040302");
			}
		}

		$_arr_posiRow = $this->mdl_posi->mdl_submit();

		$this->mdl_posi->mdl_cache();

		$this->obj_ajax->halt_alert($_arr_posiRow["alert"]);
	}


	/**
	 * ajax_status function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_status() {
		if (!isset($this->adminLogged["admin_allow"]["posi"]["edit"])) {
			$this->obj_ajax->halt_alert("x040303");
		}

		$_arr_posiIds = $this->mdl_posi->input_ids();
		if ($_arr_posiIds["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_posiIds["alert"]);
		}

		$_str_posiStatus = fn_getSafe($GLOBALS["act_post"], "txt", "");
		if (!$_str_posiStatus) {
			$this->obj_ajax->halt_alert("x040207");
		}

		$_arr_posiRow = $this->mdl_posi->mdl_status($_str_posiStatus);

		$this->mdl_posi->mdl_cache();

		$this->obj_ajax->halt_alert($_arr_posiRow["alert"]);
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		if (!isset($this->adminLogged["admin_allow"]["posi"]["del"])) {
			$this->obj_ajax->halt_alert("x040304");
		}

		$_arr_posiIds = $this->mdl_posi->input_ids();
		if ($_arr_posiIds["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_posiIds["alert"]);
		}

		$_arr_posiRow = $this->mdl_posi->mdl_del();

		$this->mdl_posi->mdl_cache($_arr_posiIds["posi_ids"]);

		$this->obj_ajax->halt_alert($_arr_posiRow["alert"]);
	}


	/**
	 * ajax_chkGroup function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_chkname() {
		$_str_posiName   = fn_getSafe(fn_get("posi_name"), "txt", "");
		$_num_posiId     = fn_getSafe(fn_get("posi_id"), "int", 0);

		$_arr_posiRow = $this->mdl_posi->mdl_read($_str_posiName, "posi_name", $_num_posiId);

		if ($_arr_posiRow["alert"] == "y040102") {
			$this->obj_ajax->halt_re("x040203");
		}

		$arr_re = array(
			"re" => "ok"
		);

		exit(json_encode($arr_re));
	}
}
