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
class CONTROL_CONSOLE_REQUEST_POSI {

    private $is_super = false;

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->dspType = 'result';
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        $this->mdl_posi      = new MODEL_POSI();

        if ($this->adminLogged['admin_type'] == 'super') {
            $this->is_super = true;
        }
    }


    function ctrl_cache() {
        $_arr_posiIds = $this->mdl_posi->input_ids();
        if ($_arr_posiIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_posiIds);
        }

        $_arr_posiRow = $this->mdl_posi->mdl_cache(0, true);

        $this->obj_tpl->tplDisplay('result', $_arr_posiRow);
    }

    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        $_arr_posiSubmit = $this->mdl_posi->input_submit();
        if ($_arr_posiSubmit['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_posiSubmit);
        }

        if ($_arr_posiSubmit['posi_id'] > 0) {
            if (!isset($this->adminLogged['admin_allow']['posi']['edit']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x040303',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
        } else {
            if (!isset($this->adminLogged['admin_allow']['posi']['add']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x040302',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
        }

        $_arr_posiRow = $this->mdl_posi->mdl_submit();

        $this->mdl_posi->mdl_cache(0, true);

        $this->obj_tpl->tplDisplay('result', $_arr_posiRow);
    }


    /**
     * ajax_status function.
     *
     * @access public
     * @return void
     */
    function ctrl_status() {
        if (!isset($this->adminLogged['admin_allow']['posi']['edit']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x040303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_posiIds = $this->mdl_posi->input_ids();
        if ($_arr_posiIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_posiIds);
        }

        $_str_posiStatus = fn_getSafe($GLOBALS['route']['bg_act'], 'txt', '');

        $_arr_posiRow = $this->mdl_posi->mdl_status($_str_posiStatus);

        $this->mdl_posi->mdl_cache(0, true);

        $this->obj_tpl->tplDisplay('result', $_arr_posiRow);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        if (!isset($this->adminLogged['admin_allow']['posi']['del']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x040304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_posiIds = $this->mdl_posi->input_ids();
        if ($_arr_posiIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_posiIds);
        }

        $_arr_posiRow = $this->mdl_posi->mdl_del();

        $this->mdl_posi->mdl_cache_del($_arr_posiIds['posi_ids']);

        $this->obj_tpl->tplDisplay('result', $_arr_posiRow);
    }


    /**
     * ajax_chkGroup function.
     *
     * @access public
     * @return void
     */
    function ctrl_chkname() {
        $_str_posiName   = fn_getSafe(fn_get('posi_name'), 'txt', '');
        $_num_posiId     = fn_getSafe(fn_get('posi_id'), 'int', 0);

        if (!fn_isEmpty($_str_posiName)) {
            $_arr_posiRow = $this->mdl_posi->mdl_read($_str_posiName, 'posi_name', $_num_posiId);

            if ($_arr_posiRow['rcode'] == 'y040102') {
                $this->obj_tpl->tplDisplay('result', 'x040203');
            }
        }

        $arr_re = array(
            'msg' => 'ok'
        );

        $this->obj_tpl->tplDisplay('result', $arr_re);
    }
}
