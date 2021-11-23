<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

return array(
  'session' => array(
    'expire'    => 20 * GK_MINUTE,
    'remember'  => 30 * GK_DAY,
  ),
  'token_reload'  => 1 * GK_MINUTE * 1000, //分 * 毫秒
  'opt_extra' => array(),
);
