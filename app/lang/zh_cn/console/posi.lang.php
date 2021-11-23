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
  'Ad script not found'                   => '广告脚本未找到',
  'Initialization function'               => '初始化函数名',
  'Ad script name'                        => '脚本名',
  'Ad container perfix'                   => '广告容器前缀',
  'Ad container'                          => '广告容器',
  'Ad position'                           => '广告位',
  'Ad count'                              => '广告数',
  'Ad content'                            => '广告内容',
  'Ad CSS'                                => '广告 CSS',
  'Ad code'                               => '广告代码',
  'Ad management'                         => '广告管理',
  'Duplicate'                             => '克隆',
  'auto'                                  => '自动识别',
  'Text of loading'                       => '加载信息',
  'Text of close'                         => '关闭文字',
  'Statistics'                            => '统计',
  'Initialization'                        => '初始化',
  'Position'                              => '广告位',
  'By percentage'                         => '按比例投放',
  'Missing ID'                            => '无法获取 ID',
  'Position not found'                    => '广告位不存在',
  'Dependent'                             => '依赖',
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
  'Data URL'                              => '广告数据 URL',
  'All status'                            => '所有状态',
  'All types'                             => '所有类型',
  'Name'                                  => '名称',
  'Option'                                => '选项',
  'Action'                                => '操作', //生效
  'enable'                                => '启用', //生效
  'disabled'                              => '禁用', //禁用
  'attach'                                => '图片',
  'text'                                  => '文本',
  'Refresh cache'                                 => '更新缓存',
  'Add position successfully'                     => '添加广告位成功',
  'Add position failed'                           => '添加广告位失败',
  'Update position successfully'                  => '更新广告位成功',
  'Refresh cache successfully'                    => '更新缓存成功',
  'Refresh cache failed'                          => '更新缓存失败',
  'Successfully updated {:count} positions'       => '成功更新 {:count} 个广告位',
  'Duplicate position successfully'               => '克隆广告位成功',
  'Duplicate position failed'                     => '克隆广告位失败',
  'Did not make any changes'                      => '未做任何修改',
  'Delete'                                        => '删除',
  'Successfully deleted {:count} positions'       => '成功删除 {:count} 个广告位',
  'No position have been deleted'                 => '未删除任何广告位',
  'Sorted successfully'                           => '排序成功',
  'Belong to category'                            => '隶属于栏目',
  'Please select'                                 => '请选择',
  'All categories'                                => '所有栏目',
  'Note'                                          => '备注',
  'Apply'                                         => '提交',
  'Bulk actions'                                  => '批量操作',
  'Form token error'                              => '表单令牌错误',
  'Choose at least one item'                      => '至少选择一项',
  'Choose at least one {:attr}'                   => '至少选择一项 {:attr}',
  'Are you sure to delete?'                       => '确认删除吗？此操作不可恢复',
  'You do not have permission'                    => '您没有权限',
  'Initialization function name of the Ad script' => '广角脚本的初始化函数名',
  '{:attr} require'                               => '{:attr} 是必需的',
  'Size of {:attr} must be {:rule}'               => '{:attr} 的长度必须在 {:rule} 之间',
  'Max size of {:attr} must be {:rule}'           => '{:attr} 最长 {:rule}',
  '{:attr} must be integer'                       => '{:attr} 必须为整数',
  '{:attr} not a valid url'                       => '{:attr} 格式不合法',
  'Support ID or class selectors, if only characters are filled in, it will be converted to an ID selector.' => '支持 ID 或 class 选择器，如果只填入字符，系统会转换为 ID 选择器。',
  'This code is used to display Ad, please use it according to the actual situation. It is recommended to place <mark>JavaScript</mark> and <mark>CSS</mark> between <code>&lt;head&gt;</code>, the <mark>Ad container</mark> where it needs to be displayed. Note: If the script is Depend on JS librarys such as jQuery, Bootstrap etc., you also need to import these librarys.' => '该代码用于显示广告，请根据实际情况灵活运用。建议将 <mark>JavaScript</mark> 和 <mark>CSS</mark> 放置在 <code>&lt;head&gt;</code> 之间，<mark>广告容器</mark> 放置在需要显示的位置。注意：如果脚本依赖 JS 库，如 jQuery、Bootstrap 等，还需要引入这些库。',
);
