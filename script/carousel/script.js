/*
v0.0.9 jQuery baigoADS 轮播 插件
(c) 2013 baigo studio - http://www.baigo.net/ads/
License: http://www.opensource.org/licenses/mit-license.php
*/

(function($){
	$.fn.adsCarousel = function(options) {

    	var thisObj = $(this); //定义当前对象
		var _parent_id = thisObj.attr("id");

		var defaults = {
			loading: "Loading..."
		}

		var opts = $.extend(defaults, options);

		$.ajax({
			url: opts.data_url, //url
			type: "get",
			dataType: "json", //数据格式为json
			data: "",
			beforeSend: function(){
				var _str_advert = "<div class='carouselChild'></div>";
				thisObj.html(_str_advert);

				$("#" + _parent_id + " .carouselChild").text(opts.loading);
			}, //输出消息
			success: function(_result){ //读取返回结果
				var _posiRow = _result.posiRow;

				var _str_advert = "<div id='carousel_" + _posiRow.posi_id + "' class='carousel slide' data-ride='carousel'><ol class='carousel-indicators'>";

				$.each(_result.advertRows, function(_key, _value){
					_str_advert += "<li data-target='#carousel_" + _posiRow.posi_id + "' data-slide-to='" + _key + "'";
					if (_key == 0) {
						_str_advert += " class='active'";
					}
					_str_advert += "></li>";
				});

				_str_advert += "</ol><div class='carousel-inner'>";

				$.each(_result.advertRows, function(_key, _value){
					_str_advert += "<div class='item";
					if (_key == 0) {
						_str_advert += " active";
					}

					var _str_media;
					if (_posiRow.posi_type == "media") {
						_str_media = "<img src='" + _value.mediaRow.media_url + "' width='" + _posiRow.posi_width + "' height='" + _posiRow.posi_height + "'>";
					} else {
						_str_media = _value.advert_content;
					}

					_str_advert += "'><a href='" + _value.advert_href + "' target='_blank'>" + _str_media + "</a></div>";
				});

				_str_advert += "</div><a class='left carousel-control' href='#carousel_" + _posiRow.posi_id + "' data-slide='prev'><span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span><span class='sr-only'>Previous</span></a><a class='right carousel-control' href='#carousel_" + _posiRow.posi_id + "' data-slide='next'><span class='glyphicon glyphicon-chevron-right' aria-hidden='true'></span><span class='sr-only'>Next</span></a></div>";

				$("#" + _parent_id + " .carouselChild").html(_str_advert);
			}
		});
	}

})(jQuery);


