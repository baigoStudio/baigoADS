<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}


/*-------------UC 类-------------*/
class CONTROL_CONSOLE_REQUEST_ADMIN {

    private $adminLogged;
    private $obj_ajax;
    private $obj_sso;
    private $mdl_admin;
    private $is_super = false;

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->dspType = 'result';
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        $this->obj_sso        = new CLASS_SSO();
        $this->mdl_admin      = new MODEL_ADMIN();

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
        $_arr_adminInput = $this->mdl_admin->input_submit();

        if ($_arr_adminInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_adminInput);
        }

        if ($_arr_adminInput['admin_id'] > 0) {
            if (!isset($this->adminLogged['admin_allow']['admin']['edit']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x020303',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }

            if ($_arr_adminInput['admin_id'] == $this->adminLogged['admin_id'] && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x020306',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }

            $_str_adminPass  = fn_post('admin_pass');

            $_arr_adminSubmit = array(
                'user_pass'     => $_str_adminPass,
                'user_mail_new' => $_arr_adminInput['admin_mail'],
                'user_nick'     => $_arr_adminInput['admin_nick'],
            );

            $_arr_ssoEdit    = $this->obj_sso->sso_user_edit($_arr_adminInput['admin_name'], 'user_name', $_arr_adminSubmit);

            $_num_adminId    = $_arr_adminInput['admin_id'];
        } else {
            if (!isset($this->adminLogged['admin_allow']['admin']['add']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x020302',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }

            $_arr_adminPass = fn_validate(fn_post('admin_pass'), 1, 0);
            switch ($_arr_adminPass['status']) {
                case 'too_short':
                    $_arr_tplData = array(
                        'rcode' => 'x010212',
                    );
                    $this->obj_tpl->tplDisplay('result', $_arr_tplData);
                break;

                case 'ok':
                    $_str_adminPass = $_arr_adminPass['str'];
                break;
            }

            $_arr_adminSubmit = array(
                'user_name' => $_arr_adminInput['admin_name'],
                'user_pass' => $_str_adminPass,
                'user_mail' => $_arr_adminInput['admin_mail'],
                'user_nick' => $_arr_adminInput['admin_nick'],
            );

            $_arr_ssoReg = $this->obj_sso->sso_user_reg($_arr_adminSubmit);
            if ($_arr_ssoReg['rcode'] != 'y010101') {
                $this->obj_tpl->tplDisplay('result', $_arr_ssoReg);
            }
            $_num_adminId = $_arr_ssoReg['user_id'];
        }

        $_arr_adminRow = $this->mdl_admin->mdl_submit($_num_adminId);

        if ($_arr_ssoEdit['rcode'] == 'y010103' || $_arr_adminRow['rcode'] == 'y020103') {
            $_str_rcode = 'y020103';
        } else {
            $_str_rcode = $_arr_adminRow['rcode'];
        }

        $_arr_tplData = array(
            'rcode' => $_str_rcode,
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }


    /**
     * ajax_auth function.
     *
     * @access public
     * @return void
     */
    function ctrl_auth() {
        $_arr_adminInput = $this->mdl_admin->input_submit();

        if ($_arr_adminInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_adminInput);
        }

        if (!isset($this->adminLogged['admin_allow']['admin']['add']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x020302',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_ssoGet = $this->obj_sso->sso_user_read($_arr_adminInput['admin_name'], 'user_name');
        if ($_arr_ssoGet['rcode'] != 'y010102') {
            if ($_arr_ssoGet['rcode'] == 'x010102') {
                $_arr_tplData = array(
                    'rcode' => 'x020205',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            } else {
                $this->obj_tpl->tplDisplay('result', $_arr_ssoGet);
            }
        } else {
            //检验用户是否存在
            $_arr_adminRow = $this->mdl_admin->mdl_read($_arr_ssoGet['user_id']);
            if ($_arr_adminRow['rcode'] == 'y020102') {
                $_arr_tplData = array(
                    'rcode' => 'x020218',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
        }

        $_arr_adminRow = $this->mdl_admin->mdl_submit($_arr_ssoGet['user_id']);
        if ($_arr_adminRow['rcode'] == 'x020101') {
            $_str_rcode = 'y020101';
        } else {
            $_str_rcode = $_arr_adminRow['rcode'];
        }

        $_arr_tplData = array(
            'rcode' => $_str_rcode,
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        if (!isset($this->adminLogged['admin_allow']['admin']['del']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x020304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_adminIds = $this->mdl_admin->input_ids();
        if ($_arr_adminIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_adminIds);
        }

        $_arr_adminRow = $this->mdl_admin->mdl_del();

        $this->obj_tpl->tplDisplay('result', $_arr_adminRow);
    }


    /**
     * ajax_status function.
     *
     * @access public
     * @return void
     */
    function ctrl_status() {
        if (!isset($this->adminLogged['admin_allow']['admin']['edit']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x020303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_adminIds = $this->mdl_admin->input_ids();
        if ($_arr_adminIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_adminIds);
        }

        $_str_adminStatus = fn_getSafe($GLOBALS['route']['bg_act'], 'txt', '');

        $_arr_adminRow = $this->mdl_admin->mdl_status($_str_adminStatus);

        $this->obj_tpl->tplDisplay('result', $_arr_adminRow);
    }


    /**
     * ajax_chkname function.
     *
     * @access public
     * @return void
     */
    function ctrl_chkname() {
        $_str_adminName   = fn_getSafe(fn_get('admin_name'), 'txt', '');
        $_arr_ssoChk      = $this->obj_sso->sso_user_chkname($_str_adminName);

        if ($_arr_ssoChk['rcode'] != 'y010205') {
            if ($_arr_ssoChk['rcode'] == 'x010205') {
                $_arr_ssoGet = $this->obj_sso->sso_user_read($_str_adminName, 'user_name');
                //检验用户是否存在
                $_arr_adminRow = $this->mdl_admin->mdl_read($_arr_ssoGet['user_id']);
                if ($_arr_adminRow['rcode'] == 'y020102') {
                    $_arr_tplData = array(
                        'rcode' => 'x020218',
                    );
                    $this->obj_tpl->tplDisplay('result', $_arr_tplData);
                } else {
                    $_arr_tplData = array(
                        'rcode' => 'x020204',
                    );
                    $this->obj_tpl->tplDisplay('result', $_arr_tplData);
                }
            } else {
                $this->obj_tpl->tplDisplay('result', $_arr_ssoChk);
            }
        }

        $arr_re = array(
            'msg' => 'ok'
        );

        $this->obj_tpl->tplDisplay('result', $arr_re);
    }


    function ctrl_chkauth() {
        $_str_adminName   = fn_getSafe(fn_get('admin_name'), 'txt', '');
        $_arr_ssoGet      = $this->obj_sso->sso_user_read($_str_adminName, 'user_name');

        if ($_arr_ssoGet['rcode'] != 'y010102') {
            if ($_arr_ssoGet['rcode'] == 'x010102') {
                $_arr_tplData = array(
                    'rcode' => 'x020205',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            } else {
                $this->obj_tpl->tplDisplay('result', $_arr_ssoGet);
            }
        } else {
            //检验用户是否存在
            $_arr_adminRow = $this->mdl_admin->mdl_read($_arr_ssoGet['user_id']);
            if ($_arr_adminRow['rcode'] == 'y020102') {
                $_arr_tplData = array(
                    'rcode' => 'x020218',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
        }

        $arr_re = array(
            'msg' => 'ok'
        );

        $this->obj_tpl->tplDisplay('result', $arr_re);
    }


    /**
     * ajax_chkmail function.
     *
     * @access public
     * @return void
     */
    function ctrl_chkmail() {
        $_str_adminMail   = fn_getSafe(fn_get('admin_mail'), 'txt', '');
        $_num_adminId     = fn_getSafe(fn_get('admin_id'), 'int', 0);
        $_arr_ssoChk      = $this->obj_sso->sso_user_chkmail($_str_adminMail, $_num_adminId);
        //print_r($_arr_ssoChk);

        if ($_arr_ssoChk['rcode'] != 'y010211') {
            $this->obj_tpl->tplDisplay('result', $_arr_ssoChk);
        }

        $arr_re = array(
            'msg' => 'ok'
        );

        $this->obj_tpl->tplDisplay('result', $arr_re);
    }
}
