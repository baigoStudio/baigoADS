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
class CONTROL_CONSOLE_REQUEST_ADVERT {

    private $adminLogged;
    private $obj_ajax;
    private $mdl_advert;
    private $is_super = false;

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->dspType = 'result';
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        $this->mdl_advert         = new MODEL_ADVERT(); //设置用户模型

        if ($this->adminLogged['admin_type'] == 'super') {
            $this->is_super = true;
        }
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        $_arr_advertInput = $this->mdl_advert->input_submit();

        if ($_arr_advertInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_advertInput);
        }

        if ($_arr_advertInput['advert_id'] > 0) {
            if (!isset($this->adminLogged['admin_allow']['advert']['edit']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x080303',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }

            $_arr_pluginReturn = $GLOBALS['obj_plugin']->trigger('filter_console_advert_edit', $_arr_advertInput); //编辑广告时触发
            if (isset($_arr_pluginReturn['filter_console_advert_edit'])) {
                $_arr_pluginReturnDo    = $_arr_pluginReturn['filter_console_advert_edit'];
            }
        } else {
            if (!isset($this->adminLogged['admin_allow']['advert']['add']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x080302',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }

            $_arr_pluginReturn = $GLOBALS['obj_plugin']->trigger('filter_console_add_add', $_arr_advertInput); //编辑广告时触发
            if (isset($_arr_pluginReturn['filter_console_advert_add'])) {
                $_arr_pluginReturnDo    = $_arr_pluginReturn['filter_console_advert_add'];
            }
        }

        if (isset($_arr_pluginReturnDo['return']) && !fn_isEmpty($_arr_pluginReturnDo['return'])) { //如果有插件返回
            $_arr_pluginInput = $this->mdl_advert->input_submit($_arr_pluginReturnDo['return'], $_num_excerptCount);

            if ($_arr_pluginInput['rcode'] != 'ok') {
                $_arr_pluginInput['msg'] = $this->obj_tpl->lang['commom']['label']['errPlugin'];
                if (isset($_arr_pluginReturnDo['plugin'])) {
                    $_arr_pluginInput['msg'] .= ' - ' . $_arr_pluginReturnDo['plugin'];
                }
                $this->obj_tpl->tplDisplay('result', $_arr_pluginInput);
            }
        }

        if (!isset($this->adminLogged['admin_allow']['advert']['approve']) && !$this->is_super) {
            $_str_advertStatus = 'wait';
        } else {
            $_str_advertStatus = $_arr_advertInput['advert_status'];
        }

        $_arr_advertRow = $this->mdl_advert->mdl_submit($this->adminLogged['admin_id'], $_str_advertStatus);

        $this->obj_tpl->tplDisplay('result', $_arr_advertRow);
    }


    /**
     * ajax_status function.
     *
     * @access public
     * @return void
     */
    function ctrl_status() {
        if (!isset($this->adminLogged['admin_allow']['advert']['approve']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x080303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_str_status = fn_getSafe($GLOBALS['route']['bg_act'], 'txt', '');

        $_arr_advertIds = $this->mdl_advert->input_ids();
        if ($_arr_advertIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_advertIds);
        }

        $_arr_return = array(
            'advert_ids'      => $_arr_advertIds['advert_ids'],
            'advert_status'   => $_str_status,
        );

        $GLOBALS['obj_plugin']->trigger('action_console_advert_status', $_arr_return); //删除链接时触发

        $_arr_advertRow = $this->mdl_advert->mdl_status($_str_status, $this->adminLogged['admin_id']);

        $this->obj_tpl->tplDisplay('result', $_arr_advertRow);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        if (!isset($this->adminLogged['admin_allow']['advert']['del']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x080304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_advertIds = $this->mdl_advert->input_ids();
        if ($_arr_advertIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_advertIds);
        }

        $GLOBALS['obj_plugin']->trigger('action_console_advert_del', $_arr_advertIds['advert_ids']); //删除链接时触发

        $_arr_advertRow = $this->mdl_advert->mdl_del();

        $this->obj_tpl->tplDisplay('result', $_arr_advertRow);
    }
}
