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
class CONTROL_ADVERT_UI_ADVERT {

    function __construct() { //构造函数
        $this->general_advert   = new GENERAL_ADVERT();
        $this->obj_tpl      = $this->general_advert->obj_tpl;

        $this->mdl_advert   = new MODEL_ADVERT(); //设置管理员模型
        $this->mdl_posi     = new MODEL_POSI();
        $this->mdl_stat     = new MODEL_STAT();
    }


    function ctrl_url() {
        $_num_advertId  = fn_getSafe(fn_get('advert_id'), 'int', 0);

        if ($_num_advertId < 1) {
            $_arr_tplData = array(
                'rcode' => 'x080228',
            );
            $this->obj_tpl->tplDisplay('error', $_arr_tplData);
        }

        $_arr_advertRow = $this->mdl_advert->mdl_read($_num_advertId);

        if ($_arr_advertRow['rcode'] != 'y080102') {
            $this->obj_tpl->tplDisplay('error', $_arr_advertRow);
        }

        if ($_arr_advertRow['advert_status'] != 'enable') {
            $_arr_tplData = array(
                'rcode' => 'x080229',
            );
            $this->obj_tpl->tplDisplay('error', $_arr_tplData);
        }

        if (($_arr_advertRow['advert_put_type'] == 'date' && $_arr_advertRow['advert_put_opt'] < time()) || ($_arr_advertRow['advert_put_type'] == 'show' && $_arr_advertRow['advert_put_opt'] < $_arr_advertRow['advert_count_show']) || ($_arr_advertRow['advert_put_type'] == 'hit' && $_arr_advertRow['advert_put_opt'] < $_arr_advertRow['advert_count_hit'])) {
            $str_rcode = 'x080229';
            $_arr_tplData = array(
                'rcode' => 'x080229',
            );
            $this->obj_tpl->tplDisplay('error', $_arr_tplData);
        }

        $this->mdl_advert->mdl_stat($_num_advertId, true);
        $this->mdl_stat->mdl_stat('posi', $_arr_advertRow['advert_posi_id'], true);
        $this->mdl_stat->mdl_stat('advert', $_num_advertId, true);

        $_arr_pluginReturn = $GLOBALS['obj_plugin']->trigger('filter_pub_advert_url', $_arr_tplData); //编辑广告时触发
        if (isset($_arr_pluginReturn['filter_pub_advert_url'])) {
            $_arr_advertRow    = $_arr_pluginReturn['filter_pub_advert_url'];
        }

        header('Location: ' . fn_htmlcode($_arr_advertRow['advert_url'], 'decode', 'url'));
    }
}
