/*
v1.0.2 jQuery baigoClear plugin 表单 ajax 清理插件
(c) 2013 baigo studio - http://www.baigo.net/
License: http://www.opensource.org/licenses/mit-license.php
*/
(function($) {
    $.fn.baigoClear = function(options) {
        "use strict";
        if (this.length < 1) {
            return this;
        }
        // support mutltiple elements
        if (this.length > 1) {
            this.each(function() {
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
            msg_complete: "Complete",
            msg_err: "Error"
        };
        var opts = $.extend(defaults, options);
        var appendMsg = function(_status, _msg) {
            $(opts.msg_selector).empty();
            var _str_msg = "<div class=\"alert alert-" + _status + "\">" + _msg + "</div>";
            $(opts.msg_selector).html(_str_msg);
        };
            //确认消息
        var clearConfirm = function() {
            if (typeof opts.confirm_selector == "undefined") {
                return true;
            } else {
                var _form_action = $(opts.confirm_selector).val();
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
        };
        var _count = 0;
        var clearAjax = function(_page, _min_id, _max_id) {
            //alert(_page);
            var formData = $(thisForm).serializeArray();
            var _str_msgResult;
            formData.push({
                name: "page",
                value: _page
            });
            formData.push({
                name: "min_id",
                value: _min_id
            });
            formData.push({
                name: "max_id",
                value: _max_id
            });
            $.ajax({
                url: opts.ajax_url,
                type: "post",
                dataType: "json",
                data: formData,
                success: function(_result) { //读取返回结果
                    if (_count < 1) {
                        _count = _result.count;
                    }
                    var _width = parseInt(_page / _count * 100 + "%");
                    if (_width > 100) {
                        _width = 100;
                    }
                    switch (_result.status) {
                        case "err":
                            if (typeof _result.msg != "undefined") {
                                _str_msgResult = _result.msg;
                            } else {
                                _str_msgResult = opts.msg_err;
                            }
                            appendMsg("danger", _str_msgResult);
                            _count  = 0;
                            _page   = 1;
                        break;
                        case "complete":
                            if (typeof _result.msg != "undefined") {
                                _str_msgResult = _result.msg;
                            } else {
                                _str_msgResult = opts.msg_complete;
                            }
                            appendMsg("success", _str_msgResult);
                            $(opts.box_selector + " .progress-bar").text("100%");
                            $(opts.box_selector + " .progress-bar").css("width", "100%");
                            _count  = 0;
                            _page   = 1;
                        break;
                        case "next":
                            if (typeof _result.msg != "undefined") {
                                _str_msgResult = _result.msg;
                            } else {
                                _str_msgResult = opts.msg_loading;
                            }
                            appendMsg("info", _str_msgResult);
                            _width = 20;
                            $(opts.box_selector + " .progress-bar").text(_width + "%");
                            $(opts.box_selector + " .progress-bar").css("min-width", "20%");
                            $(opts.box_selector + " .progress-bar").css("width", _width + "%");
                            clearAjax(1, 0, _result.max_id);
                        break;
                        default:
                            if (typeof _result.msg != "undefined") {
                                _str_msgResult = _result.msg;
                            } else {
                                _str_msgResult = opts.msg_loading;
                            }
                            appendMsg("info", _str_msgResult);
                            $(opts.box_selector + " .progress-bar").text(_width + "%");
                            $(opts.box_selector + " .progress-bar").css("min-width", "20%");
                            $(opts.box_selector + " .progress-bar").css("width", _width + "%");
                            clearAjax(_page, 0, _result.max_id);
                        break;
                    }
                }
            });
            _page++;
        };
        //ajax提交
        el.clearSubmit = function() {
            if (clearConfirm()) {
                clearAjax(1, 0);
            }
        };
        return this;
    };
})(jQuery);