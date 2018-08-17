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
            'attach',
            'admin',
            'link',
            'opt',
            'plugin',
            'profile',
            'pm',
            'login',
            'forgot',
            'captcha'
        ),
        'request' => array(
            'advert',
            'posi',
            'attach',
            'admin',
            'link',
            'opt',
            'plugin',
            'profile',
            'pm',
            'login',
            'forgot',
            'captcha',
            'token'
        ),
    ),
    'advert' => array(
        'request' => array(
            'advert',
        ),
        'ui' => array(
            'advert',
        ),
    ),
    'api' => array(
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
