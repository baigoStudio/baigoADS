<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_CLASS . "tpl.class.php");
include_once(BG_PATH_MODEL . "media.class.php");

/*-------------用户类-------------*/
class CONTROL_MEDIA {

    private $obj_base;
    private $config;
    private $adminLogged;
    private $obj_tpl;
    private $mdl_media;
    private $mdl_admin;

    function __construct() { //构造函数
        $this->obj_base       = $GLOBALS["obj_base"];
        $this->config         = $this->obj_base->config;
        $this->adminLogged    = $GLOBALS["adminLogged"];
        $this->obj_tpl        = new CLASS_TPL(BG_PATH_TPL . "admin/" . $this->config["ui"]); //初始化视图对象
        $this->mdl_media      = new MODEL_MEDIA(); //设置上传信息对象
        $this->mdl_admin      = new MODEL_ADMIN();
        $this->setUpload();
        $this->tplData = array(
            "adminLogged"    => $this->adminLogged,
            "uploadSize"     => BG_UPLOAD_SIZE * $this->sizeUnit,
            "mimeRows"       => $this->mimeRows
        );
    }


    /**
     * ctl_form function.
     *
     * @access public
     * @return void
     */
    function ctl_form() {
        if (!isset($this->adminLogged["admin_allow"]["media"]["upload"])) {
            return array(
                "alert" => "x070302",
            );
        }

        if (!is_array($this->mimeRows)) {
            return array(
                "alert" => "x070405",
            );
        }

        $_arr_yearRows    = $this->mdl_media->mdl_year(100);
        $_arr_extRows     = $this->mdl_media->mdl_ext();

        $_arr_tpl = array(
            "yearRows"   => $_arr_yearRows,
            "extRows"    => $_arr_extRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("media_form.tpl", $_arr_tplData);

        return array(
            "alert" => "y070302",
        );
    }


    /**
     * ctl_list function.
     *
     * @access public
     * @return void
     */
    function ctl_list() {
        if (!isset($this->adminLogged["admin_allow"]["media"]["browse"])) {
            return array(
                "alert" => "x070301",
            );
        }

        if (!is_array($this->mimeRows)) {
            return array(
                "alert" => "x070405",
            );
        }

        $_arr_search = array(
            "box"        => fn_getSafe(fn_get("box"), "txt", "normal"),
            "key"        => fn_getSafe(fn_get("key"), "txt", ""),
            "year"       => fn_getSafe(fn_get("year"), "txt", ""),
            "month"      => fn_getSafe(fn_get("month"), "txt", ""),
            "ext"        => fn_getSafe(fn_get("ext"), "txt", ""),
            "admin_id"   => fn_getSafe(fn_get("admin_id"), "int", 0),
        ); //搜索设置

        $_num_mediaCount  = $this->mdl_media->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_mediaCount);
        $_str_query       = http_build_query($_arr_search);
        $_arr_yearRows    = $this->mdl_media->mdl_year(100);
        $_arr_extRows     = $this->mdl_media->mdl_ext();
        $_arr_mediaRows   = $this->mdl_media->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_arr_search);

        $_arr_searchAll = array(
            "box"        => "normal",
        ); //搜索设置
        $_arr_searchRecycle = array(
            "box"        => "recycle",
        ); //搜索设置
        $_arr_mediaCount["all"]     = $this->mdl_media->mdl_count($_arr_searchAll);
        $_arr_mediaCount["recycle"] = $this->mdl_media->mdl_count($_arr_searchRecycle);

        $_arr_tpl = array(
            "query"      => $_str_query,
            "pageRow"    => $_arr_page,
            "search"     => $_arr_search,
            "mediaCount" => $_arr_mediaCount,
            "mediaRows"  => $_arr_mediaRows, //上传信息
            "yearRows"   => $_arr_yearRows, //目录列表
            "extRows"    => $_arr_extRows, //扩展名列表
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay("media_list.tpl", $_arr_tplData);

        return array(
            "alert" => "y070301",
        );
    }


    /**
     * setUpload function.
     *
     * @access private
     * @return void
     */
    private function setUpload() {
        foreach ($this->mdl_media->mime as $_key=>$_value) {
            $this->mimeRows[] = $_key;
        }

        switch (BG_UPLOAD_UNIT) { //初始化单位
            case "B":
                $this->sizeUnit = 1;
            break;

            case "KB":
                $this->sizeUnit = 1024;
            break;

            case "MB":
                $this->sizeUnit = 1024 * 1024;
            break;

            case "GB":
                $this->sizeUnit = 1024 * 1024 * 1024;
            break;
        }
    }
}
