<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/
namespace app\model;

use ginkgo\Loader;
use ginkgo\Request;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------短消息模型-------------*/
class Pm {
    protected $obj_request;

    function __construct() { //构造函数
        $this->obj_request  = Request::instance();
        $this->vld_pm       = Loader::validate('Pm');
    }

}
