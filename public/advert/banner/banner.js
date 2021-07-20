/*
v1.0.1 jQuery baigo ADS banner 插件
(c) 2013 baigo studio - http://www.baigo.net/ads/
License: http://www.opensource.org/licenses/mit-license.php
*/

;(function($){
    $.fn.adsBanner = function(options) {
        'use strict';
        var thisObj = $(this); //定义当前对象

        var defaults = {
            data_url: '', //数据 url
            selector: {
                box: '.banner-child' //子容器选择器
            },
            class_name: {
                box: 'banner-child', //子容器 class
                img: 'banner-child-img' //图片 class
            },
            loading: 'Loading...'
        };

        var opts = $.extend(defaults, options);

        var _str_conn;

        if (opts.data_url.indexOf('?') > 0) {
            _str_conn = '&';
        } else {
            _str_conn = '?';
        }

        $.ajax({
            url: opts.data_url + _str_conn + new Date().getTime() + 'at' + Math.random(), //url
            type: 'get',
            dataType: 'jsonp', //数据格式为jsonp
            data: '',
            beforeSend: function(){
                thisObj.html('<div class="' + opts.class_name.box + '">' + opts.loading + '</div>'); //向容器添加子容器
            },
            success: function(_result){ //读取返回结果
                if (typeof _result.posiRow != 'undefined' && typeof _result.advertRows[0] != 'undefined') {
                    var _posiRow    = _result.posiRow; //广告位信息
                    var _advertRow  = _result.advertRows[0]; //广告信息
                    var _attachRow  = _advertRow.attachRow; //附件信息
                    var _str_content; //广告内容
                    var _str_href; //广告链接

                    if (typeof _advertRow.advert_href != 'undefined') {
                        _str_href = _advertRow.advert_href;
                    }

                    //console.log(_attachRow);

                    if (typeof _attachRow.attach_url != 'undefined') {
                        _str_content = '<img src="' + _attachRow.attach_url + '" class="' + opts.class_name.img + '" id="posi-' + _posiRow.posi_id + '-attach-' + _attachRow.attach_id + '" alt="' + _advertRow.advert_name + '" title="' + _advertRow.advert_name + '">'; //图片
                    } else if (typeof _advertRow.advert_content != 'undefined') {
                        _str_content = _advertRow.advert_content; //文字
                    } else {
                        _str_content = _advertRow.advert_name;
                    }

                    var _str_advert = '<a href="' + _str_href + '" target="_blank" title="' + _advertRow.advert_name + '">' + _str_content + '</a>'; //广告 html

                    thisObj.find(opts.selector.box).html(_str_advert); //将广告 html 添加至子容器
                }
            }
        });
    };
})(jQuery);
