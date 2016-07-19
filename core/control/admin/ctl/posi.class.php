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
include_once(BG_PATH_CLASS . "dir.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "advert.class.php"); //载入管理帐号模型
include_once(BG_PATH_MODEL . "posi.class.php");
include_once(BG_PATH_MODEL . "media.class.php");

/*-------------用户类-------------*/
class CONTROL_POSI {

    public $obj_tpl;
    public $mdl_posi;
    public $adminLogged;

    function __construct() { //构造函数
        $this->obj_base       = $GLOBALS["obj_base"]; //获取界面类型
        $this->config         = $this->obj_base->config;
        $this->adminLogged    = $GLOBALS["adminLogged"];
        $this->mdl_advert     = new MODEL_ADVERT(); //设置管理员模型
        $this->mdl_media      = new MODEL_MEDIA();
        $this->mdl_posi       = new MODEL_POSI();
        $this->obj_tpl        = new CLASS_TPL(BG_PATH_TPL . "admin/" . $this->config["ui"]); //初始化视图对象
        $this->obj_dir        = new CLASS_DIR();
        $this->tplData = array(
            "adminLogged" => $this->adminLogged
        );
    }


    function ctl_show() {
        if (!isset($this->adminLogged["admin_allow"]["posi"]["browse"])) {
            return array(
                "alert" => "x040301",
            );
        }

        $_num_posiId  = fn_getSafe(fn_get("posi_id"), "int", 0);
        if ($_num_posiId < 1) {
            return array(
                "alert" => "x040206",
            );
        }

        $_arr_posiRow = $this->mdl_posi->mdl_read($_num_posiId);
        if ($_arr_posiRow["alert"] != "y040102") {
            return $_arr_posiRow;
        }

        $_arr_adverts     = array();
        $_arr_advertRows  = $this->mdl_advert->mdl_listPub($_num_posiId);

        if ($_arr_advertRows) {
            if ($_arr_posiRow["posi_is_percent"] == "enable") {
                foreach ($_arr_advertRows as $key=>$value) {
                    $arr_adverts[$value["advert_id"]] = $value["advert_percent"];
                }

                for ($_iii = 1; $_iii<=$_arr_posiRow["posi_count"]; $_iii++) {
                    $arr_ids[] = $this->mdl_advert->get_rand($arr_adverts); //根据概率获取奖项id
                }

                foreach ($arr_ids as $_key=>$_value) {
                    $_arr_adverts[$_key] = $this->mdl_advert->mdl_read($_value);;
                }
            } else {
                $_arr_adverts = $_arr_advertRows;
            }
        } else {
            $_arr_adverts = $this->mdl_advert->mdl_listPub($_num_posiId, "subs");
        }

        foreach ($_arr_adverts as $_key=>$_value) {
            $_arr_adverts[$_key]["mediaRow"] = $this->mdl_media->mdl_read($_value["advert_media_id"]);
        }

        //print_r($_arr_adverts);

        $_arr_tpl = array(
            "posiRow"    => $_arr_posiRow,
            "advertRows" => $_arr_adverts,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("posi_show.tpl", $_arr_tplData);

        return array(
            "alert" => "y040102",
        );
    }

    function ctl_form() {
        $_num_posiId  = fn_getSafe(fn_get("posi_id"), "int", 0);

        if ($_num_posiId > 0) {
            if (!isset($this->adminLogged["admin_allow"]["posi"]["edit"])) {
                return array(
                    "alert" => "x040303",
                );
            }
            $_arr_posiRow = $this->mdl_posi->mdl_read($_num_posiId);
            if ($_arr_posiRow["alert"] != "y040102") {
                return $_arr_posiRow;
            }
        } else {
            if (!isset($this->adminLogged["admin_allow"]["posi"]["add"])) {
                return array(
                    "alert" => "x040302",
                );
            }
            $_arr_posiRow = array(
                "posi_id"           => 0,
                "posi_name"         => "",
                "posi_count"        => 1,
                "posi_type"         => "media",
                "posi_status"       => "enable",
                "posi_script"       => "",
                "posi_plugin"       => "",
                "posi_selector"     => "",
                "posi_opts"         => array(),
                "posi_is_percent"   => "enable",
                "posi_note"         => "",
            );
        }

        $_arr_scriptRows = $this->obj_dir->list_dir(BG_PATH_ADVERT);

        foreach ($_arr_scriptRows as $_key=>$_value) {
            if ($_value["type"] == "file") {
                unset($_arr_scriptRows[$_key]);
            } else {
                $_str_config = file_get_contents(BG_PATH_ADVERT . $_value["name"] . "/config.json");
                $_arr_scriptRows[$_key]["config"] = fn_jsonDecode($_str_config, "no");
            }
        }

        //print_r($_arr_scriptRows);

        $_arr_tpl = array(
            "posiRow"        => $_arr_posiRow,
            "scriptRows"     => $_arr_scriptRows, //管理员列表
            "scriptJSON"     => fn_jsonEncode($_arr_scriptRows, "no"),
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("posi_form.tpl", $_arr_tplData);

        return array(
            "alert" => "y040102",
        );
    }

    /**
     * ctl_list function.
     *
     * @access public
     * @return void
     */
    function ctl_list() {
        if (!isset($this->adminLogged["admin_allow"]["posi"]["browse"])) {
            return array(
                "alert" => "x040301",
            );
        }

        $_arr_search = array(
            "key"       => fn_getSafe(fn_get("key"), "txt", ""),
            "status"    => fn_getSafe(fn_get("status"), "txt", ""),
        );

        $_num_posiCount   = $this->mdl_posi->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_posiCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_posiRows    = $this->mdl_posi->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_arr_search);

        $_arr_tpl = array(
            "query"      => $_str_query,
            "pageRow"    => $_arr_page,
            "search"     => $_arr_search,
            "posiRows"   => $_arr_posiRows, //管理员列表
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("posi_list.tpl", $_arr_tplData);

        return array(
            "alert" => "y040301",
        );
    }
}
