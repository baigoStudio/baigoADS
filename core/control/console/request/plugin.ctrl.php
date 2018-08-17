<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------用户控制器-------------*/
class CONTROL_CONSOLE_REQUEST_PLUGIN {

    private $group_allow    = array();
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

        if (isset($this->adminLogged['groupRow']['group_allow'])) {
            $this->group_allow = $this->adminLogged['groupRow']['group_allow'];
        }

        $this->mdl_plugin      = new MODEL_PLUGIN(); //设置用户模型
    }


    function ctrl_opt() {
        if (!isset($this->group_allow['plugin']['edit']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x190303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_optInput = $this->mdl_plugin->input_opt();

        if ($_arr_optInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_optInput);
        }

        $_arr_pluginRow = $this->mdl_plugin->mdl_read($_arr_optInput['plugin_id']);
        if ($_arr_pluginRow['rcode'] != 'y190102') {
            return $_arr_pluginRow;
        }

        $_arr_pluginRow = $this->mdl_plugin->mdl_opt($_arr_pluginRow['plugin_dir']);

        $this->obj_tpl->tplDisplay('result', $_arr_pluginRow);
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        $_arr_pluginInput = $this->mdl_plugin->input_submit();

        if ($_arr_pluginInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_pluginInput);
        }

        if ($_arr_pluginInput['plugin_id'] > 0) {
            if (!isset($this->group_allow['plugin']['edit']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x190303',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
        } else {
            if (!isset($this->group_allow['plugin']['add']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x190302',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
        }

        $_arr_pluginRow = $this->mdl_plugin->mdl_submit();

        $this->obj_tpl->tplDisplay('result', $_arr_pluginRow);
    }


    /**
     * ajax_status function.
     *
     * @access public
     * @return void
     */
    function ctrl_status() {
        if (!isset($this->group_allow['plugin']['edit']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x190303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_str_status = fn_getSafe($GLOBALS['route']['bg_act'], 'txt', '');

        $_arr_pluginIds = $this->mdl_plugin->input_ids();
        if ($_arr_pluginIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_pluginIds);
        }

        $_arr_pluginRow = $this->mdl_plugin->mdl_status($_str_status);

        $this->obj_tpl->tplDisplay('result', $_arr_pluginRow);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        if (!isset($this->group_allow['plugin']['del']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x190304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_pluginIds = $this->mdl_plugin->input_ids();
        if ($_arr_pluginIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_pluginIds);
        }

        $_arr_pluginRow = $this->mdl_plugin->mdl_del();

        $this->obj_tpl->tplDisplay('result', $_arr_pluginRow);
    }
}
