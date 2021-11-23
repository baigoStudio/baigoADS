<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿编辑
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*----------后台管理模块----------*/
return array(
  'advert' => array(
    'main' => array(
      'title'  => 'Advertisement',
      'ctrl'   => 'advert',
      'icon'   => 'ad',
    ),
    'lists' => array(
      'index' => array(
        'title' => 'Advertisement list',
        'ctrl'  => 'advert',
        'act'   => 'index',
      ),
      'form' => array(
        'title' => 'Add Ad',
        'ctrl'  => 'advert',
        'act'   => 'form',
      ),
    ),
    'allow' => array(
      'browse'    => 'Browse',
      'add'       => 'Add',
      'edit'      => 'Edit',
      'delete'    => 'Delete',
    ),
  ),
  'attach' => array(
    'main' => array(
      'title'  => 'Image',
      'ctrl'   => 'attach',
      'icon'   => 'paperclip',
    ),
    'allow' => array(
      'browse'    => 'Browse',
      'add'       => 'Upload',
      'delete'    => 'Delete',
    ),
  ),
  'posi' => array(
    'main' => array(
      'title'  => 'Ad position',
      'ctrl'   => 'posi',
      'icon'   => 'flag',
    ),
    'lists' => array(
      'index' => array(
        'title' => 'Position list',
        'ctrl'  => 'posi',
        'act'   => 'index',
      ),
      'form'      => array(
        'title' => 'Add',
        'ctrl'  => 'posi',
        'act'   => 'form',
      ),
    ),
    'allow' => array(
      'browse' => 'Browse',
      'add'    => 'Add',
      'edit'   => 'Edit',
      'del'    => 'Delete',
      'stat'   => 'Statistics',
    ),
  ),
  'admin' => array(
    'main' => array(
      'title'  => 'Administrator',
      'ctrl'   => 'admin',
      'icon'   => 'user-lock',
    ),
    'lists' => array(
      'index' => array(
        'title' => 'Administrator list',
        'ctrl'  => 'admin',
        'act'   => 'index',
      ),
      'form' => array(
        'title' => 'Add',
        'ctrl'  => 'admin',
        'act'   => 'form',
      ),
      'auth' => array(
        'title' => 'Authorization',
        'ctrl'  => 'auth',
        'act'   => 'form',
      ),
    ),
    'allow' => array(
      'browse'    => 'Browse',
      'add'       => 'Add',
      'edit'      => 'Edit',
      'delete'    => 'Delete',
    ),
  ),
  'link' => array(
    'main' => array(
      'title'  => 'Link',
      'ctrl'   => 'link',
      'icon'   => 'link',
    ),
    'lists' => array(
      'index' => array(
        'title' => 'Link management',
        'ctrl'  => 'link',
        'act'   => 'index',
      ),
    ),
    'allow' => array(
      'browse'    => 'Browse',
      'add'       => 'Add',
      'edit'      => 'Edit',
      'delete'    => 'Delete',
    ),
  ),
  'plugin' => array(
    'main' => array(
      'title' => 'Plugin',
      'ctrl'  => 'plugin',
      'icon'  => 'puzzle-piece',
    ),
    'lists' => array(
      'index' => array(
        'title' => 'Plugin management',
        'ctrl'  => 'plugin',
        'act'   => 'index',
      ),
    ),
    'allow' => array(
      'browse'    => 'Browse',
      'install'   => 'Install',
      'edit'      => 'Edit',
      'option'    => 'Option',
      'uninstall' => 'Uninstall',
    ),
  ),
);
