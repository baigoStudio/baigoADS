<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/
$arr_mod = array("user", "pm", "code", "signature", "sync", "install"); //允许的模块

if (isset($_GET["mod"])) {
    $mod = $_GET["mod"];
} else {
    $mod = $arr_mod[0];
}

if (!in_array($mod, $arr_mod)) { //非法调用
    exit("Access Denied");
}

$base = $_SERVER["DOCUMENT_ROOT"] . str_ireplace(basename(dirname($_SERVER["PHP_SELF"])), "", dirname($_SERVER["PHP_SELF"])); //初始路径

include_once($base . "config/init.class.php"); //载入初始化类

$obj_init = new CLASS_INIT(); //配置初始化

if ($mod == "install") { //如果是调用安装接口
    $is_install = true;
} else {
    $is_install = false;
}

$obj_init->config_gen($is_install); //检查并生成配置文件

include_once($obj_init->str_pathRoot . "config/config.inc.php"); //载入配置

include_once(BG_PATH_MODULE . "api/" . $mod . ".php"); //调用模块
