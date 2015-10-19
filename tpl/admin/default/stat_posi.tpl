{* admin_list.tpl 管理员列表 *}
{$cfg = [
	title          => $adminMod.posi.main.title,
	menu_active    => "posi",
	sub_active     => "list",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	tokenReload    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=posi&{$tplData.query}"
]}

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_head.tpl" cfg=$cfg}

	<li>{$adminMod.posi.main.title}</li>

	{include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<div class="pull-left">
			<ul class="nav nav-pills nav_baigo">
				<li {if $tplData.search.type == "year"}class="active"{/if}>
					<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=stat&act_get=posi&type=year&posi_id={$tplData.posiRow.posi_id}">
						{$lang.href.statYear}
					</a>
				</li>
				<li {if $tplData.search.type == "month"}class="active"{/if}>
					<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=stat&act_get=posi&type=month&posi_id={$tplData.posiRow.posi_id}">
						{$lang.href.statMonth}
					</a>
				</li>
				<li {if $tplData.search.type == "day"}class="active"{/if}>
					<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=stat&act_get=posi&type=day&posi_id={$tplData.posiRow.posi_id}">
						{$lang.href.statDay}
					</a>
				</li>
			</ul>
		</div>
		<div class="pull-right">
			<form name="stat_search" id="stat_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
				<input type="hidden" name="mod" value="stat">
				<input type="hidden" name="act_get" value="posi">
				<input type="hidden" name="type" value="{$tplData.search.type}">
				<input type="hidden" name="posi_id" value="{$tplData.posiRow.posi_id}">
				{if $tplData.search.type == "year"}
					{$_str_time    = $lang.label.statYear}
					{$_str_format  = "Y"}
				{else if $tplData.search.type == "month"}
					{$_str_time    = $lang.label.statMonth}
					{$_str_format  = "Y-m"}
					<div class="form-group">
						<select name="year" class="form-control input-sm">
							<option value="">{$lang.option.allYear}</option>
							{foreach $tplData.yearRows as $key=>$value}
								<option {if $tplData.search.year == $value.stat_year}selected{/if} value="{$value.stat_year}">{$value.stat_year}</option>
							{/foreach}
						</select>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-default btn-sm">
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</div>
				{else}
					{$_str_time    = $lang.label.statDay}
					{$_str_format  = "Y-m-d"}
					<div class="form-group">
						<select name="year" class="form-control input-sm">
							<option value="">{$lang.option.allYear}</option>
							{foreach $tplData.yearRows as $key=>$value}
								<option {if $tplData.search.year == $value.stat_year}selected{/if} value="{$value.stat_year}">{$value.stat_year}</option>
							{/foreach}
						</select>
					</div>
					<div class="form-group">
						<select name="month" class="form-control input-sm">
							<option value="">{$lang.option.allMonth}</option>
							{for $_i = 1 to 12}
								{if $_i < 10}
									{$_str_month = "0{$_i}"}
								{else}
									{$_str_month = $_i}
								{/if}
								<option {if $tplData.search.month == $_str_month}selected{/if} value="{$_str_month}">{$_str_month}</option>
							{/for}
						</select>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-default btn-sm">
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</div>
				{/if}
			</form>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="well">
		<div class="row">
			<div class="col-lg-3 col-md-4 col-sm-6">
				<div class="form-group">
					<label class="control-label static_label">{$lang.label.posiName}</label>
					<p class="form-control-static">
						{$tplData.posiRow.posi_name}
					</p>
				</div>
			</div>

			<div class="col-lg-3 col-md-4 col-sm-6">
				<div class="form-group">
					<label class="control-label static_label">{$lang.label.contentType}</label>
					<p class="form-control-static">
						{$type.posi[$tplData.posiRow.posi_type]}
					</p>
				</div>
			</div>

			{if $tplData.posiRow.posi_type == "media"}
				<div class="col-lg-3 col-md-4 col-sm-6">
					<div class="form-group">
						<label class="control-label static_label">{$lang.label.size}</label>
						<p class="form-control-static">
							{$lang.label.width}
							{$tplData.posiRow.posi_width}{$lang.label.px}
							{$lang.label.height}
							{$tplData.posiRow.posi_height}{$lang.label.px}
						</p>
					</div>
				</div>
			{/if}
		</div>
	</div>

	<div class="panel panel-default">
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>{$_str_time}</th>
						<th>{$lang.label.advertStatShow}</th>
						<th>{$lang.label.advertStatHit}</th>
					</tr>
				</thead>
				<tbody>
					{foreach $tplData.statRows as $value}
						<tr>
							<td>
								{$value.stat_time|date_format:$_str_format}
							</td>
							<td>
								{$value.stat_count_show}
							</td>
							<td>
								{$value.stat_count_hit}
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>

	<div class="text-right">
		{include "{$smarty.const.BG_PATH_TPL}admin/default/include/page.tpl" cfg=$cfg}
	</div>

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_foot.tpl" cfg=$cfg}
{include "{$smarty.const.BG_PATH_TPL}admin/default/include/html_foot.tpl" cfg=$cfg}