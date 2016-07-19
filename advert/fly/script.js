/*
v0.0.9 jQuery baigoADS 飘动 插件
(c) 2013 baigo studio - http://www.baigo.net/ads/
License: http://www.opensource.org/licenses/mit-license.php
*/

(function($) {
    jQuery.fn.adsFly = function(options) {
        "use strict";
        var thisObj       = $(this); //定义当前对象
        var _parent_id    = thisObj.attr("id");

        var xD            = 0;
        var yD            = 0;
        var i             = 1;

        var defaults = {
            speed: 15,
            pos_x: 0,
            pos_y: 0,
            close: "&times; close"
        };

        var opts = $.extend(defaults, options);

        var ownTop    = opts.pos_x;
        var ownLeft   = opts.pos_y;

        var imgPosition = function() {
            var winWidth     = $(window).width() - thisObj.width();
            var winHeight    = $(window).height() - thisObj.height();
            if (xD === 0) {
                ownLeft += i;
                thisObj.css({
                    left: ownLeft
                });
                if (ownLeft >= winWidth) {
                    ownLeft = winWidth;
                    xD = 1;
                }
            }
            if (xD == 1) {
                ownLeft -= i;
                thisObj.css({
                    left: ownLeft
                });
                if (ownLeft <= 0) xD = 0;
            }
            if (yD === 0) {
                ownTop += i;
                thisObj.css({
                    top: ownTop
                });
                if (ownTop >= winHeight) {
                    ownTop = winHeight;
                    yD = 1;
                }
            }
            if (yD == 1) {
                ownTop -= i;
                thisObj.css({
                    top: ownTop
                });
                if (ownTop <= 0) yD = 0;
            }
        };

        var imgHover = setInterval(imgPosition, opts.speed);
        thisObj.hover(function(){
            clearInterval(imgHover);
        },
        function(){
            imgHover = setInterval(imgPosition, opts.speed);
        });

        $.ajax({
            url: opts.data_url, //url
            type: "get",
            dataType: "jsonp", //数据格式为jsonp
            data: "",
            beforeSend: function(){
                var _str_advert = "<div class='flyChild'></div>";
                thisObj.html(_str_advert);

                $("#" + _parent_id + " .flyChild").text(opts.loading);
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

                $("#" + _parent_id + " .flyChild").html(_str_advert);

                $("#" + _parent_id + " .flyChild .btn_close").click(function(){
                    $("#" + _parent_id + " .fixedChild").hide();
                });
            }
        });
    };
})(jQuery);