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
class MODEL_MEDIA {

    public $arr_box     = array('normal', 'recycle');
    public $mime = array(
        'image/jpeg'     => 'jpg',
        'image/pjpeg'    => 'jpg',
        'image/gif'      => 'gif',
        'image/x-png'    => 'png',
        'image/png'      => 'png',
    );

    function __construct() { //构造函数
        $this->obj_db     = $GLOBALS['obj_db']; //设置数据库对象
        $this->is_magic   = get_magic_quotes_gpc();
    }


    function mdl_create_table() {
        $_str_boxs = implode('\',\'', $this->arr_box);

        $_arr_mediaCreat = array(
            'media_id'          => 'int NOT NULL AUTO_INCREMENT COMMENT \'ID\'',
            'media_ext'         => 'varchar(5) NOT NULL COMMENT \'扩展名\'',
            'media_mime'        => 'varchar(100) NOT NULL COMMENT \'MIME\'',
            'media_time'        => 'int NOT NULL COMMENT \'时间\'',
            'media_size'        => 'mediumint NOT NULL COMMENT \'大小\'',
            'media_name'        => 'varchar(1000) NOT NULL COMMENT \'原始文件名\'',
            'media_admin_id'    => 'smallint NOT NULL COMMENT \'上传用户 ID\'',
            'media_box'         => 'enum(\''. $_str_boxs . '\') NOT NULL COMMENT \'盒子\'',
        );

        $_num_db = $this->obj_db->create_table(BG_DB_TABLE . 'media', $_arr_mediaCreat, 'media_id', '附件');

        if ($_num_db > 0) {
            $_str_rcode = 'y070105'; //更新成功
        } else {
            $_str_rcode = 'x070105'; //更新成功
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
        );
    }


    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . 'media');

        $_arr_col = array();

        if (!fn_isEmpty($_arr_colRows)) {
            foreach ($_arr_colRows as $_key=>$_value) {
                $_arr_col[] = $_value['Field'];
            }
        }

        return $_arr_col;
    }


    /**
     * mdl_submit function.
     *
     * @access public
     * @param mixed $str_mediaName
     * @param mixed $str_mediaExt
     * @param int $num_mediaSize (default: 0)
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function mdl_submit($num_mediaId, $str_mediaName, $str_mediaExt, $str_mediaMime, $num_mediaSize = 0, $num_adminId = 0) {

        $_arr_mediaData = array(
            'media_name'    => $str_mediaName,
            'media_ext'     => $str_mediaExt,
            'media_mime'    => $str_mediaMime,
        );

        $_tm_time = time();

        if ($num_mediaId < 1) {
            $_arr_mediaData['media_time']      = $_tm_time;
            $_arr_mediaData['media_admin_id']  = $num_adminId;
            $_arr_mediaData['media_size']      = $num_mediaSize;
            $_arr_mediaData['media_box']       = 'normal';
            $_num_mediaId = $this->obj_db->insert(BG_DB_TABLE . 'media', $_arr_mediaData);

            if ($_num_mediaId > 0) { //数据库插入是否成功
                $_str_rcode = 'y070101';
            } else {
                return array(
                    'rcode' => 'x070101',
                );
            }
        } else {
            $_num_mediaId   = $num_mediaId;
            $_num_db      = $this->obj_db->update(BG_DB_TABLE . 'media', $_arr_mediaData, '`media_id`=' . $num_mediaId);

            if ($_num_db > 0) { //数据库插入是否成功
                $_str_rcode = 'y070103';
            } else {
                return array(
                    'rcode' => 'x070103',
                );
            }
        }

        return array(
            'media_id'   => $_num_mediaId,
            'media_time' => $_tm_time,
            'rcode'      => $_str_rcode,
        );
    }

    /**
     * mdl_read function.
     *
     * @access public
     * @param mixed $num_mediaId
     * @return void
     */
    function mdl_read($num_mediaId) {
        $_arr_mediaSelect = array(
            'media_id',
            'media_name',
            'media_time',
            'media_ext',
            'media_mime',
            'media_size',
            'media_box',
        );

        $_arr_mediaRows  = $this->obj_db->select(BG_DB_TABLE . 'media', $_arr_mediaSelect, '`media_id`=' . $num_mediaId, '', '', 1, 0); //检查本地表是否存在记录

        if (isset($_arr_mediaRows[0])) {
            $_arr_mediaRow   = $_arr_mediaRows[0];
        } else {
            return array(
                'rcode' => 'x070102', //不存在记录
            );
        }

        $_arr_mediaRow['media_url'] = BG_SITE_URL . BG_URL_MEDIA . date('Y', $_arr_mediaRow['media_time']) . '/' . date('m', $_arr_mediaRow['media_time']) . '/' . $_arr_mediaRow['media_id'] . '.' . $_arr_mediaRow['media_ext'];

        $_arr_mediaRow['media_path'] = BG_PATH_MEDIA . date('Y', $_arr_mediaRow['media_time']) . DS . date('m', $_arr_mediaRow['media_time']) . DS . $_arr_mediaRow['media_id'] . '.' . $_arr_mediaRow['media_ext'];

        $_arr_mediaRow['rcode'] = 'y070102';

        return $_arr_mediaRow;
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
        $_arr_mediaSelect = array(
            'media_id',
            'media_name',
            'media_time',
            'media_ext',
            'media_mime',
            'media_size',
            'media_admin_id',
            'media_box',
        );

        $_str_sqlWhere = $this->sql_process($arr_search);

        $_arr_order = array(
            array('media_id', 'DESC'),
        );

        $_arr_mediaRows = $this->obj_db->select(BG_DB_TABLE . 'media', $_arr_mediaSelect, $_str_sqlWhere, '', $_arr_order, $num_no, $num_except);

        foreach ($_arr_mediaRows as $_key=>$_value) {
            $_arr_mediaRows[$_key]['media_url'] = BG_SITE_URL . BG_URL_MEDIA . date('Y', $_value['media_time']) . '/' . date('m', $_value['media_time']) . '/' . $_value['media_id'] . '.' . $_value['media_ext'];

            $_arr_mediaRows[$_key]['media_path'] = BG_PATH_MEDIA . date('Y', $_value['media_time']) . DS . date('m', $_value['media_time']) . DS . $_value['media_id'] . '.' . $_value['media_ext'];
        }

        return $_arr_mediaRows;
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

        $_num_db = $this->obj_db->count(BG_DB_TABLE . 'media', $_str_sqlWhere);

        return $_num_db;
    }


    /**
     * mdl_del function.
     *
     * @access public
     * @param mixed $this->mediaIds['media_ids']
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function mdl_del($num_adminId = 0, $arr_mediaIds = false) {
        if ($arr_mediaIds) {
            $this->mediaIds['media_ids'] = $arr_mediaIds;
        }

        $_str_mediaIds = implode(',', $this->mediaIds['media_ids']);

        $_str_sqlWhere = '`media_id` IN (' . $_str_mediaIds . ')';

        if ($num_adminId > 0) {
            $_str_sqlWhere .= ' AND `media_admin_id`=' . $num_adminId;
        }

        $_num_db = $this->obj_db->delete(BG_DB_TABLE . 'media', $_str_sqlWhere); //删除数据

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
        $_arr_mediaSelect = array(
            'DISTINCT `media_ext`',
        );

        $_str_sqlWhere    = 'LENGTH(`media_ext`) > 0';
        $_arr_mediaRows  = $this->obj_db->select(BG_DB_TABLE . 'media', $_arr_mediaSelect, $_str_sqlWhere, '', '', 100, 0, true);

        return $_arr_mediaRows;
    }


    /**
     * mdl_year function.
     *
     * @access public
     * @param mixed $num_no
     * @return void
     */
    function mdl_year() {
        $_arr_mediaSelect = array(
            'DISTINCT FROM_UNIXTIME(`media_time`, \'%Y\') AS media_year',
        );

        $_str_sqlWhere = '`media_time` > 0';

        $_arr_order = array(
            array('media_time', 'ASC'),
        );

        $_arr_yearRows = $this->obj_db->select(BG_DB_TABLE . 'media', $_arr_mediaSelect, $_str_sqlWhere, '', $_arr_order, 100, 0, true);

        return $_arr_yearRows;
    }


    function mdl_chkMedia($num_mediaId, $str_mediaExt, $tm_mediaTime) {
        $_str_mediaUrl = date('Y', $tm_mediaTime) . '/' . date('m', $tm_mediaTime) . '/' . $num_mediaId . '.' . $str_mediaExt;

        if ($this->is_magic) {
            $_str_chk   = $_str_mediaUrl;
        } else {
            $_str_chk   = addslashes($_str_mediaUrl);
        }

        $_arr_advertSelect = array(
            'advert_id',
        );

        $_str_sqlWhere    = '`advert_media_id`=' . $num_mediaId;
        //print_r($_str_sqlWhere . '<br>');
        $_arr_order = array(
            array('advert_id', 'ASC'),
        );

        $_arr_advertRows = $this->obj_db->select(BG_DB_TABLE . 'advert', $_arr_advertSelect, $_str_sqlWhere, '', $_arr_order, 1, 0);

        //print_r($_arr_advertRows);
        if (isset($_arr_advertRows[0])) {
            return array(
                'media_id'  => $num_mediaId,
                'rcode'     => 'y070406',
            );
        }

        return array(
            'media_id'  => $num_mediaId,
            'rcode'      => 'x070406',
        );
    }


    function mdl_box($str_box, $arr_mediaIds = false) {
        if ($arr_mediaIds) {
            $this->mediaIds['media_ids'] = $arr_mediaIds;
        }

        $_str_mediaIds = implode(',', $this->mediaIds['media_ids']);

        $_arr_mediaData = array(
            'media_box' => $str_box,
        );

        $_num_db  = $this->obj_db->update(BG_DB_TABLE . 'media', $_arr_mediaData, '`media_id` IN (' . $_str_mediaIds . ')');

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

        $_arr_mediaIds = fn_post('media_ids');

        if (fn_isEmpty($_arr_mediaIds)) {
            $_str_rcode = 'x030202';
        } else {
            foreach ($_arr_mediaIds as $_key=>$_value) {
                $_arr_mediaIds[$_key] = fn_getSafe($_value, 'int', 0);
            }
            $_str_rcode = 'ok';
        }

        $this->mediaIds = array(
            'rcode'      => $_str_rcode,
            'media_ids'  => array_filter(array_unique($_arr_mediaIds)),
        );

        return $this->mediaIds;
    }

    private function sql_process($arr_search = array()) {
        $_str_sqlWhere = '1';

        if (isset($arr_search['key']) && !fn_isEmpty($arr_search['key'])) {
            $_str_sqlWhere .= ' AND `media_name` LIKE \'%' . $arr_search['key'] . '%\'';
        }

        if (isset($arr_search['year']) && !fn_isEmpty($arr_search['year'])) {
            $_str_sqlWhere .= ' AND FROM_UNIXTIME(`media_time`, \'%Y\')=\'' . $arr_search['year'] . '\'';
        }

        if (isset($arr_search['month']) && !fn_isEmpty($arr_search['month'])) {
            $_str_sqlWhere .= ' AND FROM_UNIXTIME(`media_time`, \'%m\')=\'' . $arr_search['month'] . '\'';
        }

        if (isset($arr_search['ext']) && !fn_isEmpty($arr_search['ext'])) {
            $_str_sqlWhere .= ' AND `media_ext`=\'' . $arr_search['ext'] . '\'';
        }

        if (isset($arr_search['admin_id']) && $arr_search['admin_id'] > 0) {
            $_str_sqlWhere .= ' AND `media_admin_id`=' . $arr_search['admin_id'];
        }

        if (isset($arr_search['box']) && !fn_isEmpty($arr_search['box'])) {
            $_str_sqlWhere .= ' AND `media_box`=\'' . $arr_search['box'] . '\'';
        }

        if (isset($arr_search['media_ids']) && $arr_search['media_ids']) {
            $_str_mediaIds  = implode(',', $arr_search['media_ids']);
            $_str_sqlWhere  .= ' AND `media_id` IN (' . $_str_mediaIds . ')';
        }

        if (isset($arr_search['min_id']) && $arr_search['min_id'] > 0) {
            $_str_sqlWhere .= ' AND `media_id`>' . $arr_search['min_id'];
        }

        if (isset($arr_search['max_id']) && $arr_search['max_id'] > 0) {
            $_str_sqlWhere .= ' AND `media_id`<' . $arr_search['max_id'];
        }

        return $_str_sqlWhere;
    }
}
