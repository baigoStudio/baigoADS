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
class CONTROL_CONSOLE_UI_PM {

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        $this->obj_sso      = new CLASS_SSO(); //获取界面类型

        $this->tplData = array(
            'adminLogged' => $this->adminLogged
        );
    }


    function ctrl_show() {
        $_num_pmId  = fn_getSafe(fn_get('pm_id'), 'int', 0);
        if ($_num_pmId < 1) {
            $this->tplData['rcode'] = 'x110211';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_pmSubmit = array(
            'user_access_token' => $this->adminLogged['admin_access_token'],
            'pm_id'             => $_num_pmId,
        );
        $_arr_pmRow = $this->obj_sso->sso_pm_read($this->adminLogged['admin_id'], 'user_id', $_arr_pmSubmit);
        if ($_arr_pmRow['rcode'] != 'y110102') { //不存在该管理员
            $this->tplData['rcode'] = $_arr_pmRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_pmSubmit = array(
            'user_access_token' => $this->adminLogged['admin_access_token'],
            'pm_status'         => 'read',
            'pm_ids'            => array($_num_pmId),
        );

        //print_r($_arr_pmSubmit);

        $this->obj_sso->sso_pm_status($this->adminLogged['admin_id'], 'user_id', $_arr_pmSubmit);

        $_arr_pmRow['pm_title']     = fn_htmlcode(fn_htmlcode($_arr_pmRow['pm_title'], 'decode', 'url'), 'decode', 'url');
        $_arr_pmRow['pm_content']   = fn_htmlcode(fn_htmlcode($_arr_pmRow['pm_content'], 'decode', 'url'), 'decode', 'url');

        $_arr_tpl = array(
            'pmRow'   => $_arr_pmRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('pm_show', $_arr_tplData);
    }


    function ctrl_send() {
        $_num_pmId   = fn_getSafe(fn_get('pm_id'), 'int', 0);

        if ($_num_pmId > 0) {
            $_arr_pmSubmit = array(
                'user_access_token' => $this->adminLogged['admin_access_token'],
                'pm_status'         => 'read',
                'pm_id'             => $_num_pmId,
            );

            $_arr_pmRow = $this->obj_sso->sso_pm_read($this->adminLogged['admin_id'], 'user_id', $_arr_pmSubmit);
            if ($_arr_pmRow['rcode'] != 'y110102') { //不存在该管理员
                $this->tplData['rcode'] = $_arr_pmRow['rcode'];
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
            if (isset($_arr_pmRow['fromUser']['user_name'])) {
                $_arr_pmRow['pm_to_user'] = $_arr_pmRow['fromUser']['user_name'];
            } else {
                $_arr_pmRow['pm_to_user'] = '';
            }
            $_arr_pmRow['pm_title'] = $this->obj_tpl->lang['mod']['label']['reply'] . ': ' . fn_htmlcode($_arr_pmRow['pm_title'], 'decode', 'url');
            $_arr_pmRow['pm_content'] = PHP_EOL . PHP_EOL . PHP_EOL . '------------------------------------------------' . PHP_EOL . fn_htmlcode($_arr_pmRow['pm_content'], 'decode', 'url');
        } else {
            $_arr_pmRow = array(
                'pm_id'         => 0,
                'pm_to_user'    => '',
                'pm_title'      => '',
                'pm_content'    => '',
            );
        }

        $_arr_tpl = array(
            'pmRow'    => $_arr_pmRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('pm_send', $_arr_tplData);
    }


    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_list() {
        $_str_key       = fn_getSafe(fn_get('key'), 'txt', '');
        $_str_type      = fn_getSafe(fn_get('type'), 'txt', 'in');
        $_str_status    = fn_getSafe(fn_get('status'), 'txt', '');

        $_arr_search = array(
            'key'       => $_str_key,
            'type'      => $_str_type,
            'status'    => $_str_status,
        );

        $_str_query     = http_build_query($_arr_search);

        $_arr_pmSubmit = array(
            'user_access_token' => $this->adminLogged['admin_access_token'],
            'pm_type'           => $_str_type,
            'pm_status'         => $_str_status,
            'key'               => $_str_key,
        );
        $_arr_reseult   = $this->obj_sso->sso_pm_list($this->adminLogged['admin_id'], 'user_id', $_arr_pmSubmit);

        if ($_arr_reseult['rcode'] != 'y110402' || fn_isEmpty($_arr_reseult['pmRows'])) {
            $_arr_reseult = array(
                'pageRow'   => array(
                    'page'  => 1,
                    'p'     => 0,
                    'begin' => 1,
                    'end'   => 1,
                    'total' => 1,
                ),
                'pmRows'    => array(),
            );
        }

        $_arr_tpl = array(
            'query'     => $_str_query,
            'search'    => $_arr_search,
            'pageRow'   => $_arr_reseult['pageRow'],
            'pmRows'    => $_arr_reseult['pmRows'], //管理员列表
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('pm_list', $_arr_tplData);
    }
}
