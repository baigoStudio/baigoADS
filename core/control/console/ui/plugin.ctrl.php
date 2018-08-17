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
class CONTROL_CONSOLE_UI_PLUGIN {

    private $group_allow    = array();
    private $is_super       = false;

    function __construct() { //构造函数
        $this->config   = $GLOBALS['obj_base']->config;

        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_file      = new CLASS_FILE(); //初始化文件对象
        $this->obj_tpl      = $this->general_console->obj_tpl;

        if ($this->adminLogged['admin_type'] == 'super') {
            $this->is_super = true;
        }

        if (isset($this->adminLogged['groupRow']['group_allow'])) {
            $this->group_allow = $this->adminLogged['groupRow']['group_allow'];
        }

        $this->mdl_plugin      = new MODEL_PLUGIN(); //设置管理员模型

        $this->tplData = array(
            'adminLogged'   => $this->adminLogged,
            'status'        => $this->mdl_plugin->arr_status,
        );
    }

    function ctrl_opt() {
        if (!isset($this->group_allow['plugin']['edit']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x190301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_pluginId = fn_getSafe(fn_get('plugin_id'), 'int', 0);

        if ($_num_pluginId < 1) {
            $this->tplData['rcode'] = 'x190210';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_pluginRow = $this->mdl_plugin->mdl_read($_num_pluginId);
        if ($_arr_pluginRow['rcode'] != 'y190102') {
            $this->tplData['rcode'] = $_arr_pluginRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        if (fn_isEmpty($_arr_pluginRow['plugin_dir'])) {
            $this->tplData['rcode'] = 'x190201';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        if (!file_exists(BG_PATH_PLUGIN . $_arr_pluginRow['plugin_dir'] . DS . 'config.php') || !file_exists(BG_PATH_PLUGIN . $_arr_pluginRow['plugin_dir'] . DS . 'action.php')) {
            $this->tplData['rcode'] = 'x190202';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        if (!file_exists(BG_PATH_PLUGIN . $_arr_pluginRow['plugin_dir'] . DS . 'opts.php')) {
            $this->tplData['rcode'] = 'x190212';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_pluginConfig  = fn_include(BG_PATH_PLUGIN . $_arr_pluginRow['plugin_dir'] . DS . 'config.php');
        $_arr_pluginOpts    = fn_include(BG_PATH_PLUGIN . $_arr_pluginRow['plugin_dir'] . DS . 'opts.php');

        if (!isset($_arr_pluginConfig['name']) || !isset($_arr_pluginConfig['class']) || !isset($_arr_pluginConfig['version']) || !isset($_arr_pluginConfig['author'])) {
            $this->tplData['rcode'] = 'x190211';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $this->tplData['pluginOptsJSON'] = array();

        if (file_exists(BG_PATH_PLUGIN . $_arr_pluginRow['plugin_dir'] . DS . 'opts.json')) {
            $_str_pluginOpts  = $this->obj_file->file_read(BG_PATH_PLUGIN . $_arr_pluginRow['plugin_dir'] . DS . 'opts.json');
            $this->tplData['pluginOptsJSON'] = json_decode($_str_pluginOpts, true);
        }

        $this->tplData['pluginRow']     = $_arr_pluginRow;
        $this->tplData['pluginConfig']  = $_arr_pluginConfig;
        $this->tplData['pluginOpts']    = $_arr_pluginOpts;

        $this->obj_tpl->tplDisplay('plugin_opts', $this->tplData);
    }


    /*============编辑管理员界面============
    返回提示
    */
    function ctrl_show() {
        if (!isset($this->group_allow['plugin']['browse']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x190301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_pluginId = fn_getSafe(fn_get('plugin_id'), 'int', 0);

        if ($_num_pluginId < 1) {
            $this->tplData['rcode'] = 'x190210';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_pluginRow = $this->mdl_plugin->mdl_read($_num_pluginId);
        if ($_arr_pluginRow['rcode'] != 'y190102') {
            $this->tplData['rcode'] = $_arr_pluginRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        if (fn_isEmpty($_arr_pluginRow['plugin_dir'])) {
            $this->tplData['rcode'] = 'x190201';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        if (!file_exists(BG_PATH_PLUGIN . $_arr_pluginRow['plugin_dir'] . DS . 'config.php') || !file_exists(BG_PATH_PLUGIN . $_arr_pluginRow['plugin_dir'] . DS . 'action.php')) {
            $this->tplData['rcode'] = 'x190202';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_pluginConfig  = fn_include(BG_PATH_PLUGIN . $_arr_pluginRow['plugin_dir'] . DS . 'config.php');

        if (!isset($_arr_pluginConfig['name']) || !isset($_arr_pluginConfig['class']) || !isset($_arr_pluginConfig['version']) || !isset($_arr_pluginConfig['author'])) {
            $this->tplData['rcode'] = 'x190211';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $this->tplData['pluginRow']     = $_arr_pluginRow;
        $this->tplData['pluginConfig']  = $_arr_pluginConfig;

        $this->obj_tpl->tplDisplay('plugin_show', $this->tplData);
    }


    /*============编辑管理员界面============
    返回提示
    */
    function ctrl_form() {
        $_num_pluginId = fn_getSafe(fn_get('plugin_id'), 'int', 0);

        if ($_num_pluginId > 0) {
            if (!isset($this->group_allow['plugin']['edit']) && !$this->is_super) {
                $this->tplData['rcode'] = 'x190303';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }

            $_arr_pluginRow = $this->mdl_plugin->mdl_read($_num_pluginId);
            if ($_arr_pluginRow['rcode'] != 'y190102') {
                $this->tplData['rcode'] = $_arr_pluginRow['rcode'];
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }

            $_str_pluginDir = $_arr_pluginRow['plugin_dir'];
        } else {
            if (!isset($this->group_allow['plugin']['add']) && !$this->is_super) {
                $this->tplData['rcode'] = 'x190302';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }

            $_str_pluginDir = fn_getSafe(fn_get('plugin_dir'), 'txt', '');
        }

        if (fn_isEmpty($_str_pluginDir)) {
            $this->tplData['rcode'] = 'x190201';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        if (!file_exists(BG_PATH_PLUGIN . $_str_pluginDir . DS . 'config.php') || !file_exists(BG_PATH_PLUGIN . $_str_pluginDir . DS . 'action.php')) {
            $this->tplData['rcode'] = 'x190202';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_pluginConfig  = fn_include(BG_PATH_PLUGIN . $_str_pluginDir . DS . 'config.php');

        if (!isset($_arr_pluginConfig['name']) || !isset($_arr_pluginConfig['class']) || !isset($_arr_pluginConfig['version']) || !isset($_arr_pluginConfig['author'])) {
            $this->tplData['rcode'] = 'x190211';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        if ($_num_pluginId < 1) {
            $_arr_pluginRow = array(
                'plugin_id'     => 0,
                'plugin_dir'    => $_str_pluginDir,
                'plugin_note'   => '',
            );
        }

        $_arr_pluginRow['detail'] = $_arr_pluginConfig['detail'];

        $this->tplData['pluginRow']     = $_arr_pluginRow;
        $this->tplData['pluginConfig']  = $_arr_pluginConfig;

        $this->obj_tpl->tplDisplay('plugin_form', $this->tplData);
    }


    /*============列出管理员界面============
    无返回
    */
    function ctrl_list() {
        if (!isset($this->group_allow['plugin']['browse']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x190301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_pluginRows = $this->obj_file->dir_list(BG_PATH_PLUGIN);

        foreach ($_arr_pluginRows as $_key=>$_value) {
            $_arr_pluginRow = $this->mdl_plugin->mdl_read($_value['name'], 'plugin_dir');
            if ($_arr_pluginRow['rcode'] != 'y190102') {
                $_arr_pluginRow['plugin_status']    = 'not';
                $_arr_pluginRow['plugin_note']      = '';
            }

            if (file_exists(BG_PATH_PLUGIN . $_value['name'] . DS . 'config.php') && file_exists(BG_PATH_PLUGIN . $_value['name'] . DS . 'action.php')) {
                $_arr_pluginConfig = fn_include(BG_PATH_PLUGIN . $_value['name'] . DS . 'config.php');
                if (isset($_arr_pluginConfig['name']) && isset($_arr_pluginConfig['class']) && isset($_arr_pluginConfig['version']) && isset($_arr_pluginConfig['author'])) {
                    $_arr_pluginRows[$_key]['config'] = fn_include(BG_PATH_PLUGIN . $_value['name'] . DS . 'config.php');
                } else {
                    $_arr_pluginRow['plugin_status']  = 'error';
                    $_arr_pluginRows[$_key]['config'] = array(
                        'name' => $_value['name'],
                    );
                }
            } else {
                $_arr_pluginRow['plugin_status']  = 'error';
                $_arr_pluginRows[$_key]['config'] = array(
                    'name' => $_value['name'],
                );
            }

            $_arr_pluginRows[$_key]['pluginRow'] = $_arr_pluginRow;
        }

        //print_r($_arr_pluginRows);

        $_arr_tpl = array(
            'pluginRows'    => $_arr_pluginRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('plugin_list', $_arr_tplData);
    }
}
