<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------上传类-------------*/
class MODEL_ATTACH {

    public $arr_box     = array('normal', 'recycle');
    public $mimeRows = array(
        'gif' => array(
            'image/gif'
        ),
        'jpg' => array(
            'image/jpeg',
            'image/pjpeg'
        ),
        'jpeg' => array(
            'image/jpeg',
            'image/pjpeg'
        ),
        'jpe' => array(
            'image/jpeg',
            'image/pjpeg'
        ),
        'png' => array(
            'image/png',
            'image/x-png'
        ),
    );

    function __construct() { //构造函数
        $this->obj_db     = $GLOBALS['obj_db']; //设置数据库对象
        $this->is_magic   = get_magic_quotes_gpc();
    }


    function mdl_create_table() {
        $_str_boxs = implode('\',\'', $this->arr_box);

        $_arr_attachCreat = array(
            'attach_id'          => 'int NOT NULL AUTO_INCREMENT COMMENT \'ID\'',
            'attach_ext'         => 'varchar(5) NOT NULL COMMENT \'扩展名\'',
            'attach_mime'        => 'varchar(100) NOT NULL COMMENT \'MIME\'',
            'attach_time'        => 'int NOT NULL COMMENT \'时间\'',
            'attach_size'        => 'mediumint NOT NULL COMMENT \'大小\'',
            'attach_name'        => 'varchar(1000) NOT NULL COMMENT \'原始文件名\'',
            'attach_admin_id'    => 'smallint NOT NULL COMMENT \'上传用户 ID\'',
            'attach_box'         => 'enum(\''. $_str_boxs . '\') NOT NULL COMMENT \'盒子\'',
        );

        $_num_db = $this->obj_db->create_table(BG_DB_TABLE . 'attach', $_arr_attachCreat, 'attach_id', '附件');

        if ($_num_db > 0) {
            $_str_rcode = 'y070105'; //更新成功
        } else {
            $_str_rcode = 'x070105'; //更新成功
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
        );
    }

