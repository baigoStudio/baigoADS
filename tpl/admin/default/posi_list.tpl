{* admin_posiList.tpl 后台用户组 *}
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
				<li>
					<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=posi&act_get=form">
						<span class="glyphicon glyphicon-plus"></span>
						{$lang.href.add}
					</a>
				</li>
				<li>
					<a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=posi" target="_blank">
						<span class="glyphicon glyphicon-question-sign"></span>
						{$lang.href.help}
					</a>
				</li>
			</ul>
		</div>
		<div class="pull-right">
			<form name="posi_search" id="posi_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
				<input type="hidden" name="mod" value="posi">
				<input type="hidden" name="act_get" value="list">
				<div class="form-group">
					<div class="input-posi">
						<input type="text" name="key" value="{$tplData.search.key}" placeholder="{$lang.label.key}" class="form-control input-sm">
						<span class="input-posi-btn">
							<button type="submit" class="btn btn-default btn-sm">
								<span class="glyphicon glyphicon-search"></span>
							</button>
						</span>
					</div>
				</div>
			</form>
		</div>
		<div class="clearfix"></div>
	</div>

	<form name="posi_list" id="posi_list" class="form-inline">
		<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">

		<div class="panel panel-default">
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th class="td_mn">
								<label for="chk_all" class="checkbox-inline">
									<input type="checkbox" name="chk_all" id="chk_all" class="first">
									{$lang.label.all}
								</label>
							</th>
							<th class="td_mn">{$lang.label.id}</th>
							<th>{$lang.label.posi}</th>
							<th class="td_bg">{$lang.label.contentType} / {$lang.label.size}</th>
							<th class="td_md">{$lang.label.status} / {$lang.label.note}</th>
						</tr>
					</thead>
					<tbody>
						{foreach $tplData.posiRows as $key=>$value}
							{if $value.posi_status == "enable"}
								{$_css_status = "success"}
							{else}
								{$_css_status = "danger"}
							{/if}
							<tr>
								<td class="td_mn"><input type="checkbox" name="posi_id[]" value="{$value.posi_id}" id="posi_id_{$value.posi_id}" class="validate chk_all" group="posi_id"></td>
								<td class="td_mn">{$value.posi_id}</td>
								<td>
									<ul class="list-unstyled">
										<li>{$value.posi_name}</li>
										<li>
											<ul class="list_menu">
												<li>
													<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=posi&act_get=show&posi_id={$value.posi_id}">{$lang.href.posiPreview}</a>
												</li>
												<li>
													<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=posi&act_get=form&posi_id={$value.posi_id}">{$lang.href.edit}</a>
												</li>
												<li>
													<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=stat&act_get=posi&posi_id={$value.posi_id}">{$lang.href.stat}</a>
												</li>
												<li>
													<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=advert&act_get=list&posi_id={$value.posi_id}">{$lang.href.advertMan}</a>
												</li>
											</ul>
										</li>
									</ul>
								</td>
								<td class="td_bg">
									<ul class="list-unstyled">
										<li>{$type.posi[$value.posi_type]}</li>
										{if $value.posi_type == "media"}
											<li>
												{$lang.label.width}
												{$value.posi_width}{$lang.label.px}
												{$lang.label.height}
												{$value.posi_height}{$lang.label.px}
											</li>
										{/if}
									</ul>
								</td>
								<td class="td_md label_baigo">
									<ul class="list-unstyled">
										<li class="label_baigo">
											<span class="label label-{$_css_status}">{$status.posi[$value.posi_status]}</span>
										</li>
										<li>{$value.posi_note}</li>
									</ul>
								</td>
							</tr>
						{/foreach}
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2"><span id="msg_posi_id"></span></td>
							<td colspan="3">
								<div class="form-group">
									<select name="act_post" id="act_post" class="validate form-control input-sm">
										<option value="">{$lang.option.batch}</option>
										{foreach $status.posi as $key=>$value}
											<option value="{$key}">{$value}</option>
										{/foreach}
										<option value="cache">{$lang.option.cache}</option>
										<option value="del">{$lang.option.del}</option>
									</select>
								</div>
								<div class="form-group">
									<button type="button" id="go_list" class="btn btn-primary btn-sm">{$lang.btn.submit}</button>
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

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_validator_list = {
		posi_id: {
			length: { min: 1, max: 0 },
			validate: { type: "checkbox" },
			msg: { id: "msg_posi_id", too_few: "{$alert.x030202}" }
		},
		act_post: {
			length: { min: 1, max: 0 },
			validate: { type: "select" },
			msg: { id: "msg_act_post", too_few: "{$alert.x030203}" }
		}
	};

	var opts_submit_list = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=posi",
		confirm_id: "act_post",
		confirm_val: "del",
		confirm_msg: "{$lang.confirm.del}",
		text_submitting: "{$lang.label.submitting}",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	$(document).ready(function(){
		var obj_validate_list = $("#posi_list").baigoValidator(opts_validator_list);
		var obj_submit_list   = $("#posi_list").baigoSubmit(opts_submit_list);
		$("#go_list").click(function(){
			if (obj_validate_list.validateSubmit()) {
				obj_submit_list.formSubmit();
			}
		});
		$("#posi_list").baigoCheckall();
	})
	</script>

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/html_foot.tpl" cfg=$cfg}

