<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------用户类-------------*/
class MODEL_ADMIN {

	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db     = $GLOBALS["obj_db"]; //设置数据库对象
	}

	function mdl_create_table() {
		$_arr_adminCreate = array(
			"admin_id"               => "int NOT NULL AUTO_INCREMENT COMMENT 'ID'",
			"admin_name"             => "varchar(30) NOT NULL COMMENT '用户名'",
			"admin_note"             => "varchar(30) NOT NULL COMMENT '备注'",
			"admin_nick"             => "varchar(30) NOT NULL COMMENT '昵称'",
			"admin_rand"             => "char(6) NOT NULL COMMENT '随机码'",
			"admin_allow"            => "text NOT NULL COMMENT '权限'",
			"admin_time"             => "int NOT NULL COMMENT '登录时间'",
			"admin_time_login"       => "int NOT NULL COMMENT '最后登录'",
			"admin_status"           => "enum('enable','disable') NOT NULL COMMENT '状态'",
			"admin_ip"               => "char(15) NOT NULL COMMENT 'IP'",
			"admin_allow_profile"    => "varchar(1000) NOT NULL COMMENT '个人权限'",
		);

		$_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "admin", $_arr_adminCreate, "admin_id", "管理帐号");

		if ($_num_mysql > 0) {
			$_str_alert = "y020105"; //更新成功
		} else {
			$_str_alert = "x020105"; //更新成功
		}

		return array(
			"alert" => $_str_alert, //更新成功
		);
	}


	function mdl_column() {
		$_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "admin");

		foreach ($_arr_colRows as $_key=>$_value) {
			$_arr_col[] = $_value["Field"];
		}

		return $_arr_col;
	}

	/**
	 * mdl_login function.
	 *
	 * @access public
	 * @param mixed $num_adminId
	 * @param mixed $str_rand
	 * @return void
	 */
	function mdl_login($num_adminId, $str_rand) {

		$_arr_adminUpdate = array(
			"admin_time_login"   => time(),
			"admin_ip"           => fn_getIp(),
			"admin_rand"         => $str_rand,
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "admin", $_arr_adminUpdate, "admin_id=" . $num_adminId); //更新数据

		if ($_num_mysql > 0) {
			$_str_alert = "y020103"; //更新成功
		} else {
			$_str_alert = "x020103"; //更新成功
		}

		return array(
			"alert" => $_str_alert, //更新成功
		);
	}


	function mdl_profile($num_adminId) {

		$_arr_adminData = array(
			"admin_nick" => $this->adminProfile["admin_nick"],
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "admin", $_arr_adminData, "admin_id=" . $num_adminId); //更新数据
		if ($_num_mysql > 0) {
			$_str_alert = "y020103"; //更新成功
		} else {
			$_str_alert = "x020103"; //更新失败
		}

		return array(
			"alert"  => $_str_alert, //成功
		);
	}


	/**
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $num_adminId
	 * @param mixed $str_adminNote
	 * @param mixed $str_adminRand
	 * @param mixed $str_adminStatus
	 * @param mixed $str_adminAllowCate
	 * @return void
	 */
	function mdl_submit($num_adminId) {

		$_arr_adminRow = $this->mdl_read($num_adminId);

		$_arr_adminData = array(
			"admin_note"             => $this->adminSubmit["admin_note"],
			"admin_nick"             => $this->adminSubmit["admin_nick"],
			"admin_status"           => $this->adminSubmit["admin_status"],
			"admin_allow"            => $this->adminSubmit["admin_allow"],
			"admin_allow_profile"    => $this->adminSubmit["admin_allow_profile"],
		);

		if ($_arr_adminRow["alert"] == "x020102") {
			$_arr_insert = array(
				"admin_id"      => $num_adminId,
				"admin_rand"    => fn_rand(6),
				"admin_name"    => $this->adminSubmit["admin_name"],
				"admin_time"    => time(),
			);
			$_arr_data       = array_merge($_arr_adminData, $_arr_insert);
			$_num_adminId    = $this->obj_db->insert(BG_DB_TABLE . "admin", $_arr_data); //插入数据
			if ($_num_adminId >= 0) {
				$_str_alert = "y020101"; //插入成功
			} else {
				return array(
					"alert" => "x020101", //更新失败
				);
				exit;
			}
		} else {
			$_num_adminId    = $num_adminId;
			$_num_mysql      = $this->obj_db->update(BG_DB_TABLE . "admin", $_arr_adminData, "admin_id=" . $_num_adminId); //更新数据
			if ($_num_mysql > 0) {
				$_str_alert = "y020103"; //更新成功
			} else {
				return array(
					"alert" => "x020103", //更新失败
				);
				exit;
			}
		}

		return array(
			"admin_id"   => $_num_adminId,
			"alert"  => $_str_alert, //成功
		);
	}


	/**
	 * mdl_status function.
	 *
	 * @access public
	 * @param mixed $this->adminIds["admin_ids"]
	 * @param mixed $str_status
	 * @return void
	 */
	function mdl_status($str_status) {

		$_str_adminId = implode(",", $this->adminIds["admin_ids"]);

		$_arr_adminUpdate = array(
			"admin_status" => $str_status,
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "admin", $_arr_adminUpdate, "admin_id IN (" . $_str_adminId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y020103";
		} else {
			$_str_alert = "x020103";
		}

		return array(
			"alert" => $_str_alert,
		); //成功

	}


	/**
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $num_adminId
	 * @return void
	 */
	function mdl_read($num_adminId) {

		$_arr_adminSelect = array(
			"admin_id",
			"admin_name",
			"admin_note",
			"admin_nick",
			"admin_rand",
			"admin_status",
			"admin_time",
			"admin_ip",
			"admin_allow",
			"admin_allow_profile",
		);

		$_arr_adminRows = $this->obj_db->select(BG_DB_TABLE . "admin", $_arr_adminSelect, "admin_id=" . $num_adminId, "", "", 1, 0); //检查本地表是否存在记录

		if (isset($_arr_adminRows[0])) { //用户名不存在则返回错误
			$_arr_adminRow = $_arr_adminRows[0];
		} else {
			return array(
				"alert" => "x020102", //不存在记录
			);
			exit;
		}

		if (isset($_arr_adminRow["admin_allow"])) {
			$_arr_adminRow["admin_allow"]    = fn_jsonDecode($_arr_adminRow["admin_allow"], "no"); //json解码
		} else {
			$_arr_adminRow["admin_allow"]    = array();
		}

		if (isset($_arr_adminRow["admin_allow_profile"])) {
			$_arr_adminRow["admin_allow_profile"] = fn_jsonDecode($_arr_adminRow["admin_allow_profile"], "no"); //json解码
		} else {
			$_arr_adminRow["admin_allow_profile"] = array();
		}

		$_arr_adminRow["alert"]           = "y020102";

		return $_arr_adminRow;

	}


	/**
	 * mdl_list function.
	 *
	 * @access public
	 * @param mixed $num_no
	 * @param int $num_except (default: 0)
	 * @param string $str_key (default: "")
	 * @param string $str_status (default: "")
	 * @return void
	 */
	function mdl_list($num_no, $num_except = 0, $str_key = "", $str_status = "") {

		$_arr_adminSelect = array(
			"admin_id",
			"admin_name",
			"admin_note",
			"admin_nick",
			"admin_status",
		);

		$_str_sqlWhere = "1=1";

		if ($str_key) {
			$_str_sqlWhere .= " AND (admin_note LIKE '%" . $str_key . "%' OR admin_nick LIKE '%" . $str_key . "%')";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND admin_status='" . $str_status . "'";
		}

		$_arr_adminRows = $this->obj_db->select(BG_DB_TABLE . "admin", $_arr_adminSelect, $_str_sqlWhere, "", "admin_id DESC", $num_no, $num_except); //查询数据

		//print_r($_arr_adminRows);

		return $_arr_adminRows;

	}


	/**
	 * mdl_count function.
	 *
	 * @access public
	 * @param string $str_key (default: "")
	 * @param string $str_status (default: "")
	 * @return void
	 */
	function mdl_count($str_key = "", $str_status = "") {
		$_str_sqlWhere = "1=1";

		if ($str_key) {
			$_str_sqlWhere .= " AND (admin_note LIKE '%" . $str_key . "%' OR admin_nick LIKE '%" . $str_key . "%')";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND admin_status='" . $str_status . "'";
		}

		$_num_count = $this->obj_db->count(BG_DB_TABLE . "admin", $_str_sqlWhere); //查询数据

		return $_num_count;
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @param mixed $this->adminIds["admin_ids"]
	 * @return void
	 */
	function mdl_del() {

		$_str_adminId = implode(",", $this->adminIds["admin_ids"]);

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "admin", "admin_id IN (" . $_str_adminId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y020104";
		} else {
			$_str_alert = "x020104";
		}

		return array(
			"alert" => $_str_alert,
		); //成功

	}


	function input_profile() {
		if (!fn_token("chk")) { //令牌
			return array(
				"alert" => "x030102",
			);
			exit;
		}


		$_arr_adminNick = validateStr(fn_post("admin_nick"), 0, 30);
		switch ($_arr_adminNick["status"]) {
			case "too_long":
				return array(
					"alert" => "x020216",
				);
				exit;
			break;

			case "ok":
				$this->adminProfile["admin_nick"] = $_arr_adminNick["str"];
			break;
		}

		$_arr_adminMail = validateStr(fn_post("admin_mail"), 0, 900, "str", "email");
		switch ($_arr_adminMail["status"]) {
			case "too_long":
				return array(
					"alert" => "x020208",
				);
				exit;
			break;

			case "format_err":
				return array(
					"alert" => "x020209",
				);
				exit;
			break;

			case "ok":
				$this->adminProfile["admin_mail"] = $_arr_adminMail["str"];
			break;
		}

		$this->adminProfile["alert"] = "ok";

		return $this->adminProfile;
	}


	/**
	 * input_submit function.
	 *
	 * @access public
	 * @return void
	 */
	function input_submit() {
		if (!fn_token("chk")) { //令牌
			return array(
				"alert" => "x030102",
			);
			exit;
		}

		$this->adminSubmit["admin_id"] = fn_getSafe(fn_post("admin_id"), "int", 0);

		if ($this->adminSubmit["admin_id"] > 0) {
			$_arr_adminRow = $this->mdl_read($this->adminSubmit["admin_id"]);
			if ($_arr_adminRow["alert"] != "y020102") {
				return $_arr_adminRow;
				exit;
			}
		}

		$_arr_adminName = validateStr(fn_post("admin_name"), 1, 30, "str", "strDigit");
		switch ($_arr_adminName["status"]) {
			case "too_short":
				return array(
					"alert" => "x020201",
				);
				exit;
			break;

			case "too_long":
				return array(
					"alert" => "x020202",
				);
				exit;
			break;

			case "format_err":
				return array(
					"alert" => "x020203",
				);
				exit;
			break;

			case "ok":
				$this->adminSubmit["admin_name"] = $_arr_adminName["str"];
			break;
		}

		$_arr_adminMail = validateStr(fn_post("admin_mail"), 0, 900, "str", "email");
		switch ($_arr_adminMail["status"]) {
			case "too_long":
				return array(
					"alert" => "x020208",
				);
				exit;
			break;

			case "format_err":
				return array(
					"alert" => "x020209",
				);
				exit;
			break;

			case "ok":
				$this->adminSubmit["admin_mail"] = $_arr_adminMail["str"];
			break;

		}

		$_arr_adminNick = validateStr(fn_post("admin_nick"), 0, 30);
		switch ($_arr_adminNick["status"]) {
			case "too_long":
				return array(
					"alert" => "x020216",
				);
				exit;
			break;

			case "ok":
				$this->adminSubmit["admin_nick"] = $_arr_adminNick["str"];
			break;
		}

		$_arr_adminNote = validateStr(fn_post("admin_note"), 0, 30);
		switch ($_arr_adminNote["status"]) {
			case "too_long":
				return array(
					"alert" => "x020212",
				);
				exit;
			break;

			case "ok":
				$this->adminSubmit["admin_note"] = $_arr_adminNote["str"];
			break;
		}

		$_arr_adminStatus = validateStr(fn_post("admin_status"), 1, 0);
		switch ($_arr_adminStatus["status"]) {
			case "too_short":
				return array(
					"alert" => "x020213",
				);
				exit;
			break;

			case "ok":
				$this->adminSubmit["admin_status"] = $_arr_adminStatus["str"];
			break;

		}

		$this->adminSubmit["admin_allow"]         = fn_jsonEncode(fn_post("admin_allow"), "no");
		$this->adminSubmit["admin_allow_profile"] = fn_jsonEncode(fn_post("admin_allow_profile"), "no");
		$this->adminSubmit["alert"]               = "ok";

		return $this->adminSubmit;
	}


	/**
	 * input_ids function.
	 *
	 * @access public
	 * @return void
	 */
	function input_ids() {
		if (!fn_token("chk")) { //令牌
			return array(
				"alert" => "x030102",
			);
			exit;
		}

		$_arr_adminIds = fn_post("admin_id");

		if ($_arr_adminIds) {
			foreach ($_arr_adminIds as $_key=>$_value) {
				$_arr_adminIds[$_key] = fn_getSafe($_value, "int", 0);
			}
			$_str_alert = "ok";
		} else {
			$_str_alert = "none";
		}

		$this->adminIds = array(
			"alert"   => $_str_alert,
			"admin_ids"   => $_arr_adminIds
		);

		return $this->adminIds;
	}
}
