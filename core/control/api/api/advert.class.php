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
class CONTROL_API_API_ADVERT {

    function __construct() { //构造函数
        $this->general_api      = new GENERAL_API();

        $this->mdl_advert = new MODEL_ADVERT(); //设置管理员模型
        $this->mdl_posi   = new MODEL_POSI();
        $this->mdl_media  = new MODEL_MEDIA();
        $this->mdl_stat   = new MODEL_STAT();
    }


    function ctrl_list() {
        $_num_posiId    = fn_getSafe(fn_get('posi_id'), 'int', 0);

        if ($_num_posiId < 1) {
            $_arr_return = array(
                'rcode'     => 'x040206',
            );
            $this->general_api->show_result($_arr_return);
        }

        $_arr_posiRow = $this->mdl_posi->mdl_cache($_num_posiId);
        if ($_arr_posiRow['rcode'] != 'y040102') {
            $this->general_api->show_result($_arr_posiRow);
        }

        $this->mdl_stat->mdl_stat('posi', $_num_posiId);

        $_arr_adverts     = array();
        $_arr_advertRows  = $this->mdl_advert->mdl_listPub($_num_posiId);

        if (fn_isEmpty($_arr_advertRows)) {
            $_arr_adverts = $this->mdl_advert->mdl_listPub($_num_posiId, 'subs');
        } else {
            if ($_arr_posiRow['posi_is_percent'] == 'enable') {
                foreach ($_arr_advertRows as $_key=>$_value) {
                    $arr_adverts[$_value['advert_id']] = $_value['advert_percent'];
                }

                for ($_iii = 1; $_iii<=$_arr_posiRow['posi_count']; $_iii++) {
                    $arr_ids[] = $this->mdl_advert->get_rand($arr_adverts); //根据概率获取奖项id
                }

                foreach ($arr_ids as $_key=>$_value) {
                    $_arr_adverts[$_key] = $this->mdl_advert->mdl_read($_value);
                }
            } else {
                $_arr_adverts = $_arr_advertRows;
            }
        }

        foreach ($_arr_adverts as $_key=>$_value) {
            $this->mdl_advert->mdl_stat($_value['advert_id']);
            $this->mdl_stat->mdl_stat('advert', $_value['advert_id']);

            $_arr_mediaRow = $this->mdl_media->mdl_read($_value['advert_media_id']);
            unset($_arr_mediaRow['media_time'], $_arr_mediaRow['media_box'], $_arr_mediaRow['media_path'], $_arr_adverts[$_key]['advert_count_show'], $_arr_adverts[$_key]['advert_count_hit'], $_arr_adverts[$_key]['advert_put_type'], $_arr_adverts[$_key]['advert_put_opt'], $_arr_adverts[$_key]['advert_url'], $_arr_adverts[$_key]['advert_percent'], $_arr_adverts[$_key]['advert_status'], $_arr_adverts[$_key]['advert_begin'], $_arr_adverts[$_key]['advert_note'], $_arr_adverts[$_key]['advert_time'], $_arr_adverts[$_key]['advert_admin_id'], $_arr_adverts[$_key]['advert_approve_id'], $_arr_adverts[$_key]['advert_approve_id']);

            $_arr_adverts[$_key]['mediaRow'] = $_arr_mediaRow;
        }

        //print_r($_arr_adverts);

        $_arr_tplData = array(
            'posiRow'    => $_arr_posiRow,
            'advertRows' => $_arr_adverts,
        );

        $this->show_result($_arr_tplData);
    }


    function show_result($arr_re) {
        $_str_callback  = fn_getSafe(fn_get('callback'), 'txt', 'f');
        $_str_return    = json_encode($arr_re);
        $_str_return    = $_str_callback . '(' . $_str_return . ')';

        exit($_str_return); //输出错误信息
    }
}
