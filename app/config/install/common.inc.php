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
  'index' => array(
    'index'     => 'PHP Extensions',
    'type'      => 'Installation type',
    'dbconfig'  => 'Database settings',
    'data'      => 'Create data',
    'admin'     => 'Add administrator',
    'over'      => 'Complete installation',
  ),
  'upgrade' => array(
    'index'     => 'PHP Extensions',
    'data'      => 'Update data',
    'admin'     => 'Add administrator',
    'over'      => 'Complete upgrade',
  ),
  'data' => array(
    'index' => array(
      'table' => array(
        'title' => 'Create table',
        'lists' => array(
          'Admin',
          'Advert',
          'Attach',
          'Link',
          'Posi',
          'Stat_Advert',
          'Stat_Posi',
        ),
      ),
      'index' => array(
        'title' => 'Create index',
        'lists' => array(
          'Link',
        ),
      ),
    ),
    'upgrade' => array(
      'table' => array(
        'title' => 'Create table',
        'lists' => array(
          'Link',
          'Stat_Advert',
          'Stat_Posi',
        ),
      ),
      'rename' => array(
        'title' => 'Rename table',
        'lists' => array(
          'Attach',
        ),
      ),
      'alter' => array(
        'title' => 'Update table',
        'lists' => array(
          'Admin',
          'Advert',
          'Attach',
          'Posi',
        ),
      ),
      'index' => array(
        'title' => 'Create index',
        'lists' => array(
          'Link',
        ),
      ),
    ),
  ),
);
