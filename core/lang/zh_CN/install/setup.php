<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------------------通用-------------------------*/
return array(

    /*------页面标题------*/
    'page' => array(
        'setup'     => '安装程序',
        'phplib'    => '服务器环境检查',
        'dbtable'   => '创建数据表',
        'admin'     => '创建管理员',
        'auth'      => '授权为管理员', //授权
        'over'      => '完成安装',
        'ssoAuto'   => 'SSO 自动部署', //尾页
        'ssoAdmin'  => '创建管理员', //尾页
    ),

    'href' => array(
        'admin'     => '创建管理员',
        'auth'      => '授权为管理员', //授权
        'jumping'   => '正在跳转',
        'help'      => '帮助',
        'ssoAuto'   => 'SSO 自动部署', //尾页
    ),

    'label' => array(
        'setup'       => '正在进行安装',
        'tpl'           => '模板',
        'timezone'      => '时区',
        'ssoAuto'       => '第一步',
        'over'          => '还差最后一步，完成安装',

        'username'      => '用户名', //用户名
        'password'      => '密码', //密码
        'passConfirm'   => '确认密码', //密码
        'mail'          => '邮箱',
        'nick'          => '昵称',

        'dbHost'        => '数据库服务器',
        'dbPort'        => '服务器端口',
        'dbName'        => '数据库名称',
        'dbUser'        => '用户名',
        'dbPass'        => '密码',
        'dbCharset'     => '字符编码',
        'dbtable'       => '数据表前缀',
    ),

    'phplib' => array(
        'installed'     => '已安装',
        'notinstalled'  => '未安装',
    ),

    'btn' => array(
        'save'  => '保存',
        'jump'  => '跳转至',
        'skip'  => '跳过',
        'prev'  => '上一步',
        'next'  => '下一步',
        'over'  => '完成',
    ),

    'text' => array(
        'phplibOk'  => '服务器环境检查通过，可以继续安装。',
        'phplibErr' => '服务器环境检查未通过，请检查上述扩展库是否已经正确安装。',
        'admin'     => '本操作将向 baigo SSO 注册新用户，并自动将新注册的用户授权为超级管理员，拥有所有的管理权限。如果您之前已经部署有 baigo SSO，并且不想注册新用户，只希望使用原有的 baigo SSO 用户作为管理员，请点击 <mark>授权为管理员</mark>。',
        'auth'      => '本操作将用您输入的 baigo SSO 用户作为管理员，拥有所有的管理权限。如果您要创建新的管理员请点击 <mark>创建管理员</mark>。',
        'sso'       => 'baigo ADS 的用户以及后台登录需要 baigo SSO 支持，baigo SSO 的部署方式，请查看 <a href="http://www.baigo.net/sso/" target="_blank">baigo SSO 官方网站</a>。如果您的网站没有部署 baigo SSO，请点击 <mark>SSO 自动部署</mark>。',
        'ssoAuto'   => '即将执行自动部署第一步',
        'ssoAdmin'  => '本操作将同时为 baigo ADS 与 baigo SSO 创建管理员，拥有所有的管理权限。请牢记用户名与密码。',
    ),
);
