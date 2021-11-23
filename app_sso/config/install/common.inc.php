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
  'index'     => array(
    'index'     => 'PHP Extensions',
    'dbconfig'  => 'Database settings',
    'data'      => 'Create data',
    'admin'     => 'Add administrator',
    'over'      => 'Complete installation',
  ),
  'upgrade'   => array(
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
          'App',
          'App_Belong',
          'Combine',
          'Combine_Belong',
          'Pm',
          'User',
          'Verify',
        ),
      ),
      'view' => array(
        'title' => 'Create view',
        'lists' => array(
          'App_Combine_View',
          'User_App_View',
        ),
      ),
    ),
    'upgrade' => array(
      'table' => array(
        'title' => 'Create table',
        'lists' => array(
          'App_Belong',
          'Combine',
          'Combine_Belong',
          'Pm',
          'Verify',
        ),
      ),
      'alter' => array(
        'title' => 'Update table',
        'lists' => array(
          'Admin',
          'App',
          'App_Belong',
          'User',
          'Verify',
        ),
      ),
      'view' => array(
        'title' => 'Create view',
        'lists' => array(
          'App_Combine_View',
          'User_App_View',
        ),
      ),
    ),
  ),
);
