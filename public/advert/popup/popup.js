/*
v1.0.1 jQuery baigo ADS 弹窗 插件
(c) 2013 baigo studio - https://www.baigo.net/ads/
License: http://www.opensource.org/licenses/mit-license.php
*/

;(function($){
  $.fn.adsPopup = function(options) {
    'use strict';
    var thisObj = $(this); //定义当前对象

    var defaults = {
      data_url: '',
      selector: {
        btn_close: '.btn-close',
        box: '.popup-child'
      },
      class_name: {
        btn_close: 'btn-close',
        box: 'popup-child',
        img: 'popup-child-img'
      },
      loading: 'Loading...',
      position: 'right-bottom',
      top: '5px',
      bottom: '5px',
      left: '5px',
      right: '5px',
      remain: 10000,
      speed: 'slow'
    };

    var opts = $.extend(defaults, options);

    var adPosition = function(posiOpts) {
      var _css_posi;

      switch (posiOpts.position) {
        case 'right-top':
          _css_posi = { top: posiOpts.top, right: posiOpts.right };
        break;

        case 'left-bottom':
          _css_posi = { bottom: posiOpts.bottom, left: posiOpts.left };
        break;

        case 'right-bottom':
          _css_posi = { bottom: posiOpts.bottom, right: posiOpts.right };
        break;

        default:
          _css_posi = { top: posiOpts.top, left: posiOpts.left };
        break;
      }

      thisObj.find(opts.selector.box).css(_css_posi);
    }

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

          adPosition(_posiOpts);

          if (typeof _advertRow.advert_href != 'undefined') {
            _str_href = _advertRow.advert_href;
          }

          if (typeof _advertRow.attachRow.attach_url != 'undefined') {
            _str_content = '<img src="' + _attachRow.attach_url + '" class="' + opts.class_name.img + '" id="posi-' + _posiRow.posi_id + '-attach-' + _attachRow.attach_id + '" alt="' + _advertRow.advert_name + '" title="' + _advertRow.advert_name + '">';
          } else if (typeof _advertRow.advert_content != 'undefined') {
            _str_content = _advertRow.advert_content;
          } else {
            _str_content = _advertRow.advert_name;
          }

          var _str_advert = '<div><a href="' + _str_href + '" target="_blank">' + _str_content + '</a></div><div class="' + opts.class_name.btn_close + '"><a href="javascript:void(0);">&times; ' + _posiRow.posi_close + '</a></div>';

          thisObj.find(opts.selector.box).html(_str_advert);

          thisObj.find(opts.selector.box).slideDown(_posiOpts.speed);

          setTimeout(function(){
            thisObj.find(opts.selector.box).slideUp(_posiOpts.speed);
          }, _posiOpts.remain);

          thisObj.find(opts.selector.box).on('click', opts.selector.btn_close, function(){
            thisObj.find(opts.selector.box).hide();
          });
        }
      }
    });
  };
})(jQuery);
