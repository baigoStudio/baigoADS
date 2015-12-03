<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_MODEL . "advert.class.php"); //载入管理帐号模型
include_once(BG_PATH_MODEL . "posi.class.php");
include_once(BG_PATH_MODEL . "media.class.php");
include_once(BG_PATH_MODEL . "stat.class.php");

/*-------------管理员控制器-------------*/
class CONTROL_ADVERT {

	private $mdl_advert;
	private $mdl_advertBelong;
	private $mdl_user;

	function __construct() { //构造函数
		$this->obj_base       = $GLOBALS["obj_base"]; //获取界面类型
		$this->config         = $this->obj_base->config;
		$this->mdl_advert = new MODEL_ADVERT(); //设置管理员模型
		$this->mdl_posi   = new MODEL_POSI();
		$this->mdl_media  = new MODEL_MEDIA();
		$this->mdl_stat   = new MODEL_STAT();
	}


	function ctl_url() {
		$_num_advertId  = fn_getSafe(fn_get("advert_id"), "int", 0);

		if ($_num_advertId == 0) {
    		return array(
        		"alert" => "x080228",
    		);
    		exit;
		}

		$_arr_advertRow = $this->mdl_advert->mdl_read($_num_advertId);

		if ($_arr_advertRow["alert"] != "y080102") {
    		return $_arr_advertRow;
    		exit;
		}

		if ($_arr_advertRow["advert_status"] != "enable") {
    		return array(
        		"alert" => "x080229",
    		);
    		exit;
		}

		if (($_arr_advertRow["advert_put_type"] == "date" && $_arr_advertRow["advert_put_opt"] < time()) || ($_arr_advertRow["advert_put_type"] == "show" && $_arr_advertRow["advert_put_opt"] < $_arr_advertRow["advert_count_show"]) || ($_arr_advertRow["advert_put_type"] == "hit" && $_arr_advertRow["advert_put_opt"] < $_arr_advertRow["advert_count_hit"])) {
			$str_alert = "x080229";
    		return array(
        		"alert" => "x080229",
    		);
    		exit;
		}

		$this->mdl_advert->mdl_stat($_num_advertId, true);
		$this->mdl_stat->mdl_stat("posi", $_arr_advertRow["advert_posi_id"], time(), true);
		$this->mdl_stat->mdl_stat("advert", $_num_advertId, time(), true);

		return $_arr_advertRow;
	}
}
