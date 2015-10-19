<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------------------通用-------------------------*/
return array(
	/*------站点------*/
	"site"             => array(
		"name"            => "baigo ADMS",
	),

	/*------页面标题------*/
	"page"             => array(
		"admin"           => "管理后台",
		"adminLogon"      => "管理后台登录",
		"alert"           => "提示信息",
		"edit"            => "编辑",
		"add"             => "创建",
		"detail"          => "详情",
		"show"            => "查看",
		"profile"         => "管理员个人信息",
		"pass"            => "修改密码",

		"upgrade"         => "baigo ADMS 升级程序",
		"upgradeDbtable"  => "升级数据库",
		"upgradeOver"     => "完成升级",

		"install"         => "baigo ADMS 安装程序",
		"installExt"      => "服务器环境检查",
		"installDbconfig" => "数据库设置",
		"installDbtable"  => "创建数据表",
		"installBase"     => "基本设置",
		"installUpload"   => "上传设置",
		"installSso"      => "SSO 设置",
		"installSsoAuto"  => "SSO 自动部署",
		"installAdmin"    => "创建管理员",
		"installAuto"     => "SSO 自动部署",
		"installOver"     => "完成安装",
	),

	/*------链接文字------*/
	"href"             => array(
		"all"             => "全部",
		"agree"           => "同意",
		"logout"          => "退出",
		"back"            => "返回",
		"add"             => "创建",
		"edit"            => "编辑",
		"recycle"         => "回收站",
		"help"            => "帮助",
		"preview"         => "预览",
		"upload"          => "上传",
		"select"          => "选择",

		"advertMan"       => "管理广告",
		"posiPreview"     => "预览 / 获取代码",

		"stat"            => "统计",
		"statYear"        => "年统计",
		"statMonth"       => "月统计",
		"statDay"         => "日统计",

		"ssoAuto"         => "SSO 自动部署", //尾页
		"ssoUpgrade"      => "SSO 升级", //尾页

		"passModi"        => "修改密码",
		"show"            => "查看",
		"noticeTest"      => "通知接口测试",

		"pageFirst"       => "首页",
		"pagePrevList"    => "上十页",
		"pagePrev"        => "上一页",
		"pageNext"        => "下一页",
		"pageNextList"    => "下十页",
		"pageLast"        => "尾页",
	),

	/*------说明文字------*/
	"label"            => array(
		"id"              => "ID",
		"to"              => "至",
		"add"             => "创建",
		"all"             => "全部",
		"seccode"         => "验证码",
		"key"             => "关键词",
		"type"            => "类型",
		"alert"           => "返回代码",
		"status"          => "状态",
		"note"            => "备注",
		"nick"            => "昵称",
		"allow"           => "权限",
		"modOnly"         => "（需修改时输入）",
		"submitting"      => "正在提交 ...",
		"size"            => "尺寸",
		"width"           => "宽度",
		"height"          => "高度",
		"px"              => "px",
		"expired"         => "完毕",

		"year"            => "年", //年
		"month"           => "月", //月
		"day"             => "日", //日
		"hour"            => "时", //时
		"minute"          => "分", //分

		"noname"          => "未命名", //未命名
		"unknown"         => "未知", //未知
		"normal"          => "正常", //草稿
		"recycle"         => "回收站", //回收站

		"loging"          => "正在登录 ...",
		"installSso"      => "即将执行自动部署第一步",

		"statYear"        => "年度",
		"statMonth"       => "月份",
		"statDay"         => "日期",

		"profileAllow"    => "个人权限",
		"profileInfo"     => "禁止修改个人信息",
		"profilePass"     => "禁止修改密码",

		"posi"            => "广告位",
		"posiName"        => "广告位名称",
		"posiCount"       => "显示广告数",
		"posiCode"        => "广告代码示例",
		"posiCodeNote1"   => "广告样式",
		"posiCodeNote2"   => "显示容器",
		"posiCodeNote3"   => "初始化",
		"posiCodeNote4"   => "广告脚本",
		"contentType"     => "广告内容",
		"posiScript"      => "广告脚本",
		"posiPlugin"      => "插件名",
		"posiSelector"    => "默认选择器",
		"posiOption"      => "选项：",
		"isPercent"       => "允许几率展现",
		"dataUrl"         => "广告数据 URL",

		"advert"          => "广告",
		"advertName"      => "广告名称",
		"advertUrl"       => "链接地址",
		"advertBegin"     => "生效时间",
		"advertPutType"   => "投放类型",
		"advertPutDate"   => "结束时间",
		"advertPutShow"   => "展示数不超过",
		"advertPutHit"    => "点击数不超过",
		"advertPercent"   => "展现几率",
		"advertMedia"     => "图片",
		"advertMediaNote" => "您也可以直接输入图片 ID",
		"advertContent"   => "文字内容",
		"advertShow"      => "总展示数",
		"advertHit"       => "总点击数",
		"advertStatShow"  => "展示数",
		"advertStatHit"   => "点击数",

		"mediaInfo"       => "图片信息",

		"uploading"       => "正在上传 ...",
		"uploadSucc"      => "上传成功",

		"dbHost"          => "数据库服务器",
		"dbPort"          => "服务器端口",
		"dbName"          => "数据库名称",
		"dbUser"          => "数据库用户名",
		"dbPass"          => "数据库密码",
		"dbCharset"       => "数据库字符编码",
		"dbTable"         => "数据表名前缀",
		"dbDebug"         => "数据库调试模式",

		"user"            => "用户",
		"admin"           => "管理员",

		"username"        => "用户名", //用户名
		"password"        => "密码", //密码
		"passOld"         => "旧密码", //密码
		"passNew"         => "新密码", //密码
		"passConfirm"     => "确认密码", //密码

		"upgrade"         => "正在进行升级安装",
		"upgradeDbtable"  => "即将升级数据库",
		"upgradeOver"     => "还差最后一步，完成升级",

		"installOver"     => "还差最后一步，完成安装",
		"installDbtable"  => "即将创建数据表",
		"installAuto"     => "即将执行自动部署第二步",
	),

	/*------选择项------*/
	"option"           => array(
		"allStatus"       => "所有状态",
		"allExt"          => "所有类型", //所有类型
		"allPosi"         => "所有广告位", //所有类型

		"allYear"         => "所有年份", //所有年份
		"allMonth"        => "所有月份", //所有月份

		"please"          => "请选择",
		"nolimit"         => "无限制",
		"batch"           => "批量操作",
		"cache"           => "刷新缓存",
		"del"             => "永久删除",
		"normal"          => "正常",
		"revert"          => "放回原处",
		"recycle"         => "放入回收站",
	),

	/*------按钮------*/
	"btn" => array(
		"ok"          => "确定",
		"submit"      => "提交",
		"del"         => "永久删除",
		"complete"    => "完成",
		"search"      => "搜索",
		"filter"      => "筛选",
		"login"       => "登录",
		"skip"        => "跳过",
		"save"        => "保存",
		"close"       => "关闭",
		"jump"        => "跳转至",
		"over"        => "完成",
		"auth"        => "授权",
		"select"      => "选取图片 ...",
		"stepNext"    => "下一步",
		"upload"      => "上传图片 ...",
		"empty"       => "清空回收站", //清空回收站
		"more"        => "更多详情", //清空回收站

		"mediaClear"  => "图片清理",
	),

	"digit"    => array("日", "一", "二", "三", "四", "五", "六", "七", "八", "九", "十"),

	/*------确认框------*/
	"confirm"          => array(
		"del"     => "确认永久删除吗？此操作不可恢复！",
		"clear"   => "确认清理图片吗？此操作将耗费将长时间！", //确认清空回收站
		"empty"   => "确认清空回收站吗？此操作不可恢复！", //确认清空回收站
	),

	"text" => array(
		"extErr"          => "服务器环境检查未通过，请检查上述扩展库是否已经正确安装。",
		"extOk"           => "服务器环境检查通过，可以继续安装。",
		"installSso"      => "baigo ADMS 的用户以及后台登录需要 baigo SSO 支持，baigo SSO 的部署方式，请查看 <a href=\"http://www.baigo.net/sso/\" target=\"_blank\">baigo SSO 官方网站</a>。如果您的网站没有部署 baigo SSO，请点击 <mark>SSO 自动部署</mark>。",
		"upgradeSso"      => "baigo ADMS 的用户以及后台登录需要 baigo SSO 支持，baigo SSO 的部署方式，请查看 <a href=\"http://www.baigo.net/sso/\" target=\"_blank\">baigo SSO 官方网站</a>。baigo SSO 的升级与 baigo ADMS 的升级并无直接关联，如果您要检查 baigo SSO 是否可升级，请点击 <mark>SSO 升级</mark>。",
		"installSsoAdmin" => "本操作将同时为 baigo ADMS 与 baigo SSO 创建管理员，拥有所有的管理权限。请牢记用户名与密码。",
		"posiCodeNote"    => "该代码用于显示广告，请根据实际情况灵活运用。建议将示例代码中的 <mark>广告样式</mark> 放置在网页的 <code>head</code> 之间，<mark>显示容器</mark> 放置在网页显示广告的位置，其余部分放置在网页的 <code>body</code> 末尾。",
	),

	/*------图片说明------*/
	"alt"              => array(
		"seccode"         => "看不清",
	),
);
