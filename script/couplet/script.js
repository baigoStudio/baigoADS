/*
v0.0.9 jQuery baigoADMS 对联 插件
(c) 2013 baigo studio - http://www.baigo.net/adms/
License: http://www.opensource.org/licenses/mit-license.php
*/

(function($){
	$.fn.admsCouplet = function(options) {

    	var thisObj = $(this); //定义当前对象
		var _parent_id = thisObj.attr("id");

		var defaults = {
			loading: "Loading...",
			position: "top",
			top: "50px",
			bottom: "50px",
			left: "10px",
			right: "10px",
			close: "&times; close"
		}

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
			dataType: "json", //数据格式为json
			data: "",
			beforeSend: function(){
				var _str_advert = "<div class='coupletChild left'></div><div class='coupletChild right'></div>";
				thisObj.html(_str_advert);

				$("#" + _parent_id + " .left").css(_css_left);
				$("#" + _parent_id + " .right").css(_css_right);

				$("#" + _parent_id + " .coupletChild").text(opts.loading);
			}, //输出消息
			success: function(_result){ //读取返回结果
				var _posiRow = _result.posiRow;

				var _str_media;
				if (_posiRow.posi_type == "media") {
					_str_media = "<img src='" + _result.advertRows[0].mediaRow.media_url + "' width='" + _posiRow.posi_width + "' height='" + _posiRow.posi_height + "'>";
				} else {
					_str_media = _result.advertRows[0].advert_content;
				}

				var _str_advert = "<div><a href='" + _result.advertRows[0].advert_href + "' target='_blank'>" + _str_media + "</a></div><div class='btn_close'><a href='javascript:void(0);'>" + opts.close + "</a></div>";

				$("#" + _parent_id + " .coupletChild").html(_str_advert);

				$("#" + _parent_id + " .btn_close").click(function(){
					$("#" + _parent_id + " .coupletChild").hide();
				});
			}
		});
	}

})(jQuery);