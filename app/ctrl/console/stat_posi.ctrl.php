<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;


//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

/*-------------用户类-------------*/
class Stat_Posi extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_posi      = Loader::model('Posi');
        $this->mdl_stat      = Loader::model('Stat_Posi');
    }


    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->adminAllow['posi']['stat']) && !$this->isSuper) {
            return $this->error('You do not have permission', 'x040305');
        }


        $_arr_search = array(
            'posi_id' => $this->posiRow['posi_id'],
        );

        $_arr_yearRows    = $this->mdl_stat->statYear($_arr_search);

        //print_r($_arr_yearRows);

        $_arr_tplData = array(
            'yearRows'   => $_arr_yearRows,
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_posiRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function month() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->adminAllow['posi']['stat']) && !$this->isSuper) {
            return $this->error('You do not have permission', 'x040305');
        }

        $_arr_searchParam = array(
            'year' => array('txt', date('Y')),
        );

        $_arr_search = $this->obj_request->param($_arr_searchParam);

        $_arr_search['posi_id'] = $this->posiRow['posi_id'];

        $_arr_monthRows = $this->mdl_stat->statMonth($_arr_search);
        $_arr_yearRows  = $this->mdl_stat->year($_arr_search);

        //print_r($_arr_monthRows);

        $_arr_tplData = array(
            'search'    => $_arr_search,
            'yearRows'  => $_arr_yearRows,
            'monthRows' => $_arr_monthRows,
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function day() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->adminAllow['posi']['stat']) && !$this->isSuper) {
            return $this->error('You do not have permission', 'x040305');
        }

        $_arr_searchParam = array(
            'year'  => array('txt', date('Y')),
            'month' => array('txt', date('m')),
        );

        $_arr_search = $this->obj_request->param($_arr_searchParam);

        $_arr_search['posi_id'] = $this->posiRow['posi_id'];

        $_arr_dayRows   = $this->mdl_stat->day($_arr_search);
        $_arr_monthRows = $this->mdl_stat->month($_arr_search);
        $_arr_yearRows  = $this->mdl_stat->year($_arr_search);

        //print_r($_arr_dayRows);

        $_arr_tplData = array(
            'search'    => $_arr_search,
            'yearRows'  => $_arr_yearRows,
            'monthRows' => $_arr_monthRows,
            'dayRows'   => $_arr_dayRows,
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    protected function init($chk_admin = true) {
        $_num_posiId = 0;

        if (isset($this->param['id'])) {
            $_num_posiId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_posiId < 1) {
            return array(
                'msg'   => 'Missing ID',
                'rcode' => 'x040202',
            );
        }

        $_arr_posiRow = $this->mdl_posi->read($_num_posiId);
        if ($_arr_posiRow['rcode'] != 'y040102') {
            return $_arr_posiRow;
        }

        $this->generalData['posiRow']    = $_arr_posiRow;

        $this->posiRow  = $_arr_posiRow;

        return parent::init();
    }
}
