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
  'base' => array(
    'title' => 'Base settings',
    'lists' => array(
      'site_name' => array(
        'title'      => 'Site name',
        'type'       => 'str',
        'format'     => 'text',
        'require'    => 'true',
      ),
      'site_date' => array(
        'title'      => 'Date format',
        'type'       => 'select_input',
        'note'       => 'Select or type the format parameter of the <code>date</code> function',
        'require'    => 'true',
        'date_param' => 'true',
        'option'     => array(
          'Y-m-d'     => '{:Y-m-d}',
          'y-m-d'     => '{:y-m-d}',
          'M. d, Y'   => '{:M. d, Y}',
        ),
      ),
      'site_date_short' => array(
        'title'      => 'Short date format',
        'type'       => 'select_input',
        'require'    => 'true',
        'note'       => 'Select or type the format parameter of the <code>date</code> function',
        'date_param' => 'true',
        'option'     => array(
          'm-d'    => '{:m-d}',
          'M. d'   => '{:M. d}',
        ),
      ),
      'site_time' => array(
        'title'      => 'Time format',
        'type'       => 'select_input',
        'require'    => 'true',
        'note'       => 'Select or type the format parameter of the <code>date</code> function',
        'date_param' => 'true',
        'option'     => array(
          'H:i:s'     => '{:H:i:s}',
          'h:i:s A'   => '{:h:i:s A}',
        ),
      ),
      'site_time_short' => array(
        'title'      => 'Short time format',
        'type'       => 'select_input',
        'require'    => 'true',
        'note'       => 'Select or type the format parameter of the <code>date</code> function',
        'date_param' => 'true',
        'option'     => array(
          'H:i'    => '{:H:i}',
          'h:i A'  => '{:h:i A}',
        ),
      ),
    ),
  ),
  'upload' => array(
    'title' => 'Upload settings',
  ),
  'sso' => array(
    'title' => 'SSO Settings',
    'lists' => array(
      'base_url' => array(
        'title'     => 'Base url',
        'type'      => 'str',
        'format'    => 'url',
        'require'   => 'true',
      ),
      'app_id' => array(
        'title'     => 'APP ID',
        'type'      => 'str',
        'format'    => 'int',
        'require'   => 'true',
      ),
      'app_key' => array(
        'title'     => 'APP KEY',
        'type'      => 'str',
        'format'    => 'text',
        'require'   => 'true',
      ),
      'app_secret' => array(
        'title'     => 'APP SECRET',
        'type'      => 'str',
        'format'    => 'text',
        'require'   => 'true',
      ),
    ),
  ),
  'dbconfig' => array(
    'title' => 'Database settings',
  ),
  'chkver' => array(
    'title' => 'Check for updates',
  ),
);
