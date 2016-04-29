{* advert_show.tpl 管理员编辑界面 *}
{$cfg = [
    title          => "{$adminMod.advert.main.title} - {$lang.page.show}",
    menu_active    => "advert",
    sub_active     => "list",
    baigoValidator => "true",
    baigoSubmit    => "true",
    tokenReload    => "true",
    datepicker     => "true",
    upload         => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=advert"
]}

{if ($tplData.advertRow.advert_put_type == "date" && $tplData.advertRow.advert_put_opt < $smarty.now) || ($tplData.advertRow.advert_put_type == "show" && $tplData.advertRow.advert_put_opt < $tplData.advertRow.advert_count_show) || ($tplData.advertRow.advert_put_type == "hit" && $tplData.advertRow.advert_put_opt < $tplData.advertRow.advert_count_hit)}
    {$_css_status = "warning"}
    {$_str_status = $lang.label.expired}
{else}
    {if $tplData.advertRow.advert_status == "enable"}
        {$_css_status = "success"}
        {$_str_status = $status.advert[$tplData.advertRow.advert_status]}
    {else}
        {$_css_status = "default"}
        {$_str_status = $status.advert[$tplData.advertRow.advert_status]}
    {/if}
{/if}

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=advert&act_get=list">{$adminMod.advert.main.title}</a></li>
    <li>{$lang.page.show}</li>

    {include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <ul class="nav nav-pills nav_baigo">
            <li>
                <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=advert&act_get=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    {$lang.href.back}
                </a>
            </li>
            <li>
                <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=advert#form" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    {$lang.href.help}
                </a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.advertName}</label>
                        <p class="form-control-static input-lg">{$tplData.advertRow.advert_name}</p>
                    </div>

                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.advertUrl}</label>
                        <p class="form-control-static">{$tplData.advertRow.advert_url}</p>
                    </div>

                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.posi}</label>
                        <p class="form-control-static input-lg">
                            {$tplData.advertRow.posiRow.posi_name}
                            [
                                {$type.posi[$tplData.advertRow.posiRow.posi_type]}
                                {if $tplData.advertRow.posiRow.posi_type == "media"}
                                    /
                                    {$lang.label.width}
                                    {$tplData.advertRow.posiRow.posi_width}{$lang.label.px}
                                    {$lang.label.height}
                                    {$tplData.advertRow.posiRow.posi_height}{$lang.label.px}
                                {/if}
                            ]
                        </p>
                    </div>

                    {if $tplData.advertRow.posiRow.posi_type == "media" && $tplData.advertRow.advert_media_id > 0 && $tplData.advertRow.mediaRow.alert == "y070102"}
                        <div class="form-group">
                            <label class="control-label static_label">{$lang.label.advertMedia}</label>
                            <p class="form-control-static">
                                <img src="{$tplData.advertRow.mediaRow.media_url}" width="{$tplData.advertRow.posiRow.posi_width}" height="{$tplData.advertRow.posiRow.posi_height}">
                            </p>
                        </div>
                    {else}
                        <div class="form-group">
                            <label class="control-label static_label">{$lang.label.advertContent}</label>
                            <p class="form-control-static input-lg">{$tplData.advertRow.advert_content}</p>
                        </div>
                    {/if}

                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.advertBegin}</label>
                        <p class="form-control-static input-lg">{$tplData.advertRow.advert_begin|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}</p>
                    </div>

                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.note}</label>
                        <p class="form-control-static input-lg">{$tplData.advertRow.advert_note}</p>
                    </div>

                    <div class="form-group">
                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=advert&act_get=form&advert_id={$tplData.advertRow.advert_id}">
                            <span class="glyphicon glyphicon-edit"></span>
                            {$lang.href.edit}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="well">
                <div class="form-group">
                    <label class="control-label static_label">{$lang.label.id}</label>
                    <p class="form-control-static">{$tplData.advertRow.advert_id}</p>
                </div>

                <div class="form-group">
                    <label class="control-label static_label">{$lang.label.status}</label>
                    <p class="form-control-static label_baigo">
                        <span class="label label-{$_css_status}">{$_str_status}</span>
                    </p>
                </div>

                <div class="form-group">
                    <label class="control-label static_label">{$lang.label.advertPutType}</label>
                    <p class="form-control-static">{$type.put[$tplData.advertRow.advert_put_type]}</p>
                </div>

                {if $tplData.advertRow.advert_put_type == "date"}
                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.advertPutDate}</label>
                        <p class="form-control-static">{$tplData.advertRow.advert_put_opt|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}</p>
                    </div>
                {else if $tplData.advertRow.advert_put_type == "show"}
                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.advertPutShow}</label>
                        <p class="form-control-static">{$tplData.advertRow.advert_put_opt}</p>
                    </div>
                {else}
                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.advertPutHit}</label>
                        <p class="form-control-static">{$tplData.advertRow.advert_put_opt}</p>
                    </div>
                {/if}

                <div class="form-group">
                    <label class="control-label static_label">{$lang.label.advertPercent}</label>
                    <p class="form-control-static">{$tplData.advertRow.advert_percent * 10}%</p>
                </div>

                <div class="form-group">
                    <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=advert&act_get=form&advert_id={$tplData.advertRow.advert_id}">
                        <span class="glyphicon glyphicon-edit"></span>
                        {$lang.href.edit}
                    </a>
                </div>
            </div>
        </div>
    </div>

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_foot.tpl" cfg=$cfg}
{include "{$smarty.const.BG_PATH_TPL}admin/default/include/html_foot.tpl" cfg=$cfg}
