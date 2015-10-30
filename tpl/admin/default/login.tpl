<!DOCTYPE html>
<html lang="{$config.lang|truncate:2:''}">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>{$lang.page.adminLogon} - {$lang.page.admin} - {$smarty.const.BG_SITE_NAME}</title>

	<!--jQuery 库-->
	<script src="{$smarty.const.BG_URL_STATIC}js/jquery.min.js" type="text/javascript"></script>
	<link href="{$smarty.const.BG_URL_STATIC}js/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
	<link href="{$smarty.const.BG_URL_STATIC}admin/{$config.ui}/css/admin_logon.css" type="text/css" rel="stylesheet">

</head>
<body>

	<div class="container global">

		<h3>{$smarty.const.BG_SITE_NAME}</h3>

		<div class="alert alert-success">
			<h4>
				<span class="glyphicon glyphicon-user"></span>
				{$lang.label.loging}
			</h4>
		</div>

	</div>

	<script type="text/javascript">
	$(document).ready(function(){
		{if $tplData.sync.urls}
			{foreach $tplData.sync.urls as $key=>$value}
				$.ajax({
					url: "{$value}", //url
					data: "",
					dataType: "json", //数据格式为json
					async: false, //设置为同步
					complete: function(){ //读取返回结果
						{if $value@last}
							window.location.href = "{$tplData.forward}";
						{/if}
					}
				});
			{/foreach}
		{else}
			window.location.href = "{$tplData.forward}";
		{/if}
	});
	</script>

</body>
</html>
