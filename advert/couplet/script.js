/*
v1.0 jQuery baigo ADS 对联 插件
(c) 2013 baigo studio - http://www.baigo.net/ads/
License: http://www.opensource.org/licenses/mit-license.php
*/

(function($){
    $.fn.adsCouplet = function(options) {
        "use strict";
        var thisObj = $(this); //定义当前对象
        var _parent_id = thisObj.attr("id");
        var _posiRow;
        var _str_advert;
        var _str_media;
        var _str_href;

        var defaults = {
            loading: "Loading...",
            position: "top",
            top: "50px",
            bottom: "50px",
            left: "10px",
            right: "10px",
            close: "&times; close"
        };

        var opts = $.extend(defaults, options);

        switch (opts.position) {
            case "bottom":
                _css_left     = { bottom: opts.bottom, left: opts.left };
                _css_right    = { bottom: opts.bottom, right: opts.right };
            break;

            default:
                _css_left     = { top: opts.top, left: opts.left };
                _css_right    = { top: opts.top, right: opts.right };
            break;
        }

        $.ajax({
            url: opts.data_url, //url
            type: "get",
            dataType: "jsonp", //数据格式为jsonp
            data: "",
            beforeSend: function(){
                _str_advert = "<div class='coupletChild left'></div><div class='coupletChild right'></div>";
                thisObj.html(_str_advert);

                $("#" + _parent_id + " .left").css(_css_left);
                $("#" + _parent_id + " .right").css(_css_right);

                $("#" + _parent_id + " .coupletChild").text(opts.loading);
            }, //输出消息
            success: function(_result){ //读取返回结果
                if (typeof _result.posiRow != "undefined" && typeof _result.advertRows[0] != "undefined") {
                    _posiRow = _result.posiRow;

                    if (typeof _result.advertRows[0].advert_href != "undefined") {
                        _str_href = _result.advertRows[0].advert_href;
                    }

                    if (typeof _posiRow.posi_type != "undefined" && _posiRow.posi_type == "media" && typeof _result.advertRows[0].mediaRow.media_url != "undefined") {
                        _str_media = "<img src='" + _result.advertRows[0].mediaRow.media_url + "' width='100%'>";
                    } else if (typeof _result.advertRows[0].advert_content != "undefined") {
                        _str_media = _result.advertRows[0].advert_content;
                    }

                    _str_advert = "<div><a href='" + _str_href + "' target='_blank'>" + _str_media + "</a></div><div class='btn_close'><a href='javascript:void(0);'>" + opts.close + "</a></div>";

                    $("#" + _parent_id + " .coupletChild").html(_str_advert);

                    $("#" + _parent_id + " .btn_close").click(function(){
                        $("#" + _parent_id + " .coupletChild").hide();
                    });
                }
            }
        });
    };

})(jQuery);