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
class CONTROL_CONSOLE_UI_ADVERT {

    private $is_super = false;

    function __construct() { //构造函数
        $this->general_console    = new GENERAL_CONSOLE();
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl        = $this->general_console->obj_tpl;

        $this->obj_tpl->percent     = fn_include(BG_PATH_INC . 'percent.inc.php');

        $this->mdl_advert     = new MODEL_ADVERT(); //设置管理员模型
        $this->mdl_posi       = new MODEL_POSI();
        $this->mdl_media      = new MODEL_MEDIA();

        $this->tplData = array(
            'adminLogged'   => $this->adminLogged,
            'status'        => $this->mdl_advert->arr_status,
            'putType'       => $this->mdl_advert->arr_putType,
        );

        if ($this->adminLogged['admin_type'] == 'super') {
            $this->is_super = true;
        }
    }

    /*============编辑管理员界面============
    返回提示
    */
    function ctrl_show() {
        if (!isset($this->adminLogged['admin_allow']['advert']['browse']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x080301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_advertId = fn_getSafe(fn_get('advert_id'), 'int', 0);

        if ($_num_advertId < 1) {
            $this->tplData['rcode'] = 'x080228';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_advertRow = $this->mdl_advert->mdl_read($_num_advertId);
        if ($_arr_advertRow['rcode'] != 'y080102') {
            $this->tplData['rcode'] = $_arr_advertRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_posiRow                 = $this->mdl_posi->mdl_read($_arr_advertRow['advert_posi_id']);
        $_arr_advertRow['posiRow']    = $_arr_posiRow;

        if ($_arr_posiRow['posi_type'] == 'media' && $_arr_advertRow['advert_media_id'] > 0) {
            $_arr_advertRow['mediaRow'] = $this->mdl_media->mdl_read($_arr_advertRow['advert_media_id']);
        }

        $this->tplData['advertRow'] = $_arr_advertRow;

        $this->obj_tpl->tplDisplay('advert_show', $this->tplData);
    }

    /*============编辑管理员界面============
    返回提示
    */
    function ctrl_form() {
        $_num_advertId = fn_getSafe(fn_get('advert_id'), 'int', 0);

        $_arr_mediaRow = array(
            'media_url' => '',
        );

        if ($_num_advertId > 0) {
            if (!isset($this->adminLogged['admin_allow']['advert']['edit']) && !$this->is_super) {
                $this->tplData['rcode'] = 'x080303';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
            $_arr_advertRow = $this->mdl_advert->mdl_read($_num_advertId);
            if ($_arr_advertRow['rcode'] != 'y080102') {
                $this->tplData['rcode'] = $_arr_advertRow['rcode'];
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }

            $_arr_posiRow                 = $this->mdl_posi->mdl_read($_arr_advertRow['advert_posi_id']);
            $_arr_advertRow['posiRow']    = $_arr_posiRow;

            if ($_arr_posiRow['posi_type'] == 'media' && $_arr_advertRow['advert_media_id'] > 0) {
                $_arr_advertRow['mediaRow'] = $this->mdl_media->mdl_read($_arr_advertRow['advert_media_id']);
            } else {
                $_arr_advertRow['mediaRow'] = $_arr_mediaRow;
            }
        } else {
            if (!isset($this->adminLogged['admin_allow']['advert']['add']) && !$this->is_super) {
                $this->tplData['rcode'] = 'x080302';
                $this->obj_tpl->tplDisplay('error', $this->tplData);
            }
            $_arr_advertRow = array(
                'advert_id'         => 0,
                'advert_name'       => '',
                'advert_posi_id'    => 0,
                'advert_media_id'   => 0,
                'advert_content'    => '',
                'advert_put_type'   => '',
                'advert_put_opt'    => '',
                'advert_begin'      => time(),
                'advert_percent'    => 0,
                'advert_url'        => '',
                'advert_note'       => '',
                'advert_status'     => $this->mdl_advert->arr_status[0],
                'mediaRow'          => $_arr_mediaRow,
            );
        }

        $_arr_search    = array(
            'status'    => 'enable'
        );
        $_arr_posiRows  = $this->mdl_posi->mdl_list(1000, 0, $_arr_search);
        if (count($_arr_posiRows) < 1) {
            $this->tplData['rcode'] = 'x080230';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        foreach ($_arr_posiRows as $key=>$value) {
            $_arr_posiJSON[$value['posi_id']] = $value;
            $_arr_posiJSON[$value['posi_id']]['percent_sum'] = $this->mdl_advert->mdl_sum($value['posi_id'], 'enable', true, array($_arr_advertRow['advert_id']));
        }

        //print_r($_arr_posiJSON);

        $_arr_tpl = array(
            'advertRow'  => $_arr_advertRow,
            'posiRows'   => $_arr_posiRows,
            'posiJSON'   => json_encode($_arr_posiJSON),
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('advert_form', $_arr_tplData);
    }


    /*============列出管理员界面============
    无返回
    */
    function ctrl_list() {
        if (!isset($this->adminLogged['admin_allow']['advert']['browse']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x080301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_search = array(
            'key'        => fn_getSafe(fn_get('key'), 'txt', ''),
            'posi_id'    => fn_getSafe(fn_get('posi_id'), 'int', 0),
            'status'     => fn_getSafe(fn_get('status'), 'txt', ''),
        );

        $_num_advertCount = $this->mdl_advert->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_advertCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_advertRows  = $this->mdl_advert->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page['except'], $_arr_search);

        $_arr_searchPosi    = array(
            'status'    => 'enable'
        );
        $_arr_posiRows    = $this->mdl_posi->mdl_list(1000, 0, $_arr_searchPosi);

        foreach ($_arr_advertRows as $_key=>$_value) {
            $_arr_advertRows[$_key]['posiRow'] = $this->mdl_posi->mdl_read($_value['advert_posi_id']);
        }

        $_arr_tpl = array(
            'query'      => $_str_query,
            'pageRow'    => $_arr_page,
            'search'     => $_arr_search,
            'advertRows' => $_arr_advertRows,
            'posiRows'   => $_arr_posiRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('advert_list', $_arr_tplData);
    }
}
