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
    'page' => array(
        'stat'            => '统计',
    ),

    /*------链接文字------*/
    'href' => array(
        'statYear'        => '年统计',
        'statMonth'       => '月统计',
        'statDay'         => '日统计',
    ),

    'label' => array(
        'id'              => 'ID',
        'note'            => '备注',
        'status'          => '状态',

        'statYear'        => '年度',
        'statMonth'       => '月份',
        'statDay'         => '日期',

        'posi'            => '广告位',
        'posiName'        => '广告位名称',
        'contentType'     => '广告内容',

        'advert'          => '广告',
        'advertName'      => '广告名称',
        'advertUrl'       => '链接地址',
        'advertStatShow'  => '展示数',
        'advertStatHit'   => '点击数',
        'advertBegin'     => '生效时间',
        'advertPutDate'   => '结束时间',
        'advertPutShow'   => '展示数不超过',
        'advertPutHit'    => '点击数不超过',
        'advertPercent'   => '展现几率',
        'advertShow'      => '总展示数',
        'advertHit'       => '总点击数',
    ),

    'status' => array(
        'enable'  => '启用', //生效
        'disable' => '禁用', //禁用
    ),

    'type' => array(
        'media'   => '图片',
        'text'    => '文字',
    ),

    'option' => array(
        'allYear'         => '所有年份', //所有年份
        'allMonth'        => '所有月份', //所有月份
    ),

    /*------按钮------*/
    'btn' => array(
        'more'        => '更多详情', //清空回收站
    ),
);
