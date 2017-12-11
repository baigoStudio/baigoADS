<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿编辑
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*----------后台管理模块----------*/
return array(
    'advert' => array(
        'main' => array(
            'title'  => '广告管理',
            'icon'   => 'grain',
        ),
        'sub' => array(
            'list' => '所有广告',
            'form' => '投放广告',
        ),
        'allow' => array(
            'browse'     => '浏览',
            'add'        => '创建',
            'edit'       => '编辑',
            'del'        => '删除',
            'approve'    => '审核',
            'stat'       => '统计',
        ),
    ),
    'media' => array(
        'main' => array(
            'title'  => '图片管理',
            'icon'   => 'picture',
        ),
        'sub' => array(
            'list' => '所有图片',
        ),
        'allow' => array(
            'browse'     => '浏览',
            'upload'     => '上传',
            'del'        => '删除',
        ),
    ),
    'posi' => array(
        'main' => array(
            'title'  => '广告位管理',
            'icon'   => 'flag',
        ),
        'sub' => array(
            'list' => '所有广告位',
            'form' => '创建广告位',
        ),
        'allow' => array(
            'browse' => '浏览',
            'add'    => '创建',
            'edit'   => '编辑',
            'del'    => '删除',
            'stat'   => '统计',
        ),
    ),
    'admin' => array(
        'main' => array(
            'title'  => '管理员',
            'icon'   => 'user',
        ),
        'sub' => array(
            'list' => '所有管理员',
            'form' => '创建管理员',
            'auth' => '授权为管理员',
        ),
        'allow' => array(
            'browse' => '浏览',
            'add'    => '创建',
            'edit'   => '编辑',
            'del'    => '删除',
        ),
    ),
    'link' => array(
        'main' => array(
            'title'  => '链接',
            'icon'   => 'link',
        ),
        'sub' => array(
            'list' => '链接管理',
        ),
        'allow' => array(
            'browse' => '浏览',
            'add'    => '创建',
            'edit'   => '编辑',
            'del'    => '删除',
        ),
    ),
);
