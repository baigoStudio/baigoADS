<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\index;

use app\model\Stat_Posi as Stat_Posi_Base;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------应用归属-------------*/
class Stat_Posi extends Stat_Posi_Base {

    /** 提交
     * mdl_submit function.
     *
     * @access public
     * @param mixed $num_userId
     * @param mixed $num_appId
     * @return void
     */
    function submit($num_posiId, $is_hit = false) {
        $_arr_statData = array(
            'stat_count_show'    => 1,
            'stat_count_hit'     => 1,
        );

        $_arr_statRow = $this->check($num_posiId, 'stat_posi_id', date('Y-m-d'));

        if ($_arr_statRow['rcode'] != 'y090102') {
            $_arr_statData['stat_posi_id'] = $num_posiId;
            $_arr_statData['stat_date']      = date('Y-m-d');

            $_num_statId = $this->insert($_arr_statData);

            if ($_num_statId > 0) { //数据库插入是否成功
                $_str_rcode = 'y090101';
            } else {
                return array(
                    'rcode' => 'x090101',
                );
            }
        } else {
            if ($is_hit) {
                $_arr_statData = array(
                    'stat_count_hit'   => '`stat_count_hit`+1',
                );
            } else {
                $_arr_statData = array(
                    'stat_count_show'  => '`stat_count_show`+1',
                );
            }

            $_num_count = $this->where('stat_id', '=', $_arr_statRow['stat_id'])->update( $_arr_statData);

            if ($_num_count > 0) { //数据库插入是否成功
                $_str_rcode = 'y090103';
            } else {
                return array(
                    'rcode' => 'x090103',
                );
            }
        }

        return array(
            'rcode'  => $_str_rcode,
        );
    }
}