    function mdl_rename_table() {
        $_arr_tableRows = $this->obj_db->show_tables();

        foreach ($_arr_tableRows as $_key=>$_value) {
            $_arr_tables[] = $_value['Tables_in_' . BG_DB_NAME];
        }

        $_str_rcode = 'y070113';

        if (in_array(BG_DB_TABLE . 'media', $_arr_tables) && !in_array(BG_DB_TABLE . 'attach', $_arr_tables)) {
            $_reselt = $this->obj_db->alter_table(BG_DB_TABLE . 'media', false, BG_DB_TABLE . 'attach');

            if (!fn_isEmpty($_reselt)) {
                $_str_rcode = 'y070112';
            }
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
        );
    }


    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . 'attach');

        $_arr_col = array();

        if (!fn_isEmpty($_arr_colRows)) {
            foreach ($_arr_colRows as $_key=>$_value) {
                $_arr_col[] = $_value['Field'];
            }
        }

        return $_arr_col;
    }


    function mdl_alter_table() {
        $_str_boxs = implode('\',\'', $this->arr_box);

        $_arr_col     = $this->mdl_column();
        $_arr_alter   = array();

        if (in_array('media_id', $_arr_col)) {
            $_arr_alter['media_id'] = array('CHANGE', 'int NOT NULL AUTO_INCREMENT COMMENT \'ID\'', 'attach_id');
        }

        if (in_array('media_ext', $_arr_col)) {
            $_arr_alter['media_ext'] = array('CHANGE', 'char(5) NOT NULL COMMENT \'扩展名\'', 'attach_ext');
        }

        if (in_array('media_mime', $_arr_col)) {
            $_arr_alter['media_mime'] = array('CHANGE', 'varchar(30) NOT NULL COMMENT \'MIME\'', 'attach_mime');
        }

        if (in_array('media_time', $_arr_col)) {
            $_arr_alter['media_time'] = array('CHANGE', 'int NOT NULL COMMENT \'时间\'', 'attach_time');
        }

        if (in_array('media_size', $_arr_col)) {
            $_arr_alter['media_size'] = array('CHANGE', 'mediumint NOT NULL COMMENT \'大小\'', 'attach_size');
        }

        if (in_array('media_name', $_arr_col)) {
            $_arr_alter['media_name'] = array('CHANGE', 'varchar(1000) NOT NULL COMMENT \'原始文件名\'', 'attach_name');
        }

        if (in_array('media_admin_id', $_arr_col)) {
            $_arr_alter['media_admin_id'] = array('CHANGE', 'int NOT NULL COMMENT \'上传用户ID\'', 'attach_admin_id');
        }

        if (in_array('media_box', $_arr_col)) {
            $_arr_alter['media_box'] = array('CHANGE', 'enum(\'' . $_str_boxs . '\') NOT NULL COMMENT \'盒子\'', 'attach_box');
        }

        $_str_rcode = 'y070111';

        if (!fn_isEmpty($_arr_alter)) {
            $_reselt = $this->obj_db->alter_table(BG_DB_TABLE . 'attach', $_arr_alter);

            if (!fn_isEmpty($_reselt)) {
                $_str_rcode = 'y070106';
            }
        }

        return array(
            'rcode' => $_str_rcode,
        );
    }


    /**
     * mdl_submit function.
     *
     * @access public
     * @param mixed $str_attachName
     * @param mixed $str_attachExt
     * @param int $num_attachSize (default: 0)
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function mdl_submit($num_attachId, $str_attachName, $str_attachExt, $str_attachMime, $num_attachSize = 0, $num_adminId = 0) {

        $_arr_attachData = array(
            'attach_name'    => $str_attachName,
            'attach_ext'     => $str_attachExt,
            'attach_mime'    => $str_attachMime,
        );

        $_tm_time = time();

        if ($num_attachId < 1) {
            $_arr_attachData['attach_time']      = $_tm_time;
            $_arr_attachData['attach_admin_id']  = $num_adminId;
            $_arr_attachData['attach_size']      = $num_attachSize;
            $_arr_attachData['attach_box']       = 'normal';
            $_num_attachId = $this->obj_db->insert(BG_DB_TABLE . 'attach', $_arr_attachData);

            if ($_num_attachId > 0) { //数据库插入是否成功
                $_str_rcode = 'y070101';
            } else {
                return array(
                    'rcode' => 'x070101',
                );
            }
        } else {
            $_num_attachId   = $num_attachId;
            $_num_db      = $this->obj_db->update(BG_DB_TABLE . 'attach', $_arr_attachData, '`attach_id`=' . $num_attachId);

            if ($_num_db > 0) { //数据库插入是否成功
                $_str_rcode = 'y070103';
            } else {
                return array(
                    'rcode' => 'x070103',
                );
            }
        }

        return array(
            'attach_id'   => $_num_attachId,
            'attach_time' => $_tm_time,
            'rcode'      => $_str_rcode,
        );
    }

    /**
     * mdl_read function.
     *
     * @access public
     * @param mixed $num_attachId
     * @return void
     */
    function mdl_read($num_attachId) {
        $_arr_attachSelect = array(
            'attach_id',
            'attach_name',
            'attach_time',
            'attach_ext',
            'attach_mime',
            'attach_size',
            'attach_box',
        );

        $_arr_attachRows  = $this->obj_db->select(BG_DB_TABLE . 'attach', $_arr_attachSelect, '`attach_id`=' . $num_attachId, '', '', 1, 0); //检查本地表是否存在记录

        if (isset($_arr_attachRows[0])) {
            $_arr_attachRow   = $_arr_attachRows[0];
        } else {
            return array(
                'rcode' => 'x070102', //不存在记录
            );
        }

        $_arr_attachRow['attach_url'] = BG_SITE_URL . BG_URL_ATTACH . date('Y', $_arr_attachRow['attach_time']) . '/' . date('m', $_arr_attachRow['attach_time']) . '/' . $_arr_attachRow['attach_id'] . '.' . $_arr_attachRow['attach_ext'];

        $_arr_attachRow['attach_path'] = BG_PATH_ATTACH . date('Y', $_arr_attachRow['attach_time']) . DS . date('m', $_arr_attachRow['attach_time']) . DS . $_arr_attachRow['attach_id'] . '.' . $_arr_attachRow['attach_ext'];

        $_arr_attachRow['rcode'] = 'y070102';

        return $_arr_attachRow;
    }


    /**
     * mdl_list function.
     *
     * @access public
     * @param mixed $num_no
     * @param int $num_except (default: 0)
     * @param string $str_year (default: '')
     * @param string $str_month (default: '')
     * @param string $str_ext (default: '')
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function mdl_list($num_no, $num_except = 0, $arr_search = array()) {
        $_arr_attachSelect = array(
            'attach_id',
            'attach_name',
            'attach_time',
            'attach_ext',
            'attach_mime',
            'attach_size',
            'attach_admin_id',
            'attach_box',
        );

        $_str_sqlWhere = $this->sql_process($arr_search);

        $_arr_order = array(
            array('attach_id', 'DESC'),
        );

        $_arr_attachRows = $this->obj_db->select(BG_DB_TABLE . 'attach', $_arr_attachSelect, $_str_sqlWhere, '', $_arr_order, $num_no, $num_except);

        foreach ($_arr_attachRows as $_key=>$_value) {
            $_arr_attachRows[$_key]['attach_url'] = BG_SITE_URL . BG_URL_ATTACH . date('Y', $_value['attach_time']) . '/' . date('m', $_value['attach_time']) . '/' . $_value['attach_id'] . '.' . $_value['attach_ext'];

            $_arr_attachRows[$_key]['attach_path'] = BG_PATH_ATTACH . date('Y', $_value['attach_time']) . DS . date('m', $_value['attach_time']) . DS . $_value['attach_id'] . '.' . $_value['attach_ext'];
        }

        return $_arr_attachRows;
    }


    /**
     * mdl_count function.
     *
     * @access public
     * @param string $str_year (default: '')
     * @param string $str_month (default: '')
     * @param string $str_ext (default: '')
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function mdl_count($arr_search = array()) {
        $_str_sqlWhere = $this->sql_process($arr_search);

        $_num_db = $this->obj_db->count(BG_DB_TABLE . 'attach', $_str_sqlWhere);

        return $_num_db;
    }


    /**
     * mdl_del function.
     *
     * @access public
     * @param mixed $this->attachIds['attach_ids']
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function mdl_del($num_adminId = 0, $arr_attachIds = false) {
        if ($arr_attachIds) {
            $this->attachIds['attach_ids'] = $arr_attachIds;
        }

        $_str_attachIds = implode(',', $this->attachIds['attach_ids']);

        $_str_sqlWhere = '`attach_id` IN (' . $_str_attachIds . ')';

        if ($num_adminId > 0) {
            $_str_sqlWhere .= ' AND `attach_admin_id`=' . $num_adminId;
        }

        $_num_db = $this->obj_db->delete(BG_DB_TABLE . 'attach', $_str_sqlWhere); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_db > 0) {
            $_str_rcode = 'y070104';
        } else {
            $_str_rcode = 'x070104';
        }

        return array(
            'rcode' => $_str_rcode
        ); //成功
    }


    /**
     * mdl_ext function.
     *
     * @access public
     * @param mixed $num_no
     * @return void
     */
    function mdl_ext() {
        $_arr_attachSelect = array(
            'DISTINCT `attach_ext`',
        );

        $_str_sqlWhere    = 'LENGTH(`attach_ext`) > 0';
        $_arr_attachRows  = $this->obj_db->select(BG_DB_TABLE . 'attach', $_arr_attachSelect, $_str_sqlWhere, '', '', 100, 0, true);

        return $_arr_attachRows;
    }


    /**
     * mdl_year function.
     *
     * @access public
     * @param mixed $num_no
     * @return void
     */
    function mdl_year() {
        $_arr_attachSelect = array(
            'DISTINCT FROM_UNIXTIME(`attach_time`, \'%Y\') AS attach_year',
        );

        $_str_sqlWhere = '`attach_time` > 0';

        $_arr_order = array(
            array('attach_time', 'ASC'),
        );

        $_arr_yearRows = $this->obj_db->select(BG_DB_TABLE . 'attach', $_arr_attachSelect, $_str_sqlWhere, '', $_arr_order, 100, 0, true);

        return $_arr_yearRows;
    }


    function mdl_chkAttach($num_attachId, $str_attachExt, $tm_attachTime) {
        $_str_attachUrl = date('Y', $tm_attachTime) . '/' . date('m', $tm_attachTime) . '/' . $num_attachId . '.' . $str_attachExt;

        if ($this->is_magic) {
            $_str_chk   = $_str_attachUrl;
        } else {
            $_str_chk   = addslashes($_str_attachUrl);
        }

        $_arr_advertSelect = array(
            'advert_id',
        );

        $_str_sqlWhere    = '`advert_attach_id`=' . $num_attachId;
        //print_r($_str_sqlWhere . '<br>');
        $_arr_order = array(
            array('advert_id', 'ASC'),
        );

        $_arr_advertRows = $this->obj_db->select(BG_DB_TABLE . 'advert', $_arr_advertSelect, $_str_sqlWhere, '', $_arr_order, 1, 0);

        //print_r($_arr_advertRows);
        if (isset($_arr_advertRows[0])) {
            return array(
                'attach_id'  => $num_attachId,
                'rcode'     => 'y070406',
            );
        }

        return array(
            'attach_id'  => $num_attachId,
            'rcode'      => 'x070406',
        );
    }


    function mdl_box($str_box, $arr_attachIds = false) {
        if ($arr_attachIds) {
            $this->attachIds['attach_ids'] = $arr_attachIds;
        }

        $_str_attachIds = implode(',', $this->attachIds['attach_ids']);

        $_arr_attachData = array(
            'attach_box' => $str_box,
        );

        $_num_db  = $this->obj_db->update(BG_DB_TABLE . 'attach', $_arr_attachData, '`attach_id` IN (' . $_str_attachIds . ')');

        if ($_num_db > 0) {
            $_str_rcode = 'y070103';
        } else {
            $_str_rcode = 'x070103';
        }

        return array(
            'rcode' => $_str_rcode,
        ); //成功
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

        $_arr_attachIds = fn_post('attach_ids');

        if (fn_isEmpty($_arr_attachIds)) {
            $_str_rcode = 'x030202';
        } else {
            foreach ($_arr_attachIds as $_key=>$_value) {
                $_arr_attachIds[$_key] = fn_getSafe($_value, 'int', 0);
            }
            $_str_rcode = 'ok';
        }

        $this->attachIds = array(
            'rcode'      => $_str_rcode,
            'attach_ids'  => array_filter(array_unique($_arr_attachIds)),
        );

        return $this->attachIds;
    }

    private function sql_process($arr_search = array()) {
        $_str_sqlWhere = '1';

        if (isset($arr_search['key']) && !fn_isEmpty($arr_search['key'])) {
            $_str_sqlWhere .= ' AND `attach_name` LIKE \'%' . $arr_search['key'] . '%\'';
        }

        if (isset($arr_search['year']) && !fn_isEmpty($arr_search['year'])) {
            $_str_sqlWhere .= ' AND FROM_UNIXTIME(`attach_time`, \'%Y\')=\'' . $arr_search['year'] . '\'';
        }

        if (isset($arr_search['month']) && !fn_isEmpty($arr_search['month'])) {
            $_str_sqlWhere .= ' AND FROM_UNIXTIME(`attach_time`, \'%m\')=\'' . $arr_search['month'] . '\'';
        }

        if (isset($arr_search['ext']) && !fn_isEmpty($arr_search['ext'])) {
            $_str_sqlWhere .= ' AND `attach_ext`=\'' . $arr_search['ext'] . '\'';
        }

        if (isset($arr_search['admin_id']) && $arr_search['admin_id'] > 0) {
            $_str_sqlWhere .= ' AND `attach_admin_id`=' . $arr_search['admin_id'];
        }

        if (isset($arr_search['box']) && !fn_isEmpty($arr_search['box'])) {
            $_str_sqlWhere .= ' AND `attach_box`=\'' . $arr_search['box'] . '\'';
        }

        if (isset($arr_search['attach_ids']) && $arr_search['attach_ids']) {
            $_str_attachIds  = implode(',', $arr_search['attach_ids']);
            $_str_sqlWhere  .= ' AND `attach_id` IN (' . $_str_attachIds . ')';
        }

        if (isset($arr_search['min_id']) && $arr_search['min_id'] > 0) {
            $_str_sqlWhere .= ' AND `attach_id`>' . $arr_search['min_id'];
        }

        if (isset($arr_search['max_id']) && $arr_search['max_id'] > 0) {
            $_str_sqlWhere .= ' AND `attach_id`<' . $arr_search['max_id'];
        }

        return $_str_sqlWhere;
    }
}
