<?php
return "<h3>使用</h3>
	<p>
		开发工作完成后，请将文件上传至 ./script/ 目录，然后在管理后台创建（编辑）广告位，选择新上传的脚本，保存成功后，点击 “预览 / 获取代码”，将示例代码复制到需要显示广告的网页即可。
	</p>

	<p>
		为了更灵活的运用，您也可以自行修改代码，以便达到您需要的目的，详情请看示例代码。
	</p>

	<p>&nbsp;</p>

	<h4>示例代码</h4>
	<p>
<pre><code class=\"language-markup\">&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;zh&quot;&gt;
	&lt;head&gt;
		&lt;title&gt;advert&lt;/title&gt;

		&lt;!-- 广告样式 begin --&gt;
		&lt;link href=&quot;http://www.domain.com/static/advert/banner/style.css&quot; type=&quot;text/css&quot; rel=&quot;stylesheet&quot;&gt;
		&lt;!-- 此部分为可选项，请根据实际情况决定 --&gt;

	&lt;/head&gt;
	&lt;body&gt;

		&lt;!-- 网页其他内容 --&gt;

		&lt;!-- 显示容器 begin --&gt;
		&lt;div id=&quot;admsBanner_1&quot;&gt;&lt;/div&gt;
		&lt;!-- 此部分为必须项，ID 或者 CLASS 请与初始化时的选择器相对应，您还可以根据实际情况，添加样式控制 --&gt;



		&lt;!-- 网页其他内容 --&gt;

		&lt;!-- 初始化 begin --&gt;
		&lt;script type=&quot;text/javascript&quot;&gt;
		$(document).ready(function(){
			_opts_ad_1 = { //定义选项
				loading: &quot;&#27491;&#22312;&#36733;&#20837;&#24191;&#21578; ...&quot;, //载入消息
				..., //您还可以根据脚本自行添加选项
				data_url: &quot;http://www.domain.com/advert.php?mod=advert&amp;act_get=list&amp;posi_id=2&quot; //广告数据，此为必须项
			}
			$(&quot;#admsBanner_1&quot;).admsBanner(_opts_ad_1); //初始化脚本对象，此处的选择器请与显示容器的 ID 或者 CLASS 相对应
		});
		&lt;/script&gt;
		&lt;!-- 此部分为必须项 --&gt;

		&lt;!-- 广告脚本 begin --&gt;
		&lt;script src=&quot;http://www.domain.com/static/advert/banner/script.js&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;
		&lt;!-- 此部分为必须项 --&gt;

	&lt;/body&gt;
&lt;/html&gt;</code></pre>
	<p>";