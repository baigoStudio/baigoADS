<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

return array(
    'sync' => array(
        'title' => '同步登录',
        'list'  => array(
            'sync' => array(
                'label'      => '同步登录',
                'type'       => 'radio',
                'min'        => 1,
                'default'    => 'off',
                'option' => array(
                    'on'    => array(
                        'value'    => '开启'
                    ),
                    'off'   => array(
                        'value'    => '关闭'
                    ),
                ),
            ),
        ),
    ),
);

