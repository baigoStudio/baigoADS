<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型


/**
 * fn_ssin_begin function.
 *
 * @access public
 * @return void
 */
function fn_ssin_begin() {
    $_mdl_admin  = new MODEL_ADMIN(); //设置管理员对象

    $_num_adminTimeDiff = fn_session("admin_ssin_time") + BG_DEFAULT_SESSION; //session有效期

    if (!fn_session("admin_id") || !fn_session("admin_ssin_time") || !fn_session("admin_hash") || $_num_adminTimeDiff < time()) {
        fn_ssin_end();
        $_arr_adminRow["alert"] = "x020402";
        return $_arr_adminRow;
    }

    $_arr_adminRow = $_mdl_admin->mdl_read(fn_session("admin_id"));

    if (fn_baigoEncrypt($_arr_adminRow["admin_time"], $_arr_adminRow["admin_rand"]) != fn_session("admin_hash")){
        fn_ssin_end();
        $_arr_adminRow["alert"] = "x020403";
        return $_arr_adminRow;
    }

    fn_session("admin_ssin_time", "mk", time());

    return $_arr_adminRow;
}


function fn_ssin_login($num_adminId) {
    $_mdl_admin    = new MODEL_ADMIN(); //设置管理员对象
    $_arr_adminRow = $_mdl_admin->mdl_read($num_adminId); //本地数据库处理

    if ($_arr_adminRow["alert"] != "y020102") {
        return $_arr_adminRow;
    }

    if ($_arr_adminRow["admin_status"] == "disable") {
        return array(
            "alert" => "x020401",
        );
    }

    $_str_rand = fn_rand(6);
    $_mdl_admin->mdl_login($num_adminId, $_str_rand);

    fn_session("admin_id", "mk", $num_adminId);
    fn_session("admin_ssin_time", "mk", time());
    fn_session("admin_hash", "mk", fn_baigoEncrypt($_arr_adminRow["admin_time"], $_str_rand));

    return array(
        "alert" => "ok",
    );
}

/**
 * fn_ssin_end function.
 *
 * @access public
 * @return void
 */
function fn_ssin_end() {
    fn_session("admin_id", "unset");
    fn_session("admin_ssin_time", "unset");
    fn_session("admin_hash", "unset");
}
