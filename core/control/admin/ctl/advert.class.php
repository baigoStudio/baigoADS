<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_CLASS . "tpl.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "advert.class.php"); //载入管理帐号模型
include_once(BG_PATH_MODEL . "posi.class.php");
include_once(BG_PATH_MODEL . "media.class.php");

/*-------------管理员控制器-------------*/
class CONTROL_ADVERT {

    private $adminLogged;
    private $obj_base;
    private $config; //配置
    private $obj_tpl;
    private $mdl_advert;
    private $mdl_advertBelong;
    private $mdl_user;
    private $tplData;
    private $is_super = false;

    function __construct() { //构造函数
        $this->obj_base       = $GLOBALS["obj_base"]; //获取界面类型
        $this->config         = $this->obj_base->config;
        $this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
        $this->mdl_advert     = new MODEL_ADVERT(); //设置管理员模型
        $this->mdl_posi       = new MODEL_POSI();
        $this->mdl_media      = new MODEL_MEDIA();
        $this->obj_tpl        = new CLASS_TPL(BG_PATH_TPL . "admin/" . BG_DEFAULT_UI); //初始化视图对象
        $this->tplData = array(
            "adminLogged" => $this->adminLogged
        );

        if ($this->adminLogged["admin_type"] == "super") {
            $this->is_super = true;
        }
    }

    /*============编辑管理员界面============
    返回提示
    */
    function ctl_show() {
        if (!isset($this->adminLogged["admin_allow"]["advert"]["browse"]) && !$this->is_super) {
            return array(
                "alert" => "x080301",
            );
        }

        $_num_advertId = fn_getSafe(fn_get("advert_id"), "int", 0);

        if ($_num_advertId < 1) {
            return array(
                "alert" => "x080228",
            );
        }

        $_arr_advertRow = $this->mdl_advert->mdl_read($_num_advertId);
        if ($_arr_advertRow["alert"] != "y080102") {
            return $_arr_advertRow;
        }

        $_arr_posiRow                 = $this->mdl_posi->mdl_read($_arr_advertRow["advert_posi_id"]);
        $_arr_advertRow["posiRow"]    = $_arr_posiRow;

        if ($_arr_posiRow["posi_type"] == "media" && $_arr_advertRow["advert_media_id"] > 0) {
            $_arr_advertRow["mediaRow"] = $this->mdl_media->mdl_read($_arr_advertRow["advert_media_id"]);
        }

        $this->tplData["advertRow"] = $_arr_advertRow;

        $this->obj_tpl->tplDisplay("advert_show.tpl", $this->tplData);

        return array(
            "alert" => "y080102",
        );
    }

    /*============编辑管理员界面============
    返回提示
    */
    function ctl_form() {
        $_num_advertId = fn_getSafe(fn_get("advert_id"), "int", 0);

        $_arr_mediaRow = array(
            "media_url" => "",
        );

        if ($_num_advertId > 0) {
            if (!isset($this->adminLogged["admin_allow"]["advert"]["edit"]) && !$this->is_super) {
                return array(
                    "alert" => "x080303",
                );
            }
            $_arr_advertRow = $this->mdl_advert->mdl_read($_num_advertId);
            if ($_arr_advertRow["alert"] != "y080102") {
                return $_arr_advertRow;
            }

            $_arr_posiRow                 = $this->mdl_posi->mdl_read($_arr_advertRow["advert_posi_id"]);
            $_arr_advertRow["posiRow"]    = $_arr_posiRow;

            if ($_arr_posiRow["posi_type"] == "media" && $_arr_advertRow["advert_media_id"] > 0) {
                $_arr_advertRow["mediaRow"] = $this->mdl_media->mdl_read($_arr_advertRow["advert_media_id"]);
            } else {
                $_arr_advertRow["mediaRow"] = $_arr_mediaRow;
            }
        } else {
            if (!isset($this->adminLogged["admin_allow"]["advert"]["add"]) && !$this->is_super) {
                return array(
                    "alert" => "x080302",
                );
            }
            $_arr_advertRow = array(
                "advert_id"         => 0,
                "advert_name"       => "",
                "advert_posi_id"    => 0,
                "advert_media_id"   => 0,
                "advert_content"    => "",
                "advert_put_type"   => "",
                "advert_put_opt"    => "",
                "advert_begin"      => time(),
                "advert_percent"    => 0,
                "advert_url"        => "",
                "advert_note"       => "",
                "advert_status"     => "enable",
                "mediaRow"          => $_arr_mediaRow,
            );
        }

        $_arr_search    = array(
            "status"    => "enable"
        );
        $_arr_posiRows  = $this->mdl_posi->mdl_list(1000, 0, $_arr_search);
        if (count($_arr_posiRows) < 1) {
            return array(
                "alert" => "x080230",
            );
        }

        foreach ($_arr_posiRows as $key=>$value) {
            $_arr_posiJSON[$value["posi_id"]] = $value;
            $_arr_posiJSON[$value["posi_id"]]["percent_sum"] = $this->mdl_advert->mdl_sum($value["posi_id"], "enable", true, array($_arr_advertRow["advert_id"]));
        }

        $_arr_tpl = array(
            "advertRow"  => $_arr_advertRow,
            "posiRows"   => $_arr_posiRows,
            "posiJSON"   => json_encode($_arr_posiJSON),
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("advert_form.tpl", $_arr_tplData);

        return array(
            "alert" => "y080102",
        );
    }


    /*============列出管理员界面============
    无返回
    */
    function ctl_list() {
        if (!isset($this->adminLogged["admin_allow"]["advert"]["browse"]) && !$this->is_super) {
            return array(
                "alert" => "x080301",
            );
        }

        $_arr_search = array(
            "key"        => fn_getSafe(fn_get("key"), "txt", ""),
            "posi_id"    => fn_getSafe(fn_get("posi_id"), "int", 0),
            "status"     => fn_getSafe(fn_get("status"), "txt", ""),
        );

        $_num_advertCount = $this->mdl_advert->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_advertCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_advertRows  = $this->mdl_advert->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_arr_search);

        $_arr_searchPosi    = array(
            "status"    => "enable"
        );
        $_arr_posiRows    = $this->mdl_posi->mdl_list(1000, 0, $_arr_searchPosi);

        foreach ($_arr_advertRows as $_key=>$_value) {
            $_arr_advertRows[$_key]["posiRow"] = $this->mdl_posi->mdl_read($_value["advert_posi_id"]);
        }

        $_arr_tpl = array(
            "query"      => $_str_query,
            "pageRow"    => $_arr_page,
            "search"     => $_arr_search,
            "advertRows" => $_arr_advertRows,
            "posiRows"   => $_arr_posiRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("advert_list.tpl", $_arr_tplData);
        return array(
            "alert" => "y080302",
        );
    }
}
