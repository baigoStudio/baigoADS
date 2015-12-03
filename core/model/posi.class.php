<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------广告位类-------------*/
class MODEL_POSI {

	public $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	function mdl_create_table() {
		$_arr_posiCreat = array(
			"posi_id"            => "int NOT NULL AUTO_INCREMENT COMMENT 'ID'",
			"posi_name"          => "varchar(300) NOT NULL COMMENT '名称'",
			"posi_count"         => "tinyint NOT NULL COMMENT '广告数'",
			"posi_type"          => "enum('media','text') NOT NULL COMMENT '广告位类型'",
			"posi_width"         => "varchar(4) NOT NULL COMMENT '宽度'",
			"posi_height"        => "varchar(4) NOT NULL COMMENT '高度'",
			"posi_status"        => "enum('enable','disable') NOT NULL COMMENT '状态'",
			"posi_script"        => "varchar(100) NOT NULL COMMENT '脚本'",
			"posi_plugin"        => "varchar(100) NOT NULL COMMENT '插件名'",
			"posi_selector"      => "varchar(100) NOT NULL COMMENT '默认选择器'",
			"posi_opts"          => "text NOT NULL COMMENT '选项'",
			"posi_is_percent"    => "enum('enable','disable') NOT NULL COMMENT '允许几率展现'",
			"posi_note"          => "varchar(300) NOT NULL COMMENT '备注'",
		);

		$_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "posi", $_arr_posiCreat, "posi_id", "广告位");

		if ($_num_mysql > 0) {
			$_str_alert = "y040105"; //更新成功
		} else {
			$_str_alert = "x040105"; //更新成功
		}

