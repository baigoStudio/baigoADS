<?php
return "<h3>广告数据</h3>
	<p>
		广告数据实际上是一个类似 API 接口的 URL，返回格式为 JSON，其返回的数据可用于脚本的开发。
	</p>

	<p>
		地址：<span class=\"text-primary\">http://www.domain.com/advert.php?mod=adver&act_get=list&posi_id=广告位 ID</span>
	</p>

	<p>&nbsp;</p>

	<h4>返回结果</h4>

	<div class=\"panel panel-default\">
		<div class=\"table-responsive\">
			<table class=\"table\">
				<thead>
					<tr>
						<th class=\"nowrap\">键名</th>
						<th class=\"nowrap\">类型</th>
						<th class=\"nowrap\">说明</th>
						<th>备注</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class=\"nowrap\">posiRow</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">广告位信息</td>
						<td>详情请查看 <a href=\"#posiRow\">posiRow</a>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">advertRows</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">广告列表</td>
						<td>多维数组，详情请查看 <a href=\"#advertRows\">advertRows</a></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<p>&nbsp;</p>

	<a name=\"posiRow\"></a>
	<h4><code>posiRow</code> 对象</h4>

	<div class=\"panel panel-default\">
		<div class=\"table-responsive\">
			<table class=\"table\">
				<thead>
					<tr>
						<th class=\"nowrap\">键名</th>
						<th class=\"nowrap\">类型</th>
						<th class=\"nowrap\">说明</th>
						<th>备注</th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td class=\"nowrap\">posi_id</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">广告位 ID</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">posi_name</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">广告位名称</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">posi_count</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">显示广告数</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">posi_type</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">广告内容</td>
						<td>media 或 text</td>
					</tr>
					<tr>
						<td class=\"nowrap\">posi_width</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">广告宽度</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">posi_height</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">广告高度</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">posi_script</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">广告脚本</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">posi_plugin</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">插件名</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">posi_selector</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">默认选择器</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">alert</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">返回代码</td>
						<td>详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=alert\">返回代码</a>。</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<p>&nbsp;</p>

	<a name=\"advertRows\"></a>
	<h4><code>advertRows</code> 对象</h4>

	<div class=\"panel panel-default\">
		<div class=\"table-responsive\">
			<table class=\"table\">
				<thead>
					<tr>
						<th class=\"nowrap\">键名</th>
						<th class=\"nowrap\">类型</th>
						<th class=\"nowrap\">说明</th>
						<th>备注</th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td class=\"nowrap\">advert_id</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">广告 ID</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">advert_name</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">广告名称</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">advert_content</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">广告文字内容</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">advert_href</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">广告链接地址</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">mediaRow</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">图片信息</td>
						<td>详情请查看 <a href=\"#mediaRow\">mediaRow</a>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">alert</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">返回代码</td>
						<td>详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=alert\">返回代码</a>。</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<p>&nbsp;</p>

	<a name=\"mediaRow\"></a>
	<h4><code>mediaRow</code> 对象</h4>

	<div class=\"panel panel-default\">
		<div class=\"table-responsive\">
			<table class=\"table\">
				<thead>
					<tr>
						<th class=\"nowrap\">键名</th>
						<th class=\"nowrap\">类型</th>
						<th class=\"nowrap\">说明</th>
						<th>备注</th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td class=\"nowrap\">media_id</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">图片 ID</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">media_url</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">图片 URL 地址</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">media_name</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">图片名称</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">media_ext</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">扩展名</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">media_mime</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">MIME</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">media_size</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">图片大小</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">alert</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">返回代码</td>
						<td>详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=alert\">返回代码</a>。</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>";