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
class CONTROL_CONSOLE_UI_POSI {

    public $obj_tpl;
    public $mdl_posi;
    public $adminLogged;
    private $is_super = false;

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->chk_install();

        $this->adminLogged      = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl          = $this->general_console->obj_tpl;

        $this->mdl_advert       = new MODEL_ADVERT(); //设置管理员模型
        $this->mdl_attach       = new MODEL_ATTACH();
        $this->mdl_posi         = new MODEL_POSI();
        $this->obj_file         = new CLASS_FILE();

        $this->tplData = array(
            'adminLogged'   => $this->adminLogged,
            'status'        => $this->mdl_posi->arr_status,
            'type'          => $this->mdl_posi->arr_type,
            'isPercent'     => $this->mdl_posi->arr_isPercent,
        );

        if ($this->adminLogged['admin_type'] == 'super') {
            $this->is_super = true;
        }
    }


    function ctrl_show() {
        if (!isset($this->adminLogged['admin_allow']['posi']['browse']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x040301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_posiId  = fn_getSafe(fn_get('posi_id'), 'int', 0);
        if ($_num_posiId < 1) {
            $this->tplData['rcode'] = 'x040206';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_posiRow = $this->mdl_posi->mdl_read($_num_posiId);
        if ($_arr_posiRow['rcode'] != 'y040102') {
            $this->tplData['rcode'] = $_arr_posiRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_adverts     = array();
        $_arr_advertRows  = $this->mdl_advert->mdl_listPub($_num_posiId);

        if (fn_isEmpty($_arr_advertRows)) {
            $_arr_adverts = $this->mdl_advert->mdl_listPub($_num_posiId, 'backup');
        } else {
            if ($_arr_posiRow['posi_is_percent'] == 'enable') {
                foreach ($_arr_advertRows as $key=>$value) {
                    $arr_adverts[$value['advert_id']] = $value['advert_percent'];
                }

                for ($_iii = 1; $_iii<=$_arr_posiRow['posi_count']; $_iii++) {
                    $arr_ids[] = $this->mdl_advert->get_rand($arr_adverts); //根据概率获取广告id
                }

                foreach ($arr_ids as $_key=>$_value) {
                    $_arr_adverts[$_key] = $this->mdl_advert->mdl_read($_value);
                }
            } else {
                $_arr_adverts = $_arr_advertRows;
            }
        }

        foreach ($_arr_adverts as $_key=>$_value) {
            $_arr_adverts[$_key]['attachRow'] = $this->mdl_attach->mdl_read($_value['advert_attach_id']);
        }

        //print_r($_arr_adverts);

        $_arr_tpl = array(
            'posiRow'    => $_arr_posiRow,
            'advertRows' => $_arr_adverts,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('posi_show', $_arr_tplData);
    }

    function ctrl_form() {
        $_num_posiId  = fn_getSafe(fn_get('posi_id'), 'int', 0);

        if ($_num_posiId > 0) {
            if (!isset($this->adminLogged['admin_allow']['posi']['edit']) && !$this->is_super) {
                $this->tplData['rcode'] = 'x040303';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
            $_arr_posiRow = $this->mdl_posi->mdl_read($_num_posiId);
            if ($_arr_posiRow['rcode'] != 'y040102') {
                $this->tplData['rcode'] = $_arr_posiRow['rcode'];
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
        } else {
            if (!isset($this->adminLogged['admin_allow']['posi']['add']) && !$this->is_super) {
                $this->tplData['rcode'] = 'x040302';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
            $_arr_posiRow = array(
                'posi_id'           => 0,
                'posi_name'         => '',
                'posi_count'        => 1,
                'posi_type'         => $this->mdl_posi->arr_type[0],
                'posi_status'       => $this->mdl_posi->arr_status[0],
                'posi_script'       => '',
                'posi_plugin'       => '',
                'posi_selector'     => '',
                'posi_opts'         => array(),
                'posi_is_percent'   => $this->mdl_posi->arr_isPercent[0],
                'posi_note'         => '',
            );
        }

        $_arr_scriptRows = $this->obj_file->dir_list(BG_PATH_ADVERT);

        foreach ($_arr_scriptRows as $_key=>$_value) {
            if ($_value['type'] == 'file') {
                unset($_arr_scriptRows[$_key]);
            } else {
                $_str_config = $this->obj_file->file_put(BG_PATH_ADVERT . $_value['name'] . DS . 'config.json');
                $_arr_scriptRows[$_key]['config'] = fn_jsonDecode($_str_config);

                //print_r(fn_jsonDecode($_str_config));
            }
        }

        //print_r($_arr_scriptRows);

        $_arr_tpl = array(
            'posiRow'        => $_arr_posiRow,
            'scriptRows'     => $_arr_scriptRows, //管理员列表
            'scriptJSON'     => fn_jsonEncode($_arr_scriptRows),
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('posi_form', $_arr_tplData);
    }

    /**
     * ctrl_list function.
     *
     * @access public
     */
    function ctrl_list() {
        if (!isset($this->adminLogged['admin_allow']['posi']['browse']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x040301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_search = array(
            'key'       => fn_getSafe(fn_get('key'), 'txt', ''),
            'status'    => fn_getSafe(fn_get('status'), 'txt', ''),
        );

        $_num_posiCount   = $this->mdl_posi->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_posiCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_posiRows    = $this->mdl_posi->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page['except'], $_arr_search);

        $_arr_tpl = array(
            'query'      => $_str_query,
            'pageRow'    => $_arr_page,
            'search'     => $_arr_search,
            'posiRows'   => $_arr_posiRows, //管理员列表
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('posi_list', $_arr_tplData);
    }
}
