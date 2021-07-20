<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

// 不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------------------通用-------------------------*/
return array(
    'Access denied'                             => '拒绝访问',
    'Token'                                     => '表单令牌',
    'Close'                                     => '关闭',
    'Send'                                      => '发送',
    'Sending'                                   => '正在发送 ...',
    'Keyword'                                  => '关键词',
    'Bulk'                                      => '群发',
    'To'                                        => '至',
    'Reset'                                     => '清除',
    'Cancel'                                    => '取消',
    'Confirm'                                   => '确定',
    'Back'                                      => '返回',
    'Show'                                      => '查看',
    'Submitting'                                => '正在提交 ...',
    'Input error'                               => '输入错误，请检查！',
    'Missing ID'                                => '无法获取 ID',
    'Bulk send type'                            => '群发类型',
    'Enter username'                            => '输入用户名',
    'Username keyword'                          => '用户名关键词',
    'Mailbox keyword'                           => '邮箱关键词',
    'User ID range'                             => '用户 ID 范围',
    'Registration time'                         => '注册时间',
    'Registration time range'                   => '注册时间范围',
    'Login time'                                => '登录时间',
    'Login time range'                          => '登录时间范围',
    'Message'                                   => '短信',
    'Message not found'                         => '短信不存在',
    'Private message'                           => '站内短信',
    'read'                                      => '已读',
    'wait'                                      => '未读',
    'out'                                       => '已发送',
    'in'                                        => '收件箱',
    'Status'                                    => '状态',
    'Type'                                      => '类型',
    'Time'                                      => '时间',
    'Title'                                     => '标题',
    'Content'                                   => '内容',
    'Sender'                                    => '发件人',
    'Recipient'                                 => '收件人',
    'Recipient not found'                       => '收件人不存在',
    'Unknown'                                   => '未知',
    'Apply'                                     => '提交',
    'Delete'                                    => '删除',
    'Action'                                    => '操作',
    'Bulk actions'                              => '批量操作',
    'System'                                    => '系统',
    'System message'                            => '系统消息',
    'Form token is incorrect'                   => '表单令牌错误',
    'All status'                                => '所有状态',
    'All type'                                  => '所有类型',
    'Choose at least one item'                  => '至少选择一项',
    'Choose at least one {:attr}'               => '至少选择一项 {:attr}',
    'Start ID'                                  => '起始 ID',
    'End ID'                                    => '结束 ID',
    'Start time'                                => '起始时间',
    'End time'                                  => '结束时间',
    'Successfully sent {:count} messages'       => '成功发送 {:count} 条短信',
    'Are you sure to delete?'                   => '确认删除吗？此操作不可恢复',
    'Send message successfully'                 => '发送短信成功',
    'Send message failed'                       => '发送短信失败',
    'Successfully updated {:count} messages'    => '成功更新 {:count} 条短信',
    'Did not make any changes'                  => '未做任何修改',
    'You do not have permission'                => '您没有权限',
    'Successfully deleted {:count} messages'    => '成功删除 {:count} 条短信',
    'No message have been deleted'              => '未删除任何短信',
    'No eligible recipients'                    => '没有符合条件的收件人',
    '{:attr} require'                           => '{:attr} 是必需的',
    'Size of {:attr} must be {:rule}'           => '{:attr} 的长度必须在 {:rule} 之间',
    '{:attr} must be integer'                   => '{:attr} 必须是整数',
    '{:attr} not a valid datetime'              => '{:attr} 必须是日期时间格式',
    'Max size of {:attr} must be {:rule}'       => '{:attr} 最长 {:rule}',
    'For multiple recipients, please use <kbd>,</kbd> to separate'  => '多个收件人请使用 <kbd>,</kbd> 隔开',
    'Send to users where username contains the keyword'             => '发送给用户名中包含该关键词的用户',
    'Send to users where email contains the keyword'                => '发送给邮箱中包含该关键词的用户',
    'Sent to users in the ID range'                                 => '发送给 ID 范围内的用户',
    'Sent to users in the registration time range'                  => '发送给注册时间范围内的用户',
    'Sent to users in the login time range'                         => '发送给登录时间范围内的用户',
);
