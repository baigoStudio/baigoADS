<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿编辑
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

/*----------后台管理模块----------*/
return array(
    "advert" => array(
        "main" => array(
            "title"  => "广告管理",
            "mod"    => "advert",
            "icon"   => "grain",
        ),
        "sub" => array(
            "list" => array(
                "title"     => "所有广告",
                "mod"       => "advert",
                "act_get"   => "list",
            ),
            "form" => array(
                "title"     => "投放广告",
                "mod"       => "advert",
                "act_get"   => "form",
            ),
        ),
        "allow" => array(
            "browse"     => "浏览",
            "add"        => "创建",
            "edit"       => "编辑",
            "del"        => "删除",
            "approve"    => "审核",
            "stat"       => "统计",
        ),
    ),
    "media" => array(
        "main" => array(
            "title"  => "图片管理",
            "mod"    => "media",
            "icon"   => "picture",
        ),
        "sub" => array(
            "list" => array(
                "title"     => "所有图片",
                "mod"       => "media",
                "act_get"   => "list",
            ),
        ),
        "allow" => array(
            "browse"     => "浏览",
            "upload"     => "上传",
            "del"        => "删除",
        ),
    ),
    "posi" => array(
        "main" => array(
            "title"  => "广告位管理",
            "mod"    => "posi",
            "icon"   => "flag",
        ),
        "sub" => array(
            "list" => array(
                "title"     => "所有广告位",
                "mod"       => "posi",
                "act_get"   => "list",
            ),
            "form" => array(
                "title"     => "创建广告位",
                "mod"       => "posi",
                "act_get"   => "form",
            ),
        ),
        "allow" => array(
            "browse" => "浏览",
            "add"    => "创建",
            "edit"   => "编辑",
            "del"    => "删除",
            "stat"   => "统计",
        ),
    ),
    "admin" => array(
        "main" => array(
            "title"  => "管理员",
            "mod"    => "admin",
            "icon"   => "user",
        ),
        "sub" => array(
            "list" => array(
                "title"     => "所有管理员",
                "mod"       => "admin",
                "act_get"   => "list",
            ),
            "form" => array(
                "title"     => "创建管理员",
                "mod"       => "admin",
                "act_get"   => "form",
            ),
            "auth" => array(
                "title"     => "授权为管理员",
                "mod"       => "admin",
                "act_get"   => "auth",
            ),
        ),
        "allow" => array(
            "browse" => "浏览",
            "add"    => "创建",
            "edit"   => "编辑",
            "del"    => "删除",
        ),
    ),
);
