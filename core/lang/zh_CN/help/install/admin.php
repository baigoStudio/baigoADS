<?php
return "<h3>创建管理员</h3>

    <p>
        本操作将创建管理员，拥有所有的管理权限。
    </p>

    <p>
        <a href=\"{images}admin.jpg\" target=\"_blank\"><img src=\"{images}admin.jpg\" class=\"img-responsive\"></a>
    </p>

    <p>&nbsp;</p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">填写说明</div>
        <div class=\"panel-body\">
            <h4 class=\"text_ads\">用户名</h4>
            <p>请根据实际情况填写。</p>

            <h4 class=\"text_ads\">密码</h4>
            <p>请根据实际情况填写。</p>

            <h4 class=\"text_ads\">确认密码</h4>
            <p>请根据实际情况填写。</p>

            <h4 class=\"text_ads\">昵称</h4>
            <p>请根据实际情况填写。</p>
        </div>
    </div>

    <p>
        填写完毕，点击提交，提交成功后，点击下一步。
    </p>

    <p>&nbsp;</p>
    <div class=\"text-right\">
        <a href=\"#top\">
            <span class=\"glyphicon glyphicon-chevron-up\"></span>
            top
        </a>
    </div>
    <hr>
    <p>&nbsp;</p>

    <a name=\"auth\"></a>
    <h3>授权为管理员</h3>
    <p>点左侧子菜单的“授权为管理员”，进入如下界面。此功能与创建管理员的区别为，创建管理员时，系统会向 baigo SSO 系统注册用户，而授权为管理员则是将 baigo SSO 已注册的用户授权为管理员。<a href=\"http://www.baigo.net/sso/\" target=\"_blank\">baigo SSO 官方网站</a></p>

    <p>
        <a href=\"{images}auth.jpg\" target=\"_blank\"><img src=\"{images}auth.jpg\" class=\"img-responsive\"></a>
    </p>

    <p>&nbsp;</p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">填写说明</div>
        <div class=\"panel-body\">
            <h4 class=\"text-info\">用户名</h4>
            <p>管理员登录的用户名。</p>

            <h4 class=\"text-info\">密码</h4>
            <p>管理员登录的密码。</p>

            <h4 class=\"text-info\">E-mail</h4>
            <p>管理员的联系E-mail。</p>

            <h4 class=\"text-info\">备注</h4>
            <p>管理员的备注。</p>

            <h4 class=\"text-info\">栏目管理权限</h4>
            <p>选择该管理员对每个栏目拥有的权限。</p>

            <h4 class=\"text-info\">状态</h4>
            <p>可选启用或禁用。</p>

            <h4 class=\"text-info\">个人权限</h4>
            <p>可选禁止修改个人信息和禁止修改密码。</p>
        </div>
    </div>

    <p>&nbsp;</p>
    <div class=\"text-right\">
        <a href=\"#top\">
            <span class=\"glyphicon glyphicon-chevron-up\"></span>
            top
        </a>
    </div>
    <hr>
    <p>&nbsp;</p>

    <a name=\"sso\"></a>
    <h3>自动部署 SSO 后创建管理员</h3>
    <p>自动部署 SSO 后，安装程序将会自动跳转到本界面面，本操作将同时为 CMS 与 SSO 创建管理员，拥有所有的管理权限。请牢记用户名与密码。</p>
    <p>
        <a href=\"{images}ssoAdmin.jpg\" target=\"_blank\"><img src=\"{images}ssoAdmin.jpg\" class=\"img-responsive\"></a>
    </p>";
