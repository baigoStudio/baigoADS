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
    'base' => array(
        'title'   => '基本设置',
        'list'    => array(
            'BG_SITE_NAME' => array(
                'label'      => '名称',
            ),
            'BG_SITE_DOMAIN' => array(
                'label'      => '域名',
            ),
            'BG_SITE_URL' => array(
                'label'      => '首页 URL ',
                'note'       => '末尾请勿加 /',
            ),
            'BG_SITE_PERPAGE' => array(
                'label'      => '每页显示数',
            ),
            'BG_SITE_DATE' => array(
                'label'  => '日期格式',
            ),
            'BG_SITE_DATESHORT' => array(
                'label'  => '短日期格式',
            ),
            'BG_SITE_TIME' => array(
                'label'  => '时间格式',
            ),
            'BG_SITE_TIMESHORT' => array(
                'label'  => '短时间格式',
            ),
        ),
    ),
    'upload' => array(
        'title'   => '上传设置',
        'list'    => array(
            'BG_UPLOAD_SIZE' => array(
                'label'      => '允许上传大小',
                'note'       => '单位请查看下一项',
            ),
            'BG_UPLOAD_UNIT' => array(
                'label'      => '允许上传单位',
            ),
            'BG_UPLOAD_COUNT' => array(
                'label'      => '允许同时上传数',
            ),
        ),
    ),
    'sso' => array(
        'title'   => 'SSO 设置',
        'list'    => array(
            'BG_SSO_URL' => array(
                'label'      => 'API 接口 URL',
                'note'       => '必须以 http:// 开始', //跳转至
            ),
            'BG_SSO_APPID' => array(
                'label'      => 'APP ID',
            ),
            'BG_SSO_APPKEY' => array(
                'label'      => 'APP KEY 通信密钥',
            ),
            'BG_SSO_APPSECRET' => array(
                'label' => 'APP SECRET 密文密钥',
            ),
            'BG_SSO_SYNC' => array(
                'label'      => '同步登录',
            ),
        ),
    ),
);

