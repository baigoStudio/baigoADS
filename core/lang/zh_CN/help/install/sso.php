<?php
return "<h3>SSO 设置</h3>
	<p>baigo ADMS 的用户以及后台登录需要 baigo SSO 支持，baigo SSO 的部署方式，请查看 <a href=\"http://www.baigo.net/sso/\" target=\"_blank\">baigo SSO 官方网站</a>。如果您的网站没有部署 baigo SSO，请点击“SSO 自动部署“。</p>

	<p><img src=\"{images}sso.jpg\" class=\"img-responsive\"></p>

	<div class=\"panel panel-default\">
		<div class=\"panel-heading\">填写说明</div>
		<div class=\"panel-body\">
			<h4 class=\"text_adms\">API 接口 URL</h4>
			<p>baigo SSO API 接口的 URL</p>

			<h4 class=\"text_adms\">APP ID</h4>
			<p>baigo SSO 应用的 APP ID</p>

			<h4 class=\"text_adms\">APP KEY</h4>
			<p>baigo SSO 应用的 APP KEY</p>

			<h4 class=\"text_adms\">同步登录</h4>
			<p>如为开启状态，当用户在本站登录的时候，所有部署在 baigo SSO 下的网站将同步登录，当用户切换到这些网站时，无需再次登录。</p>
		</div>
	</div>

	<p>点击“保存“，成功后点击“下一步“。</p>

	<hr>

	<a name=\"auto\"></a>
	<h3>SSO 自动部署</h3>
	<p>请按照安装程序的提示操作。</p>
	<p><img src=\"{images}ssoAuto.jpg\" class=\"img-responsive\"></p>
	<p><img src=\"{images}ssoAdmin.jpg\" class=\"img-responsive\"></p>
	<p>点击“保存“，保存成功后点击“下一步“。自动部署成功后，安装程序会直接跳转到创建管理员界面，详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=install&act_get=admin#sso\">创建管理员</a>。</p>";
