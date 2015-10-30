/*
v0.0.9 jQuery baigoADS 卷帘 插件
(c) 2013 baigo studio - http://www.baigo.net/ads/
License: http://www.opensource.org/licenses/mit-license.php
*/

(function($){
	$.fn.adsPopup = function(options) {

    	var thisObj = $(this); //定义当前对象
		var _parent_id = thisObj.attr("id");

		var defaults = {
			loading: "Loading...",
			position: "right-bottom",
			top: 0,
			bottom: 0,
			left: 0,
			right: 0,
			remain: 10000,
			speed: "slow",
			close: "&times; close"
		}

		var opts = $.extend(defaults, options);

		switch (opts.position) {
			case "left-top":
				var _css_posi = { top: opts.top, left: opts.left };
			break;

			case "right-top":
				var _css_posi = { top: opts.top, right: opts.right };
			break;

			case "left-bottom":
				var _css_posi = { bottom: opts.bottom, left: opts.left };
			break;

			default:
				var _css_posi = { bottom: opts.bottom, right: opts.right };
			break;
		}

		$.ajax({
			url: opts.data_url, //url
			type: "get",
			dataType: "json", //数据格式为json
			data: "",
			beforeSend: function(){
				var _str_advert = "<div class='popupChild'></div>";
				thisObj.html(_str_advert);

				$("#" + _parent_id + " .popupChild").css(_css_posi);
				$("#" + _parent_id + " .popupChild").text(opts.loading);
			}, //输出消息
			success: function(_result){ //读取返回结果
				var _posiRow = _result.posiRow;

				var _str_media;
				if (_posiRow.posi_type == "media") {
					_str_media = "<img src='" + _result.advertRows[0].mediaRow.media_url + "' width='" + _posiRow.posi_width + "' height='" + _posiRow.posi_height + "'>";
				} else {
					_str_media = _result.advertRows[0].advert_content;
				}

				var _str_advert = "<div class='btn_close'><a href='javascript:void(0);'>" + opts.close + "</a></div><div><a href='" + _result.advertRows[0].advert_href + "' target='_blank'>" + _str_media + "</a></div>";

				$("#" + _parent_id + " .popupChild").html(_str_advert);

				$("#" + _parent_id + " .popupChild").slideDown(opts.speed);

				setTimeout(function(){
					$("#" + _parent_id + " .popupChild").slideUp(opts.speed);
				}, opts.remain);

				$("#" + _parent_id + " .popupChild .btn_close").click(function(){
					$("#" + _parent_id + " .popupChild").slideUp(opts.speed);
				});
			}
		});
	}

})(jQuery);