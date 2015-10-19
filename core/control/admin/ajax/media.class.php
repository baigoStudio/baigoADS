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
include_once(BG_PATH_CLASS . "dir.class.php"); //载入文件操作类
include_once(BG_PATH_CLASS . "upload.class.php"); //载入上传类
include_once(BG_PATH_MODEL . "media.class.php");

/*-------------用户类-------------*/
class AJAX_MEDIA {

	private $adminLogged;
	private $obj_ajax;
	private $mdl_media;
	private $mediaMime;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_ajax       = new CLASS_AJAX();
		$this->obj_ajax->chk_install();
		$this->obj_upload     = new CLASS_UPLOAD();
		$this->mdl_media      = new MODEL_MEDIA();
		$this->mdl_admin      = new MODEL_ADMIN();
		$this->setUpload();
	}


	function ajax_empty() {
		if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
			$this->show_err($this->adminLogged["alert"], "err");
		}

		if (!isset($this->adminLogged["admin_allow"]["media"]["del"])) {
			$this->show_err("x070304", "err");
		}

		if (!fn_token("chk")) { //令牌
			$this->show_err("x030102", "err");
		}

		$_arr_status = $this->obj_upload->upload_init();
		if ($_arr_status["alert"] != "y070403") {
			$this->show_err($_arr_status["alert"], "err");
		}


		$_arr_mediaIds    = array();
		$_num_perPage     = 10;
		$_num_mediaCount  = $this->mdl_media->mdl_count("", "", "", "", 0, "recycle");
		$_arr_page        = fn_page($_num_mediaCount, $_num_perPage, "post");
		$_arr_mediaRows   = $this->mdl_media->mdl_list($_num_perPage, 0, "", "", "", "", 0, "recycle");

		if ($_num_mediaCount > 0) {
			foreach ($_arr_mediaRows as $_key=>$_value) {
				$_arr_mediaIds[] = $_value["media_id"];
			}

			$_arr_mediaRows  = $this->mdl_media->mdl_list(1000, 0, "", "", "", "", 0, "recycle", $_arr_mediaIds);
			//print_r($_arr_mediaRows);
			$this->obj_upload->upload_del($_arr_mediaRows);
			//exit;

			$_arr_mediaDel   = $this->mdl_media->mdl_del(0, $_arr_mediaIds);
			$_str_status     = "loading";
			$_str_msg        = $this->obj_ajax->alert["x070408"];
		} else {
			$_str_status = "complete";
			$_str_msg    = $this->obj_ajax->alert["y070408"];
		}

		$_arr_re = array(
			"msg"    => $_str_msg,
			"count"  => $_arr_page["total"],
			"status" => $_str_status,
		);

		exit(json_encode($_arr_re));
	}


	function ajax_clear() {
		if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
			$this->show_err($this->adminLogged["alert"], "err");
		}

		if (!isset($this->adminLogged["admin_allow"]["media"]["del"])) {
			$this->show_err("x070304", "err");
		}

		$_num_last        = fn_getSafe(fn_post("last"), "int", 0);

		$_num_perPage     = 10;
		$_num_mediaCount  = $this->mdl_media->mdl_count("", "", "", "", 0, "normal");
		$_arr_page        = fn_page($_num_mediaCount, $_num_perPage, "post");
		$_arr_mediaRows   = $this->mdl_media->mdl_list($_num_perPage, 0, "", "", "", "", 0, "normal", false, 0, $_num_last);

		if ($_arr_mediaRows) {
			foreach ($_arr_mediaRows as $_key=>$_value) {
				$_arr_mediaRow = $this->mdl_media->mdl_chkMedia($_value["media_id"], $_value["media_ext"], $_value["media_time"]);
				if ($_arr_mediaRow["alert"] == "x070406") {
					$this->mdl_media->mdl_box("recycle", array($_value["media_id"]));
				}
			}
			$_str_status = "loading";
			$_str_msg    = $this->obj_ajax->alert["x070407"];
		} else {
			$_str_status = "complete";
			$_str_msg    = $this->obj_ajax->alert["y070407"];
		}

		$_arr_re = array(
			"msg"    => $_str_msg,
			"count"  => $_arr_page["total"],
			"last"   => $_value["media_id"],
			"status" => $_str_status,
		);

		exit(json_encode($_arr_re));
	}


	function ajax_box() {
		if (!isset($this->adminLogged["admin_allow"]["media"]["del"])) {
			$this->obj_ajax->halt_alert("x170303");
		}

		$_arr_mediaIds = $this->mdl_media->input_ids();
		if ($_arr_mediaIds["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_mediaIds["alert"]);
		}

		$_str_mediaStatus = fn_getSafe($GLOBALS["act_post"], "txt", "");
		if (!$_str_mediaStatus) {
			$this->obj_ajax->halt_alert("x070102");
		}

		$_arr_mediaRow = $this->mdl_media->mdl_box($_str_mediaStatus);

		$this->obj_ajax->halt_alert($_arr_mediaRow["alert"]);
	}

	/**
	 * ajax_submit function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_submit() {
		if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
			$this->show_err($this->adminLogged["alert"]);
		}

		$_arr_status = $this->obj_upload->upload_init();
		if ($_arr_status["alert"] != "y070403") {
			$this->show_err($_arr_status["alert"]);
		}

		if (!isset($this->adminLogged["admin_allow"]["media"]["upload"])) {
			$this->show_err("x070302");
		}

		if (!fn_token("chk")) { //令牌
			$this->show_err("x030102");
		}

		if (!is_array($this->mediaMime)) {
			$this->show_err("x070405");
		}

		$_arr_uploadRow = $this->obj_upload->upload_pre();

		if ($_arr_uploadRow["alert"] != "y100201") {
			$this->show_err($_arr_uploadRow["alert"]);
		}

		$_arr_mediaRow = $this->mdl_media->mdl_submit(0, $_arr_uploadRow["media_name"], $_arr_uploadRow["media_ext"], $_arr_uploadRow["media_mime"], $_arr_uploadRow["media_size"], $this->adminLogged["admin_id"]);

		if ($_arr_mediaRow["alert"] != "y070101") {
			$this->show_err($_arr_mediaRow["alert"]);
		}

		$_arr_uploadRowSubmit = $this->obj_upload->upload_submit($_arr_mediaRow["media_time"], $_arr_mediaRow["media_id"]);
		if ($_arr_uploadRowSubmit["alert"] != "y070401") {
			$this->show_err($_arr_uploadRowSubmit["alert"]);
		}
		$_arr_uploadRowSubmit["media_id"]    = $_arr_mediaRow["media_id"];
		$_arr_uploadRowSubmit["media_ext"]   = $_arr_uploadRow["media_ext"];
		$_arr_uploadRowSubmit["media_name"]  = $_arr_uploadRow["media_name"];

		exit(json_encode($_arr_uploadRowSubmit));
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
			$this->obj_ajax->halt_alert($this->adminLogged["alert"]);
		}

		$_arr_status = $this->obj_upload->upload_init();
		if ($_arr_status["alert"] != "y070403") {
			$this->obj_ajax->halt_alert($_arr_status["alert"]);
		}

		if (isset($this->adminLogged["admin_allow"]["media"]["del"])) {
			$_num_adminId = 0;
		} else {
			$_num_adminId = $this->adminLogged["admin_id"];
		}

		$_arr_mediaIds = $this->mdl_media->input_ids();
		if ($_arr_mediaIds["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_mediaIds["alert"]);
		}

		$_arr_mediaRows = $this->mdl_media->mdl_list(1000, 0, "", "", "", "", $_num_adminId, "", $_arr_mediaIds["media_ids"]);
		$this->obj_upload->upload_del($_arr_mediaRows);

		$_arr_mediaDel = $this->mdl_media->mdl_del($_num_adminId);

		$this->obj_ajax->halt_alert($_arr_mediaDel["alert"]);
	}


	/**
	 * ajax_list function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_list() {
		if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
			$this->obj_ajax->halt_alert($this->adminLogged["alert"]);
		}

		if (!isset($this->adminLogged["admin_allow"]["media"]["browse"])) {
			$this->obj_ajax->halt_alert("x070301");
		}

		$_str_key     = fn_getSafe(fn_get("key"), "txt", "");
		$_str_year    = fn_getSafe(fn_get("year"), "txt", "");
		$_str_month   = fn_getSafe(fn_get("month"), "txt", "");
		$_str_ext     = fn_getSafe(fn_get("ext"), "txt", "");

		$_num_perPage     = 8;
		$_num_mediaCount  = $this->mdl_media->mdl_count($_str_key, $_str_year, $_str_month, $_str_ext, 0, "normal");
		$_arr_page        = fn_page($_num_mediaCount, $_num_perPage);
		$_arr_mediaRows   = $this->mdl_media->mdl_list($_num_perPage, $_arr_page["except"], $_str_key, $_str_year, $_str_month, $_str_ext, 0, "normal");

		foreach ($_arr_mediaRows as $_key=>$_value) {
			$_arr_mediaRows[$_key]["adminRow"]  = $this->mdl_admin->mdl_read($_value["media_admin_id"]);
		}

		//print_r($_arr_page);

		$_arr_tpl = array(
			"pageRow"    => $_arr_page,
			"mediaRows"  => $_arr_mediaRows, //上传信息
		);

		exit(json_encode($_arr_tpl));
	}


	/**
	 * show_err function.
	 *
	 * @access private
	 * @param mixed $str_alert
	 * @return void
	 */
	private function show_err($str_alert, $status = "ok") {
		$_arr_re = array(
			"alert"  => $str_alert,
			"msg"        => $this->obj_ajax->alert[$str_alert],
			"status"     => $status,
		);
		if ($str_alert == "x070203") {
			$_arr_re["msg"] = $this->obj_ajax->alert[$str_alert] . " " . BG_UPLOAD_SIZE . " " . BG_UPLOAD_UNIT;
		}
		exit(json_encode($_arr_re));
	}


	/**
	 * setUpload function.
	 *
	 * @access private
	 * @return void
	 */
	private function setUpload() {
		foreach ($this->mdl_media->mime as $_key=>$_value) {
			$this->mediaMime[$_key] = $_value;
		}

		$this->obj_upload->mimeRows   = $this->mediaMime;
	}
}
