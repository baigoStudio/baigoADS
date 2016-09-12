<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_FUNC . "http.func.php"); //载入模板类
include_once(BG_PATH_CLASS . "tpl.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "opt.class.php"); //载入管理帐号模型

/*-------------管理员控制器-------------*/
class CONTROL_OPT {

    private $adminLogged;
    private $obj_base;
    private $config; //配置
    private $obj_tpl;
    private $tplData;
    private $is_super = false;

    function __construct() { //构造函数
        $this->obj_base       = $GLOBALS["obj_base"]; //获取界面类型
        $this->config         = $this->obj_base->config;
        $this->mdl_opt        = new MODEL_OPT(); //设置管理组模型
        $this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
        $this->obj_tpl        = new CLASS_TPL(BG_PATH_TPL . "admin/" . BG_DEFAULT_UI); //初始化视图对象
        $this->tplData = array(
            "adminLogged" => $this->adminLogged
        );

        if ($this->adminLogged["admin_type"] == "super") {
            $this->is_super = true;
        }
    }


    function ctl_chkver() {
        if (!isset($this->adminLogged["admin_allow"]["opt"]["chkver"]) && !$this->is_super) {
            return array(
                "alert" => "x060301",
            );
        }

        $this->tplData["act_get"]       = $GLOBALS["act_get"];
        $this->tplData["latest_ver"]    = $this->mdl_opt->chk_ver();
        $this->tplData["install_pub"]   = strtotime(BG_INSTALL_PUB);

        $this->obj_tpl->tplDisplay("opt_chkver.tpl", $this->tplData);

        return array(
            "alert" => "y060301",
        );
    }

    function ctl_dbconfig() {
        if (!isset($this->adminLogged["admin_allow"]["opt"]["dbconfig"]) && !$this->is_super) {
            return array(
                "alert" => "x060301",
            );
        }

        $this->tplData["act_get"] = $GLOBALS["act_get"];

        $this->obj_tpl->tplDisplay("opt_dbconfig.tpl", $this->tplData);

        return array(
            "alert" => "y060301",
        );
    }


    function ctl_form() {
        $_act_get    = fn_getSafe(fn_get("act_get"), "txt", "base");

        if (!isset($this->adminLogged["admin_allow"]["opt"][$_act_get]) && !$this->is_super) {
            return array(
                "alert" => "x060301",
            );
        }

        $this->tplData["act_get"] = $_act_get;

        $this->obj_tpl->tplDisplay("opt_form.tpl", $this->tplData);

        return array(
            "alert" => "y060301",
        );
    }
}
