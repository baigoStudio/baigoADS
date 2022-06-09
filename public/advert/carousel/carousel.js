/*
v1.0.1 jQuery baigo ADS 轮播 插件
(c) 2013 baigo studio - https://www.baigo.net/ads/
License: http://www.opensource.org/licenses/mit-license.php
*/

;(function($){
  $.fn.adsCarousel = function(options) {
    'use strict';
    var thisObj = $(this); //定义当前对象

    var defaults = {
      data_url: '',
      selector: {
        box: '.carousel-child'
      },
      class_name: {
        box: 'carousel-child',
        img: 'carousel-child-img'
      },
      effect: 'slide',
      indicator: 'on',
      caption: 'on',
      advert_name: 'on',
      loading: 'Loading...'
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
        if (typeof _result.posiRow != 'undefined' && typeof _result.advertRows != 'undefined') {
          var _posiRow = _result.posiRow;
          var _str_advert;
          var _posiOpts = opts;

          if (typeof _posiRow.posi_opts != 'undefined') {
            _posiOpts = $.extend(_posiOpts, _posiRow.posi_opts);
          }

          _str_advert = '<div id="posi' + _posiRow.posi_id + '-carousel" class="carousel slide';

          if (_posiOpts.effect == 'fade') {
            _str_advert += ' carousel-fade';
          }

          _str_advert += '" data-ride="carousel">';

          if (_posiOpts.indicator === 'on') {
             _str_advert += '<ol class="carousel-indicators">';

            $.each(_result.advertRows, function(_key, _value){
              _str_advert += '<li data-target="#posi' + _posiRow.posi_id + '-carousel" data-slide-to="' + _key + '"';
              if (_key < 1) {
                _str_advert += ' class="active"';
              }
              _str_advert += '></li>';
            });

            _str_advert += '</ol>';
          }

          _str_advert += '<div class="carousel-inner">';

          $.each(_result.advertRows, function(_key, _value){
            var _attachRow = _value.attachRow;
            var _str_href;
            var _str_content;

            if (typeof _value.advert_href != 'undefined') {
              _str_href = _value.advert_href;
            }

            if (typeof _attachRow.attach_url != 'undefined') {
              _str_content = '<img src="' + _attachRow.attach_url + '" class="' + opts.class_name.img + '" id="posi-' + _posiRow.posi_id + '-attach-' + _attachRow.attach_id + '" alt="' + _advertRow.advert_name + '" title="' + _advertRow.advert_name + '">';
            } else if (typeof _value.advert_content != 'undefined') {
              _str_content = _value.advert_content;
            } else {
              _str_content = _value.advert_name;
            }

            _str_advert += '<div class="carousel-item';

            if (_key < 1) {
              _str_advert += ' active';
            }

            _str_advert += '">' +

            '<a href="' + _str_href + '" target="_blank">' + _str_content + '</a>';

            if (_posiOpts.caption === 'on') {
              _str_advert += '<div class="carousel-caption d-none d-md-block">';

              if (_posiOpts.advert_name === 'on') {
                _str_advert += '<h5>' + _value.advert_name + '</h5>';
              }

              if (typeof _value.advert_content != 'undefined') {
                _str_advert += '<p>' + _value.advert_content + '</p>';
              }

              _str_advert += '</div>';
            }

            _str_advert += '</div>';
          });

          _str_advert += '</div>';

          if (_posiOpts.control === 'on') {
            _str_advert += '<a class="carousel-control-prev" href="#posi' + _posiRow.posi_id + '-carousel" data-slide="prev">' +
              '<span class="carousel-control-prev-icon" aria-hidden="true"></span>' +
              '<span class="sr-only">Previous</span>' +
            '</a>' +
            '<a class="carousel-control-next" href="#posi' + _posiRow.posi_id + '-carousel" data-slide="next">' +
              '<span class="carousel-control-next-icon" aria-hidden="true"></span>' +
              '<span class="sr-only">Next</span>' +
            '</a>';
          }

          _str_advert += '</div>';

          thisObj.find(opts.selector.box).html(_str_advert);
        }
      }
    });
  };
})(jQuery);
