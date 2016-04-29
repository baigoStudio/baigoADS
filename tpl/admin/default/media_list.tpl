{*media_list.php 上传管理*}
{$cfg = [
    title          => "{$adminMod.media.main.title}",
    menu_active    => "media",
    sub_active     => "list",
    baigoCheckall  => "true",
    baigoValidator => "true",
    baigoSubmit    => "true",
    baigoClear     => "true",
    upload         => "true",
    tokenReload    => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=media&{$tplData.query}"
]}

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li>{$adminMod.media.main.title}</li>

    {include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills nav_baigo">
                    <li {if !$tplData.search.box || $tplData.search.box == "normal"}class="active"{/if}>
                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=media">
                            {$lang.href.all}
                            <span class="badge">{$tplData.mediaCount.all}</span>
                        </a>
                    </li>
                    {if $tplData.mediaCount.recycle > 0}
                        <li {if $tplData.search.box == "recycle"}class="active"{/if}>
                            <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=media&box=recycle">
                                {$lang.href.recycle}
                                <span class="badge">{$tplData.mediaCount.recycle}</span>
                            </a>
                        </li>
                    {/if}
                    <li>
                        <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=media" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            {$lang.href.help}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pull-right">
            <form name="media_search" id="media_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
                <input type="hidden" name="mod" value="media">
                <input type="hidden" name="act_get" value="list">
                <div class="form-group">
                    <select name="year" class="form-control input-sm">
                        <option value="">{$lang.option.allYear}</option>
                        {foreach $tplData.yearRows as $key=>$value}
                            <option {if $tplData.search.year == $value.media_year}selected{/if} value="{$value.media_year}">{$value.media_year}</option>
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
                    <select name="ext" class="form-control input-sm">
                        <option value="">{$lang.option.allExt}</option>
                        {foreach $tplData.extRows as $key=>$value}
                            <option {if $tplData.search.ext == $value.media_ext}selected{/if} value="{$value.media_ext}">{$value.media_ext}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-sm">
                        <input type="text" name="key" class="form-control" value="{$tplData.search.key}" placeholder="{$lang.label.key}">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="well">
                {include "{$smarty.const.BG_PATH_TPL}admin/default/include/upload.tpl" cfg=$cfg}
            </div>
            <div class="well">
                {if $tplData.search.box == "recycle"}
                    <form name="media_empty" id="media_empty">
                        <input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
                        <input type="hidden" name="act_post" id="act_empty" value="empty">
                        <div class="form-group">
                            <button type="button" class="btn btn-warning" id="go_empty">
                                <span class="glyphicon glyphicon-trash"></span>
                                {$lang.btn.empty}
                            </button>
                        </div>
                        <div class="form-group">
                            <div class="baigoClear progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped active"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="baigoClearMsg">

                            </div>
                        </div>
                    </form>
                {else}
                    <form name="media_clear" id="media_clear">
                        <input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
                        <input type="hidden" name="act_post" id="act_clear" value="clear">
                        <div class="form-group">
                            <button type="button" class="btn btn-warning" id="go_clear">
                                <span class="glyphicon glyphicon-trash"></span>
                                {$lang.btn.mediaClear}
                            </button>
                        </div>
                        <div class="form-group">
                            <div class="baigoClear progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped active"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="baigoClearMsg">

                            </div>
                        </div>
                    </form>
                {/if}
            </div>
        </div>

        <div class="col-md-9">
            <form name="media_list" id="media_list" class="form-inline">
                <input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">

                <div class="panel panel-default">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-nowrap td_mn">
                                        <label for="chk_all" class="checkbox-inline">
                                            <input type="checkbox" name="chk_all" id="chk_all" data-parent="first">
                                            {$lang.label.all}
                                        </label>
                                    </th>
                                    <th class="text-nowrap td_mn">{$lang.label.id}</th>
                                    <th>{$lang.label.mediaInfo}</th>
                                    <th class="text-nowrap td_md">{$lang.label.status} / {$lang.label.admin}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach $tplData.mediaRows as $key=>$value}
                                    {if $value.media_box == "normal"}
                                        {$_css_status = "success"}
                                    {else}
                                        {$_css_status = "default"}
                                    {/if}
                                    <tr>
                                        <td class="text-nowrap td_mn"><input type="checkbox" name="media_ids[]" value="{$value.media_id}" id="media_id_{$value.media_id}" data-validate="media_id" data-parent="chk_all"></td>
                                        <td class="text-nowrap td_mn">{$value.media_id}</td>
                                        <td>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <a href="#" role="button" tabindex="0" data-trigger="focus" data-toggle="popover" data-placement="right" data-content="<a href='{$value.media_url}' target='_blank'><img src='{$value.media_url}' class='img-responsive'></a>">{$value.media_name}</a>
                                                </li>
                                                <li>
                                                    <abbr data-toggle="tooltip" data-placement="bottom" title="{$value.media_time|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIME}"}">{$value.media_time|date_format:$smarty.const.BG_SITE_DATE}</abbr>
                                                </li>
                                                {if $value.media_size > 1024}
                                                    {$_num_mediaSize = $value.media_size / 1024}
                                                    {$_str_mediaUnit = "KB"}
                                                {else if $value.media_size > 1024 * 1024}
                                                    {$_num_mediaSize = $value.media_size / 1024 / 1024}
                                                    {$_str_mediaUnit = "MB"}
                                                {else if $value.media_size > 1024 * 1024 * 1024}
                                                    {$_num_mediaSize = $value.media_size / 1024 / 1024 / 1024}
                                                    {$_str_mediaUnit = "GB"}
                                                {else}
                                                    {$_num_mediaSize = $value.media_size}
                                                    {$_str_mediaUnit = "B"}
                                                {/if}
                                                <li>{$_num_mediaSize|string_format:"%.2f"} {$_str_mediaUnit}</li>
                                            </ul>
                                        </td>
                                        <td class="text-nowrap td_md">
                                            <ul class="list-unstyled">
                                                <li class="label_baigo">
                                                    <span class="label label-{$_css_status}">{$lang.label[$value.media_box]}</span>
                                                </li>
                                                <li>
                                                    {if isset($value.adminRow.admin_name)}
                                                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=media&admin_id={$value.media_admin_id}">{$value.adminRow.admin_name}</a>
                                                    {else}
                                                        {$lang.label.unknown}
                                                    {/if}
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                {/foreach}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                        <span id="msg_media_id"></span>
                                    </td>
                                    <td colspan="3">
                                        <div class="form-group">
                                            <div id="group_act_post">
                                                <select name="act_post" id="act_post" data-validate class="form-control input-sm">
                                                    <option value="">{$lang.option.batch}</option>
                                                    {if $tplData.search.box == "recycle"}
                                                        <option value="normal">{$lang.option.revert}</option>
                                                        <option value="del">{$lang.option.del}</option>
                                                    {else}
                                                        <option value="recycle">{$lang.option.recycle}</option>
                                                    {/if}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" id="go_submit" class="btn btn-primary btn-sm">{$lang.btn.submit}</button>
                                        </div>
                                        <div class="form-group">
                                            <span id="msg_act_post"></span>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </form>

            <div class="text-right">
                {include "{$smarty.const.BG_PATH_TPL}admin/default/include/page.tpl" cfg=$cfg}
            </div>
        </div>
    </div>

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_foot.tpl" cfg=$cfg}

    <script type="text/javascript">
    var opts_validator_list = {
        media_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='media_id']", type: "checkbox" },
            msg: { selector: "#msg_media_id", too_few: "{$alert.x030202}" }
        },
        act_post: {
            len: { min: 1, "max": 0 },
            validate: { type: "select", group: "#group_act_post" },
            msg: { selector: "#msg_act_post", too_few: "{$alert.x030203}" }
        }
    };

    var opts_submit_list = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=media",
        confirm_selector: "#act_post",
        confirm_val: "del",
        confirm_msg: "{$lang.confirm.del}",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    var opts_empty = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=media",
        confirm_selector: "#act_empty",
        confirm_val: "empty",
        confirm_msg: "{$lang.confirm.empty}",
        msg_loading: "{$alert.x070408}",
        msg_complete: "{$alert.y070408}"
    };

    var opts_clear = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=media",
        confirm_selector: "#act_clear",
        confirm_val: "clear",
        confirm_msg: "{$lang.confirm.clear}",
        msg_loading: "{$alert.x070407}",
        msg_complete: "{$alert.y070407}"
    };

    $(document).ready(function(){
        var obj_validate_list = $("#media_list").baigoValidator(opts_validator_list);
        var obj_submit_list   = $("#media_list").baigoSubmit(opts_submit_list);
        $("#go_submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        var obj_empty = $("#media_empty").baigoClear(opts_empty);
        $("#go_empty").click(function(){
            obj_empty.clearSubmit();
        });
        var obj_clear  = $("#media_clear").baigoClear(opts_clear);
        $("#go_clear").click(function(){
            obj_clear.clearSubmit();
        });
        $("#media_list").baigoCheckall();
        $("[data-toggle='tooltip']").tooltip({
            html: true
        });
        $("[data-toggle='popover']").popover({
            html: true
        });
    });
    </script>

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/html_foot.tpl" cfg=$cfg}