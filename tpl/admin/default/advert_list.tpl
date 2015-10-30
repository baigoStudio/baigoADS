{* admin_list.tpl 管理员列表 *}
{$cfg = [
	title          => $adminMod.advert.main.title,
	menu_active    => "advert",
	sub_active     => "list",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	tokenReload    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=advert&{$tplData.query}"
]}

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_head.tpl" cfg=$cfg}

	<li>{$adminMod.advert.main.title}</li>

	{include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<div class="pull-left">
			<ul class="nav nav-pills nav_baigo">
				<li>
					<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=advert&act_get=form">
						<span class="glyphicon glyphicon-plus"></span>
						{$lang.href.add}
					</a>
				</li>
				<li>
					<a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=advert" target="_blank">
						<span class="glyphicon glyphicon-question-sign"></span>
						{$lang.href.help}
					</a>
				</li>
			</ul>
		</div>
		<div class="pull-right">
			<form name="advert_search" id="advert_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
				<input type="hidden" name="mod" value="advert">
				<input type="hidden" name="act_get" value="list">

				<div class="form-group">
					<select name="posi_id" class="form-control">
						<option value="">{$lang.option.allPosi}</option>
						{foreach $tplData.posiRows as $key=>$value}
							<option {if $tplData.search.posi_id == $value.posi_id}selected{/if} value="{$value.posi_id}">{$value.posi_name}</option>
						{/foreach}
					</select>
				</div>
				<div class="form-group">
					<select name="status" class="form-control input-sm">
						<option value="">{$lang.option.allStatus}</option>
						{foreach $status.advert as $key=>$value}
							<option {if $tplData.search.status == $key}selected{/if} value="{$key}">{$value}</option>
						{/foreach}
					</select>
				</div>
				<div class="form-group">
					<input type="text" name="key" value="{$tplData.search.key}" placeholder="{$lang.label.key}" class="form-control input-sm">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-default btn-sm">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</div>
			</form>
		</div>
		<div class="clearfix"></div>
	</div>

	<form name="advert_list" id="advert_list" class="form-inline">
		<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">

		<div class="panel panel-default">
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th class="text-nowrap td_mn">
								<label for="chk_all" class="checkbox-inline">
									<input type="checkbox" name="chk_all" id="chk_all" class="first">
									{$lang.label.all}
								</label>
							</th>
							<th class="text-nowrap td_mn">{$lang.label.id}</th>
							<th>{$lang.label.advertName}</th>
							<th class="text-nowrap td_bg">{$lang.label.advertShow} / {$lang.label.advertHit}</th>
							<th class="text-nowrap td_bg">{$lang.label.posi} / {$lang.label.advertPercent}</th>
							<th class="text-nowrap td_bg">{$lang.label.advertBegin} / {$lang.label.advertPutType}</th>
							<th class="text-nowrap td_md">{$lang.label.status} / {$lang.label.note}</th>
						</tr>
					</thead>
					<tbody>
						{foreach $tplData.advertRows as $value}
							{if ($value.advert_put_type == "date" && $value.advert_put_opt < $smarty.now) || ($value.advert_put_type == "show" && $value.advert_put_opt < $value.advert_count_show) || ($value.advert_put_type == "hit" && $value.advert_put_opt < $value.advert_count_hit)}
								{$_css_status = "default"}
								{$_str_status = $lang.label.expired}
							{else}
								{if $value.advert_status == "enable"}
									{$_css_status = "success"}
									{$_str_status = $status.advert[$value.advert_status]}
								{else}
									{$_css_status = "danger"}
									{$_str_status = $status.advert[$value.advert_status]}
								{/if}
							{/if}
							<tr>
								<td class="text-nowrap td_mn"><input type="checkbox" name="advert_id[]" value="{$value.advert_id}" id="advert_id_{$value.advert_id}" group="advert_id" class="validate chk_all"></td>
								<td class="text-nowrap td_mn">{$value.advert_id}</td>
								<td>
									<ul class="list-unstyled">
										<li>{$value.advert_name}</li>
										<li>
											<ul class="list_menu">
												<li>
													<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=advert&act_get=show&advert_id={$value.advert_id}">{$lang.href.show}</a>
												</li>
												<li>
													<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=advert&act_get=form&advert_id={$value.advert_id}">{$lang.href.edit}</a>
												</li>
												<li>
													<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=stat&act_get=advert&advert_id={$value.advert_id}">{$lang.href.stat}</a>
												</li>
											</ul>
										</li>
									</ul>
								</td>
								<td class="text-nowrap td_bg">
									<ul class="list-unstyled">
										<li>
											{$value.advert_count_show}
										</li>
										<li>
											{$value.advert_count_hit}
										</li>
									</ul>
								</td>
								<td class="text-nowrap td_bg">
									<ul class="list-unstyled">
										<li>
											{if isset($value.posiRow.posi_name)}
												<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=advert&act_get=list&posi_id={$value.posiRow.posi_id}">{$value.posiRow.posi_name}</a>
											{else}
												{$lang.label.unknow}
											{/if}
										</li>
										<li>
											{$value.advert_percent * 10}%
										</li>
									</ul>
								</td>
								<td class="text-nowrap td_bg">
									<ul class="list-unstyled">
										<li>
											{$value.advert_begin|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}
										</li>
										<li>
											{$type.put[$value.advert_put_type]}
											{if $value.advert_put_type == "date"}
												{$value.advert_put_opt|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}
											{else}
												{$value.advert_put_opt}
											{/if}
										</li>
									</ul>
								</td>
								<td class="text-nowrap td_md">
									<ul class="list-unstyled">
										<li class="label_baigo">
											<span class="label label-{$_css_status}">{$_str_status}</span>
										</li>
										<li>{$value.advert_note}</li>
									</ul>
								</td>
							</tr>
						{/foreach}
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2"><span id="msg_advert_id"></span></td>
							<td colspan="5">
								<div class="form-group">
									<select name="act_post" id="act_post" class="validate form-control input-sm">
										<option value="">{$lang.option.batch}</option>
										{foreach $status.advert as $key=>$value}
											<option value="{$key}">{$value}</option>
										{/foreach}
										<option value="del">{$lang.option.del}</option>
									</select>
								</div>
								<div class="form-group">
									<button type="button" id="go_list" class="btn btn-sm btn-primary">{$lang.btn.submit}</button>
								</div>
								<div class="form-group">
									<span id="msg_act_post"></span>
								</div>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>

	</form>

	<div class="text-right">
		{include "{$smarty.const.BG_PATH_TPL}admin/default/include/page.tpl" cfg=$cfg}
	</div>

	<form id="advert_notice">
		<input type="hidden" name="act_post" id="act_post" value="notice">
		<input type="hidden" name="advert_id_notice" id="advert_id_notice" value="">
	</form>

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_validator_list = {
		advert_id: {
			length: { min: 1, max: 0 },
			validate: { type: "checkbox" },
			msg: { id: "msg_advert_id", too_few: "{$alert.x030202}" }
		},
		act_post: {
			length: { min: 1, max: 0 },
			validate: { type: "select" },
			msg: { id: "msg_act_post", too_few: "{$alert.x030203}" }
		}
	};

	var opts_submit_list = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=advert",
		confirm_id: "act_post",
		confirm_val: "del",
		confirm_msg: "{$lang.confirm.del}",
		text_submitting: "{$lang.label.submitting}",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	var opts_submit_notice = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=advert",
		text_submitting: "{$lang.label.submitting}",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	$(document).ready(function(){
		var obj_validator_list = $("#advert_list").baigoValidator(opts_validator_list);
		var obj_submit_list = $("#advert_list").baigoSubmit(opts_submit_list);
		$("#go_list").click(function(){
			if (obj_validator_list.validateSubmit()) {
				obj_submit_list.formSubmit();
			}
		});

		var obj_notice = $("#advert_notice").baigoSubmit(opts_submit_notice);
		$(".go_notice").click(function(){
			var __id = $(this).attr("id");
			$("#advert_id_notice").val(__id);
			obj_notice.formSubmit();
		});
		$("#advert_list").baigoCheckall();
	})
	</script>

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/html_foot.tpl" cfg=$cfg}