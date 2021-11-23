<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------------------通用-------------------------*/
return array(
  'Access denied'                     => '拒绝访问',
  'Administrator'                     => '管理员',
  'User already exists'               => '用户已存在',
  'Add'                               => '添加',
  'Add administrator'                 => '添加管理员',
  'Add administrator successfully'    => '创建管理员成功',
  'Add administrator failed'          => '创建管理员失败',
  'Authorization'                     => '授权',
  'Authorize as administrator'        => '授权为管理员',
  'Administrator already exists'      => '管理员已存在',

  'Status'                            => '状态',
  'Created data'                      => '已创建数据',
  'Create data'                       => '创建数据',

  'Create table'                      => '创建数据表',
  'Create table successfully'         => '创建成功',
  'Create table failed'               => '创建失败',

  'Create index'                      => '创建索引',
  'Create index successfully'         => '创建成功',
  'Create index failed'               => '创建失败',

  'Create view'                       => '创建视图',
  'Create view successfully'          => '创建成功',
  'Create view failed'                => '创建失败',

  'Type'                                              => '数据类型',
  'Model'                                             => '模型名称',

  'Complete installation'                             => '完成安装',
  'Confirm password'                                  => '确认密码',
  'Nickname'                                          => '昵称',
  'Database'                                          => '数据库名称',
  'Database host'                                     => '数据库服务器',
  'Database settings'                                 => '数据库设置',
  'Host port'                                         => '服务器端口',
  'Charset'                                           => '字符编码',
  'Database set successful'                           => '数据库设置成功',
  'Database set failed'                               => '数据库设置失败',
  'Set successfully'                                  => '设置成功',
  'Set failed'                                        => '设置失败',
  'Installation type'                                 => '安装方式',
  'Email'                                             => '邮箱地址',
  'Form token is incorrect'                           => '表单令牌错误',
  'Installed'                                         => '已安装',
  'Not installed'                                     => '未安装',
  'Input error'                                       => '输入错误，请检查！',
  'Next'                                              => '下一步',
  'Prefix'                                            => '数据表前缀',
  'Previous'                                          => '上一步',
  'Password'                                          => '密码',
  'Missing PHP extensions'                            => '缺少必要的 PHP 扩展',
  'PHP Extensions'                                    => '服务器环境检查',
  'Redirecting'                                       => '正在跳转 ...',
  'Save'                                              => '保存',
  'Installer'                                         => '安装程序',
  'Type'                                              => '类型',
  'Name'                                              => '名称',
  'Skip'                                              => '跳过',
  'Token'                                             => '表单令牌',
  'Username'                                          => '用户名',
  'Base url'                                          => '基本 URL',

  'Installation successful'                           => '安装成功',
  'Installation failed'                               => '安装失败',
  'SSO installation failed'                           => 'SSO 安装失败',

  'Do not add a slash <kbd>/</kbd> at the end'        => '末尾请勿加斜杠 <kbd>/</kbd>',

  '{:attr} require'                                   => '{:attr} 是必需的',
  '{:attr} must be numeric'                           => '{:attr} 必须为数字',
  '{:attr} must be alpha-numeric, dash, underscore'   => '{:attr} 必须为字母、数字、连接符和下划线',
  '{:attr} not a valid email address'                 => '{:attr} 不是一个合法的 Email 地址',
  'Size of {:attr} must be {:rule}'                   => '{:attr} 的长度必须在 {:rule} 之间',
  'Max size of {:attr} must be {:rule}'               => '{:attr} 最长 {:rule}',
  '{:attr} out of accord with {:confirm}'             => '{:attr} 和 {:confirm} 不一致',

  'Installation type is not set'                      => '未设置安装方式',
  'Choose installation type'                          => '选择安装方式',
  'Full installation (Include baigo SSO)'             => '全新安装（含 baigo SSO）',
  'Only install baigo ADS (Manually set the baigo SSO)' => '仅安装 baigo ADS（手动设置 baigo SSO）',
  'Disabled during full installation'                 => '全新安装时禁用',
  'baigo SSO is an Single Sign On system, baigo ADS dependent on this system.' => 'baigo SSO 是一个单点登录系统，baigo ADS 依赖于此系统。',
  'This step will authorizes an existing user as a super administrator with all permissions.' => '此步骤将已存在的用户授权为超级管理员，拥有所有权限。',
  'This step will add a new user as a super administrator with all permissions.' => '此步骤将注册新用户作为超级管理员，拥有所有权限。',
  'If you already have installed baigo SSO, you can set the parameters here. If you want to install baigo SSO yourself, please visit the <a href="http://www.baigo.net/sso/" target="_blank">official website</a>.' => '如果您已经安装了 baigo SSO，请设置以下参数。如果你想自行安装 baigo SSO，请查看 <a href="http://www.baigo.net/sso/" target="_blank">官方网站</a>。',
  'You have chosen "Full installation", this is the installed information of baigo SSO, please confirm!' => '您选择了“全新安装”，以下是 baigo SSO 已安装信息，请确认！',
  'You have chosen "Full installation", this is the result of the data created by baigo SSO, please confirm!' => '您选择了“全新安装”，以下是 baigo SSO 创建数据的结果，请确认！',
  'Warning! This is the installed information of baigo SSO!'  => '注意！以上是 baigo SSO 已安装信息！',

  'Last step, complete the installation'  => '还差最后一步，完成安装',
);
