<?php
/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
！！！！警告！！！！
以下为系统文件，请勿修改
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*++++++提示信息++++++
x开头为错误
y开头为成功
++++++++++++++++++*/

return array(
  /*@@@@@@ x-1---- 用户 @@@@@@*/

  /*++++++ x-1-1-- 数据 ++++++*/
  'y010101' => '用户注册成功',
  'x010101' => '用户注册失败',
  'y010102' => '用户存在',
  'x010102' => '用户不存在',
  'y010103' => '更新用户成功',
  'x010103' => '没有做任何修改',
  'y010104' => '删除用户成功',
  'x010104' => '未删除任何用户',
  'y010105' => '创建用户表成功',
  'x010105' => '创建用户表失败',
  'y010106' => '更新用户表成功',
  'x010106' => '没有做任何修改',
  'y010107' => '删除用户表成功',
  'x010107' => '未删除任何表',

  'y010108' => '创建用户视图成功',
  'x010108' => '创建用户视图失败',

  'y010111' => '无需更新用户表',

  /*++++++ x-1-2-- 验证 ++++++*/
  'y010201' => '验证通过',
  'x010201' => '输入错误',
  'x010202' => '获取用户 ID 错误',
  'x010203' => '获取用户名错误',

  /*++++++ x-1-3-- 权限 ++++++*/
  'x010301' => '您没有浏览用户的权限',
  'x010302' => '您没有创建用户的权限',
  'x010303' => '您没有编辑用户的权限',
  'x010304' => '您没有删除用户的权限',
  'x010305' => '您没有批量导入的权限',

  /*++++++ x-1-4-- 状态 ++++++*/
  'y010401' => '用户名可以注册',
  'x010402' => '用户被禁用',
  'x010403' => '您没有设置邮箱和密保问题，无法找回密码，请联系系统管理员！',
  'x010404' => '用户已存在',
  'y010405' => '更换邮箱成功',
  'x010405' => '更换邮箱失败',
  'y010406' => '找回密码成功',
  'x010406' => '找回密码失败',
  'x010407' => '发送确认邮件失败',
  'y010408' => '删除 CSV 成功',
  'x010408' => '删除 CSV 失败',
  'x010409' => '无需重复激活',

  /*@@@@@@ x-2---- 管理员 @@@@@@*/

  /*++++++ x-2-1-- 数据 ++++++*/
  'y020101' => '创建管理员成功',
  'x020101' => '创建管理员失败',
  'y020102' => '管理员存在',
  'x020102' => '管理员未授权',
  'y020103' => '更新管理员成功',
  'x020103' => '没有做任何修改',
  'y020104' => '删除管理员成功',
  'x020104' => '未删除任何管理员',
  'y020105' => '创建管理员表成功',
  'x020105' => '创建管理员表失败',
  'y020106' => '更新管理员表成功',
  'x020106' => '没有做任何修改',
  'y020107' => '删除管理员表成功',
  'x020107' => '未删除任何表',

  'y020111' => '无需更新管理员表',

  /*++++++ x-2-2-- 验证 ++++++*/
  'y020201' => '验证通过',
  'x020201' => '输入错误',
  'x020202' => '获取管理员 ID 错误',
  'x020203' => '获取用户名错误',

  /*++++++ x-2-3-- 权限 ++++++*/
  'x020301' => '您没有浏览管理员的权限',
  'x020302' => '您没有创建管理员的权限',
  'x020303' => '您没有编辑管理员的权限',
  'x020304' => '您没有删除管理员的权限',
  'x020305' => '禁止更新个人资料',
  'x020306' => '不能编辑自己',

  /*++++++ x-2-4-- 状态 ++++++*/
  'y020401' => '管理员登录成功',
  'x020402' => '管理员被禁用',
  'x020403' => '登录校验错误',
  'x020404' => '管理员已存在',
  'x020405' => '登录超时，请重新登录！',

  /*@@@@@@ x-3---- 系统 @@@@@@*/

  /*++++++ x-3-1-- 数据 ++++++*/

  /*++++++ x-3-2-- 验证 ++++++*/
  'y030201' => '验证通过',
  'x030201' => '输入错误',
  'x030202' => '验证码错误',
  'x030203' => '安全码错误',
  'x030204' => '安装类型未设置',

  /*++++++ x-3-3-- php 上传 ++++++*/
  'x030301' => '您没有设置的权限',

  /*++++++ x-3-4-- 状态 ++++++*/
  'y030401' => '设置成功',
  'x030401' => '设置失败',
  'x030402' => '系统已安装',
  'x030403' => '系统未安装',
  'x030404' => '需要执行升级程序',
  'x030405' => '缺少必要的 PHP 扩展',
  'x030406' => '签名错误',
  'x030407' => '解密失败',
  'x030408' => '加密失败',
  'x030409' => '未正确设置数据库',
  'x030411' => '全新安装时禁用',
  'x030410' => '模板不存在',
  'y030412' => '系统未安装',
  'x030412' => '系统已安装',


  /*@@@@@@ x-4---- 广告位 @@@@@@*/

  /*++++++ x-4-1-- 数据 ++++++*/
  'y040101' => '创建广告位成功',
  'x040101' => '创建广告位失败',
  'y040102' => '广告位存在',
  'x040102' => '广告位不存在',
  'y040103' => '更新广告位成功',
  'x040103' => '没有做任何修改',
  'y040104' => '删除广告位成功',
  'x040104' => '未删除任何广告位',
  'y040105' => '创建广告位表成功',
  'x040105' => '创建广告位表失败',
  'y040106' => '更新广告位表成功',
  'x040106' => '没有做任何修改',
  'y040107' => '删除广告位表成功',
  'x040107' => '未删除任何表',

  'y040110' => '生成广告位缓存成功',
  'x040110' => '生成广告位缓存失败',
  'y040111' => '无需更新广告位表',
  'y040113' => '更新广告位表成功',

  /*++++++ x-4-2-- 验证 ++++++*/
  'y040201' => '验证通过',
  'x040201' => '输入错误',
  'x040202' => '获取广告位 ID 错误',

  /*++++++ x-4-3-- 权限 ++++++*/
  'x040301' => '您没有浏览广告位的权限',
  'x040302' => '您没有创建广告位的权限',
  'x040303' => '您没有编辑广告位的权限',
  'x040304' => '您没有删除广告位的权限',
  'x040305' => '您没有查看广告位统计的权限',

  /*++++++ x-4-3-- 权限 ++++++*/
  'x040401' => '广告位被禁用',
  'x040402' => '没有可供设置的选项',


  /*@@@@@@ x-5---- 应用 @@@@@@*/

  /*++++++ x-5-1-- 数据 ++++++*/
  'y050101' => '创建应用成功',
  'x050101' => '创建应用失败',
  'y050102' => '应用存在',
  'x050102' => '应用不存在',
  'y050103' => '更新应用成功',
  'x050103' => '没有做任何修改',
  'y050104' => '删除应用成功',
  'x050104' => '未删除任何应用',
  'y050105' => '创建应用表成功',
  'x050105' => '创建应用表失败',
  'y050106' => '更新应用表成功',
  'x050106' => '没有做任何修改',
  'y050107' => '删除应用表成功',
  'x050107' => '未删除任何表',

  'y050111' => '无需更新应用表',

  /*++++++ x-5-2-- 验证 ++++++*/
  'y050201' => '验证通过',
  'x050201' => '输入错误',
  'x050202' => '获取应用 ID 错误',
  'x050203' => '解码错误',

  /*++++++ x-5-3-- 权限 ++++++*/
  'x050301' => '您没有浏览应用的权限',
  'x050302' => '您没有创建应用的权限',
  'x050303' => '您没有编辑应用的权限',
  'x050304' => '您没有删除应用的权限',
  'x050305' => '您没有授权的权限',

  'x050307' => '本应用没有用户注册权限',
  'x050308' => '本应用没有编辑用户权限',
  'x050309' => '本应用没有删除用户权限',

  'x050316' => '系统禁止注册',

  /*++++++ x-5-4-- 状态 ++++++*/
  'y050401' => '同步接口调用成功',
  'x050401' => '同步接口调用失败',
  'x050402' => '应用被禁用',
  'x050403' => '签名错误',
  'x050405' => '加密失败',
  'x050406' => '解密失败',
  'x050407' => '不允许访问的 IP 地址',
  'x050408' => '禁止访问的 IP 地址',


  /*@@@@@@ x-6---- 接收通知 @@@@@@*/

  /*++++++ x-6-1-- 数据 ++++++*/

  /*++++++ x-6-2-- 验证 ++++++*/

  /*++++++ x-6-3-- 权限 ++++++*/


  /*@@@@@@ x-7---- 应用从属 @@@@@@*/

  /*++++++ x-7-1-- 数据 ++++++*/

  /*++++++ x-7-4-- 状态 ++++++*/

  /*@@@@@@ x-8---- 广告 @@@@@@*/

  /*++++++ x-8-1-- 数据 ++++++*/
  'y080101' => '投放广告成功',
  'x080101' => '投放广告失败',
  'y080102' => '广告存在',
  'x080102' => '广告不存在',
  'y080103' => '更新广告成功',
  'x080103' => '没有做任何修改',
  'y080104' => '删除广告成功',
  'x080104' => '未删除任何广告',

  'y080105' => '创建广告表成功',
  'x080105' => '创建广告表失败',
  'y080106' => '更新广告表成功',
  'x080106' => '没有做任何修改',
  'y080107' => '删除广告表成功',
  'x080107' => '未删除任何表',

  'y080111' => '无需更新广告表',

  /*++++++ x-8-2-- 验证 ++++++*/
  'y080201' => '验证通过',
  'x080201' => '输入错误',
  'x080202' => '获取广告 ID 错误',

  /*++++++ x-8-3-- 权限 ++++++*/
  'x080301' => '您没有浏览广告的权限',
  'x080302' => '您没有投放广告的权限',
  'x080303' => '您没有编辑广告的权限',
  'x080304' => '您没有删除广告的权限',
  'x080305' => '您没有查看广告统计的权限',

  /*++++++ x-8-4-- 状态 ++++++*/
  'x080401' => '尚未创建广告位',
  'x080402' => '广告已无效',


  /*@@@@@@ x-9---- 统计 @@@@@@*/

  /*++++++ x-9-1-- 数据 ++++++*/
  'y090101' => '插入统计数据成功',
  'x090101' => '插入统计数据失败',
  'y090102' => '统计数据存在',
  'x090102' => '统计数据不存在',
  'y090103' => '更新统计数据成功',
  'x090103' => '没有做任何修改',
  'y090104' => '删除统计数据成功',
  'x090104' => '未删除任何统计数据',

  'y090105' => '创建统计表成功',
  'x090105' => '创建统计表失败',
  'y090106' => '更新统计表成功',
  'x090106' => '没有做任何修改',
  'y090107' => '删除统计表成功',
  'x090107' => '未删除任何表',

  'y090111' => '无需更新统计表',


  /*@@@@@@ x10---- 签名 @@@@@@*/

  /*++++++ x10-2-- 验证 ++++++*/
  'y100201' => '验证通过',
  'x100201' => '输入错误',

  /*++++++ x10-4-- 状态 ++++++*/
  'x100401' => '签名错误',
  'x100402' => '加密失败',
  'x100403' => '解密失败',


  /*@@@@@@ x11---- 短信 @@@@@@*/

  /*++++++ x11-1-- 数据 ++++++*/
  'y110101' => '发送短信成功',
  'x110101' => '发送短信失败',
  'y110102' => '短信存在',
  'x110102' => '短信不存在',
  'y110103' => '更新短信成功',
  'x110103' => '没有做任何修改',
  'y110104' => '删除短信成功',
  'x110104' => '未删除任何短信',

  'y110105' => '创建短信表成功',
  'x110105' => '创建短信表失败',
  'y110106' => '更新短信表成功',
  'x110106' => '没有做任何修改',
  'y110107' => '删除短信表成功',
  'x110107' => '未删除任何表',

  /*++++++ x11-2-- 验证 ++++++*/
  'y110201' => '验证通过',
  'x110201' => '输入错误',
  'x110202' => '获取短信 ID 错误',

  /*++++++ x11-3-- 权限 ++++++*/
  'x110301' => '您没有浏览短信的权限',
  'x110302' => '您没有群发短信的权限',
  'x110303' => '您没有发送短信的权限',
  'x110304' => '您没有删除短信的权限',
  'x110305' => '您没有编辑短信的权限',

  /*++++++ x11-4-- 权限 ++++++*/
  'x110403' => '该短信不属于您',


  /*@@@@@@ x12---- 验证 @@@@@@*/

  /*++++++ x12-1-- 数据 ++++++*/
  'y120101' => '创建验证成功',
  'x120101' => '创建验证失败',
  'y120102' => '验证存在',
  'x120102' => '验证不存在',
  'y120103' => '更新验证成功',
  'x120103' => '没有做任何修改',
  'y120104' => '删除验证成功',
  'x120104' => '未删除任何验证',

  'y120105' => '创建验证表成功',
  'x120105' => '创建验证表失败',
  'y120106' => '更新验证表成功',
  'x120106' => '没有做任何修改',
  'y120107' => '删除验证表成功',
  'x120107' => '未删除任何表',

  'y120111' => '无需更新验证表',

  /*++++++ x12-2-- 验证 ++++++*/
  'y120201' => '验证通过',
  'x120201' => '输入错误',
  'x120202' => '获取验证 ID 错误',

  /*++++++ x12-3-- 权限 ++++++*/
  'x120301' => '您没有操作验证的权限',


  /*@@@@@@ x19---- 插件 @@@@@@*/

  /*++++++ x19-1-- 数据 ++++++*/
  'y190101' => '安装插件成功',
  'x190101' => '安装插件失败',
  'y190102' => '插件存在',
  'x190102' => '插件不存在',
  'y190103' => '更新插件成功',
  'x190103' => '没有做任何修改',
  'y190104' => '卸载插件成功',
  'x190104' => '未卸载任何插件',
  'y190108' => '更新插件设置成功',

  /*++++++ x19-2-- 验证 ++++++*/
  'y190201' => '验证通过',
  'x190201' => '输入错误',
  'x190203' => '获取插件目录错误',

  /*++++++ x19-3-- 权限 ++++++*/
  'x190301' => '您没有浏览插件的权限',
  'x190302' => '您没有安装插件的权限',
  'x190303' => '您没有编辑插件的权限',
  'x190304' => '您没有卸载插件的权限',

  /*++++++ x19-4-- 状态 ++++++*/
  'x190401' => '没有可供设置的选项',
  'x190404' => '插件已安装',
);
