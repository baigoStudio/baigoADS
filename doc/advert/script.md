## 脚本

脚本文件为一个 JS 文件。

关于此文件的命名，与描述文件有关，如描述文件的 `script_name` 未定义或为空，系统将自动生成为 `目录名.min.js`，如没有后缀，系统将自动添加 `.min.js` 后缀。

当然上述规则仅影响后台管理的 `广告位 -> 查看` 中自动生成的代码，如果您自己创建广告代码，则可以根据实际情况做出调整。

为了保证广告脚本不影响网页的正常展示，系统内置的常用广告脚本均采用异步加载的模式，广告数据通过 ajax 方式读取，格式为 JSONP。

----------

##### 关于广告尺寸

`1.0.2` 起，系统取消了广告位的尺寸定义，建议开发者和使用者采用 css 方式定义广告的尺寸。

##### 关于跨域加载

`1.0.2` 起，系统为解决 ajax 无法跨域获取广告数据的问题，变更为 JSONP 方式获取数据。

----------

### 脚本文件示例

``` javascript
;(function($){
  $.fn.adsBanner = function(options) {
    'use strict';
    var thisObj = $(this); //定义当前对象
    var _parent_id = thisObj.attr('id');
    var _posiRow;
    var _str_advert;
    var _str_attach;
    var _str_href;

    var defaults = {
      loading: 'Loading...'
    };

    var opts = $.extend(defaults, options);

    $.ajax({
      url: opts.data_url, //url
      type: 'get',
      dataType: 'jsonp', //数据格式为jsonp
      data: '',
      beforeSend: function(){
        _str_advert = '<div class="bannerChild"></div>';
        thisObj.html(_str_advert);

        $('#' + _parent_id + ' .bannerChild').text(opts.loading);
      }, //输出消息
      success: function(_result){ //读取返回结果
        //console.log(_result);
        if (typeof _result.posiRow != 'undefined' && typeof _result.advertRows[0] != 'undefined') {
          _posiRow = _result.posiRow;

          if (typeof _result.advertRows[0].advert_href != 'undefined') {
            _str_href = _result.advertRows[0].advert_href;
          }

          if (typeof _posiRow.posi_type != 'undefined' && _posiRow.posi_type == 'attach' && typeof _result.advertRows[0].attachRow.attach_url != 'undefined') {
            _str_attach = '<img src="' + _result.advertRows[0].attachRow.attach_url + '" width="100%">';
          } else if (typeof _result.advertRows[0].advert_content != 'undefined') {
            _str_attach = _result.advertRows[0].advert_content;
          }

          _str_advert = '<a href="' + _str_href + '" target="_blank">' + _str_attach + '</a>';

          $('#' + _parent_id + ' .bannerChild').html(_str_advert);
        }
      }
    });
  };
})(jQuery);
```
