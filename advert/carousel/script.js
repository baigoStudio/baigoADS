/*
v1.0 jQuery baigo ADS 轮播 插件
(c) 2013 baigo studio - http://www.baigo.net/ads/
License: http://www.opensource.org/licenses/mit-license.php
*/

(function($){
    $.fn.adsCarousel = function(options) {
        "use strict";
        var thisObj = $(this); //定义当前对象
        var _parent_id = thisObj.attr("id");
        var _posiRow;
        var _str_advert;
        var _str_media;
        var _str_href;
        var _num_posiId;

        var defaults = {
            loading: "Loading..."
        };

        var opts = $.extend(defaults, options);

        $.ajax({
            url: opts.data_url, //url
            type: "get",
            dataType: "jsonp", //数据格式为jsonp
            data: "",
            beforeSend: function(){
                _str_advert = "<div class='carouselChild'></div>";
                thisObj.html(_str_advert);

                $("#" + _parent_id + " .carouselChild").text(opts.loading);
            }, //输出消息
            success: function(_result){ //读取返回结果
                if (typeof _result.posiRow != "undefined") {
                    _posiRow = _result.posiRow;

                    if (typeof _posiRow.posi_id != "undefined") {
                        _num_posiId = _posiRow.posi_id;
                    }

                    if (typeof _result.advertRows != "undefined") {
                        _str_advert = "<div id='carousel_" + _num_posiId + "' class='carousel slide' data-ride='carousel'><ol class='carousel-indicators'>";

                        $.each(_result.advertRows, function(_key, _value){
                            _str_advert += "<li data-target='#carousel_" + _num_posiId + "' data-slide-to='" + _key + "'";
                            if (_key < 1) {
                                _str_advert += " class='active'";
                            }
                            _str_advert += "></li>";
                        });

                        _str_advert += "</ol><div class='carousel-inner'>";

                        $.each(_result.advertRows, function(_key, _value){
                            if (typeof _value.advert_href != "undefined") {
                                _str_href = _value.advert_href;
                            }

                            if (typeof _posiRow.posi_type != "undefined" && _posiRow.posi_type == "media" && typeof _value.mediaRow.media_url != "undefined") {
                                _str_media = "<img src='" + _value.mediaRow.media_url + "' width='100%'>";
                            } else if (typeof _value.advert_content != "undefined") {
                                _str_media = _value.advert_content;
                            }

                            _str_advert += "<div class='item";
                            if (_key < 1) {
                                _str_advert += " active";
                            }

                            _str_advert += "'><a href='" + _str_href + "' target='_blank'>" + _str_media + "</a></div>";
                        });

                        _str_advert += "</div><a class='left carousel-control' href='#carousel_" + _num_posiId + "' data-slide='prev'><span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span><span class='sr-only'>Previous</span></a><a class='right carousel-control' href='#carousel_" + _num_posiId + "' data-slide='next'><span class='glyphicon glyphicon-chevron-right' aria-hidden='true'></span><span class='sr-only'>Next</span></a></div>";

                        $("#" + _parent_id + " .carouselChild").html(_str_advert);
                    }
                }
            }
        });
    };
})(jQuery);


