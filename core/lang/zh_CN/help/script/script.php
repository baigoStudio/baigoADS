<?php
return "<h3>脚本</h3>
    <p>
        脚本文件为一个 JS 文件，必须命名为 script.js，系统将读取此文件，以便使脚本生效。
    </p>

    <p>
        为了保证广告脚本不影响网页的正常展示，系统内置的常用广告脚本均采用异步加载的模式，广告数据通过 ajax 方式读取，格式为 JSON。
    </p>

    <p>&nbsp;</p>

    <h4>脚本文件示例</h4>
    <p>
<pre><code class=\"language-javascript\">(function($){
    $.fn.adsBanner = function(options) { //定义插件名

        var thisObj = $(this);
        var _parent_id = thisObj.attr(&quot;id&quot;); //获取选择器的 ID

        var defaults = { //默认选项
            loading: &quot;Loading...&quot;
        }

        var opts = $.extend(defaults, options); //合并选项

        $.ajax({
            url: opts.data_url, //广告数据 URL
            type: &quot;get&quot;,
            dataType: &quot;json&quot;, //数据格式为json
            beforeSend: function(){ //获取广告数据前的动作
                var _str_advert = &quot;&lt;div class='bannerChild'&gt;&lt;/div&gt;&quot;; //定义类名为 bannerChild 的容器
                thisObj.html(_str_advert);  //为当前对象添加上述 HTML 代码

                $(&quot;#&quot; + _parent_id + &quot; .bannerChild&quot;).text(opts.loading); //显示正在载入消息
            },
            success: function(_result){ //获取广告数据成功后的动作
                var _posiRow = _result.posiRow; //取得广告位信息
                var _str_media; //定义广告 HTML 代码
                if (_posiRow.posi_type == &quot;media&quot;) {
                    _str_media = &quot;&lt;img src='&quot; + _result.advertRows[0].mediaRow.media_url + &quot;' width='&quot; + _posiRow.posi_width + &quot;' height='&quot; + _posiRow.posi_height + &quot;'&gt;&quot;; //如果广告位定义的广告内容为图片则生成图片代码
                } else {
                    _str_media = _result.advertRows[0].advert_content; //如果广告位定义的广告内容为文字则生成文字代码
                }

                var _str_advert = &quot;&lt;a href='&quot; + _result.advertRows[0].advert_href + &quot;' target='_blank'&gt;&quot; + _str_media + &quot;&lt;/a&gt;&quot;; //为广告添加链接

                $(&quot;#&quot; + _parent_id + &quot; .bannerChild&quot;).html(_str_advert); //为当前对象的 bannerChild 子项添加上述 HTML 代码
            }
        });
    }
})(jQuery);</code></pre>
    <p>";