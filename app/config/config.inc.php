<?php return array(
    'var_default' => array(
        'site_name' => 'baigo ADS',
    ),
    'module' => array(
        'ftp'       => true,
    ),
    'tpl' => array(
        'path'      => 'default',
    ),
    'session' => array(
        'autostart'     => true,
        'name'          => 'baigoADSssinID',
        'prefix'        => 'baigo.ads',
    ),
    'cookie' => array(
        'prefix'    => 'baigo_ads_', // cookie 名称前缀
    ),
    'route' => array(
        'default_mod'   => '',
        'default_ctrl'  => '',
        'default_act'   => '',
        'route_rule'    => array(
            'console/opt/base'  => 'console/opt/form',
            'console/opt/sso'   => 'console/opt/form',
            array('posi/:id', 'index/posi/index'),
            array('advert/:id', 'index/advert/index'),
        ),
    ),
    'config_extra' => array(
        'base'  => true,
        'sso'   => true,
    ),
    'var_extra' => array(
        'base' => array( //设置默认值
            'site_name'         => 'baigo ADS',
            'site_date'         => 'Y-m-d',
            'site_date_short'   => 'm-d',
            'site_time'         => 'H:i:s',
            'site_time_short'   => 'H:i',
            'site_timezone'     => 'Asia/Shanghai',
            'site_tpl'          => 'default',
        ),
        'sso' => array(
            'app_id'        => 1,
            'app_key'       => '',
            'app_secret'    => '',
            'base_url'      => '',
            'sso_sync'      => 'on',
        ),
        'upload' => array(
            'ftp_host' => '',
            'ftp_port' => 21,
            'ftp_user' => '',
            'ftp_pass' => '',
            'ftp_path' => '',
            'ftp_pasv' => 'off',
        ),
    ),
    'ui_ctrl' => array(
        'copyright'             => 'on',
        'update_check'          => 'on',
        'logo_index'            => '',
        'logo_install'          => '',
        'logo_console_login'    => '',
        'logo_console_head'     => '',
        'logo_console_foot'     => '',
    ),
);
