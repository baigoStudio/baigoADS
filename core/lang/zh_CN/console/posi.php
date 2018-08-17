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
        'edit'              => '编辑',
        'add'               => '创建',
        'show'              => '查看',
    ),

    /*------链接文字------*/
    'href' => array(
        'all'             => '全部',
        'add'             => '创建',
        'edit'            => '编辑',
        'help'            => '帮助',

        'advertMan'       => '管理广告',
        'posiPreview'     => '预览 / 获取代码',

        'stat'            => '统计',
        'statYear'        => '年统计',
        'statMonth'       => '月统计',
        'statDay'         => '日统计',
    ),

    /*------说明文字------*/
    'label' => array(
        'id'              => 'ID',
        'add'             => '创建',
        'all'             => '全部',
        'key'             => '关键词',
        'type'            => '类型',
        'status'          => '状态',
        'note'            => '备注',
        'unknown'         => '未知', //未知

        'statYear'        => '年度',
        'statMonth'       => '月份',
        'statDay'         => '日期',

        'posi'            => '广告位',
        'posiName'        => '广告位名称',
        'posiCount'       => '显示广告数',
        'posiCode'        => '广告代码示例',
        'posiCodeNote1'   => '广告样式',
        'posiCodeNote2'   => '显示容器',
        'posiCodeNote3'   => '初始化',
        'posiCodeNote4'   => '广告脚本',
        'jQuery'          => 'jQuery 库',
        'contentType'     => '广告内容',
        'posiScript'      => '广告脚本',
        'posiPlugin'      => '插件名',
        'posiPluginNote'  => '此处指广告脚本的 jQuery 插件名',
        'posiSelector'    => '默认选择器',
        'posiOption'      => '选项：',
        'isPercent'       => '允许按几率展现',
        'dataUrl'         => '广告数据 URL',
    ),

    'status' => array(
        'enable'  => '启用', //生效
        'disable' => '禁用', //禁用
    ),

    'type' => array(
        'attach'  => '图片',
        'text'    => '文字',
    ),

    'isPercent' => array(
        'enable'  => '允许', //生效
        'disable' => '禁止', //禁用
    ),

    /*------选择项------*/
    'option' => array(
        'allStatus'       => '所有状态',
        'batch'           => '批量操作',
        'del'             => '永久删除',
        'cache'           => '刷新缓存',
        'please'          => '请选择',
    ),

    /*------按钮------*/
    'btn' => array(
        'submit'      => '提交',
        'del'         => '永久删除',
        'save'        => '保存',
    ),

    /*------确认框------*/
    'confirm' => array(
        'del'     => '确认永久删除吗？此操作不可恢复！',
    ),

    'text' => array(
        'posiCodeNote'    => '该代码用于显示广告，请根据实际情况灵活运用。建议将示例代码中的 <mark>jQuery 库</mark> 和 <mark>广告样式</mark> 放置在网页的 <code>head</code> 之间，<mark>显示容器</mark> 放置在网页显示广告的位置，其余部分放置在网页的 <code>body</code> 末尾。特别注意：如果广告脚本基于 JS 库开发，如 jQuery 等，还需要引入 JS 库，具体请查看相关文档。',
    ),
);
