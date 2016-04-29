{* admin_list.tpl 管理员列表 *}
{$cfg = [
    title          => $adminMod.advert.main.title,
    menu_active    => "advert",
    sub_active     => "list",
    baigoCheckall  => "true",
    baigoValidator => "true",
    baigoSubmit    => "true",
    tokenReload    => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=advert&{$tplData.query}"
]}

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li>{$adminMod.advert.main.title}</li>

    {include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <div class="pull-left">
            <ul class="nav nav-pills nav_baigo">
                <li {if $tplData.search.type == "year"}class="active"{/if}>
                    <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=stat&act_get=advert&type=year&advert_id={$tplData.advertRow.advert_id}">
                        {$lang.href.statYear}
                    </a>
                </li>
                <li {if $tplData.search.type == "month"}class="active"{/if}>
                    <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=stat&act_get=advert&type=month&advert_id={$tplData.advertRow.advert_id}">
                        {$lang.href.statMonth}
                    </a>
                </li>
                <li {if $tplData.search.type == "day"}class="active"{/if}>
                    <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=stat&act_get=advert&type=day&advert_id={$tplData.advertRow.advert_id}">
                        {$lang.href.statDay}
                    </a>
                </li>
            </ul>
        </div>
        <div class="pull-right">
            <form name="stat_search" id="stat_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
                <input type="hidden" name="mod" value="stat">
                <input type="hidden" name="act_get" value="advert">
                <input type="hidden" name="type" value="{$tplData.search.type}">
                <input type="hidden" name="advert_id" value="{$tplData.advertRow.advert_id}">
                {if $tplData.search.type == "year"}
                    {$_str_time    = $lang.label.statYear}
                    {$_str_format  = "Y"}
                {else if $tplData.search.type == "month"}
                    {$_str_time    = $lang.label.statMonth}
                    {$_str_format  = "Y-m"}
                    <div class="form-group">
                        <select name="year" class="form-control input-sm">
                            <option value="">{$lang.option.allYear}</option>
                            {foreach $tplData.yearRows as $key=>$value}
                                <option {if $tplData.search.year == $value.stat_year}selected{/if} value="{$value.stat_year}">{$value.stat_year}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-default btn-sm">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </div>
                {else}
                    {$_str_time    = $lang.label.statDay}
                    {$_str_format  = "Y-m-d"}
                    <div class="form-group">
                        <select name="year" class="form-control input-sm">
                            <option value="">{$lang.option.allYear}</option>
                            {foreach $tplData.yearRows as $key=>$value}
                                <option {if $tplData.search.year == $value.stat_year}selected{/if} value="{$value.stat_year}">{$value.stat_year}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="month" class="form-control input-sm">
                            <option value="">{$lang.option.allMonth}</option>
                            {for $_i = 1 to 12}
                                {if $_i < 10}
                                    {$_str_month = "0{$_i}"}
                                {else}
                                    {$_str_month = $_i}
                                {/if}
                                <option {if $tplData.search.month == $_str_month}selected{/if} value="{$_str_month}">{$_str_month}</option>
                            {/for}
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-default btn-sm">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </div>
                {/if}
            </form>
        </div>
        <div class="clearfix"></div>
    </div>

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

    <div class="well">
        <div class="form-group">
            <label class="control-label static_label">{$lang.label.advert}</label>
            <p class="form-control-static">
                {if $tplData.advertRow.posiRow.posi_type == "media" && $tplData.advertRow.advert_media_id > 0 && $tplData.advertRow.mediaRow.alert == "y070102"}
                    <img src="{$tplData.advertRow.mediaRow.media_url}" width="{$tplData.advertRow.posiRow.posi_width}" height="{$tplData.advertRow.posiRow.posi_height}">
                {else}
                    {$tplData.advertRow.advert_content}
                {/if}
            </p>
        </div>

        <div class="form-group">
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapse_advert">
                {$lang.btn.more}
                <span class="caret"></span>
            </a>
        </div>

        <div class="collapse" id="collapse_advert">

            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.id}</label>
                        <p class="form-control-static">{$tplData.advertRow.advert_id}</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.advertName}</label>
                        <p class="form-control-static">{$tplData.advertRow.advert_name}</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.advertUrl}</label>
                        <p class="form-control-static">{$tplData.advertRow.advert_url}</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.posi}</label>
                        <p class="form-control-static">
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
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.advertBegin}</label>
                        <p class="form-control-static">{$tplData.advertRow.advert_begin|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.status}</label>
                        <p class="form-control-static label_baigo">
                            <span class="label label-{$_css_status}">{$_str_status}</span>
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
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
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.advertPercent}</label>
                        <p class="form-control-static">{$tplData.advertRow.advert_percent * 10}%</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="control-label static_label">
                            {$lang.label.advertShow} / {$lang.label.advertHit}
                        </label>
                        <p class="form-control-static">
                            {$tplData.advertRow.advert_count_show} / {$tplData.advertRow.advert_count_hit}
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.note}</label>
                        <p class="form-control-static">{$tplData.advertRow.advert_note}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>{$_str_time}</th>
                        <th>{$lang.label.advertStatShow}</th>
                        <th>{$lang.label.advertStatHit}</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach $tplData.statRows as $key=>$value}
                        <tr>
                            <td>
                                {$value.stat_time|date_format:$_str_format}
                            </td>
                            <td>
                                {$value.stat_count_show}
                            </td>
                            <td>
                                {$value.stat_count_hit}
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-right">
        {include "{$smarty.const.BG_PATH_TPL}admin/default/include/page.tpl" cfg=$cfg}
    </div>

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_foot.tpl" cfg=$cfg}
{include "{$smarty.const.BG_PATH_TPL}admin/default/include/html_foot.tpl" cfg=$cfg}