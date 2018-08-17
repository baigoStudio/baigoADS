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
class CONTROL_CONSOLE_REQUEST_LINK {

    private $is_super       = false;

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->dspType = 'result';
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        if ($this->adminLogged['admin_type'] == 'super') {
            $this->is_super = true;
        }

        $this->mdl_link     = new MODEL_LINK();
    }


    function ctrl_order() {
        if (!isset($this->adminLogged['admin_allow']['link']['edit']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x120303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }
        if (!fn_token('chk')) { //令牌
            $_arr_tplData = array(
                'rcode' => 'x030206',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_num_linkId = fn_getSafe(fn_post('link_id'), 'int', 0); //ID

        if ($_num_linkId < 1) {
            $_arr_tplData = array(
                'rcode' => 'x120209',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_linkRow = $this->mdl_link->mdl_read($_num_linkId);
        if ($_arr_linkRow['rcode'] != 'y120102') {
            $this->obj_tpl->tplDisplay('result', $_arr_linkRow);
        }

        $_str_orderType = fn_getSafe(fn_post('order_type'), 'txt', 'order_first');
        $_num_targetId  = fn_getSafe(fn_post('order_target'), 'int', 0);
        $_arr_linkRow   = $this->mdl_link->mdl_order($_str_orderType, $_num_linkId, $_num_targetId);

        $this->obj_tpl->tplDisplay('result', $_arr_linkRow);
    }


    function ctrl_status() {
        if (!isset($this->adminLogged['admin_allow']['link']['edit']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x120303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_linkIds = $this->mdl_link->input_ids();
        if ($_arr_linkIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_linkIds);
        }

        $_str_linkStatus = fn_getSafe($GLOBALS['route']['bg_act'], 'txt', '');

        $_arr_linkRow = $this->mdl_link->mdl_status($_str_linkStatus);

        $this->obj_tpl->tplDisplay('result', $_arr_linkRow);
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        $_arr_linkInput = $this->mdl_link->input_submit();

        if ($_arr_linkInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_linkInput);
        }

        if ($_arr_linkInput['link_id'] > 0) {
            if (!isset($this->adminLogged['admin_allow']['link']['edit']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x120303',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
        } else {
            if (!isset($this->adminLogged['admin_allow']['link']['add']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x120302',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
        }

        $_arr_linkRow = $this->mdl_link->mdl_submit();

        $this->obj_tpl->tplDisplay('result', $_arr_linkRow);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        if (!isset($this->adminLogged['admin_allow']['link']['del']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x120304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_linkIds = $this->mdl_link->input_ids();
        if ($_arr_linkIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_linkIds);
        }

        $_arr_linkRow = $this->mdl_link->mdl_del();

        $this->obj_tpl->tplDisplay('result', $_arr_linkRow);
    }
}
