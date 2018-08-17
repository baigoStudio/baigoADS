<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------插件模型-------------*/
class MODEL_PLUGIN {

    public $arr_status = array('enable', 'disable');

    function __construct() { //构造函数
        $this->obj_db   = $GLOBALS['obj_db']; //设置数据库对象
        $this->obj_file  = new CLASS_FILE();
    }


    /** 创建表
     * mdl_create function.
     *
     * @access public
     * @return void
     */
    function mdl_create_table() {
        $_str_status = implode('\',\'', $this->arr_status);

        $_arr_pluginCreate = array(
            'plugin_id'        => 'smallint NOT NULL AUTO_INCREMENT COMMENT \'ID\'',
            //'plugin_name'      => 'varchar(300) NOT NULL COMMENT \'插件名\'',
            'plugin_dir'       => 'varchar(300) NOT NULL COMMENT \'插件目录\'',
            'plugin_status'    => 'enum(\'' . $_str_status . '\') NOT NULL COMMENT \'状态\'',
            'plugin_note'      => 'varchar(300) NOT NULL COMMENT \'备注\'',
            'plugin_time'      => 'int NOT NULL COMMENT \'创建时间\'',
        );

        $_num_db = $this->obj_db->create_table(BG_DB_TABLE . 'plugin', $_arr_pluginCreate, 'plugin_id', '插件');

        if ($_num_db > 0) {
            $_str_rcode = 'y190105'; //更新成功
        } else {
            $_str_rcode = 'x190105'; //更新成功
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
        );
    }


