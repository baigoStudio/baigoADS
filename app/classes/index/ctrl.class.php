<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\classes\index;

use app\classes\Ctrl as Ctrl_Base;
use ginkgo\Plugin;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}


/*-------------控制中心通用控制器-------------*/
abstract class Ctrl extends Ctrl_Base {

    protected function c_init($param = array()) { //构造函数
        parent::c_init();

        Plugin::listen('action_pub_init'); //管理后台初始化时触发

        $this->obj_view->setPath(BG_TPL_INDEX . $this->configBase['site_tpl']);
    }
}
