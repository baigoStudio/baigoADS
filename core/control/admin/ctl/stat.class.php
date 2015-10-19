<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_CLASS . "tpl.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "stat.class.php");
include_once(BG_PATH_MODEL . "advert.class.php"); //载入管理帐号模型
include_once(BG_PATH_MODEL . "posi.class.php");
include_once(BG_PATH_MODEL . "media.class.php");

/*-------------用户类-------------*/
class CONTROL_STAT {

	public $obj_tpl;
	public $mdl_stat;
	public $adminLogged;

	function __construct() { //构造函数
		$this->obj_base       = $GLOBALS["obj_base"]; //获取界面类型
		$this->config         = $this->obj_base->config;
		$this->adminLogged    = $GLOBALS["adminLogged"];
		$this->mdl_stat       = new MODEL_STAT();
		$this->mdl_advert     = new MODEL_ADVERT(); //设置管理员模型
		$this->mdl_posi       = new MODEL_POSI();
		$this->mdl_media      = new MODEL_MEDIA();
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_TPL . "admin/" . $this->config["ui"]); //初始化视图对象
		$this->tplData = array(
			"adminLogged" => $this->adminLogged
		);
	}


	function ctl_advert() {
		if (!isset($this->adminLogged["admin_allow"]["advert"]["stat"])) {
			return array(
				"alert" => "x080305",
			);
			exit;
		}

		$_num_advertId    = fn_getSafe(fn_get("advert_id"), "int", 0);
		$_str_type        = fn_getSafe(fn_get("type"), "txt", "year");
		$_str_year        = fn_getSafe(fn_get("year"), "txt", "");
		$_str_month       = fn_getSafe(fn_get("month"), "txt", "");

		$_arr_search = array(
			"act_get"    => $GLOBALS["act_get"],
			"advert_id"  => $_num_advertId,
			"type"       => $_str_type,
			"year"       => $_str_year,
			"month"      => $_str_month,
		);

		$_arr_advertRow = $this->mdl_advert->mdl_read($_num_advertId);
		if ($_arr_advertRow["alert"] != "y080102") {
			return $_arr_advertRow;
			exit;
		}

		$_arr_posiRow                 = $this->mdl_posi->mdl_read($_arr_advertRow["advert_posi_id"]);
		$_arr_advertRow["posiRow"]    = $_arr_posiRow;

		if ($_arr_posiRow["posi_type"] == "media" && $_arr_advertRow["advert_media_id"] > 0) {
			$_arr_advertRow["mediaRow"] = $this->mdl_media->mdl_read($_arr_advertRow["advert_media_id"]);
		}

		$_num_statCount   = $this->mdl_stat->mdl_count($_str_type, "advert", $_num_advertId, $_str_year, $_str_month);
		$_arr_page        = fn_page($_num_statCount); //取得分页数据
		$_str_query       = http_build_query($_arr_search);
		$_arr_yearRows    = $this->mdl_stat->mdl_year(100);
		$_arr_statRows    = $this->mdl_stat->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_str_type, "advert", $_num_advertId, $_str_year, $_str_month);

		$_arr_tpl = array(
			"query"      => $_str_query,
			"pageRow"    => $_arr_page,
			"search"     => $_arr_search,
			"advertRow"  => $_arr_advertRow,
			"yearRows"   => $_arr_yearRows, //目录列表
			"statRows"   => $_arr_statRows,
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("stat_advert.tpl", $_arr_tplData);

		return array(
			"alert" => "y080305",
		);
	}


	function ctl_posi() {
		if (!isset($this->adminLogged["admin_allow"]["posi"]["stat"])) {
			return array(
				"alert" => "x040305",
			);
			exit;
		}

		$_num_posiId  = fn_getSafe(fn_get("posi_id"), "int", 0);
		$_str_type    = fn_getSafe(fn_get("type"), "txt", "year");
		$_str_year    = fn_getSafe(fn_get("year"), "txt", "");
		$_str_month   = fn_getSafe(fn_get("month"), "txt", "");

		$_arr_search = array(
			"act_get"    => $GLOBALS["act_get"],
			"posi_id"    => $_num_posiId,
			"type"       => $_str_type,
			"year"       => $_str_year,
			"month"      => $_str_month,
		);

		$_arr_posiRow = $this->mdl_posi->mdl_read($_num_posiId);
		if ($_arr_posiRow["alert"] != "y040102") {
			return $_arr_posiRow;
			exit;
		}

		$_num_statCount   = $this->mdl_stat->mdl_count($_str_type, "posi", $_num_posiId, $_str_year, $_str_month);
		$_arr_page        = fn_page($_num_statCount); //取得分页数据
		$_str_query       = http_build_query($_arr_search);
		$_arr_yearRows    = $this->mdl_stat->mdl_year(100);
		$_arr_statRows    = $this->mdl_stat->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_str_type, "posi", $_num_posiId, $_str_year, $_str_month);

		$_arr_tpl = array(
			"query"      => $_str_query,
			"pageRow"    => $_arr_page,
			"search"     => $_arr_search,
			"posiRow"    => $_arr_posiRow,
			"yearRows"   => $_arr_yearRows, //目录列表
			"statRows"   => $_arr_statRows,
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("stat_posi.tpl", $_arr_tplData);

		return array(
			"alert" => "y040305",
		);
	}
}
