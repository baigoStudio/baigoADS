<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_CLASS . "ajax.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "advert.class.php"); //载入管理帐号模型

/*-------------用户控制器-------------*/
class AJAX_ADVERT {

	private $adminLogged;
	private $obj_ajax;
	private $mdl_advert;

	function __construct() { //构造函数
		$this->adminLogged        = $GLOBALS["adminLogged"]; //已登录用户信息
		$this->obj_ajax           = new CLASS_AJAX(); //获取界面类型
		$this->obj_ajax->chk_install(); //获取界面类型
		$this->mdl_advert         = new MODEL_ADVERT(); //设置用户模型

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
		$_arr_advertSubmit = $this->mdl_advert->input_submit();

		if ($_arr_advertSubmit["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_advertSubmit["alert"]);
		}

		if ($_arr_advertSubmit["advert_id"] > 0) {
			if (!isset($this->adminLogged["admin_allow"]["advert"]["edit"])) {
				$this->obj_ajax->halt_alert("x080303");
			}
		} else {
			if (!isset($this->adminLogged["admin_allow"]["advert"]["add"])) {
				$this->obj_ajax->halt_alert("x080302");
			}
		}

		if (!isset($this->adminLogged["admin_allow"]["advert"]["approve"])) {
			$_str_advertStatus = "wait";
		} else {
			$_str_advertStatus = $_arr_advertSubmit["advert_status"];
		}

		$_arr_advertRow = $this->mdl_advert->mdl_submit($this->adminLogged["admin_id"], $_str_advertStatus);

		$this->obj_ajax->halt_alert($_arr_advertRow["alert"]);
	}


	/**
	 * ajax_status function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_status() {
		if (!isset($this->adminLogged["admin_allow"]["advert"]["approve"])) {
			$this->obj_ajax->halt_alert("x080303");
		}

		$_str_status = fn_getSafe($GLOBALS["act_post"], "txt", "");

		$_arr_advertIds = $this->mdl_advert->input_ids();
		if ($_arr_advertIds["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_advertIds["alert"]);
		}

		$_arr_advertRow = $this->mdl_advert->mdl_status($_str_status, $this->adminLogged["admin_id"]);

		$this->obj_ajax->halt_alert($_arr_advertRow["alert"]);
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		if (!isset($this->adminLogged["admin_allow"]["advert"]["del"])) {
			$this->obj_ajax->halt_alert("x080304");
		}

		$_arr_advertIds = $this->mdl_advert->input_ids();
		if ($_arr_advertIds["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_advertIds["alert"]);
		}

		$_arr_advertRow = $this->mdl_advert->mdl_del();

		$this->obj_ajax->halt_alert($_arr_advertRow["alert"]);
	}
}
