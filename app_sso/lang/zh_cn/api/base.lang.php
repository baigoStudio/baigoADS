<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

// 不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------------------通用-------------------------*/
return array(
    'read'  => '已读',
    'wait'  => '未读',
    'out'   => '已发送',
    'in'    => '收件箱',
);
