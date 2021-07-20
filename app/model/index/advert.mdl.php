<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\index;

use app\model\Advert as Advert_Base;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------应用模型-------------*/
class Advert extends Advert_Base {

    protected $whereOr_1 = array(
        array('advert_type', '=', 'date', 'advert_type_date'),
        array('advert_opt', '>=', GK_NOW, 'now'),
    );

    protected $whereOr_2 = array(
        array('advert_type', '=', 'show', 'advert_type_show'),
        array('advert_count_show', '<=', '`advert_opt`'),
    );

    protected $whereOr_3 = array(
        array('advert_type', '=', 'hit', 'advert_type_hit'),
        array('advert_count_hit', '<=', '`advert_opt`'),
    );

    protected $whereOr_4 = array(
        array('advert_type', '=', 'none', 'advert_type_none'),
    );


    function stat($num_advertId, $is_hit = false) {
        if ($is_hit) {
            $_arr_advertData = array(
                'advert_count_hit'  => '`advert_count_hit`+1',
            );
        } else {
            $_arr_advertData = array(
                'advert_count_show'  => '`advert_count_show`+1',
            );
        }

        $_num_count = $this->where('advert_id', '=', $num_advertId)->update($_arr_advertData); //更新数据

        if ($_num_count > 0) {
            $_str_rcode = 'y080103'; //更新成功
        } else {
            return array(
                'rcode' => 'x080103', //更新失败
            );
        }

        return array(
            'advert_id'  => $num_advertId,
            'rcode'      => $_str_rcode, //成功
        );
    }


    function lists($limit = 1000, $arr_search = array()) {
        $_arr_advertSelect = array(
            'advert_id',
            'advert_name',
            'advert_posi_id',
            'advert_attach_id',
            'advert_count_show',
            'advert_count_hit',
            'advert_type',
            'advert_opt',
            'advert_url',
            'advert_percent',
            'advert_content',
            'advert_status',
            'advert_begin',
        );

        $_arr_where         = $this->queryProcess($arr_search);
        $_str_sql_1         = $this->where($_arr_where)->buildSql();
        $_str_sql_2         = $this->whereOr($this->whereOr_1)->whereOr($this->whereOr_2)->whereOr($this->whereOr_3)->whereOr($this->whereOr_4)->buildSql();

        $_arr_getData       = $this->where($_str_sql_1)->whereAnd($_str_sql_2)->order('advert_id', 'DESC')->limit($limit)->select($_arr_advertSelect); //查询数据

        foreach ($_arr_getData as $_key=>&$_value) {
            $_value = $this->rowProcess($_value);
        }

        return $_arr_getData;
    }
}
