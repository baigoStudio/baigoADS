/*
v1.0.1 jQuery baigo ADS 卷帘 插件
(c) 2013 baigo studio - https://www.baigo.net/ads/
License: http://www.opensource.org/licenses/mit-license.php
*/

;(function($){
  $.fn.adsCurtain = function(options) {
    'use strict';
    var thisObj = $(this); //定义当前对象

    var defaults = {
      data_url: '',
      selector: {
        box: '.curtain-child'
      },
      class_name: {
        box: 'curtain-child',
        img: 'curtain-child-img'
      },
      loading: 'Loading...',
      remain: 5000,
      speed: 'slow'
    };

    var opts = $.extend(defaults, options);

    var _str_conn;

    if (opts.data_url.indexOf('?') > 0) {
      _str_conn = '&';
    } else {
      _str_conn = '?';
    }

    $.ajax({
      url: opts.data_url + _str_conn + new Date().getTime() + 'at' + Math.random(), //url
      type: 'get',
      dataType: 'jsonp', //数据格式为jsonp
      data: '',
      beforeSend: function(){
        thisObj.html('<div class="' + opts.class_name.box + '">' + opts.loading + '</div>');
      }, //输出消息
      success: function(_result){ //读取返回结果
        if (typeof _result.posiRow != 'undefined' && typeof _result.advertRows[0] != 'undefined') {
          var _posiRow    = _result.posiRow;
          var _advertRow  = _result.advertRows[0];
          var _attachRow  = _advertRow.attachRow;
          var _str_content;
          var _str_href;
          var _posiOpts = opts;

          if (typeof _posiRow.posi_opts != 'undefined') {
            _posiOpts = $.extend(_posiOpts, _posiRow.posi_opts);
          }

          if (typeof _advertRow.advert_href != 'undefined') {
            _str_href = _advertRow.advert_href;
          }

          if (typeof _attachRow.attach_url != 'undefined') {
            _str_content = '<img src="' + _attachRow.attach_url + '" class="' + opts.class_name.img + '" id="posi-' + _posiRow.posi_id + '-attach-' + _attachRow.attach_id + '" alt="' + _advertRow.advert_name + '" title="' + _advertRow.advert_name + '">';
          } else if (typeof _advertRow.advert_content != 'undefined') {
            _str_content = _advertRow.advert_content;
          } else {
            _str_content = _advertRow.advert_name;
          }

          var _str_advert = '<a href="' + _str_href + '" target="_blank" title="' + _advertRow.advert_name + '">' + _str_content + '</a>';

          thisObj.find(opts.selector.box).html(_str_advert);

          setTimeout(function(){
            thisObj.find(opts.selector.box).slideUp(_posiOpts.speed);
          }, _posiOpts.remain);
        }
      }
    });
  };
})(jQuery);
