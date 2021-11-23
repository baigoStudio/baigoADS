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
  'count_lists' => array(
    'advert'     => array(
      'title'  => 'Advertisement',
      'lists'  => array(
        'total'  => true,
        'status' => true,
      ),
    ),
    'posi' => array(
      'title'  => 'Ad position',
      'lists'  => array(
        'total'  => true,
        'status' => true,
      ),
    ),
    'attach'  => array(
      'title'  => 'Image',
      'lists'  => array(
        'total'  => array('box', 'normal'),
      ),
    ),
    'admin'   => array(
      'title'  => 'Administrator',
      'lists'  => array(
        'total'  => true,
        'status' => true,
        'type'   => true,
      ),
    ),
    'link'    => array(
      'title'  => 'Link',
      'lists'  => array(
        'total'  => true,
        'status' => true,
      ),
    ),
  ),
);
