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
  'Ad script'                             => '广告脚本',
  'Advertisement'                         => '广告',
  'Percentage'                            => '投放比例',
  'Missing ID'                            => '无法获取 ID',
  'Advertisement not found'               => '广告不存在',
  'Ad position has not created'           => '尚未创建广告位',
  'All position'                          => '所有广告位',
  'Statistics'                            => '统计',
  'Help'                                  => '帮助',
  'Token'                                 => '表单令牌',
  'Image'                                 => '图片',
  'Content'                               => '内容',
  'Select'                                => '选择',
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
  'Name'                                  => '名称',
  'Option'                                => '选项',
  'Action'                                => '操作', //生效
  'enable'                                => '启用', //生效
  'disabled'                              => '禁用', //禁用
  'wait'                                  => '待审',
  'attach'                                => '图片',
  'text'                                  => '文本',
  'date'                      => '按日期',
  'show'                      => '按显示数',
  'hit'                       => '按点击数',
  'none'                      => '无限制',
  'backup'                    => '替补',
  'Invalid time'              => '失效时间',
  'Display count'             => '展示数',
  'Click count'               => '点击数',
  'Display count not exceed'  => '展示数不超过',
  'Click count not exceed'    => '点击数不超过',
  'Destination URL'                       => '目的 URL',
  'Ad position'                           => '广告位',
  'Effective time'                        => '生效时间',
  'Placement type'                        => '投放方式',
  'Refresh cache'                         => '更新缓存',
  'Add advertisement successfully'        => '添加广告成功',
  'Add advertisement failed'              => '添加广告失败',
  'Update advertisement successfully'     => '更新广告成功',
  'Successfully updated {:count} advertisements'   => '成功更新 {:count} 个广告',
  'Did not make any changes'              => '未做任何修改',
  'Delete'                                => '删除',
  'Successfully deleted {:count} advertisements'   => '成功删除 {:count} 个广告',
  'No advertisement have been deleted'             => '未删除任何广告',
  'Please select'                         => '请选择',
  'Note'                                  => '备注',
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
  '{:attr} not a valid datetime'          => '{:attr} 格式不合法',
);
