<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

for ($_iii=1;$_iii<=10;$_iii++) {
    $_arr_percent[$_iii] = $_iii * 10 . "%";
}

/*-------------------------类型-------------------------*/
return array(
    "ui" => array(
        "default" => "标准", //标准
        "mobile"  => "移动设备", //标准
    ),

    "lang" => array(
        "zh_CN"   => "简体中文", //简体中文
        "en"      => "English", //English
    ),

    "admin" => array(
        "normal"    => "普通管理员",
        "super"     => "超级管理员",
    ),

    "put" => array(
        "date"    => "按日期",
        "show"    => "按展示数",
        "hit"     => "按点击数",
        "none"    => "无限制",
        "subs"    => "替补广告",
    ),

    "posi" => array(
        "media"   => "图片",
        "text"    => "文字",
    ),

    "percent" => $_arr_percent,

    "stat" => array(
        "day"     => "日统计",
        "month"   => "月统计",
        "year"    => "年统计",
    ),

    "target" => array(
        "advert"  => "广告",
        "posi"    => "广告位",
    ),

    "ext" => array(
        "mysqli"      => "Mysqli 扩展库", //栏目类型
        "gd"          => "GD 扩展库", //栏目类型
        "mbstring"    => "mbstring 扩展库", //栏目类型
        "curl"        => "cURL 扩展库", //栏目类型
    ),
);
