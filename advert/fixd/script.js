/*
v0.0.9 jQuery baigoADS 定位 插件
(c) 2013 baigo studio - http://www.baigo.net/ads/
License: http://www.opensource.org/licenses/mit-license.php
*/

(function($){
    $.fn.adsFixed = function(options) {
        "use strict";
        var thisObj = $(this); //定义当前对象
        var _parent_id = thisObj.attr("id");

        var defaults = {
            loading: "Loading...",
            position: "left-top",
            top: "10px",
            bottom: "10px",
            left: "10px",
            right: "10px",
            close: "&times; close"
        };

        var opts = $.extend(defaults, options);
        var _css_posi;

        switch (opts.position) {
            case "right-top":
                _css_posi = { top: opts.top, right: opts.right };
            break;

            case "left-bottom":
                _css_posi = { bottom: opts.bottom, left: opts.left };
            break;

            case "right-bottom":
                _css_posi = { bottom: opts.bottom, right: opts.right };
            break;

            default:
                _css_posi = { top: opts.top, left: opts.left };
            break;
        }

        $.ajax({
            url: opts.data_url, //url
            type: "get",
            dataType: "jsonp", //数据格式为jsonp
            data: "",
            beforeSend: function(){
                var _str_advert = "<div class='fixedChild'></div>";
                thisObj.html(_str_advert);

                $("#" + _parent_id + " .fixedChild").css(_css_posi);
                $("#" + _parent_id + " .fixedChild").text(opts.loading);
            }, //输出消息
            success: function(_result){ //读取返回结果
                var _posiRow = _result.posiRow;

                var _str_media;
                if (_posiRow.posi_type == "media") {
                    _str_media = "<img src='" + _result.advertRows[0].mediaRow.media_url + "' width='100%'>";
                } else {
                    _str_media = _result.advertRows[0].advert_content;
                }

                var _str_advert = "<div><a href='" + _result.advertRows[0].advert_href + "' target='_blank'>" + _str_media + "</a></div><div class='btn_close'><a href='javascript:void(0);'>" + opts.close + "</a></div>";

                $("#" + _parent_id + " .fixedChild").html(_str_advert);

                $("#" + _parent_id + " .fixedChild .btn_close").click(function(){
                    $("#" + _parent_id + " .fixedChild").hide();
                });
            }
        });
    };
})(jQuery);