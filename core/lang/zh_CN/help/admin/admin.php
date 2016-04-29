<?php
return "<h3>所有管理员</h3>
    <p>
        点左侧菜单管理员，进入如下界面，可以对管理员进行编辑、删除、改变状态和加入组等操作。
    </p>
    <p>
        <img src=\"{images}admin_list.jpg\" class=\"img-responsive thumbnail\">
    </p>

    <hr>

    <a name=\"form\"></a>
    <h3>创建（编辑）管理员</h3>
    <p>
        点左侧子菜单的创建管理员或者点击管理员列表的编辑菜单，进入如下界面，在此，您可以对管理员进行各项操作。
    </p>
    <p>
        <img src=\"{images}admin_form.jpg\" class=\"img-responsive thumbnail\">
    </p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">填写说明</div>
        <div class=\"panel-body\">
            <h4 class=\"text_ads\">用户名</h4>
            <p>管理员登录的用户名。</p>

            <h4 class=\"text_ads\">密码</h4>
            <p>管理员登录的密码。</p>

            <h4 class=\"text_ads\">昵称</h4>
            <p>管理员的昵称。</p>

            <h4 class=\"text_ads\">备注</h4>
            <p>管理员的备注。</p>

            <h4 class=\"text_ads\">权限</h4>
            <p>选择该管理员拥有的权限。</p>

            <h4 class=\"text_ads\">状态</h4>
            <p>可选启用或禁用。</p>

            <h4 class=\"text_ads\">个人权限</h4>
            <p>可选禁止修改个人信息和禁止修改密码。</p>
        </div>
    </div>

    <hr>

    <a name=\"auth\"></a>
    <h3>授权为管理员</h3>
    <p>点左侧子菜单的“授权为管理员”，进入如下界面。此功能与创建管理员的区别为，创建管理员时，系统会向 baigo SSO 系统注册用户，而授权为管理员则是将 baigo SSO 已注册的用户授权为管理员。<a href=\"http://www.baigo.net/sso/\" target=\"_blank\">baigo SSO 官方网站</a></p>
    <p><img src=\"{images}admin_auth.jpg\" class=\"img-responsive thumbnail\"></p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">填写说明</div>
        <div class=\"panel-body\">
            <h4 class=\"text_ads\">用户名</h4>
            <p>管理员登录的用户名。</p>

            <h4 class=\"text_ads\">密码</h4>
            <p>管理员登录的密码。</p>

            <h4 class=\"text_ads\">E-mail</h4>
            <p>管理员的联系E-mail。</p>

            <h4 class=\"text_ads\">备注</h4>
            <p>管理员的备注。</p>

            <h4 class=\"text_ads\">权限</h4>
            <p>选择该管理员拥有的权限。</p>

            <h4 class=\"text_ads\">状态</h4>
            <p>可选启用或禁用。</p>

            <h4 class=\"text_ads\">个人权限</h4>
            <p>可选禁止修改个人信息和禁止修改密码。</p>
        </div>
    </div>";