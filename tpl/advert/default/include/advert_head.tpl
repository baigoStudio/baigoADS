{* advert_head.tpl 管理后台头部，包含菜单 *}
{include "{$smarty.const.BG_PATH_TPL}advert/default/include/html_head.tpl"}

    <header class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                    <span class="sr-only">nav</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                {if $config.ui == "default"}
                    <a class="navbar-brand" href="{$smarty.const.PRD_ADS_URL}" target="_blank">
                        <img src="{$smarty.const.BG_URL_STATIC}advert/{$config.ui}/image/advert_logo.png">
                    </a>
                {else}
                    <a class="navbar-brand" href="#">
                        <img src="{$smarty.const.BG_URL_STATIC}advert/{$config.ui}/image/advert_logo.png">
                    </a>
                {/if}
            </div>
            <nav class="collapse navbar-collapse bs-navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php">{$smarty.const.BG_SITE_NAME}</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <p>&nbsp;</p>

    <div class="container">
