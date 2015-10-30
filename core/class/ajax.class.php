<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------AJAX 通用-------------*/
class CLASS_AJAX {

	public $config; //配置

	function __construct() {
		$this->obj_base   = $GLOBALS["obj_base"];
		$this->config     = $this->obj_base->config;
		$this->alert      = include_once(BG_PATH_LANG . $this->config["lang"] . "/alert.php"); //载入提示信息
		$this->type       = include_once(BG_PATH_LANG . $this->config["lang"] . "/type.php"); //载入类型文件
		$this->opt        = include_once(BG_PATH_LANG . $this->config["lang"] . "/opt.php"); //载入类型文件
	}


	/**
	 * halt_alert function.
	 *
	 * @access public
	 * @param mixed $str_alert
	 * @return void
	 */
	function halt_alert($str_alert) {
		$arr_re = array(
			"msg"    => $this->alert[$str_alert], //具体信息
			"alert"  => $str_alert, //代码
		);
		exit(json_encode($arr_re));
	}


	/**
	 * halt_re function.
	 *
	 * @access public
	 * @param mixed $str_alert
	 * @return void
	 */
	function halt_re($str_alert) {
		$arr_re = array(
			"re" => $this->alert[$str_alert]
		);
		exit(json_encode($arr_re));
	}


	function chk_install() {
		if (file_exists(BG_PATH_CONFIG . "is_install.php")) { //验证是否已经安装
			include_once(BG_PATH_CONFIG . "is_install.php");
			if (!defined("BG_INSTALL_PUB") || PRD_ADS_PUB > BG_INSTALL_PUB) {
				$this->halt_alert("x030416");
			}
		} else {
			$this->halt_alert("x030415");
		}
	}
}