<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

/*-------------应用模型-------------*/
class MODEL_ADVERT {
    private $obj_db;
    public $advertStatus    = array();
    public $advertPutTypes  = array();

    function __construct() { //构造函数
        $this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
    }


    /** 创建表
     * mdl_create function.
     *
     * @access public
     * @return void
     */
    function mdl_create_table() {
        foreach ($this->advertStatus as $_key=>$_value) {
            $_arr_status[] = $_key;
        }
        $_str_status = implode("','", $_arr_status);

        foreach ($this->advertPutTypes as $_key=>$_value) {
            $_arr_putTyes[] = $_key;
        }
        $_str_putTyes = implode("','", $_arr_putTyes);

        $_arr_advertCreate = array(
            "advert_id"          => "int NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            "advert_name"        => "varchar(300) NOT NULL COMMENT '广告名称'",
            "advert_posi_id"     => "int NOT NULL COMMENT '广告位 ID'",
            "advert_media_id"    => "int NOT NULL COMMENT '广告图片 ID'",
            "advert_count_show"  => "int NOT NULL COMMENT '展示数'",
            "advert_count_hit"   => "int NOT NULL COMMENT '点击数'",
            "advert_put_type"    => "enum('" . $_str_putTyes . "') NOT NULL COMMENT '投放类型'",
            "advert_put_opt"     => "int NOT NULL COMMENT '投放条件'",
            "advert_url"         => "varchar(3000) NOT NULL COMMENT '链接地址'",
            "advert_percent"     => "tinyint NOT NULL COMMENT '展现几率'",
            "advert_content"     => "text NOT NULL COMMENT '文字内容'",
            "advert_status"      => "enum('" . $_str_status . "') NOT NULL COMMENT '状态'",
            "advert_begin"       => "int NOT NULL COMMENT '生效时间'",
            "advert_note"        => "varchar(300) NOT NULL COMMENT '备注'",
            "advert_time"        => "int NOT NULL COMMENT '创建时间'",
            "advert_admin_id"    => "int NOT NULL COMMENT '管理员 ID'",
            "advert_approve_id"  => "int NOT NULL COMMENT '审核人 ID'",
        );

        $_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "advert", $_arr_advertCreate, "advert_id", "应用");

        if ($_num_mysql > 0) {
            $_str_alert = "y080105"; //更新成功
        } else {
            $_str_alert = "x080105"; //更新成功
        }