		return array(
			"alert" => $_str_alert, //更新成功
		);
	}


	function mdl_column() {
		$_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "posi");

		foreach ($_arr_colRows as $_key=>$_value) {
			$_arr_col[] = $_value["Field"];
		}

		return $_arr_col;
	}


	function mdl_cache($arr_posiDels = false) {
		$_str_alert       = "y040110";

		$_arr_posiRows    = $this->mdl_list(1000, 0, "", "enable");

		$_str_outList     = "<?php" . PHP_EOL;
		$_str_outList    .= "return array(" . PHP_EOL;

		foreach ($_arr_posiRows as $_key=>$_value) {
			$_str_outId = "<?php" . PHP_EOL;
			$_str_outId .= "return array(" . PHP_EOL;
				$_str_outId .= "\"posi_id\" => " . $_value["posi_id"] . "," . PHP_EOL;
				$_str_outId .= "\"posi_name\" => \"" . $_value["posi_name"] . "\"," . PHP_EOL;
				$_str_outId .= "\"posi_count\" => " . $_value["posi_count"] . "," . PHP_EOL;
				$_str_outId .= "\"posi_type\" => \"" . $_value["posi_type"] . "\"," . PHP_EOL;
				$_str_outId .= "\"posi_width\" => \"" . $_value["posi_width"] . "\"," . PHP_EOL;
				$_str_outId .= "\"posi_height\" => " . $_value["posi_height"] . "," . PHP_EOL;
				$_str_outId .= "\"posi_script\" => \"" . $_value["posi_script"] . "\"," . PHP_EOL;
				$_str_outId .= "\"posi_plugin\" => \"" . $_value["posi_plugin"] . "\"," . PHP_EOL;
				$_str_outId .= "\"posi_selector\" => \"" . $_value["posi_selector"] . "\"," . PHP_EOL;
				$_str_outId .= "\"posi_is_percent\" => \"" . $_value["posi_is_percent"] . "\"," . PHP_EOL;
				$_str_outId .= "\"alert\" => \"y040102\"," . PHP_EOL;
			$_str_outId .= ");";

			$_num_size = file_put_contents(BG_PATH_CACHE . "sys/posi_" . $_value["posi_id"] . ".php", $_str_outId);

			if (!$_num_size) {
				$_str_alert = "x040110";
			}

			$_str_outList .= $_value["posi_id"] . " => array(" . PHP_EOL;
				$_str_outList  .= "\"posi_id\" => " . $_value["posi_id"] . "," . PHP_EOL;
				$_str_outList  .= "\"posi_name\" => \"" . $_value["posi_name"] . "\"," . PHP_EOL;
				$_str_outList  .= "\"posi_count\" => " . $_value["posi_count"] . "," . PHP_EOL;
				$_str_outList  .= "\"posi_type\" => \"" . $_value["posi_type"] . "\"," . PHP_EOL;
				$_str_outList  .= "\"posi_width\" => \"" . $_value["posi_width"] . "\"," . PHP_EOL;
				$_str_outList  .= "\"posi_height\" => " . $_value["posi_height"] . "," . PHP_EOL;
				$_str_outList  .= "\"posi_script\" => \"" . $_value["posi_script"] . "\"," . PHP_EOL;
				$_str_outList  .= "\"posi_plugin\" => \"" . $_value["posi_plugin"] . "\"," . PHP_EOL;
				$_str_outList  .= "\"posi_selector\" => \"" . $_value["posi_selector"] . "\"," . PHP_EOL;
				$_str_outList  .= "\"posi_is_percent\" => \"" . $_value["posi_is_percent"] . "\"," . PHP_EOL;
				$_str_outList  .= "\"alert\" => \"y040102\"," . PHP_EOL;
			$_str_outList .= ")," . PHP_EOL;
		}

		$_str_outList.= ");";

		$_num_size    = file_put_contents(BG_PATH_CACHE . "sys/posi_list.php", $_str_outList);

		if (!$_num_size) {
			$_str_alert = "x040110";
		}

		if ($arr_posiDels) {
			foreach ($arr_posiDels as $_key=>$_value) {
				if (file_exists(BG_PATH_CACHE . "sys/posi_" . $_value . ".php")) {
					unlink(BG_PATH_CACHE . "sys/posi_" . $_value . ".php");
				}
			}
		}

		return array(
			"alert" => $_str_alert,
		);
	}


	/**
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $num_posiId
	 * @param mixed $str_posiName
	 * @param mixed $str_posiType
	 * @param string $str_posiNote (default: "")
	 * @param string $str_posiAllow (default: "")
	 * @return void
	 */
	function mdl_submit() {

		$_arr_posiData = array(
			"posi_name"          => $this->posiSubmit["posi_name"],
			"posi_count"         => $this->posiSubmit["posi_count"],
			"posi_script"        => $this->posiSubmit["posi_script"],
			"posi_type"          => $this->posiSubmit["posi_type"],
			"posi_width"         => $this->posiSubmit["posi_width"],
			"posi_height"        => $this->posiSubmit["posi_height"],
			"posi_status"        => $this->posiSubmit["posi_status"],
			"posi_script"        => $this->posiSubmit["posi_script"],
			"posi_plugin"        => $this->posiSubmit["posi_plugin"],
			"posi_selector"      => $this->posiSubmit["posi_selector"],
			"posi_opts"          => $this->posiSubmit["posi_opts"],
			"posi_is_percent"    => $this->posiSubmit["posi_is_percent"],
			"posi_note"          => $this->posiSubmit["posi_note"],
		);

		if ($this->posiSubmit["posi_id"] == 0) { //插入
			$_num_posiId = $this->obj_db->insert(BG_DB_TABLE . "posi", $_arr_posiData);

			if ($_num_posiId > 0) { //数据库插入是否成功
				$_str_alert = "y040101";
			} else {
				return array(
					"alert" => "x040101",
				);
				exit;
			}
		} else {
			$_num_posiId = $this->posiSubmit["posi_id"];
			$_num_mysql  = $this->obj_db->update(BG_DB_TABLE . "posi", $_arr_posiData, "posi_id=" . $_num_posiId);

			if ($_num_mysql > 0) { //数据库更新是否成功
				$_str_alert = "y040103";
			} else {
				return array(
					"alert" => "x040103",
				);
				exit;
			}
		}

		return array(
			"posi_id"    => $_num_posiId,
			"alert"      => $_str_alert,
		);

	}


	/**
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $str_posi
	 * @param string $str_readBy (default: "posi_id")
	 * @param int $num_notId (default: 0)
	 * @return void
	 */
	function mdl_read($str_posi, $str_readBy = "posi_id", $num_notId = 0) {

		$_arr_posiSelect = array(
			"posi_id",
			"posi_name",
			"posi_count",
			"posi_type",
			"posi_width",
			"posi_height",
			"posi_status",
			"posi_script",
			"posi_plugin",
			"posi_selector",
			"posi_opts",
			"posi_is_percent",
			"posi_note",
		);

		switch ($str_readBy) {
			case "posi_id":
				$_str_sqlWhere = $str_readBy . "=" . $str_posi;
			break;
			default:
				$_str_sqlWhere = $str_readBy . "='" . $str_posi . "'";
			break;
		}

		if ($num_notId > 0) {
			$_str_sqlWhere .= " AND posi_id<>" . $num_notId;
		}

		$_arr_posiRows = $this->obj_db->select(BG_DB_TABLE . "posi",  $_arr_posiSelect, $_str_sqlWhere, "", "", 1, 0); //检查本地表是否存在记录

		if (isset($_arr_posiRows[0])) {
			$_arr_posiRow = $_arr_posiRows[0];
		} else {
			return array(
				"alert" => "x040102", //不存在记录
			);
			exit;
		}

		$_arr_posiRow["posi_opts"]    = fn_jsonDecode($_arr_posiRow["posi_opts"], "decode");
		$_arr_posiRow["alert"]        = "y040102";

		return $_arr_posiRow;
	}


	function mdl_status($str_status) {

		$_str_posiId = implode(",", $this->posiIds["posi_ids"]);

		$_arr_posiUpdate = array(
			"posi_status" => $str_status,
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "posi", $_arr_posiUpdate, "posi_id IN (" . $_str_posiId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y040103";
		} else {
			$_str_alert = "x040103";
		}

		return array(
			"alert" => $_str_alert,
		); //成功

	}

	/**
	 * mdl_list function.
	 *
	 * @access public
	 * @param mixed $num_no
	 * @param int $num_except (default: 0)
	 * @param string $str_key (default: "")
	 * @param string $str_type (default: "")
	 * @return void
	 */
	function mdl_list($num_no, $num_except = 0, $str_key = "", $str_status = "") {

		$_arr_posiSelect = array(
			"posi_id",
			"posi_name",
			"posi_count",
			"posi_type",
			"posi_width",
			"posi_height",
			"posi_status",
			"posi_script",
			"posi_plugin",
			"posi_selector",
			"posi_is_percent",
			"posi_note",
		);

		$_str_sqlWhere = "1=1";

		if ($str_key) {
			$_str_sqlWhere .= " AND posi_name LIKE '%" . $str_key . "%' OR posi_note LIKE '%" . $str_key . "%'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND posi_status='" . $str_status . "'";
		}

		$_arr_posiRows = $this->obj_db->select(BG_DB_TABLE . "posi",  $_arr_posiSelect, $_str_sqlWhere, "", "posi_id DESC", $num_no, $num_except); //列出本地表是否存在记录

		return $_arr_posiRows;

	}


	/**
	 * mdl_count function.
	 *
	 * @access public
	 * @param string $str_key (default: "")
	 * @param string $str_status (default: "")
	 * @return void
	 */
	function mdl_count($str_key = "", $str_type = "", $str_status = "") {
		$_str_sqlWhere = "1=1";

		if ($str_key) {
			$_str_sqlWhere .= " AND posi_name LIKE '%" . $str_key . "%' OR posi_note LIKE '%" . $str_key . "%'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND posi_status='" . $str_status . "'";
		}

		$_num_count = $this->obj_db->count(BG_DB_TABLE . "posi", $_str_sqlWhere); //查询数据

		return $_num_count;
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @param mixed $this->posiIds["posi_ids"]
	 * @return void
	 */
	function mdl_del() {

		$_str_posiId = implode(",", $this->posiIds["posi_ids"]);

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "posi",  "posi_id IN (" . $_str_posiId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y040104";
		} else {
			$_str_alert = "x040104";
		}

		return array(
			"alert" => $_str_alert,
		);
		exit;

	}


	function input_submit() {
		if (!fn_token("chk")) { //令牌
			return array(
				"alert" => "x030102",
			);
			exit;
		}

		$this->posiSubmit["posi_id"] = fn_getSafe(fn_post("posi_id"), "int", 0);

		if ($this->posiSubmit["posi_id"]) {
			$_arr_posiRow = $this->mdl_read($this->posiSubmit["posi_id"]);
			if ($_arr_posiRow["alert"] != "y040102") {
				$this->obj_ajax->halt_alert($_arr_posiRow["alert"]);
			}
		}

		$_arr_posiName = validateStr(fn_post("posi_name"), 1, 300);
		switch ($_arr_posiName["status"]) {
			case "too_short":
				return array(
					"alert" => "x040201",
				);
				exit;
			break;

			case "too_long":
				return array(
					"alert" => "x040202",
				);
				exit;
			break;

			case "ok":
				$this->posiSubmit["posi_name"] = $_arr_posiName["str"];
			break;

		}

		$_arr_posiRow = $this->mdl_read($this->posiSubmit["posi_name"], "posi_name", $this->posiSubmit["posi_id"]);

		if ($_arr_posiRow["alert"] == "y040102") {
			return array(
				"alert" => "x040203",
			);
			exit;
		}

		$_arr_posiCount = validateStr(fn_post("posi_count"), 1, 0, "str", "int");
		switch ($_arr_posiCount["status"]) {
			case "too_short":
				return array(
					"alert" => "x040205",
				);
				exit;
			break;

			case "format_err":
				return array(
					"alert" => "x040208",
				);
				exit;
			break;

			case "ok":
				$this->posiSubmit["posi_count"] = $_arr_posiCount["str"];
			break;
		}

		$_arr_posiScript = validateStr(fn_post("posi_script"), 1, 0);
		switch ($_arr_posiScript["status"]) {
			case "too_short":
				return array(
					"alert" => "x040214",
				);
				exit;
			break;

			case "ok":
				$this->posiSubmit["posi_script"] = $_arr_posiScript["str"];
			break;
		}


		$_arr_posiNote = validateStr(fn_post("posi_note"), 0, 300);
		switch ($_arr_posiNote["status"]) {
			case "too_long":
				return array(
					"alert" => "x040204",
				);
				exit;
			break;

			case "ok":
				$this->posiSubmit["posi_note"] = $_arr_posiNote["str"];
			break;
		}

		$_arr_posiType = validateStr(fn_post("posi_type"), 1, 0);
		switch ($_arr_posiType["status"]) {
			case "too_short":
				return array(
					"alert" => "x040209",
				);
				exit;
			break;

			case "ok":
				$this->posiSubmit["posi_type"] = $_arr_posiType["str"];
			break;
		}

		switch ($this->posiSubmit["posi_type"]) {

			case "media":
				$_arr_posiWidth = validateStr(fn_post("posi_width"), 1, 4);
				switch ($_arr_posiWidth["status"]) {
					case "too_short":
						return array(
							"alert" => "x040210",
						);
						exit;
					break;

					case "too_long":
						return array(
							"alert" => "x040211",
						);
						exit;
					break;

					case "ok":
						$this->posiSubmit["posi_width"] = $_arr_posiWidth["str"];
					break;
				}

				$_arr_posiHeight = validateStr(fn_post("posi_height"), 1, 4);
				switch ($_arr_posiHeight["status"]) {
					case "too_short":
						return array(
							"alert" => "x040212",
						);
						exit;
					break;

					case "too_long":
						return array(
							"alert" => "x040213",
						);
						exit;
					break;

					case "ok":
						$this->posiSubmit["posi_height"] = $_arr_posiHeight["str"];
					break;
				}
			break;

			default:
				$this->posiSubmit["posi_width"]     = 0;
				$this->posiSubmit["posi_height"]    = 0;
			break;

		}

		$_arr_posiStatus = validateStr(fn_post("posi_status"), 1, 0);
		switch ($_arr_posiStatus["status"]) {
			case "too_short":
				return array(
					"alert" => "x040207",
				);
				exit;
			break;

			case "ok":
				$this->posiSubmit["posi_status"] = $_arr_posiStatus["str"];
			break;
		}

		$_arr_posiScript = validateStr(fn_post("posi_script"), 1, 100);
		switch ($_arr_posiScript["status"]) {
			case "too_short":
				return array(
					"alert" => "x040215",
				);
				exit;
			break;

			case "ok":
				$this->posiSubmit["posi_script"] = $_arr_posiScript["str"];
			break;
		}

		$_arr_posiPlugin = validateStr(fn_post("posi_plugin"), 1, 100);
		switch ($_arr_posiPlugin["status"]) {
			case "too_short":
				return array(
					"alert" => "x040216",
				);
				exit;
			break;

			case "too_long":
				return array(
					"alert" => "x040217",
				);
				exit;
			break;

			case "ok":
				$this->posiSubmit["posi_plugin"] = $_arr_posiPlugin["str"];
			break;
		}

		$_arr_posiSelector = validateStr(fn_post("posi_selector"), 1, 100);
		switch ($_arr_posiSelector["status"]) {
			case "too_short":
				return array(
					"alert" => "x040218",
				);
				exit;
			break;

			case "too_long":
				return array(
					"alert" => "x040219",
				);
				exit;
			break;

			case "ok":
				$this->posiSubmit["posi_selector"] = $_arr_posiSelector["str"];
			break;
		}

		$_arr_posiIsPercent = validateStr(fn_post("posi_is_percent"), 1, 0);
		switch ($_arr_posiIsPercent["status"]) {
			case "too_short":
				return array(
					"alert" => "x040221",
				);
				exit;
			break;

			case "ok":
				$this->posiSubmit["posi_is_percent"] = $_arr_posiIsPercent["str"];
			break;
		}

		$this->posiSubmit["posi_opts"]    = fn_jsonEncode(fn_post("posi_opts"), "encode");
		$this->posiSubmit["alert"]        = "ok";

		return $this->posiSubmit;
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

		$_arr_posiIds = fn_post("posi_id");

		if ($_arr_posiIds) {
			foreach ($_arr_posiIds as $_key=>$_value) {
				$_arr_posiIds[$_key] = fn_getSafe($_value, "int", 0);
			}
			$_str_alert = "ok";
		} else {
			$_str_alert = "none";
		}

		$this->posiIds = array(
			"alert"   => $_str_alert,
			"posi_ids"   => $_arr_posiIds
		);

		return $this->posiIds;
	}
}
