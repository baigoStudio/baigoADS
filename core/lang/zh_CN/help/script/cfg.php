<?php
return "<h3>配置</h3>
	<p>
		配置文件为一个 JSON 文件，必须命名为 config.json，系统将读取此文件，以便使脚本生效。
	</p>

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
						<td class=\"nowrap\">name</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">脚本名</td>
						<td>创建（编辑）广告位时，选择脚本，会将此参数填入广告位名称。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">plugin</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">插件名</td>
						<td>创建（编辑）广告位时，选择脚本，会将此参数填入插件名。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">selector</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">默认选择器</td>
						<td>创建（编辑）广告位时，选择脚本，会将此参数填入默认选择器。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">ispercent</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">是否允许几率展现</td>
						<td>enable 或 disable，创建（编辑）广告位时，选择脚本，会自动选择允许几率展现。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">type</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">广告内容</td>
						<td>media 或 text，创建（编辑）广告位时，选择脚本，会自动选择广告内容。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">note</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">备注</td>
						<td>创建（编辑）广告位时，选择脚本，会自动显示本参数。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">opts</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">选项，多维数组</td>
						<td>查看 <a href=\"#opts\">opts</a> 对象。</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<p>&nbsp;</p>

	<a name=\"opts\"></a>
	<h4><code>opts</code> 对象</h4>

	<p>
		选择脚本，会自动在表单中添加选项表单，并在生成广告代码时，成为广告插件的 JSON 对象。
	</p>

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
						<td class=\"nowrap\">field</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">选项名</td>
						<td>表单子健，在生成广告代码时，此对象为选项键名。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">label</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">说明文字</td>
						<td>表单说明，在生成广告代码时，此对象为备注。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">value</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">默认值</td>
						<td>填入表单，在生成广告代码时，此对象为选项键值。</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<p>&nbsp;</p>

	<h4>配置文件示例</h4>
	<p>
<pre><code class=\"language-javascript\">{
	&quot;name&quot;: &quot;Banner&quot;, //脚本名
	&quot;plugin&quot;: &quot;admsBanner&quot;, //插件名
	&quot;selector&quot;: &quot;#admsBanner&quot;, //默认选择器
	&quot;ispercent&quot;: &quot;enable&quot;, //是否允许几率展现（enable 或 disable）
	&quot;type&quot;: &quot;media&quot;, //广告内容（media 或 text）
	&quot;note&quot;: &quot;本脚本需要 jQuery 支持&quot;, //备注说明
	&quot;opts&quot;: [ //选项
		{
			&quot;field&quot;: &quot;loading&quot;, //选项名
			&quot;label&quot;: &quot;载入消息&quot;, //说明文字
			&quot;value&quot;: &quot;正在载入广告 ...&quot; //默认值
		}
	]
}</code></pre>
	<p>";