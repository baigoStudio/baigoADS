<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------用户类-------------*/
class MODEL_ADMIN {

    public $arr_status = array('enable', 'disable');
    public $arr_type   = array('normal', 'super');

    function __construct() { //构造函数
        $this->obj_db     = $GLOBALS['obj_db']; //设置数据库对象
    }

    function mdl_create_table() {
        $_str_status    = implode('\',\'', $this->arr_status);
        $_str_type      = implode('\',\'', $this->arr_type);

        $_arr_adminCreate = array(
            'admin_id'              => 'int NOT NULL AUTO_INCREMENT COMMENT \'ID\'',
            'admin_name'            => 'varchar(30) NOT NULL COMMENT \'用户名\'',
            'admin_note'            => 'varchar(30) NOT NULL COMMENT \'备注\'',
            'admin_nick'            => 'varchar(30) NOT NULL COMMENT \'昵称\'',
            'admin_allow'           => 'text NOT NULL COMMENT \'权限\'',
            'admin_allow_profile'   => 'varchar(1000) NOT NULL COMMENT \'个人权限\'',
            'admin_prefer'          => 'varchar(3000) NOT NULL COMMENT \'个人偏好\'',
            'admin_time'            => 'int NOT NULL COMMENT \'登录时间\'',
            'admin_time_login'      => 'int NOT NULL COMMENT \'最后登录\'',
            'admin_status'          => 'enum(\'' . $_str_status . '\') NOT NULL COMMENT \'状态\'',
            'admin_type'            => 'enum(\'' . $_str_type . '\') NOT NULL COMMENT \'类型\'',
            'admin_ip'              => 'char(15) NOT NULL COMMENT \'IP\'',
            'admin_access_token'    => 'char(32) NOT NULL COMMENT \'访问口令\'',
            'admin_access_expire'   => 'int NOT NULL COMMENT \'访问口令过期时间\'',
            'admin_refresh_token'   => 'char(32) NOT NULL COMMENT \'访问口令\'',
            'admin_refresh_expire'  => 'int NOT NULL COMMENT \'访问口令过期时间\'',
        );

        $_num_db = $this->obj_db->create_table(BG_DB_TABLE . 'admin', $_arr_adminCreate, 'admin_id', '管理帐号');

        if ($_num_db > 0) {
            $_str_rcode = 'y020105'; //更新成功
        } else {
            $_str_rcode = 'x020105'; //更新成功
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
        );
    }


    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . 'admin');

        $_arr_col = array();

        if (!fn_isEmpty($_arr_colRows)) {
            foreach ($_arr_colRows as $_key=>$_value) {
                $_arr_col[] = $_value['Field'];
            }
        }

        return $_arr_col;
    }


    function mdl_alter_table() {
        $_str_status    = implode('\',\'', $this->arr_status);
        $_str_type      = implode('\',\'', $this->arr_type);

        $_arr_col     = $this->mdl_column();
        $_arr_alter   = array();

        if (!in_array('admin_type', $_arr_col)) {
            $_arr_alter['admin_type'] = array('ADD', 'enum(\'' . $_str_type . '\') NOT NULL COMMENT \'类型\'');
        }

        if (!in_array('admin_access_token', $_arr_col)) {
            $_arr_alter['admin_access_token'] = array('ADD', 'char(32) NOT NULL COMMENT \'访问口令\'');
        }

        if (!in_array('admin_access_expire', $_arr_col)) {
            $_arr_alter['admin_access_expire'] = array('ADD', 'int NOT NULL COMMENT \'访问口令过期时间\'');
        }

        if (!in_array('admin_refresh_token', $_arr_col)) {
            $_arr_alter['admin_refresh_token'] = array('ADD', 'char(32) NOT NULL COMMENT \'刷新口令\'');
        }

        if (!in_array('admin_refresh_expire', $_arr_col)) {
            $_arr_alter['admin_refresh_expire'] = array('ADD', 'int NOT NULL COMMENT \'刷新口令过期时间\'');
        }

        if (!in_array('admin_prefer', $_arr_col)) {
            $_arr_alter['admin_prefer'] = array('ADD', 'varchar(3000) NOT NULL COMMENT \'个人偏好\'');
        }

        $_str_rcode = 'y020111';

        if (!fn_isEmpty($_arr_alter)) {
            $_reselt = $this->obj_db->alter_table(BG_DB_TABLE . 'admin', $_arr_alter);

            if (!fn_isEmpty($_reselt)) {
                $_str_rcode = 'y020106';
                $_arr_adminData = array(
                    'admin_type' => $this->arr_type[0],
                );
                $this->obj_db->update(BG_DB_TABLE . 'admin', $_arr_adminData, 'LENGTH(`admin_type`) < 1'); //更新数据
            }
        }

        return array(
            'rcode' => $_str_rcode,
        );
    }


    /**
     * mdl_login function.
     *
     * @access public
     * @param mixed $num_adminId
     * @param mixed $str_rand
     * @return void
     */
    function mdl_login($num_adminId, $str_accessToken, $tm_accessExpire, $str_refreshToken, $tm_refreshExpire) {
        $_tm_time       = time();
        $_str_adminIp   = fn_getIp();

        $_arr_adminUpdate = array(
            'admin_time_login'      => $_tm_time,
            'admin_ip'              => $_str_adminIp,
            'admin_access_token'    => $str_accessToken,
            'admin_access_expire'   => $tm_accessExpire,
            'admin_refresh_token'   => $str_refreshToken,
            'admin_refresh_expire'  => $tm_refreshExpire,
        );

        $_num_db = $this->obj_db->update(BG_DB_TABLE . 'admin', $_arr_adminUpdate, '`admin_id`=' . $num_adminId); //更新数据

        if ($_num_db > 0) {
            $_str_rcode = 'y020103'; //更新成功
        } else {
            $_str_rcode = 'x020103'; //更新成功
        }

        return array(
            'admin_id'          => $num_adminId,
            'admin_time_login'  => $_tm_time,
            'admin_ip'          => $_str_adminIp,
            'rcode'             => $_str_rcode, //更新成功
        );
    }


    /**
     * mdl_submit function.
     *
     * @access public
     * @param mixed $num_adminId
     * @param mixed $str_adminNote
     * @param mixed $str_adminRand
     * @param mixed $str_adminStatus
     * @param mixed $str_adminAllowCate
     * @return void
     */
    function mdl_submit($num_adminId) {

        $_arr_adminRow = $this->mdl_read($num_adminId);

        $_arr_adminData = array(
            'admin_note'            => $this->adminInput['admin_note'],
            'admin_nick'            => $this->adminInput['admin_nick'],
            'admin_status'          => $this->adminInput['admin_status'],
            'admin_type'            => $this->adminInput['admin_type'],
            'admin_allow'           => $this->adminInput['admin_allow'],
            'admin_allow_profile'   => $this->adminInput['admin_allow_profile'],
        );

        if ($_arr_adminRow['rcode'] == 'x020102') {
            $_arr_insert = array(
                'admin_id'      => $num_adminId,
                'admin_name'    => $this->adminInput['admin_name'],
                'admin_time'    => time(),
            );
            $_arr_data       = array_merge($_arr_adminData, $_arr_insert);
            $_num_adminId    = $this->obj_db->insert(BG_DB_TABLE . 'admin', $_arr_data); //插入数据
            if ($_num_adminId >= 0) {
                $_str_rcode = 'y020101'; //插入成功
            } else {
                return array(
                    'rcode' => 'x020101', //更新失败
                );
            }
        } else {
            $_num_adminId    = $num_adminId;
            $_num_db      = $this->obj_db->update(BG_DB_TABLE . 'admin', $_arr_adminData, '`admin_id`=' . $_num_adminId); //更新数据
            if ($_num_db > 0) {
                $_str_rcode = 'y020103'; //更新成功
            } else {
                return array(
                    'rcode' => 'x020103', //更新失败
                );
            }
        }

        return array(
            'admin_id'  => $_num_adminId,
            'rcode'     => $_str_rcode, //成功
        );
    }


    /**
     * mdl_status function.
     *
     * @access public
     * @param mixed $this->adminIds['admin_ids']
     * @param mixed $str_status
     * @return void
     */
    function mdl_status($str_status) {

        $_str_adminId = implode(',', $this->adminIds['admin_ids']);

        $_arr_adminUpdate = array(
            'admin_status' => $str_status,
        );

        $_num_db = $this->obj_db->update(BG_DB_TABLE . 'admin', $_arr_adminUpdate, '`admin_id` IN (' . $_str_adminId . ')'); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_db > 0) {
            $_str_rcode = 'y020103';
        } else {
            $_str_rcode = 'x020103';
        }

        return array(
            'rcode' => $_str_rcode,
        ); //成功

    }


    /**
     * mdl_read function.
     *
     * @access public
     * @param mixed $num_adminId
     * @return void
     */
    function mdl_read($num_adminId) {

        $_arr_adminSelect = array(
            'admin_id',
            'admin_name',
            'admin_note',
            'admin_nick',
            'admin_status',
            'admin_type',
            'admin_time',
            'admin_time_login',
            'admin_ip',
            'admin_allow',
            'admin_allow_profile',
            'admin_prefer',
            'admin_access_token',
            'admin_access_expire',
            'admin_refresh_token',
            'admin_refresh_expire',
        );

        $_arr_adminRows = $this->obj_db->select(BG_DB_TABLE . 'admin', $_arr_adminSelect, '`admin_id`=' . $num_adminId, '', '', 1, 0); //检查本地表是否存在记录

        if (isset($_arr_adminRows[0])) { //用户名不存在则返回错误
            $_arr_adminRow = $_arr_adminRows[0];
        } else {
            return array(
                'rcode' => 'x020102', //不存在记录
            );
        }

        if (isset($_arr_adminRow['admin_allow'])) {
            $_arr_adminRow['admin_allow']    = fn_jsonDecode($_arr_adminRow['admin_allow']); //json解码
        } else {
            $_arr_adminRow['admin_allow']    = array();
        }

        if (isset($_arr_adminRow['admin_allow_profile'])) {
            $_arr_adminRow['admin_allow_profile'] = fn_jsonDecode($_arr_adminRow['admin_allow_profile']); //json解码
        } else {
            $_arr_adminRow['admin_allow_profile'] = array();
        }

        if (isset($_arr_adminRow['admin_prefer'])) {
            $_arr_adminRow['admin_prefer']    = fn_jsonDecode($_arr_adminRow['admin_prefer']); //json解码
        } else {
            $_arr_adminRow['admin_prefer']    = array();
        }

        $_arr_adminRow['rcode']           = 'y020102';

        return $_arr_adminRow;

    }


    /**
     * mdl_list function.
     *
     * @access public
     * @param mixed $num_no
     * @param int $num_except (default: 0)
     * @param string $str_key (default: '')
     * @param string $str_status (default: '')
     * @return void
     */
    function mdl_list($num_no, $num_except = 0, $arr_search = array()) {

        $_arr_adminSelect = array(
            'admin_id',
            'admin_name',
            'admin_note',
            'admin_nick',
            'admin_status',
            'admin_type',
        );

        $_str_sqlWhere = $this->sql_process($arr_search);

        $_arr_order = array(
            array('admin_id', 'DESC'),
        );

        $_arr_adminRows = $this->obj_db->select(BG_DB_TABLE . 'admin', $_arr_adminSelect, $_str_sqlWhere, '', $_arr_order, $num_no, $num_except); //查询数据

        //print_r($_arr_adminRows);

        return $_arr_adminRows;

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

        $_num_count = $this->obj_db->count(BG_DB_TABLE . 'admin', $_str_sqlWhere); //查询数据

        return $_num_count;
    }


    /**
     * mdl_del function.
     *
     * @access public
     * @param mixed $this->adminIds['admin_ids']
     * @return void
     */
    function mdl_del() {

        $_str_adminId = implode(',', $this->adminIds['admin_ids']);

        $_num_db = $this->obj_db->delete(BG_DB_TABLE . 'admin', '`admin_id` IN (' . $_str_adminId . ')'); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_db > 0) {
            $_str_rcode = 'y020104';
        } else {
            $_str_rcode = 'x020104';
        }

        return array(
            'rcode' => $_str_rcode,
        ); //成功

    }


    /**
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

        $this->adminInput['admin_id'] = fn_getSafe(fn_post('admin_id'), 'int', 0);

        if ($this->adminInput['admin_id'] > 0) {
            $_arr_adminRow = $this->mdl_read($this->adminInput['admin_id']);
            if ($_arr_adminRow['rcode'] != 'y020102') {
                return $_arr_adminRow;
            }
        }

        $_arr_adminName = fn_validate(fn_post('admin_name'), 1, 30, 'str', 'strDigit');
        switch ($_arr_adminName['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x010201',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x010202',
                );
            break;

            case 'format_err':
                return array(
                    'rcode' => 'x010203',
                );
            break;

            case 'ok':
                $this->adminInput['admin_name'] = $_arr_adminName['str'];
            break;
        }

        $_arr_adminMail = fn_validate(fn_post('admin_mail'), 0, 900, 'str', 'email');
        switch ($_arr_adminMail['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x010207',
                );
            break;

            case 'format_err':
                return array(
                    'rcode' => 'x010208',
                );
            break;

            case 'ok':
                $this->adminInput['admin_mail'] = $_arr_adminMail['str'];
            break;

        }

        $_arr_adminNick = fn_validate(fn_post('admin_nick'), 0, 30);
        switch ($_arr_adminNick['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x010214',
                );
            break;

            case 'ok':
                $this->adminInput['admin_nick'] = $_arr_adminNick['str'];
            break;
        }

        $_arr_adminNote = fn_validate(fn_post('admin_note'), 0, 30);
        switch ($_arr_adminNote['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x020212',
                );
            break;

            case 'ok':
                $this->adminInput['admin_note'] = $_arr_adminNote['str'];
            break;
        }

        $_arr_adminStatus = fn_validate(fn_post('admin_status'), 1, 0);
        switch ($_arr_adminStatus['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x020213',
                );
            break;

            case 'ok':
                $this->adminInput['admin_status'] = $_arr_adminStatus['str'];
            break;
        }

        $_arr_adminType = fn_validate(fn_post('admin_type'), 1, 0);
        switch ($_arr_adminType['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x020219',
                );
            break;

            case 'ok':
                $this->adminInput['admin_type'] = $_arr_adminType['str'];
            break;
        }

        $this->adminInput['admin_allow']         = fn_jsonEncode(fn_post('admin_allow'));
        $this->adminInput['admin_allow_profile'] = fn_jsonEncode(fn_post('admin_allow_profile'));
        $this->adminInput['rcode']               = 'ok';

        return $this->adminInput;
    }


    /**
     * fn_consoleLogin function.
     *
     * @access public
     * @return void
     */
    function input_login() {
        $_arr_consoleLogin['forward'] = fn_getSafe(fn_post('forward'), 'txt', '');
        if (fn_isEmpty($_arr_consoleLogin['forward'])) {
            $_arr_consoleLogin['forward'] = fn_forward(BG_URL_CONSOLE . 'index.php');
        }

        if (!fn_captcha()) { //验证码
            return array(
                'rcode'     => 'x030205',
            );
        }

        if (!fn_token('chk')) { //令牌
            return array(
                'rcode'     => 'x030206',
            );
        }

        $_arr_adminName = fn_validate(fn_post('admin_name'), 1, 30, 'str', 'strDigit');
        switch ($_arr_adminName['status']) {
            case 'too_short':
                return array(
                    'rcode'     => 'x010201',
                );
            break;

            case 'too_long':
                return array(
                    'rcode'     => 'x010202',
                );
            break;

            case 'format_err':
                return array(
                    'rcode'     => 'x010203',
                );
            break;

            case 'ok':
                $_arr_consoleLogin['admin_name'] = $_arr_adminName['str'];
            break;

        }

        $_arr_adminPass = fn_validate(fn_post('admin_pass'), 1, 0);
        switch ($_arr_adminPass['status']) {
            case 'too_short':
                return array(
                    'rcode'     => 'x010207',
                );
            break;

            case 'ok':
                $_arr_consoleLogin['admin_pass'] = $_arr_adminPass['str'];
            break;

        }

        $_arr_consoleLogin['rcode']   = 'ok';

        return $_arr_consoleLogin;
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

        $_arr_adminIds = fn_post('admin_ids');

        if (fn_isEmpty($_arr_adminIds)) {
            $_str_rcode = 'x030202';
        } else {
            foreach ($_arr_adminIds as $_key=>$_value) {
                $_arr_adminIds[$_key] = fn_getSafe($_value, 'int', 0);
            }
            $_str_rcode = 'ok';
        }

        $this->adminIds = array(
            'rcode'     => $_str_rcode,
            'admin_ids' => array_filter(array_unique($_arr_adminIds)),
        );

        return $this->adminIds;
    }


    private function sql_process($arr_search = array()) {
        $_str_sqlWhere = '1';

        if (isset($arr_search['key']) && !fn_isEmpty($arr_search['key'])) {
            $_str_sqlWhere .= ' AND (`admin_name` LIKE \'%' . $arr_search['key'] . '%\' OR `admin_note` LIKE \'%' . $arr_search['key'] . '%\' OR `admin_nick` LIKE \'%' . $arr_search['key'] . '%\')';
        }

        if (isset($arr_search['status']) && !fn_isEmpty($arr_search['status'])) {
            $_str_sqlWhere .= ' AND `admin_status`=\'' . $arr_search['status'] . '\'';
        }

        if (isset($arr_search['type']) && !fn_isEmpty($arr_search['type'])) {
            $_str_sqlWhere .= ' AND `admin_type`=\'' . $arr_search['type'] . '\'';
        }

        return $_str_sqlWhere;
    }
}
