<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿编辑
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

return array(
    'console' => array(
        'ui' => array(
            'advert',
            'posi',
            'stat',
            'media',
            'admin',
            'link',
            'opt',
            'profile',
            'pm',
            'login',
            'forgot',
            'seccode'
        ),
        'request' => array(
            'advert',
            'posi',
            'media',
            'admin',
            'link',
            'opt',
            'profile',
            'pm',
            'login',
            'forgot',
            'seccode',
            'token'
        ),
    ),
    'advert' => array(
        'ui' => array(
            'advert',
        ),
    ),
    'api' => array(
        'api' => array(
            'advert',
        ),
        'sso' => array(
            'notify',
            'sync',
        ),
    ),
    'install' => array(
        'ui' => array(
            'setup',
            'upgrade',
        ),
        'request' => array(
            'setup',
            'upgrade',
        ),
    ),
    'help' => array(
        'ui' => array(
            'help',
        ),
    ),
);
