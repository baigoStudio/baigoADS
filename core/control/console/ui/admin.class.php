<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}


/*-------------管理员控制器-------------*/
class CONTROL_CONSOLE_UI_ADMIN {

    private $is_super = false;

    function __construct() { //构造函数
        $this->general_console    = new GENERAL_CONSOLE();
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl        = $this->general_console->obj_tpl;

        $this->obj_sso        = new CLASS_SSO(); //初始化单点登录
        $this->mdl_admin      = new MODEL_ADMIN(); //设置管理员对象
        $this->tplData = array(
            'adminLogged'   => $this->adminLogged,
            'status'        => $this->mdl_admin->arr_status,
            'type'          => $this->mdl_admin->arr_type,
        );

        if ($this->adminLogged['admin_type'] == 'super') {
            $this->is_super = true;
        }
    }


    /** 管理员表单
     * ctrl_form function.
     *
     * @access public
     */
    function ctrl_form() {
        $_num_adminId = fn_getSafe(fn_get('admin_id'), 'int', 0);

        if ($_num_adminId > 0) {
            if (!isset($this->adminLogged['admin_allow']['admin']['edit']) && !$this->is_super) {
                $this->tplData['rcode'] = 'x020303';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
            if ($_num_adminId == $this->adminLogged['admin_id'] && !$this->is_super) {
                $this->tplData['rcode'] = 'x020306';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
            $_arr_adminRow = $this->mdl_admin->mdl_read($_num_adminId);
            if ($_arr_adminRow['rcode'] != 'y020102') { //不存在该管理员
                $this->tplData['rcode'] = $_arr_adminRow['rcode'];
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
            $_arr_ssoRow = $this->obj_sso->sso_user_read($_num_adminId);
            if ($_arr_ssoRow['rcode'] != 'y010102') { //SSO 中不存在该用户
                $this->tplData['rcode'] = $_arr_ssoRow['rcode'];
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
            $_arr_adminRow['ssoRow'] = $_arr_ssoRow;
        } else {
            if (!isset($this->adminLogged['admin_allow']['admin']['add']) && !$this->is_super) {
                $this->tplData['rcode'] = 'x020302';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
            $_arr_adminRow = array(
                'admin_id'      => 0,
                'admin_nick'    => '',
                'admin_note'    => '',
                'admin_type'    => $this->mdl_admin->arr_type[0],
                'admin_status'  => $this->mdl_admin->arr_status[0],
                'ssoRow'  => array(
                    'user_mail' => '',
                    'user_nick' => '',
                ),
            );
        }

        $_arr_tpl = array(
            'adminRow'   => $_arr_adminRow, //管理员信息
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('admin_form', $_arr_tplData);
    }


    /** 显示管理员信息表单
     * ctrl_show function.
     *
     * @access public
     */
    function ctrl_show() {
        if (!isset($this->adminLogged['admin_allow']['admin']['browse']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x020301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_adminId = fn_getSafe(fn_get('admin_id'), 'int', 0);

        $_arr_adminRow = $this->mdl_admin->mdl_read($_num_adminId);
        if ($_arr_adminRow['rcode'] != 'y020102') {
            $this->tplData['rcode'] = $_arr_adminRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }
        $_arr_ssoRow = $this->obj_sso->sso_user_read($_num_adminId);
        if ($_arr_ssoRow['rcode'] != 'y010102') {
            $this->tplData['rcode'] = $_arr_ssoRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }
        $_arr_adminRow['ssoRow'] = $_arr_ssoRow;

        $_arr_tpl = array(
            'adminRow'   => $_arr_adminRow, //管理员信息
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('admin_show', $_arr_tplData);
    }


    /** 将用户授权为管理员表单
     * ctrl_auth function.
     *
     * @access public
     */
    function ctrl_auth() {

        if (!isset($this->adminLogged['admin_allow']['admin']['add']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x020302';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }
        $_arr_adminRow = array(
            'admin_status'  => 'enable',
            'admin_type'    => 'normal',
        );

        $_arr_tpl = array(
            'adminRow'   => $_arr_adminRow, //管理员信息
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('admin_auth', $_arr_tplData);
    }


    /** 列出管理员
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_list() {
        if (!isset($this->adminLogged['admin_allow']['admin']['browse']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x020301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_search = array(
            'key'        => fn_getSafe(fn_get('key'), 'txt', ''),
            'status'     => fn_getSafe(fn_get('status'), 'txt', ''),
        );

        $_num_adminCount  = $this->mdl_admin->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_adminCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_adminRows   = $this->mdl_admin->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page['except'], $_arr_search);

        $_arr_tpl = array(
            'query'      => $_str_query,
            'pageRow'    => $_arr_page,
            'search'     => $_arr_search,
            'adminRows'  => $_arr_adminRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('admin_list', $_arr_tplData);
    }
}
