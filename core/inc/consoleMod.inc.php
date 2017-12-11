<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿Edit
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*----------后台管理模块----------*/
return array(
    'advert' => array(
        'main' => array(
            'title'  => 'Advertisement',
            'mod'    => 'advert',
        ),
        'sub' => array(
            'list' => array(
                'title' => 'Advertisement',
                'mod'   => 'advert',
                'act'   => 'list',
            ),
            'form' => array(
                'title' => 'Advertise',
                'mod'   => 'advert',
                'act'   => 'form',
            ),
        ),
        'allow' => array(
            'browse'     => 'Browse',
            'add'        => 'Create',
            'edit'       => 'Edit',
            'del'        => 'Delete',
            'approve'    => 'Approve',
            'stat'       => 'Statistics',
        ),
    ),
    'media' => array(
        'main' => array(
            'title'  => 'Image',
            'mod'    => 'media',
        ),
        'sub' => array(
            'list' => array(
                'title'     => 'Image List',
                'mod'       => 'media',
                'act'   => 'list',
            ),
        ),
        'allow' => array(
            'browse'     => 'Browse',
            'upload'     => 'Upload',
            'del'        => 'Delete',
        ),
    ),
    'posi' => array(
        'main' => array(
            'title'  => 'Ad Position',
            'mod'    => 'posi',
        ),
        'sub' => array(
            'list' => array(
                'title'     => 'Position List',
                'mod'       => 'posi',
                'act'   => 'list',
            ),
            'form' => array(
                'title'     => 'Create',
                'mod'       => 'posi',
                'act'   => 'form',
            ),
        ),
        'allow' => array(
            'browse' => 'Browse',
            'add'    => 'Create',
            'edit'   => 'Edit',
            'del'    => 'Delete',
            'stat'   => 'Statistics',
        ),
    ),
    'admin' => array(
        'main' => array(
            'title'  => 'Administrator',
            'mod'    => 'admin',
        ),
        'sub' => array(
            'list' => array(
                'title'     => 'Administrator List',
                'mod'       => 'admin',
                'act'   => 'list',
            ),
            'form' => array(
                'title'     => 'Create',
                'mod'       => 'admin',
                'act'   => 'form',
            ),
            'auth' => array(
                'title'     => 'Authorization',
                'mod'       => 'admin',
                'act'   => 'auth',
            ),
        ),
        'allow' => array(
            'browse' => 'Browse',
            'add'    => 'Create',
            'edit'   => 'Edit',
            'del'    => 'Delete',
        ),
    ),
    'link' => array(
        'main' => array(
            'title'  => 'Link',
            'mod'    => 'link',
        ),
        'sub' => array(
            'list' => array(
                'title' => 'Link Management',
                'mod'   => 'link',
                'act'   => 'list',
            ),
        ),
        'allow' => array(
            'browse' => 'Browse',
            'add'    => 'Create',
            'edit'   => 'Edit',
            'del'    => 'Delete',
        ),
    ),
);
