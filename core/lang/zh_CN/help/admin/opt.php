<?php
return "<h3>检查更新</h3>
    <p>
        点左侧子菜单检查更新，进入如下界面，系统会定时检查最新版本，也可点击“再次检查更新”按钮进行手工检查。
    </p>
    <p>
        <a href=\"{images}opt_chkver.jpg\" target=\"_blank\"><img src=\"{images}opt_chkver.jpg\" class=\"img-responsive thumbnail\"></a>
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

    <a name=\"base\"></a>
    <h3>基本设置</h3>
    <p>
        点右上角菜单系统设置，进入如下界面，可以对系统进行设置。
    </p>

    <p>
        <a href=\"{images}opt_base.jpg\" target=\"_blank\"><img src=\"{images}opt_base.jpg\" class=\"img-responsive thumbnail\"></a>
    </p>

    <p>&nbsp;</p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">填写说明</div>
        <div class=\"panel-body\">
            <h4 class=\"text_ads\">名称</h4>
            <p>请按照自己意愿填写，如：<mark>baigo 广告管理系统</mark></p>

            <h4 class=\"text_ads\">域名</h4>
            <p>请根据实际情况填写，如：<mark>www.domain.com</mark>，默认为当前网站域名。</p>

            <h4 class=\"text_ads\">首页 URL</h4>
            <p>请根据实际情况填写，如：<mark>http://www.domain.com</mark>，默认为当前网站 URL，末尾请勿加 <mark>/</mark>。</p>

            <h4 class=\"text_ads\">每页显示数</h4>
            <p>管理后台以及前台页面，在对文章、TAG 等进行分页管理的时候，每一页所显示的数量，默认为 30。</p>

            <h4 class=\"text_ads\">时区</h4>
            <p>请根据当地实际情况填写，默认为 Etc/GMT+8，即北京时间。</p>

            <h4 class=\"text_ads\">日期格式</h4>
            <p>部分页面显示日期的格式，此日期为完整的日期格式，默认为 xxxx-xx-xx（年-月-日）。</p>

            <h4 class=\"text_ads\">短日期格式</h4>
            <p>部分页面显示日期的格式，此日期为缩短的日期格式，不显示年份，默认为 xx-xx（月-日）。</p>

            <h4 class=\"text_ads\">时间格式</h4>
            <p>部分页面显示时间的格式，此日期为完整的时间格式，默认为 xx:xx:xx（时:分:秒）。</p>

            <h4 class=\"text_ads\">短时间格式</h4>
            <p>部分页面显示时间的格式，此日期为缩短的时间格式，不显示秒，默认为 xx:xx（时:分）。</p>
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

    <a name=\"dbconfig\"></a>
    <h3>数据库设置</h3>
    <p>
        点右上角子菜单数据库设置，进入如下界面，可以对数据库进行设置。
    </p>

    <p>
        <a href=\"{images}opt_dbconfig.jpg\" target=\"_blank\"><img src=\"{images}opt_dbconfig.jpg\" class=\"img-responsive thumbnail\"></a>
    </p>

    <p>&nbsp;</p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">填写说明</div>
        <div class=\"panel-body\">
            <h4 class=\"text_ads\">数据库服务器</h4>
            <p>请按照服务器提供商所提供的资料填写。</p>

            <h4 class=\"text_ads\">数据库名称</h4>
            <p>请按照服务器提供商所提供的资料填写。</p>

            <h4 class=\"text_ads\">数据库用户名</h4>
            <p>请按照服务器提供商所提供的资料填写。</p>

            <h4 class=\"text_ads\">数据库密码</h4>
            <p>请按照服务器提供商所提供的资料填写。</p>

            <h4 class=\"text_ads\">数据库字符编码</h4>
            <p>一般为 <mark>utf8</mark>，请按照服务器提供商所提供的资料填写。</p>

            <h4 class=\"text_ads\">数据表名前缀</h4>
            <p>默认为 <mark>ads_</mark>，推荐用默认值。</p>
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

    <a name=\"upload\"></a>
    <h3>上传设置</h3>
    <p>
        点右上角子菜单上传设置，进入如下界面，可以对上传进行设置。
    </p>

    <p>
        <a href=\"{images}opt_upload.jpg\" target=\"_blank\"><img src=\"{images}opt_upload.jpg\" class=\"img-responsive thumbnail\"></a>
    </p>

    <p>&nbsp;</p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">填写说明</div>
        <div class=\"panel-body\">
            <h4 class=\"text_ads\">允许上传大小</h4>
            <p>允许上传的文件大小，超过此数值，系统将禁止上传，单位请查看下设置项；默认为 200 KB</p>

            <h4 class=\"text_ads\">允许上传单位</h4>
            <p>文件大小的单位，可选 KB、MB，默认为 KB。</p>

            <h4 class=\"text_ads\">允许同时上传数</h4>
            <p>允许同时上传的文件数量，默认可以同时上传 10 个。</p>
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
    <h3>SSO 设置</h3>
    <p>
        点右上角子菜单“SSO 设置“，进入如下界面，可以对 SSO 设置进行设置。baigo CMS 的用户以及后台登录需要 baigo SSO 支持，baigo SSO 的部署方式，请查看 <a href=\"http://www.baigo.net/sso/\" target=\"_blank\">baigo SSO 官方网站</a>。
    </p>

    <p>
        <a href=\"{images}opt_sso.jpg\" target=\"_blank\"><img src=\"{images}opt_sso.jpg\" class=\"img-responsive thumbnail\"></a>
    </p>

    <p>&nbsp;</p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">填写说明</div>
        <div class=\"panel-body\">
            <h4 class=\"text_ads\">API 接口 URL</h4>
            <p>baigo SSO API 接口的 URL</p>

            <h4 class=\"text_ads\">APP ID</h4>
            <p>baigo SSO 应用的 APP ID</p>

            <h4 class=\"text_ads\">APP KEY</h4>
            <p>baigo SSO 应用的 APP KEY</p>

            <h4 class=\"text_ads\">同步登录</h4>
            <p>如为开启状态，当用户在本站登录的时候，所有部署在 baigo SSO 下的网站将同步登录，当用户切换到这些网站时，无需再次登录。</p>
        </div>
    </div>";