        return array(
            "alert" => $_str_alert, //更新成功
        );
    }


    /** 检查字段
     * mdl_column function.
     *
     * @access public
     * @return void
     */
    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "advert");

        foreach ($_arr_colRows as $_key=>$_value) {
            $_arr_col[] = $_value["Field"];
        }

        return $_arr_col;
    }


    function mdl_stat($num_advertId, $is_hit = false) {
        if ($is_hit) {
            $_arr_advertData = array(
                "advert_count_hit"  => "advert_count_hit+1",
            );
        } else {
            $_arr_advertData = array(
                "advert_count_show"  => "advert_count_show+1",
            );
        }

        $_num_mysql = $this->obj_db->update(BG_DB_TABLE . "advert", $_arr_advertData, "advert_id=" . $num_advertId, true); //更新数据

        if ($_num_mysql > 0) {
            $_str_alert = "y080103"; //更新成功
        } else {
            return array(
                "alert" => "x080103", //更新失败
            );
        }

        return array(
            "advert_id"  => $num_advertId,
            "alert"      => $_str_alert, //成功
        );
    }

    /** 提交
     * mdl_submit function.
     *
     * @access public
     * @return void
     */
    function mdl_submit($num_adminId, $str_advertStatus) {
        $_arr_advertData = array(
            "advert_name"        => $this->advertSubmit["advert_name"],
            "advert_posi_id"     => $this->advertSubmit["advert_posi_id"],
            "advert_media_id"    => $this->advertSubmit["advert_media_id"],
            "advert_content"     => $this->advertSubmit["advert_content"],
            "advert_put_type"    => $this->advertSubmit["advert_put_type"],
            "advert_put_opt"     => $this->advertSubmit["advert_put_opt"],
            "advert_url"         => $this->advertSubmit["advert_url"],
            "advert_percent"     => $this->advertSubmit["advert_percent"],
            "advert_begin"       => $this->advertSubmit["advert_begin"],
            "advert_note"        => $this->advertSubmit["advert_note"],
            "advert_status"      => $str_advertStatus,
            "advert_admin_id"    => $num_adminId,
        );

        if ($this->advertSubmit["advert_id"] < 1) {
            $_arr_insert = array(
                "advert_time"          => time(),
            );
            $_arr_data = array_merge($_arr_advertData, $_arr_insert);

            $_num_advertId = $this->obj_db->insert(BG_DB_TABLE . "advert", $_arr_data); //更新数据
            if ($_num_advertId > 0) {
                $_str_alert = "y080101"; //更新成功
            } else {
                return array(
                    "alert" => "x080101", //更新失败
                );

            }
        } else {
            $_num_advertId   = $this->advertSubmit["advert_id"];
            $_num_mysql      = $this->obj_db->update(BG_DB_TABLE . "advert", $_arr_advertData, "advert_id=" . $_num_advertId); //更新数据
            if ($_num_mysql > 0) {
                $_str_alert = "y080103"; //更新成功
            } else {
                return array(
                    "alert" => "x080103", //更新失败
                );

            }
        }

        return array(
            "advert_id"     => $_num_advertId,
            "alert"  => $_str_alert, //成功
        );
    }


    /** 更改状态
     * mdl_status function.
     *
     * @access public
     * @param mixed $str_status
     * @return void
     */
    function mdl_status($str_status, $num_adminId) {
        $_str_advertId = implode(",", $this->advertIds["advert_ids"]);

        $_arr_advertUpdate = array(
            "advert_status"      => $str_status,
            "advert_approve_id"  => $num_adminId,
        );

        $_num_mysql = $this->obj_db->update(BG_DB_TABLE . "advert", $_arr_advertUpdate, "advert_id IN (" . $_str_advertId . ")"); //删除数据

        //如影响行数大于0则返回成功
        if ($_num_mysql > 0) {
            $_str_alert = "y080103"; //成功
        } else {
            $_str_alert = "x080103"; //失败
        }

        return array(
            "alert" => $_str_alert,
        );
    }


    /** 读取
     * mdl_read function.
     *
     * @access public
     * @param mixed $str_advert
     * @param string $str_by (default: "advert_id")
     * @param int $num_notId (default: 0)
     * @return void
     */
    function mdl_read($str_advert, $str_by = "advert_id", $num_notId = 0) {
        $_arr_advertSelect = array(
            "advert_id",
            "advert_name",
            "advert_posi_id",
            "advert_media_id",
            "advert_count_show",
            "advert_count_hit",
            "advert_put_type",
            "advert_put_opt",
            "advert_url",
            "advert_percent",
            "advert_content",
            "advert_status",
            "advert_begin",
            "advert_note",
            "advert_time",
            "advert_admin_id",
            "advert_approve_id",
        );

        switch ($str_by) {
            case "advert_id":
                $_str_sqlWhere = "advert_id=" . $str_advert;
            break;
            default:
                $_str_sqlWhere = $str_by . "='" . $str_advert . "'";
            break;
        }

        if ($num_notId > 0) {
            $_str_sqlWhere .= " AND advert_id<>" . $num_notId;
        }

        $_arr_advertRows = $this->obj_db->select(BG_DB_TABLE . "advert", $_arr_advertSelect, $_str_sqlWhere, "", "", 1, 0); //检查本地表是否存在记录

        if (isset($_arr_advertRows[0])) { //用户名不存在则返回错误
            $_arr_advertRow = $_arr_advertRows[0];
        } else {
            return array(
                "alert" => "x080102", //不存在记录
            );
        }

        $_arr_advertRow["advert_href"]    = BG_SITE_URL . BG_URL_ADVERT . "ctl.php?mod=advert&act_get=url&advert_id=" . $_arr_advertRow["advert_id"];
        $_arr_advertRow["alert"]          = "y080102";

        return $_arr_advertRow;
    }


    function mdl_sum($num_posiId, $str_status = "", $is_enable = false, $arr_notIds = false) {
        $_arr_advertSelect = array(
            "SUM(advert_percent) AS advert_percent_sum",
        );

        $_str_sqlWhere = "advert_posi_id=" . $num_posiId;

        if ($str_status) {
            $_str_sqlWhere .= " AND advert_status='" . $str_status . "'";
        }

        if ($is_enable) {
            $_str_sqlWhere .= " AND ((advert_put_type='date' AND advert_put_opt>=" . time() . ") OR (advert_put_type='show' AND advert_count_show<=advert_put_opt) OR (advert_put_type='hit' AND advert_count_hit<=advert_put_opt))";
        }

        if ($arr_notIds) {
            $_str_advertIds = implode(",", $arr_notIds);
            $_str_sqlWhere .= " AND advert_id NOT IN (" . $_str_advertIds . ")";
        }

        $_arr_advertRows = $this->obj_db->select(BG_DB_TABLE . "advert", $_arr_advertSelect, $_str_sqlWhere, "", "", 1, 0, "", true); //检查本地表是否存在记录

        if (isset($_arr_advertRows[0]) && $_arr_advertRows[0]["advert_percent_sum"]) { //用户名不存在则返回错误
            $_num_percentSum = $_arr_advertRows[0]["advert_percent_sum"];
        } else {
            $_num_percentSum = 0;
        }

        return $_num_percentSum;
    }


    function mdl_listPub($num_posi, $str_type = "") {
        $_arr_advertSelect = array(
            "advert_id",
            "advert_name",
            "advert_posi_id",
            "advert_media_id",
            "advert_count_show",
            "advert_count_hit",
            "advert_put_type",
            "advert_put_opt",
            "advert_url",
            "advert_percent",
            "advert_content",
            "advert_status",
            "advert_begin",
        );

        $_str_sqlWhere = "advert_status='enable' AND advert_posi_id=" . $num_posi;

        if ($str_type == "subs") {
            $_str_sqlWhere .= " AND advert_put_type='subs'";
        } else {
            $_str_sqlWhere .= " AND ((advert_put_type='date' AND advert_put_opt>=" . time() . ") OR (advert_put_type='show' AND advert_count_show<=advert_put_opt) OR (advert_put_type='hit' AND advert_count_hit<=advert_put_opt) OR advert_put_type='none')";
        }

        //print_r($_str_sqlWhere);

        $_arr_advertRows = $this->obj_db->select(BG_DB_TABLE . "advert", $_arr_advertSelect, $_str_sqlWhere, "", "advert_id DESC", 1000, 0); //查询数据

        foreach ($_arr_advertRows as $_key=>$_value) {
            $_arr_advertRows[$_key]["advert_href"]    = BG_SITE_URL . BG_URL_ADVERT . "ctl.php?mod=advert&act_get=url&advert_id=" . $_value["advert_id"];
        }

        return $_arr_advertRows;
    }


    /** 列出
     * mdl_list function.
     *
     * @access public
     * @param mixed $num_advertNo
     * @param int $num_advertExcept (default: 0)
     * @param string $str_key (default: "")
     * @param string $str_status (default: "")
     * @param string $str_sync (default: "")
     * @return void
     */
    function mdl_list($num_advertNo, $num_advertExcept = 0, $arr_search = array()) {
        $_arr_advertSelect = array(
            "advert_id",
            "advert_name",
            "advert_posi_id",
            "advert_media_id",
            "advert_count_show",
            "advert_count_hit",
            "advert_put_type",
            "advert_put_opt",
            "advert_url",
            "advert_percent",
            "advert_content",
            "advert_status",
            "advert_begin",
            "advert_note",
            "advert_time",
            "advert_admin_id",
            "advert_approve_id",
        );

        $_str_sqlWhere = $this->sql_process();

        $_arr_advertRows = $this->obj_db->select(BG_DB_TABLE . "advert", $_arr_advertSelect, $_str_sqlWhere, "", "advert_id DESC", $num_advertNo, $num_advertExcept); //查询数据

        return $_arr_advertRows;
    }


    /** 计数
     * mdl_count function.
     *
     * @access public
     * @param string $str_key (default: "")
     * @param string $str_status (default: "")
     * @param string $str_sync (default: "")
     * @return void
     */
    function mdl_count($arr_search = array()) {
        $_str_sqlWhere = $this->sql_process();

        $_num_advertCount = $this->obj_db->count(BG_DB_TABLE . "advert", $_str_sqlWhere); //查询数据

        return $_num_advertCount;
    }


    /** 删除
     * mdl_del function.
     *
     * @access public
     * @return void
     */
    function mdl_del() {
        $_str_advertId = implode(",", $this->advertIds["advert_ids"]);

        $_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "advert", "advert_id IN (" . $_str_advertId . ")"); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_mysql > 0) {
            $_str_alert = "y080104"; //成功
        } else {
            $_str_alert = "x080104"; //失败
        }

        return array(
            "alert" => $_str_alert,
        );
    }


    /** 表单验证
     * input_submit function.
     *
     * @access public
     * @return void
     */
    function input_submit() {
        if (!fn_token("chk")) { //令牌
            return array(
                "alert" => "x030206",
            );
        }

        $this->advertSubmit["advert_id"] = fn_getSafe(fn_post("advert_id"), "int", 0);

        if ($this->advertSubmit["advert_id"] > 0) {
            //检查用户是否存在
            $_arr_advertRow = $this->mdl_read($this->advertSubmit["advert_id"]);
            if ($_arr_advertRow["alert"] != "y080102") {
                return $_arr_advertRow;
            }
        }

        $_arr_advertName = validateStr(fn_post("advert_name"), 1, 300);
        switch ($_arr_advertName["status"]) {
            case "too_short":
                return array(
                    "alert" => "x080201",
                );
            break;

            case "too_long":
                return array(
                    "alert" => "x080202",
                );
            break;

            case "ok":
                $this->advertSubmit["advert_name"] = $_arr_advertName["str"];
            break;

        }

        $_arr_advertPosiId = validateStr(fn_post("advert_posi_id"), 1, 0);
        switch ($_arr_advertPosiId["status"]) {
            case "too_short":
                return array(
                    "alert" => "x080203",
                );
            break;

            case "ok":
                $this->advertSubmit["advert_posi_id"] = $_arr_advertPosiId["str"];
            break;
        }

        $this->advertSubmit["advert_media_id"]    = fn_getSafe(fn_post("advert_media_id"), "int", 0);
        $this->advertSubmit["advert_content"]     = fn_getSafe(fn_post("advert_content"), "txt", "");

        if ($this->advertSubmit["advert_media_id"] < 1 && !$this->advertSubmit["advert_content"]) {
            return array(
                "alert" => "x080227",
            );
        }

        $_arr_advertPutType = validateStr(fn_post("advert_put_type"), 1, 0);
        switch ($_arr_advertPutType["status"]) {
            case "too_short":
                return array(
                    "alert" => "x080204",
                );
            break;

            case "ok":
                $this->advertSubmit["advert_put_type"] = $_arr_advertPutType["str"];
            break;
        }

        switch ($this->advertSubmit["advert_put_type"]) {
            case "date":
                $_num_min       = 1;
                $_str_format    = "datetime";
                $_str_tooShort  = "x080216";
                $_str_formatErr = "x080217";
            break;

            case "show":
                $_num_min       = 1;
                $_str_format    = "int";
                $_str_tooShort  = "x080218";
                $_str_formatErr = "x080219";
            break;

            case "hit":
                $_num_min       = 1;
                $_str_format    = "int";
                $_str_tooShort  = "x080220";
                $_str_formatErr = "x080221";
            break;

            default:
                $_num_min       = 0;
                $_str_format    = "text";
                $_str_tooShort  = "x080220";
                $_str_formatErr = "x080221";
            break;
        }

        $_arr_advertPutOpts = validateStr(fn_post("advert_put_opt"), $_num_min, 0, "str", $_str_format);
        switch ($_arr_advertPutOpts["status"]) {
            case "too_short":
                return array(
                    "alert" => $_str_tooShort,
                );
            break;

            case "format_err":
                return array(
                    "alert" => $_str_formatErr,
                );
            break;

            case "ok":
                if ($this->advertSubmit["advert_put_type"] == "date") {
                    $_num_advertPutOpts = fn_strtotime($_arr_advertPutOpts["str"]);
                } else {
                    $_num_advertPutOpts = $_arr_advertPutOpts["str"];
                }
                $this->advertSubmit["advert_put_opt"] = $_num_advertPutOpts;
            break;
        }

        $_arr_advertUrl = validateStr(fn_post("advert_url"), 1, 3000);
        switch ($_arr_advertUrl["status"]) {
            case "too_short":
                return array(
                    "alert" => "x080205",
                );
            break;

            case "too_long":
                return array(
                    "alert" => "x080206",
                );
            break;

            case "ok":
                $this->advertSubmit["advert_url"] = $_arr_advertUrl["str"];
            break;
        }

        $_arr_advertNote = validateStr(fn_post("advert_note"), 0, 30);
        switch ($_arr_advertNote["status"]) {
            case "too_long":
                return array(
                    "alert" => "x080207",
                );
            break;

            case "ok":
                $this->advertSubmit["advert_note"] = $_arr_advertNote["str"];
            break;

        }

        $_arr_advertStatus = validateStr(fn_post("advert_status"), 1, 0);
        switch ($_arr_advertStatus["status"]) {
            case "too_short":
                return array(
                    "alert" => "x080208",
                );
            break;

            case "ok":
                $this->advertSubmit["advert_status"] = $_arr_advertStatus["str"];
            break;
        }

        $_arr_advertPercent = validateStr(fn_post("advert_percent"), 1, 10, "digit", "int");
        switch ($_arr_advertPercent["status"]) {
            case "too_small":
                return array(
                    "alert" => "x080209",
                );
            break;

            case "too_big":
                return array(
                    "alert" => "x080210",
                );
            break;

            case "format_err":
                return array(
                    "alert" => "x080211",
                );
            break;

            case "ok":
                $this->advertSubmit["advert_percent"] = $_arr_advertPercent["str"];
            break;
        }

        $_num_percentSum = $this->mdl_sum($this->advertSubmit["advert_posi_id"], "enable", true, array($this->advertSubmit["advert_id"]));

        if ($this->advertSubmit["advert_percent"] > (10 - $_num_percentSum)) {

        }

        $_arr_advertBegin = validateStr(fn_post("advert_begin"), 1, 0, "str", "datetime");
        switch ($_arr_advertBegin["status"]) {
            case "too_short":
                return array(
                    "alert" => "x080214",
                );
            break;

            case "format_err":
                return array(
                    "alert" => "x080215",
                );
            break;

            case "ok":
                $this->advertSubmit["advert_begin"] = fn_strtotime($_arr_advertBegin["str"]);
            break;
        }

        $this->advertSubmit["alert"] = "ok";

        return $this->advertSubmit;
    }


    /** 选择 advert
     * input_ids function.
     *
     * @access public
     * @return void
     */
    function input_ids() {
        if (!fn_token("chk")) { //令牌
            return array(
                "alert" => "x030206",
            );
        }

        $_arr_advertIds = fn_post("advert_ids");

        if ($_arr_advertIds) {
            foreach ($_arr_advertIds as $_key=>$_value) {
                $_arr_advertIds[$_key] = fn_getSafe($_value, "int", 0);
            }
            $_str_alert = "ok";
        } else {
            $_str_alert = "x030202";
        }

        $this->advertIds = array(
            "alert"         => $_str_alert,
            "advert_ids"    => $_arr_advertIds
        );

        return $this->advertIds;
    }


    function get_rand($arr_adverts) {
        $result = "";

        //概率数组的总概率精度
        $_num_percentSum = array_sum($arr_adverts);

        //概率数组循环
        foreach ($arr_adverts as $_key=>$_value) {
            $_num_rand = mt_rand(1, $_num_percentSum);
            if ($_num_rand <= $_value) {
                $result = $_key;
                break;
            } else {
                $_num_percentSum -= $_value;
            }
        }
        unset($arr_adverts);

        return $result;
    }


    private function sql_process($arr_search = array()) {
        $_str_sqlWhere = "1=1";

        if (isset($arr_search["key"]) && $arr_search["key"]) {
            $_str_sqlWhere .= " AND (advert_name LIKE '%" . $arr_search["key"] . "%' OR advert_note LIKE '%" . $arr_search["key"] . "%')";
        }

        if (isset($arr_search["status"]) && $arr_search["status"]) {
            $_str_sqlWhere .= " AND advert_status='" . $arr_search["status"] . "'";
        }

        if (isset($arr_search["posi_id"]) && $arr_search["posi_id"] > 0) {
            $_str_sqlWhere .= " AND advert_posi_id=" . $arr_search["posi_id"];
        }

        return $_str_sqlWhere;
    }
}
