<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\index;

use app\model\Posi as Posi_Base;
use ginkgo\Func;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

/*-------------广告位类-------------*/
class Posi extends Posi_Base {


    function cache($num_posiId = 0) {
        $_arr_return = array(
            'rcode' => 'x040102'
        );

        if ($num_posiId > 0) {
            $_str_cacheName = 'posi_' . $num_posiId;
            if (!$this->obj_cache->check($_str_cacheName)) {
                $this->cacheProcess($num_posiId);
            }
        } else {
            $_str_cacheName = 'posi_lists';
            if (!$this->obj_cache->check($_str_cacheName)) {
                $this->cacheListsProcess();
            }
        }

        $_arr_return = $this->obj_cache->read($_str_cacheName);

        if (!$_arr_return) {
            $_arr_return = array(
                'rcode' => 'x040102'
            );
        }

        return $_arr_return;
    }
}
