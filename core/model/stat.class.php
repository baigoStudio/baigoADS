<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------应用归属-------------*/
class MODEL_STAT {

	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	/** 创建表
	 * mdl_create function.
	 *
	 * @access public
	 * @return void
	 */
	function mdl_create_table() {
		$_arr_statCreat = array(
			"stat_id"            => "int NOT NULL AUTO_INCREMENT COMMENT 'ID'",
			"stat_type"          => "enum('day','month','year') NOT NULL COMMENT '统计类型'",
			"stat_target"        => "enum('advert','posi') NOT NULL COMMENT '统计目标'",
			"stat_target_id"     => "int NOT NULL COMMENT '目标 ID'",
			"stat_time"          => "int NOT NULL COMMENT '统计时间'",
			"stat_count_show"    => "int NOT NULL COMMENT '显示数'",
			"stat_count_hit"     => "int NOT NULL COMMENT '点击数'",
		);

		$_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "stat", $_arr_statCreat, "stat_id", "统计");

		if ($_num_mysql > 0) {
			$_str_alert = "y090105"; //更新成功
		} else {
			$_str_alert = "x090105"; //更新失败
		}

		return array(
			"alert" => $_str_alert, //更新成功
		);
	}

	/** 检查字段
	 * mdl_column function.
	 *
	 * @access public
	 * @return void
	 */
	function mdl_column() {
		$_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "stat");

		foreach ($_arr_colRows as $_key=>$_value) {
			$_arr_col[] = $_value["Field"];
		}

		return $_arr_col;
	}


	function mdl_stat($str_statTarget, $num_statTargetId, $tm_time, $is_hit = false) {
		$this->mdl_submit("year", $str_statTarget, $num_statTargetId, $tm_time, $is_hit);
		$this->mdl_submit("month", $str_statTarget, $num_statTargetId, $tm_time, $is_hit);
		$this->mdl_submit("day", $str_statTarget, $num_statTargetId, $tm_time, $is_hit);
	}


	/** 提交
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $num_userId
	 * @param mixed $num_appId
	 * @return void
	 */
	function mdl_submit($str_statType, $str_statTarget, $num_statTargetId, $tm_time, $is_hit = false) {

		$_arr_statData = array(
			"stat_count_show"    => 1,
			"stat_count_hit"     => 1,
		);

		$_arr_statRow = $this->mdl_read($str_statType, $str_statTarget, $num_statTargetId, $tm_time);

		if ($_arr_statRow["alert"] != "y090102") {
			$_arr_statData["stat_type"]      = $str_statType;
			$_arr_statData["stat_target"]    = $str_statTarget;
			$_arr_statData["stat_target_id"] = $num_statTargetId;
			$_arr_statData["stat_time"]      = time();

			$_num_statId = $this->obj_db->insert(BG_DB_TABLE . "stat", $_arr_statData);

			if ($_num_statId > 0) { //数据库插入是否成功
				$_str_alert = "y090101";
			} else {
				return array(
					"alert" => "x090101",
				);
				exit;
			}
		} else {
			if ($is_hit) {
				$_arr_statData = array(
					"stat_count_hit"   => "stat_count_hit+1",
				);
			} else {
				$_arr_statData = array(
					"stat_count_show"   => "stat_count_show+1",
				);
			}

			$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "stat", $_arr_statData, "stat_id=" . $_arr_statRow["stat_id"], true);

			if ($_num_mysql > 0) { //数据库插入是否成功
				$_str_alert = "y090103";
			} else {
				return array(
					"alert" => "x090103",
				);
				exit;
			}
		}

		return array(
			"alert"  => $_str_alert,
		);
	}


	function mdl_read($str_statType = "", $str_statTarget = "", $num_statTargetId = 0, $tm_time = 0) {
		$_arr_statSelect = array(
			"stat_id",
			"stat_type",
			"stat_target",
			"stat_target_id",
			"stat_time",
			"stat_count_show",
			"stat_count_hit",
		);

		$_str_sqlWhere = "1+1";

		if ($str_statType) {
			$_str_sqlWhere .= " AND stat_type='" . $str_statType . "'";
		}

		if ($str_statTarget) {
			$_str_sqlWhere .= " AND stat_target='" . $str_statTarget . "'";
		}

		if ($num_statTargetId > 0) {
			$_str_sqlWhere .= " AND stat_target_id=" . $num_statTargetId;
		}

		switch ($str_statType) {
			case "year":
				$_str_sqlWhere .= " AND FROM_UNIXTIME(stat_time, '%Y')='" . date("Y", $tm_time) . "'";
			break;

			case "month":
				$_str_sqlWhere .= " AND FROM_UNIXTIME(stat_time, '%Y-%m')='" . date("Y-m", $tm_time) . "'";
			break;

			case "day":
				$_str_sqlWhere .= " AND FROM_UNIXTIME(stat_time, '%Y-%m-%d')='" . date("Y-m-d", $tm_time) . "'";
			break;
		}

		$_arr_statRows = $this->obj_db->select(BG_DB_TABLE . "stat", $_arr_statSelect, $_str_sqlWhere, "", "stat_id DESC", 1, 0);

		if (isset($_arr_statRows[0])) { //用户名不存在则返回错误
			$_arr_statRow = $_arr_statRows[0];
		} else {
			return array(
				"alert" => "x090102", //不存在记录
			);
			exit;
		}

		$_arr_statRow["alert"] = "y090102";

		return $_arr_statRow;
	}


	/** 列出
	 * mdl_list function.
	 *
	 * @access public
	 * @param mixed $num_statNo
	 * @param int $num_statExcept (default: 0)
	 * @param int $num_appId (default: 0)
	 * @param int $num_userId (default: 0)
	 * @param bool $arr_userIds (default: false)
	 * @return void
	 */
	function mdl_list($num_statNo, $num_statExcept, $str_statType, $str_statTarget, $num_statTargetId, $str_year = "", $str_month = "") {
		$_arr_statSelect = array(
			"stat_type",
			"stat_target",
			"stat_target_id",
			"stat_time",
			"stat_count_show",
			"stat_count_hit",
		);

		$_str_sqlWhere = "1+1";

		if ($str_statType) {
			$_str_sqlWhere .= " AND stat_type='" . $str_statType . "'";
		}

		if ($str_statTarget) {
			$_str_sqlWhere .= " AND stat_target='" . $str_statTarget . "'";
		}

		if ($num_statTargetId > 0) {
			$_str_sqlWhere .= " AND stat_target_id=" . $num_statTargetId;
		}

		if ($str_year) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(stat_time, '%Y')='" . $str_year . "'";
		}

		if ($str_month) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(stat_time, '%m')='" . $str_month . "'";
		}

		$_arr_statRows = $this->obj_db->select(BG_DB_TABLE . "stat", $_arr_statSelect, $_str_sqlWhere, "", "stat_id DESC", $num_statNo, $num_statExcept);

		return $_arr_statRows;
	}


	/** 计数
	 * mdl_count function.
	 *
	 * @access public
	 * @param int $num_appId (default: 0)
	 * @param int $num_userId (default: 0)
	 * @param bool $arr_userIds (default: false)
	 * @return void
	 */
	function mdl_count($str_statType, $str_statTarget, $num_statTargetId, $str_year = "", $str_month = "") {

		$_str_sqlWhere = "1=1";

		if ($str_statType) {
			$_str_sqlWhere .= " AND stat_type='" . $str_statType . "'";
		}

		if ($str_statTarget) {
			$_str_sqlWhere .= " AND stat_target='" . $str_statTarget . "'";
		}

		if ($num_statTargetId > 0) {
			$_str_sqlWhere .= " AND stat_target_id=" . $num_statTargetId;
		}

		if ($str_year) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(stat_time, '%Y')='" . $str_year . "'";
		}

		if ($str_month) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(stat_time, '%m')='" . $str_month . "'";
		}

		$_num_statCount = $this->obj_db->count(BG_DB_TABLE . "stat", $_str_sqlWhere); //查询数据

		/*print_r($_arr_userRow);
		exit;*/

		return $_num_statCount;
	}


	function mdl_year() {
		$_arr_statSelect = array(
			"DISTINCT FROM_UNIXTIME(stat_time, '%Y') AS stat_year",
		);

		$_str_sqlWhere = "stat_time > 0";

		$_arr_yearRows = $this->obj_db->select(BG_DB_TABLE . "stat", $_arr_statSelect, $_str_sqlWhere, "", "stat_time ASC", 100, 0, false, true);

		return $_arr_yearRows;
	}

	/** 删除
	 * mdl_del function.
	 *
	 * @access public
	 * @param int $num_appId (default: 0)
	 * @param int $num_userId (default: 0)
	 * @param bool $arr_appIds (default: false)
	 * @param bool $arr_userIds (default: false)
	 * @param bool $arr_notAppIds (default: false)
	 * @param bool $arr_notUserIds (default: false)
	 * @return void
	 */
	function mdl_del() {

		$_str_sqlWhere = "1=1";

		//print_r($_str_sqlWhere);

		//$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "stat", $_str_sqlWhere); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y090104";
		} else {
			$_str_alert = "x090104";
		}

		return array(
			"alert" => $_str_alert,
		); //成功
	}
}
