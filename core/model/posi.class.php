<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------广告位类-------------*/
class MODEL_POSI {

    public $arr_status      = array('enable', 'disable');
    public $arr_type        = array('media', 'text');
    public $arr_isPercent   = array('enable', 'disable');

    function __construct() { //构造函数
        $this->obj_db   = $GLOBALS['obj_db']; //设置数据库对象
        $this->obj_dir  = new CLASS_DIR();
    }


    function mdl_create_table() {
        $_str_status    = implode('\',\'', $this->arr_status);
        $_str_type      = implode('\',\'', $this->arr_type);
        $_str_isPercent = implode('\',\'', $this->arr_isPercent);

        $_arr_posiCreat = array(
            'posi_id'            => 'int NOT NULL AUTO_INCREMENT COMMENT \'ID\'',
            'posi_name'          => 'varchar(300) NOT NULL COMMENT \'名称\'',
            'posi_count'         => 'tinyint NOT NULL COMMENT \'广告数\'',
            'posi_type'          => 'enum(\'' . $_str_type . '\') NOT NULL COMMENT \'广告位类型\'',
            'posi_status'        => 'enum(\'' . $_str_status . '\') NOT NULL COMMENT \'状态\'',
            'posi_script'        => 'varchar(100) NOT NULL COMMENT \'脚本\'',
            'posi_plugin'        => 'varchar(100) NOT NULL COMMENT \'插件名\'',
            'posi_selector'      => 'varchar(100) NOT NULL COMMENT \'默认选择器\'',
            'posi_opts'          => 'text NOT NULL COMMENT \'选项\'',
            'posi_is_percent'    => 'enum(\'' . $_str_isPercent . '\') NOT NULL COMMENT \'允许几率展现\'',
            'posi_note'          => 'varchar(300) NOT NULL COMMENT \'备注\'',
        );

        $_num_db = $this->obj_db->create_table(BG_DB_TABLE . 'posi', $_arr_posiCreat, 'posi_id', '广告位');

        if ($_num_db > 0) {
            $_str_rcode = 'y040105'; //更新成功
        } else {
            $_str_rcode = 'x040105'; //更新成功
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
        );
    }


    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . 'posi');

        $_arr_col = array();

        if (!fn_isEmpty($_arr_colRows)) {
            foreach ($_arr_colRows as $_key=>$_value) {
                $_arr_col[] = $_value['Field'];
            }
        }

        return $_arr_col;
    }


    function mdl_cache($num_posiId = 0, $is_reGen = false) {
        $_str_cacheReturn = '{"rcode":"x040102"}';

        if ($is_reGen || !file_exists(BG_PATH_CACHE . 'sys' . DS . 'posi_list.json')) {
            $_arr_search    = array(
                'status'    => 'enable'
            );
            $_arr_posiRows  = $this->mdl_list(1000, 0, $_arr_search);

            foreach ($_arr_posiRows as $_key=>$_value) {
                $_value['rcode'] = 'y040102';
                $_str_outId = fn_jsonEncode($_value, 'no');

                $this->obj_dir->put_file(BG_PATH_CACHE . 'sys' . DS . 'posi_' . $_value['posi_id'] . '.json', $_str_outId);
            }

            $_str_outList = fn_jsonEncode($_arr_posiRows, 'no');

            $_num_size    = $this->obj_dir->put_file(BG_PATH_CACHE . 'sys' . DS . 'posi_list.json', $_str_outList);
        }

        if ($num_posiId > 0) {
            if (file_exists(BG_PATH_CACHE . 'sys' . DS . 'posi_' . $num_posiId . '.json')) {
                $_str_cacheReturn = file_get_contents(BG_PATH_CACHE . 'sys' . DS . 'posi_' . $num_posiId . '.json');
            } else {
                $_arr_posiRow  = $this->mdl_read($num_posiId);
                if ($_arr_posiRow['rocde'] == 'y040102') {
                    $_str_outId = fn_jsonEncode($_arr_posiRow, 'no');

                    $this->obj_dir->put_file(BG_PATH_CACHE . 'sys' . DS . 'posi_' . $_arr_posiRow['posi_id'] . '.json', $_str_outId);
                }
            }
        } else {
            $_str_cacheReturn = file_get_contents(BG_PATH_CACHE . 'sys' . DS . 'posi_list.json');
        }

        $_arr_cacheReturn = fn_jsonDecode($_str_cacheReturn, 'no');

        return $_arr_cacheReturn;
    }


    function mdl_cache_del($arr_posiDels = false) {
        if (is_array($arr_posiDels)) {
            foreach ($arr_posiDels as $_key=>$_value) {
                $this->obj_dir->del_file(BG_PATH_CACHE . 'sys' . DS . 'posi_' . $_value . '.json');
            }
        }
    }


    /**
     * mdl_submit function.
     *
     * @access public
     * @param mixed $num_posiId
     * @param mixed $str_posiName
     * @param mixed $str_posiType
     * @param string $str_posiNote (default: '')
     * @param string $str_posiAllow (default: '')
     * @return void
     */
    function mdl_submit() {

        $_arr_posiData = array(
            'posi_name'         => $this->posiSubmit['posi_name'],
            'posi_count'        => $this->posiSubmit['posi_count'],
            'posi_script'       => $this->posiSubmit['posi_script'],
            'posi_type'         => $this->posiSubmit['posi_type'],
            'posi_status'       => $this->posiSubmit['posi_status'],
            'posi_script'       => $this->posiSubmit['posi_script'],
            'posi_plugin'       => $this->posiSubmit['posi_plugin'],
            'posi_selector'     => $this->posiSubmit['posi_selector'],
            'posi_opts'         => $this->posiSubmit['posi_opts'],
            'posi_is_percent'   => $this->posiSubmit['posi_is_percent'],
            'posi_note'         => $this->posiSubmit['posi_note'],
        );

        if ($this->posiSubmit['posi_id'] < 1) { //插入
            $_num_posiId = $this->obj_db->insert(BG_DB_TABLE . 'posi', $_arr_posiData);

            if ($_num_posiId > 0) { //数据库插入是否成功
                $_str_rcode = 'y040101';
            } else {
                return array(
                    'rcode' => 'x040101',
                );
            }
        } else {
            $_num_posiId = $this->posiSubmit['posi_id'];
            $_num_db  = $this->obj_db->update(BG_DB_TABLE . 'posi', $_arr_posiData, '`posi_id`=' . $_num_posiId);

            if ($_num_db > 0) { //数据库更新是否成功
                $_str_rcode = 'y040103';
            } else {
                return array(
                    'rcode' => 'x040103',
                );
            }
        }

        return array(
            'posi_id'    => $_num_posiId,
            'rcode'      => $_str_rcode,
        );

    }


    /**
     * mdl_read function.
     *
     * @access public
     * @param mixed $str_posi
     * @param string $str_readBy (default: 'posi_id')
     * @param int $num_notId (default: 0)
     * @return void
     */
    function mdl_read($str_posi, $str_readBy = 'posi_id', $num_notId = 0) {

        $_arr_posiSelect = array(
            'posi_id',
            'posi_name',
            'posi_count',
            'posi_type',
            'posi_status',
            'posi_script',
            'posi_plugin',
            'posi_selector',
            'posi_opts',
            'posi_is_percent',
            'posi_note',
        );

        if (is_numeric($str_posi)) {
            $_str_sqlWhere = '`' . $str_readBy . '`=' . $str_posi;
        } else {
            $_str_sqlWhere = '`' . $str_readBy . '`=\'' . $str_posi . '\'';
        }

        if ($num_notId > 0) {
            $_str_sqlWhere .= ' AND posi_id<>' . $num_notId;
        }

        $_arr_posiRows = $this->obj_db->select(BG_DB_TABLE . 'posi',  $_arr_posiSelect, $_str_sqlWhere, '', '', 1, 0); //检查本地表是否存在记录

        if (isset($_arr_posiRows[0])) {
            $_arr_posiRow = $_arr_posiRows[0];
        } else {
            return array(
                'rcode' => 'x040102', //不存在记录
            );
        }

        $_arr_posiRow['posi_opts']    = fn_jsonDecode($_arr_posiRow['posi_opts'], 'decode');
        $_arr_posiRow['rcode']        = 'y040102';

        return $_arr_posiRow;
    }


    function mdl_status($str_status) {

        $_str_posiId = implode(',', $this->posiIds['posi_ids']);

        $_arr_posiUpdate = array(
            'posi_status' => $str_status,
        );

        $_num_db = $this->obj_db->update(BG_DB_TABLE . 'posi', $_arr_posiUpdate, '`posi_id` IN (' . $_str_posiId . ')'); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_db > 0) {
            $_str_rcode = 'y040103';
        } else {
            $_str_rcode = 'x040103';
        }

        return array(
            'rcode' => $_str_rcode,
        ); //成功

    }

    /**
     * mdl_list function.
     *
     * @access public
     * @param mixed $num_no
     * @param int $num_except (default: 0)
     * @param string $str_key (default: '')
     * @param string $str_type (default: '')
     * @return void
     */
    function mdl_list($num_no, $num_except = 0, $arr_search = array()) {

        $_arr_posiSelect = array(
            'posi_id',
            'posi_name',
            'posi_count',
            'posi_type',
            'posi_status',
            'posi_script',
            'posi_plugin',
            'posi_selector',
            'posi_is_percent',
            'posi_note',
        );

        $_str_sqlWhere = $this->sql_process($arr_search);

        $_arr_order = array(
            array('posi_id', 'DESC'),
        );

        $_arr_posiRows = $this->obj_db->select(BG_DB_TABLE . 'posi',  $_arr_posiSelect, $_str_sqlWhere, '', $_arr_order, $num_no, $num_except); //列出本地表是否存在记录

        return $_arr_posiRows;

    }


    /**
     * mdl_count function.
     *
     * @access public
     * @param string $str_key (default: '')
     * @param string $str_status (default: '')
     * @return void
     */
    function mdl_count($arr_search = array()) {
        $_str_sqlWhere = $this->sql_process($arr_search);

        $_num_count = $this->obj_db->count(BG_DB_TABLE . 'posi', $_str_sqlWhere); //查询数据

        return $_num_count;
    }


    /**
     * mdl_del function.
     *
     * @access public
     * @param mixed $this->posiIds['posi_ids']
     * @return void
     */
    function mdl_del() {

        $_str_posiId = implode(',', $this->posiIds['posi_ids']);

        $_num_db = $this->obj_db->delete(BG_DB_TABLE . 'posi',  'posi_id` IN (' . $_str_posiId . ')'); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_db > 0) {
            $_str_rcode = 'y040104';
        } else {
            $_str_rcode = 'x040104';
        }

        return array(
            'rcode' => $_str_rcode,
        );
        exit;

    }


    function input_submit() {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $this->posiSubmit['posi_id'] = fn_getSafe(fn_post('posi_id'), 'int', 0);

        if ($this->posiSubmit['posi_id'] > 0) {
            $_arr_posiRow = $this->mdl_read($this->posiSubmit['posi_id']);
            if ($_arr_posiRow['rcode'] != 'y040102') {
                $this->obj_tpl->tplDisplay('result', $_arr_posiRow['rcode']);
            }
        }

        $_arr_posiName = fn_validate(fn_post('posi_name'), 1, 300);
        switch ($_arr_posiName['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x040201',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x040202',
                );
            break;

            case 'ok':
                $this->posiSubmit['posi_name'] = $_arr_posiName['str'];
            break;

        }

        $_arr_posiRow = $this->mdl_read($this->posiSubmit['posi_name'], 'posi_name', $this->posiSubmit['posi_id']);

        if ($_arr_posiRow['rcode'] == 'y040102') {
            return array(
                'rcode' => 'x040203',
            );
        }

        $_arr_posiCount = fn_validate(fn_post('posi_count'), 1, 0, 'str', 'int');
        switch ($_arr_posiCount['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x040205',
                );
            break;

            case 'format_err':
                return array(
                    'rcode' => 'x040208',
                );
            break;

            case 'ok':
                $this->posiSubmit['posi_count'] = $_arr_posiCount['str'];
            break;
        }

        $_arr_posiNote = fn_validate(fn_post('posi_note'), 0, 300);
        switch ($_arr_posiNote['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x040204',
                );
            break;

            case 'ok':
                $this->posiSubmit['posi_note'] = $_arr_posiNote['str'];
            break;
        }

        $_arr_posiType = fn_validate(fn_post('posi_type'), 1, 0);
        switch ($_arr_posiType['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x040209',
                );
            break;

            case 'ok':
                $this->posiSubmit['posi_type'] = $_arr_posiType['str'];
            break;
        }

        $_arr_posiStatus = fn_validate(fn_post('posi_status'), 1, 0);
        switch ($_arr_posiStatus['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x040207',
                );
            break;

            case 'ok':
                $this->posiSubmit['posi_status'] = $_arr_posiStatus['str'];
            break;
        }

        $_arr_posiScript = fn_validate(fn_post('posi_script'), 1, 100);
        switch ($_arr_posiScript['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x040215',
                );
            break;

            case 'ok':
                $this->posiSubmit['posi_script'] = $_arr_posiScript['str'];
            break;
        }

        $_arr_posiPlugin = fn_validate(fn_post('posi_plugin'), 1, 100);
        switch ($_arr_posiPlugin['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x040216',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x040217',
                );
            break;

            case 'ok':
                $this->posiSubmit['posi_plugin'] = $_arr_posiPlugin['str'];
            break;
        }

        $_arr_posiSelector = fn_validate(fn_post('posi_selector'), 1, 100);
        switch ($_arr_posiSelector['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x040218',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x040219',
                );
            break;

            case 'ok':
                $this->posiSubmit['posi_selector'] = $_arr_posiSelector['str'];
            break;
        }

        $_arr_posiIsPercent = fn_validate(fn_post('posi_is_percent'), 1, 0);
        switch ($_arr_posiIsPercent['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x040221',
                );
            break;

            case 'ok':
                $this->posiSubmit['posi_is_percent'] = $_arr_posiIsPercent['str'];
            break;
        }

        $this->posiSubmit['posi_opts']    = fn_jsonEncode(fn_post('posi_opts'), 'encode');
        $this->posiSubmit['rcode']        = 'ok';

        return $this->posiSubmit;
    }


    /**
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

        $_arr_posiIds = fn_post('posi_ids');

        if (fn_isEmpty($_arr_posiIds)) {
            $_str_rcode = 'x030202';
        } else {
            foreach ($_arr_posiIds as $_key=>$_value) {
                $_arr_posiIds[$_key] = fn_getSafe($_value, 'int', 0);
            }
            $_str_rcode = 'ok';
        }

        $this->posiIds = array(
            'rcode'     => $_str_rcode,
            'posi_ids'  => array_filter(array_unique($_arr_posiIds)),
        );

        return $this->posiIds;
    }


    private function sql_process($arr_search = array()) {
        $_str_sqlWhere = '1';

        if (isset($arr_search['key']) && !fn_isEmpty($arr_search['key'])) {
            $_str_sqlWhere .= ' AND (`posi_name` LIKE \'%' . $arr_search['key'] . '%\' OR `posi_note` LIKE \'%' . $arr_search['key'] . '%\')';
        }

        if (isset($arr_search['key']) && !fn_isEmpty($arr_search['status'])) {
            $_str_sqlWhere .= ' AND `posi_status`=\'' . $arr_search['status'] . '\'';
        }

        return $_str_sqlWhere;
    }
}
