<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------上传类-------------*/
class MODEL_MEDIA {

	private $obj_db;
	private $is_magic;

	function __construct() { //构造函数
		$this->obj_db     = $GLOBALS["obj_db"]; //设置数据库对象
		$this->is_magic   = get_magic_quotes_gpc();

		$this->mime = array(
			"image/jpeg"                     => "jpg",
			"image/pjpeg"                    => "jpg",
			"image/gif"                      => "gif",
			"image/x-png"                    => "png",
			"image/png"                      => "png",
		);
	}


	function mdl_create_table() {
		$_arr_mediaCreat = array(
			"media_id"          => "int NOT NULL AUTO_INCREMENT COMMENT 'ID'",
			"media_ext"         => "varchar(5) NOT NULL COMMENT '扩展名'",
			"media_mime"        => "varchar(30) NOT NULL COMMENT 'MIME'",
			"media_time"        => "int NOT NULL COMMENT '时间'",
			"media_size"        => "mediumint NOT NULL COMMENT '大小'",
			"media_name"        => "varchar(1000) NOT NULL COMMENT '原始文件名'",
			"media_admin_id"    => "smallint NOT NULL COMMENT '上传用户 ID'",
			"media_box"         => "enum('normal','recycle') NOT NULL COMMENT '盒子'",
		);

		$_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "media", $_arr_mediaCreat, "media_id", "附件");

		if ($_num_mysql > 0) {
			$_str_alert = "y070105"; //更新成功
		} else {
			$_str_alert = "x070105"; //更新成功
		}

