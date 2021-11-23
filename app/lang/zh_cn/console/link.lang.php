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
  'Access denied'                         => '拒绝访问',
  'Add'                                   => '添加', //添加
  'Back'                                  => '返回',
  'Edit'                                  => '编辑', //编辑
  'Show'                                  => '查看',
  'Reset'                                 => '清除',
  'Input error'                           => '输入错误，请检查！',
  'Link'                                  => '链接',
  'Missing ID'                            => '无法获取 ID',
  'Link not found'                        => '链接不存在',
  'Target link not found'                 => '目标链接不存在',
  'Help'                                  => '帮助',
  'Token'                                 => '表单令牌',
  'Keyword'                               => '关键词',
  'All'                                   => '全部',
  'Status'                                => '状态',
  'Type'                                  => '类型',
  'Save'                                  => '保存',
  'Sort'                                  => '排序',
  'Unnamed'                               => '未命名',
  'Server side error'                     => '服务器错误',
  'Saving'                                => '正在保存 ...',
  'All status'                            => '所有状态',
  'All types'                             => '所有类型',
  'Top'                                   => '最前',
  'Bottom'                                => '末尾',
  'After ID'                              => '该 ID 之后',
  'Name'                                  => '名称',
  'Action'                                => '操作', //生效
  'enable'                                => '启用', //生效
  'disabled'                              => '禁用', //禁用
  'console'                               => '后台',
  'auto'                                  => '自动',
  'friend'                                => '友情链接',
  'Refresh cache'                         => '更新缓存',
  'Open in blank window'                  => '新窗口中打开',
  'Add link successfully'                 => '添加链接成功',
  'Add link failed'                       => '添加链接失败',
  'Update link successfully'              => '更新链接成功',
  'Refresh cache successfully'            => '更新缓存成功',
  'Refresh cache failed'                  => '更新缓存失败',
  'Successfully updated {:count} links'   => '成功更新 {:count} 个链接',
  'Did not make any changes'              => '未做任何修改',
  'Delete'                                => '删除',
  'Successfully deleted {:count} links'   => '成功删除 {:count} 个链接',
  'No link have been deleted'             => '未删除任何链接',
  'Sorted successfully'                   => '排序成功',
  'Belong to category'                    => '隶属于栏目',
  'Please select'                         => '请选择',
  'All categories'                        => '所有栏目',
  'Apply'                                 => '提交',
  'Bulk actions'                          => '批量操作',
  'Form token error'                      => '表单令牌错误',
  'Choose at least one item'              => '至少选择一项',
  'Choose at least one {:attr}'           => '至少选择一项 {:attr}',
  'Are you sure to delete?'               => '确认删除吗？此操作不可恢复',
  'You do not have permission'            => '您没有权限',
  '{:attr} require'                       => '{:attr} 是必需的',
  'Size of {:attr} must be {:rule}'       => '{:attr} 的长度必须在 {:rule} 之间',
  'Max size of {:attr} must be {:rule}'   => '{:attr} 最长 {:rule}',
  '{:attr} must be integer'               => '{:attr} 必须为整数',
  '{:attr} not a valid url'               => '{:attr} 格式不合法',
  'Start with <code>http://</code> or <code>https://</code>' => '以 <code>http://</code> 或者 <code>https://</code> 开头',
);
