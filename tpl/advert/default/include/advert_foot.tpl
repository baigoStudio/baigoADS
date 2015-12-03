	</div>

	<p>&nbsp;</p>
	<p>&nbsp;</p>

	<footer class="container">
		<div class="page_foot">
    		<div class="pull-left foot_logo">
    			{if $config.ui == "default"}
    				<a href="{$smarty.const.PRD_ADS_URL}" target="_blank">{$smarty.const.PRD_ADS_POWERED} {$smarty.const.PRD_ADS_NAME} {$smarty.const.PRD_ADS_VER}</a>
    			{else}
    				<a href="#">{$config.ui} ADS</a>
    			{/if}
    		</div>
    		<div class="pull-right foot_power">
    			{$smarty.const.PRD_ADS_POWERED}
    			{if $config.ui == "default"}
    				<a href="{$smarty.const.PRD_ADS_URL}" target="_blank">{$smarty.const.PRD_ADS_NAME}</a>
    			{else}
    				{$config.ui} ADS
    			{/if}
    			{$smarty.const.PRD_ADS_VER}
    		</div>
    		<div class="clearfix"></div>
		</div>
	</footer>