		return array(
			"alert" => $_str_alert, //更新成功
		);
	}


	function mdl_column() {
		$_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "media");

		foreach ($_arr_colRows as $_key=>$_value) {
			$_arr_col[] = $_value["Field"];
		}

		return $_arr_col;
	}


	/**
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $str_mediaName
	 * @param mixed $str_mediaExt
	 * @param int $num_mediaSize (default: 0)
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_submit($num_mediaId, $str_mediaName, $str_mediaExt, $str_mediaMime, $num_mediaSize = 0, $num_adminId = 0) {

		$_arr_mediaData = array(
			"media_name"    => $str_mediaName,
			"media_ext"     => $str_mediaExt,
			"media_mime"    => $str_mediaMime,
		);

		$_tm_time = time();

		if ($num_mediaId == 0) {
			$_arr_mediaData["media_time"]      = $_tm_time;
			$_arr_mediaData["media_admin_id"]  = $num_adminId;
			$_arr_mediaData["media_size"]      = $num_mediaSize;
			$_arr_mediaData["media_box"]       = "normal";
			$_num_mediaId = $this->obj_db->insert(BG_DB_TABLE . "media", $_arr_mediaData);

			if ($_num_mediaId > 0) { //数据库插入是否成功
				$_str_alert = "y070101";
			} else {
				return array(
					"alert" => "x070101",
				);
				exit;
			}
		} else {
			$_num_mediaId   = $num_mediaId;
			$_num_mysql      = $this->obj_db->update(BG_DB_TABLE . "media", $_arr_mediaData, "media_id=" . $num_mediaId);

			if ($_num_mysql > 0) { //数据库插入是否成功
				$_str_alert = "y070103";
			} else {
				return array(
					"alert" => "x070103",
				);
				exit;
			}
		}

		return array(
			"media_id"   => $_num_mediaId,
			"media_time" => $_tm_time,
			"alert"      => $_str_alert,
		);
	}

	/**
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $num_mediaId
	 * @return void
	 */
	function mdl_read($num_mediaId) {
		$_arr_mediaSelect = array(
			"media_id",
			"media_name",
			"media_time",
			"media_ext",
			"media_mime",
			"media_size",
			"media_box",
		);

		$_arr_mediaRows  = $this->obj_db->select(BG_DB_TABLE . "media", $_arr_mediaSelect, "media_id=" . $num_mediaId, "", "", 1, 0); //检查本地表是否存在记录

		if (isset($_arr_mediaRows[0])) {
			$_arr_mediaRow   = $_arr_mediaRows[0];
		} else {
			return array(
				"alert" => "x070102", //不存在记录
			);
			exit;
		}

		$_arr_mediaRow["media_url"] = BG_SITE_URL . BG_URL_MEDIA . date("Y", $_arr_mediaRow["media_time"]) . "/" . date("m", $_arr_mediaRow["media_time"]) . "/" . $_arr_mediaRow["media_id"] . "." . $_arr_mediaRow["media_ext"];

		$_arr_mediaRow["media_path"] = BG_PATH_MEDIA . date("Y", $_arr_mediaRow["media_time"]) . "/" . date("m", $_arr_mediaRow["media_time"]) . "/" . $_arr_mediaRow["media_id"] . "." . $_arr_mediaRow["media_ext"];

		$_arr_mediaRow["alert"] = "y070102";

		return $_arr_mediaRow;
	}


	/**
	 * mdl_list function.
	 *
	 * @access public
	 * @param mixed $num_no
	 * @param int $num_except (default: 0)
	 * @param string $str_year (default: "")
	 * @param string $str_month (default: "")
	 * @param string $str_ext (default: "")
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_list($num_no, $num_except = 0, $str_key = "", $str_year = "", $str_month = "", $str_ext = "", $num_adminId = 0, $str_box = "normal", $num_begin = 0, $num_end = 0) {
		$_arr_mediaSelect = array(
			"media_id",
			"media_name",
			"media_time",
			"media_ext",
			"media_mime",
			"media_size",
			"media_admin_id",
			"media_box",
		);

		$_str_sqlWhere = "1=1";

		if ($str_key) {
			$_str_sqlWhere .= " AND media_name LIKE '%" . $str_key . "%'";
		}

		if ($str_year) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(media_time, '%Y')='" . $str_year . "'";
		}

		if ($str_month) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(media_time, '%m')='" . $str_month . "'";
		}

		if ($str_ext) {
			$_str_sqlWhere .= " AND media_ext='" . $str_ext . "'";
		}

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND media_admin_id=" . $num_adminId;
		}

		if ($str_box) {
			$_str_sqlWhere .= " AND media_box='" . $str_box . "'";
		}

		if ($num_begin > 0) {
			$_str_sqlWhere .= " AND media_id>" . $num_begin;
		}

		if ($num_end > 0) {
			$_str_sqlWhere .= " AND media_id<" . $num_end;
		}

		$_arr_mediaRows = $this->obj_db->select(BG_DB_TABLE . "media", $_arr_mediaSelect, $_str_sqlWhere, "", "media_id DESC", $num_no, $num_except);

		foreach ($_arr_mediaRows as $_key=>$_value) {
			$_arr_mediaRows[$_key]["media_url"] = BG_SITE_URL . BG_URL_MEDIA . date("Y", $_value["media_time"]) . "/" . date("m", $_value["media_time"]) . "/" . $_value["media_id"] . "." . $_value["media_ext"];

			$_arr_mediaRows[$_key]["media_path"] = BG_PATH_MEDIA . date("Y", $_value["media_time"]) . "/" . date("m", $_value["media_time"]) . "/" . $_value["media_id"] . "." . $_value["media_ext"];
		}

		return $_arr_mediaRows;
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @param mixed $this->mediaIds["media_ids"]
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_del($num_adminId = 0) {
		$_str_mediaIds = implode(",", $this->mediaIds["media_ids"]);

		$_str_sqlWhere = "media_id IN (" . $_str_mediaIds . ")";

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND media_admin_id=" . $num_adminId;
		}

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "media", $_str_sqlWhere); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y070104";
		} else {
			$_str_alert = "x070104";
		}

		return array(
			"alert" => $_str_alert
		); //成功
	}


	/**
	 * mdl_count function.
	 *
	 * @access public
	 * @param string $str_year (default: "")
	 * @param string $str_month (default: "")
	 * @param string $str_ext (default: "")
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_count($str_key = "", $str_year = "", $str_month = "", $str_ext = "", $num_adminId = 0, $str_box = "normal", $num_begin = 0, $num_end = 0) {
		$_str_sqlWhere = "1=1";

		if ($str_key) {
			$_str_sqlWhere .= " AND media_name LIKE '%" . $str_key . "%'";
		}

		if ($str_year) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(media_time, '%Y')='" . $str_year . "'";
		}

		if ($str_month) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(media_time, '%m')='" . $str_month . "'";
		}

		if ($str_ext) {
			$_str_sqlWhere .= " AND media_ext='" . $str_ext . "'";
		}

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND media_admin_id=" . $num_adminId;
		}

		if ($str_box) {
			$_str_sqlWhere .= " AND media_box='" . $str_box . "'";
		}

		if ($num_begin > 0) {
			$_str_sqlWhere .= " AND media_id>" . $num_begin;
		}

		if ($num_end > 0) {
			$_str_sqlWhere .= " AND media_id<" . $num_end;
		}

		$_num_mysql = $this->obj_db->count(BG_DB_TABLE . "media", $_str_sqlWhere);

		return $_num_mysql;
	}


	/**
	 * mdl_ext function.
	 *
	 * @access public
	 * @param mixed $num_no
	 * @return void
	 */
	function mdl_ext() {
		$_arr_mediaSelect = array(
			"DISTINCT media_ext",
		);

		$_str_sqlWhere    = "LENGTH(media_ext) > 0";
		$_arr_mediaRows  = $this->obj_db->select(BG_DB_TABLE . "media", $_arr_mediaSelect, $_str_sqlWhere, "", "", 100, 0, false, true);

		return $_arr_mediaRows;
	}


	/**
	 * mdl_year function.
	 *
	 * @access public
	 * @param mixed $num_no
	 * @return void
	 */
	function mdl_year() {
		$_arr_mediaSelect = array(
			"DISTINCT FROM_UNIXTIME(media_time, '%Y') AS media_year",
		);

		$_str_sqlWhere = "media_time > 0";

		$_arr_yearRows = $this->obj_db->select(BG_DB_TABLE . "media", $_arr_mediaSelect, $_str_sqlWhere, "", "media_time ASC", 100, 0, false, true);

		return $_arr_yearRows;
	}


	function mdl_chkMedia($num_mediaId, $str_mediaExt, $tm_mediaTime) {
		$_str_mediaUrl = date("Y", $tm_mediaTime) . "/" . date("m", $tm_mediaTime) . "/" . $num_mediaId . "." . $str_mediaExt;

		if (!$this->is_magic) {
			$_str_chk   = addslashes($_str_mediaUrl);
		} else {
			$_str_chk   = $_str_mediaUrl;
		}

		$_arr_articleSelect = array(
			"article_id",
		);

		$_str_sqlWhere    = "article_media_id=" . $num_mediaId;
		//print_r($_str_sqlWhere . "<br>");
		$_arr_articleRows = $this->obj_db->select(BG_DB_TABLE . "article", $_arr_articleSelect, $_str_sqlWhere, "", "article_id ASC", 1, 0);

		//print_r($_arr_articleRows);
		if (isset($_arr_articleRows[0])) {
			return array(
				"media_id" => $num_mediaId,
				"alert" => "y070406",
			);
			exit;
		}

		$_str_sqlWhere    = "article_excerpt LIKE '%" . $_str_chk . "%'";
		//print_r($_str_sqlWhere . "<br>");
		$_arr_articleRows = $this->obj_db->select(BG_DB_TABLE . "article", $_arr_articleSelect, $_str_sqlWhere, "", "article_id ASC", 1, 0);

		//print_r($_arr_articleRows);
		if (isset($_arr_articleRows[0])) {
			return array(
				"media_id" => $num_mediaId,
				"alert" => "y070406",
			);
			exit;
		}

		$_str_sqlWhere    = "article_content LIKE '%" . $_str_chk . "%'";
		//print_r($_str_sqlWhere . "<br>");
		$_arr_articleRows = $this->obj_db->select(BG_DB_TABLE . "article_content", $_arr_articleSelect, $_str_sqlWhere, "", "article_id ASC", 1, 0);

		//print_r($_arr_articleRows);
		if (isset($_arr_articleRows[0])) {
			return array(
				"media_id" => $num_mediaId,
				"alert" => "y070406",
			);
			exit;
		}

		$_arr_cateSelect = array(
			"cate_id",
		);

		$_str_sqlWhere    = "cate_content LIKE '%" . $_str_chk . "%'";
		//print_r($_str_sqlWhere . "<br>");
		$_arr_cateRows = $this->obj_db->select(BG_DB_TABLE . "cate", $_arr_cateSelect, $_str_sqlWhere, "", "cate_id ASC", 1, 0);

		//print_r($_arr_cateRows);
		if (isset($_arr_cateRows[0])) {
			return array(
				"media_id" => $num_mediaId,
				"alert" => "y070406",
			);
			exit;
		}

		$_arr_specSelect = array(
			"spec_id",
		);

		$_str_sqlWhere    = "spec_content LIKE '%" . $_str_chk . "%'";
		//print_r($_str_sqlWhere . "<br>");
		$_arr_specRows = $this->obj_db->select(BG_DB_TABLE . "spec", $_arr_specSelect, $_str_sqlWhere, "", "spec_id ASC", 1, 0);

		//print_r($_arr_specRows);
		if (isset($_arr_specRows[0])) {
			return array(
				"media_id" => $num_mediaId,
				"alert"     => "y070406",
			);
			exit;
		}

		$_arr_customSelect = array(
			"value_id",
		);

		$_str_sqlWhere   = "value_custom_value=" . $num_mediaId;
		//print_r($_str_sqlWhere . "<br>");
		$_arr_customRows = $this->obj_db->select(BG_DB_TABLE . "custom_value", $_arr_customSelect, $_str_sqlWhere, "", "value_id ASC", 1, 0);

		//print_r($_arr_customRows);
		if (isset($_arr_customRows[0])) {
			return array(
				"media_id" => $num_mediaId,
				"alert"     => "y070406",
			);
			exit;
		}

		return array(
			"media_id"  => $num_mediaId,
			"alert"      => "x070406",
		);
	}


	function mdl_box($str_box, $arr_mediaIds = false) {
		if ($arr_mediaIds) {
			$this->mediaIds["media_ids"] = $arr_mediaIds;
		}

		$_str_mediaIds = implode(",", $this->mediaIds["media_ids"]);

		$_arr_mediaData = array(
			"media_box" => $str_box,
		);

		$_num_mysql  = $this->obj_db->update(BG_DB_TABLE . "media", $_arr_mediaData, "media_id IN (" . $_str_mediaIds . ")");

		if ($_num_mysql > 0) {
			$_str_alert = "y070103";
		} else {
			$_str_alert = "x070103";
		}

		return array(
			"alert" => $_str_alert,
		); //成功
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

		$_arr_mediaIds = fn_post("media_id");

		if ($_arr_mediaIds) {
			foreach ($_arr_mediaIds as $_key=>$_value) {
				$_arr_mediaIds[$_key] = fn_getSafe($_value, "int", 0);
			}
			$_str_alert = "ok";
		} else {
			$_str_alert = "none";
		}

		$this->mediaIds = array(
			"alert"      => $_str_alert,
			"media_ids"  => $_arr_mediaIds,
		);

		return $this->mediaIds;
	}
}
