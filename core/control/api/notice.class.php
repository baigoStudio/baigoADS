<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------文章类-------------*/
class NOTICE_NOTICE {

	/**
	 * notice_list function.
	 *
	 * @access public
	 * @return void
	 */
	function notice_test() {
		$_str_echostr     = fn_get("echostr");

		echo $_str_echostr;
	}
}
