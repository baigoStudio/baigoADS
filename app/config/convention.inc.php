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
  'var_extra' => array(
    'base' => array( //设置默认值
      'site_name'         => 'baigo ADS',
      'site_date'         => 'Y-m-d',
      'site_date_short'   => 'm-d',
      'site_time'         => 'H:i:s',
      'site_time_short'   => 'H:i',
      'site_timezone'     => 'Asia/Shanghai',
      'site_tpl'          => 'default',
    ),
  ),
);
