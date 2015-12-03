{* admin_posiForm.tpl 管理组编辑界面 *}
{$cfg = [
	title          => "{$adminMod.posi.main.title} - {$lang.page.show}",
	css            => "admin_form",
	menu_active    => "posi",
	prism          => "true",
	sub_active     => "list"
]}

{if $tplData.posiRow.posi_status == "enable"}
	{$_css_status = "success"}
{else}
	{$_css_status = "danger"}
{/if}

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_head.tpl" cfg=$cfg}

	<li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=posi&act_get=list">{$adminMod.posi.main.title}</a></li>
	<li>{$lang.page.show}</li>

	{include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<ul class="nav nav-pills nav_baigo">
			<li>
				<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=posi&act_get=list">
					<span class="glyphicon glyphicon-chevron-left"></span>
					{$lang.href.back}
				</a>
			</li>
		</ul>
	</div>

	<div class="row">
		<div class="col-md-9">
			<div class="panel panel-default">
				<div class="panel-body">
					{if $tplData.posiRow.posi_type == "media"}
						{foreach $tplData.advertRows as $key=>$value}
							<div class="form-group">
								<a href="{$value.advert_url}" target="_blank"><img src="{$value.mediaRow.media_url}" width="{$tplData.posiRow.posi_width}" height="{$tplData.posiRow.posi_height}"></a>
							</div>
						{/foreach}
					{else}
						{foreach $tplData.advertRows as $key=>$value}
							<div class="form-group">
								<a href="{$value.advert_url}" target="_blank">{$value.advert_content}</a>
							</div>
						{/foreach}
					{/if}

					<div class="form-group">
						<label class="control-label static_label">{$lang.label.dataUrl}</label>
						<div class="form-control-static">
							{$smarty.const.BG_SITE_URL}{$smarty.const.BG_URL_API}api.php?mod=advert&amp;act_get=list&amp;posi_id={$tplData.posiRow.posi_id}
						</div>
					</div>

					<div class="form-group">
						<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=posi&act_get=form&posi_id={$tplData.posiRow.posi_id}">
							<span class="glyphicon glyphicon-edit"></span>
							{$lang.href.edit}
						</a>
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-group">
						<label class="control-label static_label">{$lang.label.posiCode}</label>
						<p>
<pre><code class="language-markup">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;{$config.lang|truncate:2:''}&quot;&gt;
	&lt;head&gt;
		&lt;title&gt;advert&lt;/title&gt;

		&lt;!-- {$lang.label.posiCodeNote1} begin --&gt;
		&lt;link href=&quot;{$smarty.const.BG_SITE_URL}{$smarty.const.BG_URL_SCRIPT}{$tplData.posiRow.posi_script}/style.css&quot; type=&quot;text/css&quot; rel=&quot;stylesheet&quot;&gt;
		&lt;!-- {$lang.label.posiCodeNote1} end --&gt;

	&lt;/head&gt;
	&lt;body&gt;

		&lt;!-- {$lang.label.posiCodeNote2} begin --&gt;
		&lt;div id=&quot;{$tplData.posiRow.posi_selector|replace:"#":""}_{$tplData.posiRow.posi_id}&quot;&gt;&lt;/div&gt;
		&lt;!-- {$lang.label.posiCodeNote2} end --&gt;

		&lt;!-- {$lang.label.posiCodeNote3} begin --&gt;
		&lt;script type=&quot;text/javascript&quot;&gt;
		$(document).ready(function(){
			_opts_ad_{$tplData.posiRow.posi_id} = {
{if $tplData.posiRow.posi_opts}
{foreach $tplData.posiRow.posi_opts as $key=>$value}
				{$value.field}: &quot;{$value.value}&quot;,//{$value.label}
{/foreach}
{/if}
				data_url: &quot;{$smarty.const.BG_SITE_URL}{$smarty.const.BG_URL_API}api.php?mod=advert&amp;act_get=list&amp;posi_id={$tplData.posiRow.posi_id}&quot
			}
			$(&quot;{$tplData.posiRow.posi_selector}_{$tplData.posiRow.posi_id}&quot;).{$tplData.posiRow.posi_plugin}(_opts_ad_{$tplData.posiRow.posi_id});
		});
		&lt;/script&gt;
		&lt;!-- {$lang.label.posiCodeNote3} end --&gt;

		&lt;!-- {$lang.label.posiCodeNote4} begin --&gt;
		&lt;script src=&quot;{$smarty.const.BG_SITE_URL}{$smarty.const.BG_URL_SCRIPT}{$tplData.posiRow.posi_script}/script.js&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;
		&lt;!-- {$lang.label.posiCodeNote4} end --&gt;

	&lt;/body&gt;
&lt;/html&gt;
</code></pre>
						</p>

						<p class="help-block">{$lang.text.posiCodeNote}</p>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="well">
				<div class="form-group">
					<label class="control-label static_label">{$lang.label.id}</label>
					<p class="form-control-static">{$tplData.posiRow.posi_id}</p>
				</div>

				<div class="form-group">
					<label class="control-label static_label">{$lang.label.posiName}</label>
					<p class="form-control-static static_input">{$tplData.posiRow.posi_name}</p>
				</div>

				<div class="form-group">
					<label class="control-label static_label">{$lang.label.posiCount}</label>
					<p class="form-control-static static_input">{$tplData.posiRow.posi_count}</p>
				</div>

				<div class="form-group">
					<label class="control-label static_label">{$lang.label.contentType}</label>
					<p class="form-control-static static_input">{$type.posi[$tplData.posiRow.posi_type]}</p>
				</div>

				{if $tplData.posiRow.posi_type == "media"}
					<div class="form-group">
						<label class="control-label static_label">{$lang.label.size}</label>
						<p class="form-control-static static_input">
							{$lang.label.width}
							{$tplData.posiRow.posi_width}{$lang.label.px}
							{$lang.label.height}
							{$tplData.posiRow.posi_height}{$lang.label.px}
						</p>
					</div>
				{/if}

				<div class="form-group">
					<label class="control-label static_label">{$lang.label.note}</label>
					<p class="form-control-static static_input">{$tplData.posiRow.posi_note}</p>
				</div>

				<div class="form-group">
					<label class="control-label static_label">{$lang.label.status}</label>
					<p class="form-control-static label_baigo">
						<span class="label label-{$_css_status}">{$status.posi[$tplData.posiRow.posi_status]}</span>
					</p>
				</div>

				<div class="form-group">
					<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=posi&act_get=form&posi_id={$tplData.posiRow.posi_id}">
						<span class="glyphicon glyphicon-edit"></span>
						{$lang.href.edit}
					</a>
				</div>
			</div>
		</div>
	</div>

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_foot.tpl" cfg=$cfg}
{include "{$smarty.const.BG_PATH_TPL}admin/default/include/html_foot.tpl" cfg=$cfg}
