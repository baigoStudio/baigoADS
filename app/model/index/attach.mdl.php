<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\index;

use app\model\Attach as Attach_Base;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------栏目模型-------------*/
class Attach extends Attach_Base {

    function __construct() { //构造函数
        parent::__construct();
    }


    function url($num_attachId) {
        $_arr_return    = array();
        $_arr_attachRow = parent::read($num_attachId);

        if ($_arr_attachRow['rcode'] == 'y070102') {
            if ($_arr_attachRow['attach_box'] != 'normal') {
                $_arr_return = array(
                    'rcode' => 'x070102',
                );
            } else {
                $_arr_return['attach_url'] = $_arr_attachRow['attach_url'];
            }
        } else {
            $_arr_return = $_arr_attachRow;
        }

        return $_arr_return;
    }
}
