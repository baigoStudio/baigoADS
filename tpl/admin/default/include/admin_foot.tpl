			</div>
			<div class="col-md-2 col-md-pull-10">
				<div class="panel panel-default panel_adms">
					<div class="list-group list_group_adms">
						{foreach $adminMod as $key_m=>$value_m}
							<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod={$value_m.main.mod}" class="list-group-item {if $cfg.menu_active == $key_m}active{/if}">
								<i class="glyphicon glyphicon-{$value_m.main.icon}"></i>
								{$value_m.main.title}
								<span class="caret"></span>
							</a>
							{if isset($cfg.menu_active) && $cfg.menu_active == $key_m}
								{foreach $value_m.sub as $key_s=>$value_s}
									<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod={$value_s.mod}&act_get={$value_s.act_get}" class="list-group-item {if $cfg.sub_active == $key_s}sub_active{else}sub_normal{/if}">{$value_s.title}</a>
								{/foreach}
							{/if}
						{/foreach}
					</div>
				</div>
			</div>
		</div>
	</div>

	<footer class="page_foot">
		<div class="pull-left foot_logo">
			{if $config.ui == "default"}
				<a href="{$smarty.const.PRD_ADMS_URL}" target="_blank">{$smarty.const.PRD_ADMS_POWERED} {$smarty.const.PRD_ADMS_NAME} {$smarty.const.PRD_ADMS_VER}</a>
			{else}
				<a href="#">{$config.ui} ADMS</a>
			{/if}
		</div>
		<div class="pull-right foot_power">
			{$smarty.const.PRD_ADMS_POWERED}
			{if $config.ui == "default"}
				<a href="{$smarty.const.PRD_ADMS_URL}" target="_blank">{$smarty.const.PRD_ADMS_NAME}</a>
			{else}
				{$config.ui} ADMS
			{/if}
			{$smarty.const.PRD_ADMS_VER}
		</div>
		<div class="clearfix"></div>
	</footer>

</body>
