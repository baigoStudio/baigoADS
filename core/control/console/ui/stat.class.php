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
class CONTROL_CONSOLE_UI_STAT {

    public $obj_tpl;
    public $mdl_stat;
    public $adminLogged;
    private $is_super = false;

    function __construct() { //构造函数
        $this->general_console    = new GENERAL_CONSOLE();
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl        = $this->general_console->obj_tpl;

        $this->mdl_stat       = new MODEL_STAT();
        $this->mdl_advert     = new MODEL_ADVERT(); //设置管理员模型
        $this->mdl_posi       = new MODEL_POSI();
        $this->mdl_media      = new MODEL_MEDIA();

        $this->tplData = array(
            'adminLogged' => $this->adminLogged
        );

        if ($this->adminLogged['admin_type'] == 'super') {
            $this->is_super = true;
        }
    }


    function ctrl_advert() {
        if (!isset($this->adminLogged['admin_allow']['advert']['stat']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x080305';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_search = array(
            'advert_id' => fn_getSafe(fn_get('advert_id'), 'int', 0),
            'target_id' => fn_getSafe(fn_get('advert_id'), 'int', 0),
            'type'      => fn_getSafe(fn_get('type'), 'txt', 'year'),
            'year'      => fn_getSafe(fn_get('year'), 'txt', ''),
            'month'     => fn_getSafe(fn_get('month'), 'txt', ''),
            'target'    => 'advert',
        );

        $_arr_advertRow = $this->mdl_advert->mdl_read($_arr_search['advert_id']);
        if ($_arr_advertRow['rcode'] != 'y080102') {
            $this->tplData['rcode'] = $_arr_advertRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_posiRow                 = $this->mdl_posi->mdl_read($_arr_advertRow['advert_posi_id']);
        $_arr_advertRow['posiRow']    = $_arr_posiRow;

        if ($_arr_posiRow['posi_type'] == 'media' && $_arr_advertRow['advert_media_id'] > 0) {
            $_arr_advertRow['mediaRow'] = $this->mdl_media->mdl_read($_arr_advertRow['advert_media_id']);
        }

        $_num_statCount   = $this->mdl_stat->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_statCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_yearRows    = $this->mdl_stat->mdl_year();
        $_arr_statRows    = $this->mdl_stat->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page['except'], $_arr_search);

        $_arr_tpl = array(
            'query'      => $_str_query,
            'pageRow'    => $_arr_page,
            'search'     => $_arr_search,
            'advertRow'  => $_arr_advertRow,
            'yearRows'   => $_arr_yearRows, //目录列表
            'statRows'   => $_arr_statRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('stat_advert', $_arr_tplData);
    }


    function ctrl_posi() {
        if (!isset($this->adminLogged['admin_allow']['posi']['stat']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x040305';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_search = array(
            'posi_id'   => fn_getSafe(fn_get('posi_id'), 'int', 0),
            'target_id' => fn_getSafe(fn_get('posi_id'), 'int', 0),
            'type'      => fn_getSafe(fn_get('type'), 'txt', 'year'),
            'year'      => fn_getSafe(fn_get('year'), 'txt', ''),
            'month'     => fn_getSafe(fn_get('month'), 'txt', ''),
            'target'    => 'posi',
        );

        $_arr_posiRow = $this->mdl_posi->mdl_read($_arr_search['posi_id']);
        if ($_arr_posiRow['rcode'] != 'y040102') {
            $this->tplData['rcode'] = $_arr_posiRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_statCount   = $this->mdl_stat->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_statCount); //取得分页数据
        $_str_query       = http_build_query($_arr_search);
        $_arr_yearRows    = $this->mdl_stat->mdl_year();
        $_arr_statRows    = $this->mdl_stat->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page['except'], $_arr_search);

        $_arr_tpl = array(
            'query'      => $_str_query,
            'pageRow'    => $_arr_page,
            'search'     => $_arr_search,
            'posiRow'    => $_arr_posiRow,
            'yearRows'   => $_arr_yearRows, //目录列表
            'statRows'   => $_arr_statRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('stat_posi', $_arr_tplData);
    }
}
