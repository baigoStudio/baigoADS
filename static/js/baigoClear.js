/*
v0.0.9 jQuery baigoClear plugin 表单 ajax 清理插件
(c) 2013 baigo studio - http://www.baigo.net/
License: http://www.opensource.org/licenses/mit-license.php
*/

(function($){
	$.fn.baigoClear = function(options) {

		if(this.length == 0) {
			return this;
		}

		// support mutltiple elements
		if(this.length > 1){
			this.each(function(){
				$(this).baigoClear(options);
			});
			return this;
		}

    	var thisForm = $(this); //定义表单对象
		var el = this;

		var defaults = {
			box_selector: ".baigoClear",
			msg_selector: ".baigoClearMsg",
			msg_loading: "Loading...",
			msg_complete: "Complete"
		}

		var opts = $.extend(defaults, options);

		var appendMsg = function(_status, _msg) {
			$(opts.msg_selector).empty();
			var _str_msg = "<div class=\"alert alert-" + _status + "\">" + _msg + "</div>";
			$(opts.msg_selector).html(_str_msg);
		}

		//确认消息
		var clearConfirm = function() {
			if (typeof opts.confirm_id == "undefined") {
				return true;
			} else {
				var _form_action = $("#" + opts.confirm_id).val();
				if (_form_action == opts.confirm_val) {
					if (confirm(opts.confirm_msg)) {
						return true;
					} else {
						return false;
					}
				} else {
					return true;
				}
			}
		}

		var _count = 0;

		var clearAjax = function(_page, _last) {
			//alert(_page);
			var formData = $(thisForm).serializeArray();
			formData.push({ name: "page", value: _page });
			formData.push({ name: "last", value: _last });
			$.ajax({
				url: opts.ajax_url, //url
				//async: false, //设置为同步
				type: "post",
				dataType: "json", //数据格式为json
				data: formData,
				success: function(_result){ //读取返回结果
					if (_count == 0) {
						_count = _result.count;
					}
					var _width = parseInt(_page / _count * 100 + "%");
					if (_width > 100) {
						_width = 100;
					}

					switch (_result.status) {
						case "err":
							appendMsg("danger", _result.msg);
							_count   = 0;
							_page    = 1;
						break;

						default:
							if (_page <= _count) {
								appendMsg("info", opts.msg_loading);
								$(opts.box_selector + " .progress-bar").text(_width + "%");
								$(opts.box_selector + " .progress-bar").css("min-width", "20%");
								$(opts.box_selector + " .progress-bar").css("width", _width + "%");
								clearAjax(_page, _result.last);
							} else {
								appendMsg("success", opts.msg_complete);
								$(opts.box_selector + " .progress-bar").text("100%");
								$(opts.box_selector + " .progress-bar").css("width", "100%");
								$(opts.box_selector + " .progress-bar").attr("class", "progress-bar progress-bar-success");
								_count  = 0;
								_page   = 1;
							}
						break;
					}
				}
			});

			_page++;
		}

		//ajax提交
		el.clearSubmit = function() {
			if (clearConfirm()) {
				clearAjax(1, 0);
			}
		}

		return this;
	}

})(jQuery);