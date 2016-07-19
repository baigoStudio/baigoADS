/*
v0.0.9 jQuery baigoADS 巨幕 插件
(c) 2013 baigo studio - http://www.baigo.net/ads/
License: http://www.opensource.org/licenses/mit-license.php
*/

(function($){
    $.fn.adsJumbotron = function(options) {
        "use strict";
        var thisObj = $(this); //定义当前对象
        var _parent_id = thisObj.attr("id");

        var defaults = {
            loading: "Loading...",
            remain: 5000,
            speed: "slow"
        };

        var opts = $.extend(defaults, options);

        $.ajax({
            url: opts.data_url, //url
            type: "get",
            dataType: "jsonp", //数据格式为jsonp
            data: "",
            beforeSend: function(){
                var _str_advert = "<div class='jumbotronChild'></div>";
                thisObj.html(_str_advert);

                $("#" + _parent_id + " .jumbotronChild").text(opts.loading);
            }, //输出消息
            success: function(_result){ //读取返回结果
                var _posiRow = _result.posiRow;

                var _str_media;
                if (_posiRow.posi_type == "media") {
                    _str_media = "<img src='" + _result.advertRows[0].mediaRow.media_url + "' width='100%'>";
                } else {
                    _str_media = _result.advertRows[0].advert_content;
                }

                var _str_advert = "<div><a href='" + _result.advertRows[0].advert_href + "' target='_blank'>" + _str_media + "</a></div>";

                $("#" + _parent_id + " .jumbotronChild").html(_str_advert);

                setTimeout(function(){
                    $("#" + _parent_id + " .jumbotronChild").slideUp(opts.speed);
                }, opts.remain);
            }
        });
    };
})(jQuery);