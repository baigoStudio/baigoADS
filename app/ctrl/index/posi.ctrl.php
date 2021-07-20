<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\index;

use app\classes\index\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

class Posi extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_statAdvert  = Loader::model('Stat_Advert');
        $this->mdl_statPosi    = Loader::model('Stat_Posi');

        $this->mdl_attach      = Loader::model('Attach');
        $this->mdl_advert      = Loader::model('Advert');
        $this->mdl_posi        = Loader::model('Posi');
    }

    function index() {
        $_num_posiId = 0;

        if (isset($this->param['id'])) {
            $_num_posiId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_posiId < 1) {
            return $this->fetchJsonp('Missing ID', 'x040202');
        }

        $_arr_posiRow = $this->mdl_posi->cache($_num_posiId);

        if (!isset($_arr_posiRow['rcode'])) {
            return $this->fetchJsonp('Missing rcode', 'x040102');
        }

        if ($_arr_posiRow['rcode'] != 'y040102') {
            return $this->fetchJsonp($_arr_posiRow['msg'], $_arr_posiRow['rcode']);
        }

        if ($_arr_posiRow['posi_status'] != 'enable') {
            return $this->fetchJsonp('Position is disabled', 'x040102');
        }

        unset($_arr_posiRow['posi_name'], $_arr_posiRow['posi_status'], $_arr_posiRow['posi_script'], $_arr_posiRow['posi_box_perfix'], $_arr_posiRow['posi_note'], $_arr_posiRow['posi_selector'], $_arr_posiRow['posi_box_attr'], $_arr_posiRow['posi_data_url']);

        $this->mdl_statPosi->submit($_num_posiId);

        $_arr_search = array(
            'posi_id'   => $_num_posiId,
            'status'    => 'enable',
            'is_enable' => true,
        );

        $_arr_adverts       = array();
        $_arr_advertRows    = $this->mdl_advert->lists(1000, $_arr_search); //列出

        if (Func::isEmpty($_arr_advertRows)) {
            $_arr_search = array(
                'posi_id'   => $_num_posiId,
                'status'    => 'enable',
                'type'      => 'backup',
            );
            $_arr_adverts = $this->mdl_advert->lists(1000, $_arr_search);
        } else {
            if ($_arr_posiRow['posi_is_percent'] == 'enable') {
                foreach ($_arr_advertRows as $_key=>$_value) {
                    $arr_adverts[$_value['advert_id']] = $_value['advert_percent'];
                }

                for ($_iii = 1; $_iii<=$_arr_posiRow['posi_count']; $_iii++) {
                    $arr_ids[] = $this->mdl_advert->listsRand($arr_adverts); //根据概率获取广告id
                }

                foreach ($arr_ids as $_key=>$_value) {
                    $_arr_adverts[$_key] = $this->mdl_advert->read($_value);
                }
            } else {
                $_arr_adverts = $_arr_advertRows;
            }
        }

        foreach ($_arr_adverts as $_key=>$_value) {
            $this->mdl_advert->stat($_value['advert_id']);
            $this->mdl_statAdvert->submit($_value['advert_id']);

            $_arr_attachRow = $this->mdl_attach->read($_value['advert_attach_id']);
            unset($_arr_attachRow['attach_time'], $_arr_attachRow['attach_box'], $_arr_attachRow['attach_path'], $_arr_attachRow['attach_admin_id']);

            unset($_arr_adverts[$_key]['advert_count_show'], $_arr_adverts[$_key]['advert_count_hit'], $_arr_adverts[$_key]['advert_put_type'], $_arr_adverts[$_key]['advert_put_opt'], $_arr_adverts[$_key]['advert_url'], $_arr_adverts[$_key]['advert_percent'], $_arr_adverts[$_key]['advert_status'], $_arr_adverts[$_key]['advert_begin'], $_arr_adverts[$_key]['advert_note'], $_arr_adverts[$_key]['advert_time'], $_arr_adverts[$_key]['advert_admin_id'], $_arr_adverts[$_key]['advert_approve_id'], $_arr_adverts[$_key]['advert_posi_id']);

            $_arr_adverts[$_key]['attachRow'] = $_arr_attachRow;
        }

        $_arr_tplData = array(
            'posiRow'       => $_arr_posiRow,
            'advertRows'    => $_arr_adverts,
        );

        return $this->jsonp($_arr_tplData);
    }
}