    /** 列出字段
     * mdl_column function.
     *
     * @access public
     * @return void
     */
    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . 'plugin');

        $_arr_col = array();

        if (!fn_isEmpty($_arr_colRows)) {
            foreach ($_arr_colRows as $_key=>$_value) {
                $_arr_col[] = $_value['Field'];
            }
        }

        return $_arr_col;
    }


    /** 修改表
     * mdl_alter_table function.
     *
     * @access public
     * @return void
     */
    function mdl_alter_table() {
        $_str_status = implode('\',\'', $this->arr_status);

        $_arr_col     = $this->mdl_column();
        $_arr_alter   = array();

        $_str_rcode = 'y190111';

        if (!fn_isEmpty($_arr_alter)) {
            $_reselt = $this->obj_db->alter_table(BG_DB_TABLE . 'plugin', $_arr_alter);

            if (!fn_isEmpty($_reselt)) {
                $_str_rcode = 'y190106';
            }
        }

        return array(
            'rcode' => $_str_rcode,
        );
    }



    /** 提交
     * mdl_submit function.
     *
     * @access public
     * @return void
     */
    function mdl_submit() {
        $_arr_pluginData = array(
            //'plugin_name'   => $this->pluginInput['plugin_name'],
            'plugin_dir'    => $this->pluginInput['plugin_dir'],
            'plugin_note'   => $this->pluginInput['plugin_note'],
            'plugin_status' => $this->pluginInput['plugin_status'],
        );

        if ($this->pluginInput['plugin_id'] < 1) {
            $_arr_insert = array(
                'plugin_time'  => time(),
            );
            $_arr_data = array_merge($_arr_pluginData, $_arr_insert);

            $_num_pluginId = $this->obj_db->insert(BG_DB_TABLE . 'plugin', $_arr_data); //更新数据
            if ($_num_pluginId > 0) {
                $_str_rcode = 'y190101'; //更新成功
            } else {
                return array(
                    'rcode' => 'x190101', //更新失败
                );

            }
        } else {
            $_num_pluginId = $this->pluginInput['plugin_id'];
            $_num_db = $this->obj_db->update(BG_DB_TABLE . 'plugin', $_arr_pluginData, '`plugin_id`=' . $_num_pluginId); //更新数据
            if ($_num_db > 0) {
                $_str_rcode = 'y190103'; //更新成功
            } else {
                return array(
                    'rcode' => 'x190103', //更新失败
                );

            }
        }

        return array(
            'plugin_id' => $_num_pluginId,
            'rcode'     => $_str_rcode, //成功
        );
    }


    /** 更改状态
     * mdl_status function.
     *
     * @access public
     * @param mixed $str_status
     * @return void
     */
    function mdl_status($str_status) {
        $_str_pluginId = implode(',', $this->pluginIds['plugin_ids']);

        $_arr_pluginUpdate = array(
            'plugin_status' => $str_status,
        );

        $_num_db = $this->obj_db->update(BG_DB_TABLE . 'plugin', $_arr_pluginUpdate, '`plugin_id` IN (' . $_str_pluginId . ')'); //删除数据

        //如影响行数大于0则返回成功
        if ($_num_db > 0) {
            $_str_rcode = 'y190103'; //成功
        } else {
            $_str_rcode = 'x190103'; //失败
        }

        return array(
            'rcode' => $_str_rcode,
        );
    }


    /** 读取
     * mdl_read function.
     *
     * @access public
     * @param mixed $str_plugin
     * @param string $str_readBy (default: 'plugin_id')
     * @return void
     */
    function mdl_read($str_plugin, $str_readBy = 'plugin_id', $num_notId = 0) {
        $_arr_pluginSelect = array(
            'plugin_id',
            //'plugin_name',
            'plugin_dir',
            'plugin_note',
            'plugin_status',
            'plugin_time',
        );

        if (is_numeric($str_plugin)) {
            $_str_sqlWhere = '`' . $str_readBy . '`=' . $str_plugin;
        } else {
            $_str_sqlWhere = '`' . $str_readBy . '`=\'' . $str_plugin . '\'';
        }

        if ($num_notId > 0) {
            $_str_sqlWhere = ' AND `plugin_id`<>' . $num_notId;
        }

        $_arr_pluginRows = $this->obj_db->select(BG_DB_TABLE . 'plugin', $_arr_pluginSelect, $_str_sqlWhere, '', '', '', 1, 0); //检查本地表是否存在记录

        if (isset($_arr_pluginRows[0])) { //用户名不存在则返回错误
            $_arr_pluginRow = $_arr_pluginRows[0];
        } else {
            return array(
                'rcode' => 'x190102', //不存在记录
            );
        }

        $_arr_pluginRow['rcode'] = 'y190102';

        return $_arr_pluginRow;
    }


    /** 列出
     * mdl_list function.
     *
     * @access public
     * @param mixed $num_pluginNo
     * @param int $num_pluginExcept (default: 0)
     * @param array $arr_search (default: array())
     * @return void
     */
    function mdl_list($num_pluginNo, $num_pluginExcept = 0, $arr_search = array()) {
        $_arr_pluginSelect = array(
            'plugin_id',
            'plugin_dir',
            //'plugin_name',
            'plugin_note',
            'plugin_status',
            'plugin_time',
        );

        $_str_sqlWhere = $this->sql_process($arr_search);

        $_arr_order = array(
            array('plugin_id', 'DESC'),
        );

        $_arr_pluginRows = $this->obj_db->select(BG_DB_TABLE . 'plugin', $_arr_pluginSelect, $_str_sqlWhere, '', $_arr_order, $num_pluginNo, $num_pluginExcept); //查询数据

        return $_arr_pluginRows;
    }


    /** 计数
     * mdl_count function.
     *
     * @access public
     * @param array $arr_search (default: array())
     * @return void
     */
    function mdl_count($arr_search = array()) {
        $_str_sqlWhere = $this->sql_process($arr_search);

        $_num_pluginCount = $this->obj_db->count(BG_DB_TABLE . 'plugin', $_str_sqlWhere); //查询数据

        return $_num_pluginCount;
    }


    /** 删除
     * mdl_del function.
     *
     * @access public
     * @return void
     */
    function mdl_del() {
        $_str_pluginId = implode(',', $this->pluginIds['plugin_ids']);

        $_num_db = $this->obj_db->delete(BG_DB_TABLE . 'plugin', '`plugin_id` IN (' . $_str_pluginId . ')'); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_db > 0) {
            $_str_rcode = 'y190104'; //成功
        } else {
            $_str_rcode = 'x190104'; //失败
        }

        return array(
            'rcode' => $_str_rcode,
        );
    }

    function mdl_opt($str_pluginDir) {
        $_str_outPut = json_encode($this->optInput['plugin_opts']);

        $_num_size   = $this->obj_file->file_put(BG_PATH_PLUGIN . $str_pluginDir . DS . 'opts.json', $_str_outPut);

        if ($_num_size > 0) {
            $_str_rcode = 'y190108'; //成功
        } else {
            $_str_rcode = 'x190103'; //失败
        }

        return array(
            'rcode' => $_str_rcode,
        );
    }


    function input_opt() {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $this->optInput['plugin_id'] = fn_getSafe(fn_post('plugin_id'), 'int', 0);

        if ($this->optInput['plugin_id'] < 1) {
            return array(
                'rcode' => 'x190210',
            );
        }

        $this->optInput['plugin_opts'] = fn_post('plugin_opts');

        $this->optInput['rcode'] = 'ok';

        return $this->optInput;
    }

    /** 提交输入
     * input_submit function.
     *
     * @access public
     * @return void
     */
    function input_submit() {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $this->pluginInput['plugin_id'] = fn_getSafe(fn_post('plugin_id'), 'int', 0);

        if ($this->pluginInput['plugin_id'] > 0) {
            //检查用户是否存在
            $_arr_pluginRow = $this->mdl_read($this->pluginInput['plugin_id']);
            if ($_arr_pluginRow['rcode'] != 'y190102') {
                return $_arr_pluginRow;
            }
        }

        /*$_arr_pluginName = fn_validate(fn_post('plugin_name'), 1, 300);
        switch ($_arr_pluginName['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x190203',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x190204',
                );
            break;

            case 'ok':
                $this->pluginInput['plugin_name'] = $_arr_pluginName['str'];
            break;

        }*/

        $_arr_pluginDir = fn_validate(fn_post('plugin_dir'), 1, 300, 'str', 'alphabetDigit');
        switch ($_arr_pluginDir['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x190207',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x190208',
                );
            break;

            case 'format_err':
                return array(
                    'rcode' => 'x190209',
                );
            break;

            case 'ok':
                $this->pluginInput['plugin_dir'] = $_arr_pluginDir['str'];
            break;
        }

        $_arr_pluginRow = $this->mdl_read($this->pluginInput['plugin_dir'], 'plugin_dir', $this->pluginInput['plugin_id']);

        if ($_arr_pluginRow['rcode'] == 'y190102') {
            return array(
                'rcode' => 'x190203',
            );
        }

        $_arr_pluginNote = fn_validate(fn_post('plugin_note'), 0, 300);
        switch ($_arr_pluginNote['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x190205',
                );
            break;

            case 'ok':
                $this->pluginInput['plugin_note'] = $_arr_pluginNote['str'];
            break;
        }

        $_arr_pluginStatus = fn_validate(fn_post('plugin_status'), 1, 0);
        switch ($_arr_pluginStatus['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x190206',
                );
            break;

            case 'ok':
                $this->pluginInput['plugin_status'] = $_arr_pluginStatus['str'];
            break;
        }

        $this->pluginInput['rcode'] = 'ok';

        return $this->pluginInput;
    }


    /** 批量操作选择
     * input_ids function.
     *
     * @access public
     * @return void
     */
    function input_ids() {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $_arr_pluginIds = fn_post('plugin_ids');

        if (fn_isEmpty($_arr_pluginIds)) {
            $_str_rcode = 'x030202';
        } else {
            foreach ($_arr_pluginIds as $_key=>$_value) {
                $_arr_pluginIds[$_key] = fn_getSafe($_value, 'int', 0);
            }
            $_str_rcode = 'ok';
        }

        $this->pluginIds = array(
            'rcode'     => $_str_rcode,
            'plugin_ids'   => array_filter(array_unique($_arr_pluginIds)),
        );

        return $this->pluginIds;
    }


    /** 列出及统计 SQL 处理
     * sql_process function.
     *
     * @access private
     * @param array $arr_search (default: array())
     * @return void
     */
    private function sql_process($arr_search = array()) {
        $_str_sqlWhere = '1';

        if (isset($arr_search['key']) && !fn_isEmpty($arr_search['key'])) {
            $_str_sqlWhere .= ' AND (`plugin_note` LIKE \'%' . $arr_search['key'] . '%\')';
        }

        if (isset($arr_search['status']) && !fn_isEmpty($arr_search['status'])) {
            $_str_sqlWhere .= ' AND `plugin_status`=\'' . $arr_search['status'] . '\'';
        }

        return $_str_sqlWhere;
    }
}
