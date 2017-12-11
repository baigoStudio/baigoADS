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
        'show'            => '查看',
        'stat'            => '统计',
    ),

    /*------说明文字------*/
    'label' => array(
        'id'              => 'ID',
        'all'             => '全部',
        'type'            => '类型',
        'status'          => '状态',
        'note'            => '备注',
        'posi'            => '广告位',
        'key'             => '关键词',

        'advert'          => '广告',
        'advertName'      => '广告名称',
        'advertUrl'       => '链接地址',
        'advertBegin'     => '生效时间',
        'advertPutType'   => '投放类型',
        'advertPutDate'   => '结束时间',
        'advertPutShow'   => '展示数不超过',
        'advertPutHit'    => '点击数不超过',
        'advertPercent'   => '展现几率',
        'advertMedia'     => '图片',
        'advertMediaNote' => '您也可以直接输入图片 ID',
        'advertContent'   => '文字内容',
        'advertShow'      => '总展示数',
        'advertHit'       => '总点击数',
        'advertStatShow'  => '展示数',
        'advertStatHit'   => '点击数',
    ),

    'status' => array(
        'enable'    => '启用', //生效
        'disable'   => '禁用', //禁用
        'wait'      => '待审', //待审
        'expired'   => '过期',
    ),

    'type' => array(
        'media'   => '图片',
        'text'    => '文字',
    ),

    'putType' => array(
        'date'    => '按日期',
        'show'    => '按展示数',
        'hit'     => '按点击数',
        'none'    => '无限制',
        'subs'    => '替补广告',
    ),

    /*------选择项------*/
    'option' => array(
        'please'          => '请选择',
        'allStatus'       => '所有状态',
        'allPosi'         => '所有广告位', //所有类型
        'batch'           => '批量操作',
        'del'             => '永久删除',
    ),

    /*------按钮------*/
    'btn' => array(
        'ok'          => '确定',
        'submit'      => '提交',
        'select'      => '选取图片 ...',
        'save'        => '保存',
    ),

    /*------确认框------*/
    'confirm' => array(
        'del'     => '确认永久删除吗？此操作不可恢复！',
    ),
);
