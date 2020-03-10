<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Stat_Posi as Stat_Posi_Base;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

/*-------------应用归属-------------*/
class Stat_Posi extends Stat_Posi_Base {

    function statYear($arr_search) {
        $_arr_yearRows = $this->year($arr_search);

        foreach ($_arr_yearRows as $_key=>$_value) {
            $_arr_search = array(
                'posi_id' => $arr_search['posi_id'],
                'year'      => $_value['stat_year'],
                'type'      => 'show',
            );
            $_arr_yearRows[$_key]['stat_count_show'] = $this->sum($_arr_search);
            $_arr_search['type'] = 'hit';
            $_arr_yearRows[$_key]['stat_count_hit']  = $this->sum($_arr_search);
        }

        return $_arr_yearRows;
    }


    function year($arr_search) {
        $_arr_statSelect = array(
            'DISTINCT DATE_FORMAT(`stat_date`, \'%Y\') AS `stat_year`',
        );

        unset($arr_search['year'], $arr_search['month']);

        $_arr_where   = $this->queryProcess($arr_search);

        $_arr_yearRows = $this->where($_arr_where)->order('stat_date', 'DESC')->limit(100)->select($_arr_statSelect);

        return $_arr_yearRows;
    }


    function statMonth($arr_search) {
        $_arr_monthRows = $this->month($arr_search);

        foreach ($_arr_monthRows as $_key=>$_value) {
            $_arr_search = array(
                'posi_id' => $arr_search['posi_id'],
                'year'      => $arr_search['year'],
                'month'     => $_value['stat_month'],
                'type'      => 'show',
            );
            $_arr_monthRows[$_key]['stat_count_show'] = $this->sum($_arr_search);
            $_arr_search['type'] = 'hit';
            $_arr_monthRows[$_key]['stat_count_hit']  = $this->sum($_arr_search);
        }

        return $_arr_monthRows;
    }


    function month($arr_search) {
        $_arr_statSelect = array(
            'DISTINCT DATE_FORMAT(`stat_date`, \'%m\') AS `stat_month`',
        );

        unset($arr_search['month']);

        $_arr_where   = $this->queryProcess($arr_search);

        $_arr_monthRows = $this->where($_arr_where)->order('stat_date', 'DESC')->limit(100)->select($_arr_statSelect);

        return $_arr_monthRows;
    }


    function day($arr_search) {
        $_arr_statSelect = array(
            'stat_count_show',
            'stat_count_hit',
            'DATE_FORMAT(`stat_date`, \'%d\') AS `stat_day`',
        );

        $_arr_where   = $this->queryProcess($arr_search);

        //print_r($_arr_where);

        $_arr_dayRows = $this->where($_arr_where)->order('stat_date', 'DESC')->limit(100)->select($_arr_statSelect);

        return $_arr_dayRows;
    }


    function sum($arr_search) {
        if (isset($arr_search['type']) && $arr_search['type'] == 'show') {
            $_str_sum = 'stat_count_show';
        } else {
            $_str_sum = 'stat_count_hit';
        }

        $_arr_where   = $this->queryProcess($arr_search);

        $_num_percentSum = $this->where($_arr_where)->sum($_str_sum);

        return $_num_percentSum;
    }
}
