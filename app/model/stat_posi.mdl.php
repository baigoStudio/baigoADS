<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Func;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

/*-------------应用归属-------------*/
class Stat_Posi extends Model {

    function check($mix_stat, $str_by = 'stat_id', $str_date = '') {
        $_arr_statSelect = array(
            'stat_id',
        );

        $_arr_where = $this->readQueryProcess($mix_stat, $str_by, $str_date);

        $_arr_statRow = $this->where($_arr_where)->find($_arr_statSelect);

        if (!$_arr_statRow) {
            return array(
                'rcode' => 'x090102', //不存在记录
            );
        }

        $_arr_statRow['rcode']   = 'y090102';

        //print_r($_arr_statRow);

        return $_arr_statRow;
    }


    function lists($num_no, $num_except = 0, $arr_search = array()) {
        $_arr_statSelect = array(
            'stat_posi_id',
            'stat_date',
            'stat_count_show',
            'stat_count_hit',
        );

        $_arr_where = $this->queryProcess($arr_search);

        $_arr_statRows = $this->where($_arr_where)->order('stat_id', 'DESC')->limit($num_except, $num_no)->select($_arr_statSelect);

        return $_arr_statRows;
    }


    function count($arr_search = array()) {

        $_arr_where = $this->queryProcess($arr_search);

        $_num_statCount = $this->where($_arr_where)->count(); //查询数据

        return $_num_statCount;
    }


    function readQueryProcess($mix_stat, $str_by = 'stat_id', $str_date = '') {
        $_arr_where[] = array($str_by, '=', $mix_stat);

        if (!Func::isEmpty($str_date)) {
            $_arr_where[] = array('stat_date', '=', $str_date);
        }

        return $_arr_where;
    }


    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['posi_id']) && $arr_search['posi_id'] > 0) {
            $_arr_where[] = array('stat_posi_id', '=', $arr_search['posi_id']);
        }

        if (isset($arr_search['year']) && $arr_search['year']) {
            $_arr_where[] = array('DATE_FORMAT(`stat_date`, \'%Y\')', '=', $arr_search['year'], 'year');
        }

        if (isset($arr_search['month']) && $arr_search['month']) {
            $_arr_where[] = array('DATE_FORMAT(`stat_date`, \'%m\')', '=', $arr_search['month'], 'month');
        }

        return $_arr_where;
    }
}
