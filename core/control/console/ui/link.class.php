<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------允许类-------------*/
class CONTROL_CONSOLE_UI_LINK {

    private $is_super       = false;

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        if ($this->adminLogged['admin_type'] == 'super') {
            $this->is_super = true;
        }

        $this->mdl_link     = new MODEL_LINK();

        $this->tplData = array(
            'adminLogged'   => $this->adminLogged,
            'status'        => $this->mdl_link->arr_status,
        );
    }


    function ctrl_order() {
        if (!isset($this->adminLogged['admin_allow']['link']['edit']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x120303';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_linkId = fn_getSafe(fn_get('link_id'), 'int', 0);

        if ($_num_linkId < 1) {
            $this->tplData['rcode'] = 'x120209';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_linkRow = $this->mdl_link->mdl_read($_num_linkId);
        if ($_arr_linkRow['rcode'] != 'y120102') {
            $this->tplData['rcode'] = $_arr_linkRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_tpl = array(
            'linkRow'    => $_arr_linkRow, //栏目信息
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('link_order', $_arr_tplData);
    }


    function ctrl_form() {
        $_num_linkId  = fn_getSafe(fn_get('link_id'), 'int', 0);

        if ($_num_linkId > 0) {
            if (!isset($this->adminLogged['admin_allow']['link']['edit']) && !$this->is_super) {
                $this->tplData['rcode'] = 'x120303';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }

            $_arr_linkRow = $this->mdl_link->mdl_read($_num_linkId);
            if ($_arr_linkRow['rcode'] != 'y120102') {
                $this->tplData['rcode'] = $_arr_linkRow['rcode'];
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
        } else {
            if (!isset($this->adminLogged['admin_allow']['link']['add']) && !$this->is_super) {
                $this->tplData['rcode'] = 'x120302';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }

            $_arr_linkRow = array(
                'link_id'       => 0,
                'link_name'     => '',
                'link_url'      => '',
                'link_status'   => $this->mdl_link->arr_status[0],
            );
        }

        $_arr_searchCate = array(
            'status' => 'show',
        );

        $_arr_tpl = array(
            'linkRow'    => $_arr_linkRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('link_form', $_arr_tplData);
    }


    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_list() {
        if (!isset($this->adminLogged['admin_allow']['link']['browse']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x120301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_search = array(
            'key'        => fn_getSafe(fn_get('key'), 'txt', ''),
            'type'       => fn_getSafe(fn_get('type'), 'txt', ''),
            'status'     => fn_getSafe(fn_get('status'), 'txt', ''),
        );

        $_num_linkCount   = $this->mdl_link->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_linkCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_linkRows    = $this->mdl_link->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page['except'], $_arr_search);

        $_arr_tpl = array(
            'query'      => $_str_query,
            'pageRow'    => $_arr_page,
            'search'     => $_arr_search,
            'linkRows'   => $_arr_linkRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('link_list', $_arr_tplData);
    }
}
