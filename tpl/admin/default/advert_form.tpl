{* advert_form.tpl 管理员编辑界面 *}
{if $tplData.advertRow.advert_id < 1}
    {$title_sub = $lang.page.add}
    {$str_sub = "form"}
{else}
    {$title_sub = $lang.page.edit}
    {$str_sub = "list"}
{/if}

{$cfg = [
    title          => "{$adminMod.advert.main.title} - {$title_sub}",
    menu_active    => "advert",
    sub_active     => $str_sub,
    baigoValidator => "true",
    baigoSubmit    => "true",
    tokenReload    => "true",
    datepicker     => "true",
    upload         => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=advert"
]}

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=advert&act_get=list">{$adminMod.advert.main.title}</a></li>
    <li>{$title_sub}</li>

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

    <form name="advert_form" id="advert_form">
        <input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
        <input type="hidden" name="act_post" value="submit">
        <input type="hidden" name="advert_id" value="{$tplData.advertRow.advert_id}">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div id="group_advert_name">
                                <label class="control-label">{$lang.label.advertName}<span id="msg_advert_name">*</span></label>
                                <input type="text" name="advert_name" id="advert_name" value="{$tplData.advertRow.advert_name}" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_advert_url">
                                <label class="control-label">{$lang.label.advertUrl}<span id="msg_advert_url">*</span></label>
                                <input type="text" name="advert_url" id="advert_url" value="{$tplData.advertRow.advert_url}" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_advert_posi_id">
                            <label class="control-label">{$lang.label.posi}<span id="msg_advert_posi_id">*</span></label>
                                <select name="advert_posi_id" id="advert_posi_id" data-validate class="form-control">
                                    <option value="">{$lang.option.please}</option>
                                    {foreach $tplData.posiRows as $key=>$value}
                                        <option {if $tplData.advertRow.advert_posi_id == $value.posi_id}selected{/if} value="{$value.posi_id}">
                                            {$value.posi_name}
                                            [
                                                {$type.posi[$value.posi_type]}
                                            ]
                                        </option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>

                        <div id="group_advert_media_id">
                            <div class="form-group">
                                <label class="control-label">{$lang.label.advertMedia}<span id="msg_advert_media_id">*</span></label>
                                <div class="panel panel-default panel_dashed">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="img-thumbnail">
                                                {if $tplData.advertRow.advert_media_id > 0 && $tplData.advertRow.mediaRow.alert == "y070102"}
                                                    {$str_mediaUrl = $tplData.advertRow.mediaRow.media_url}
                                                {else}
                                                    {$str_mediaUrl = "{$smarty.const.BG_URL_STATIC}image/image.png"}
                                                {/if}
                                                <img id="advert_media" src="{$str_mediaUrl}" class="img-responsive">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" name="advert_media_id" id="advert_media_id" value="{$tplData.advertRow.advert_media_id}" data-validate class="form-control">
                                            <p class="help-block">{$lang.label.advertMediaNote}</p>
                                        </div>

                                        <div class="form-group">
                                            <a class="btn btn-success" href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=media&act_get=form&view=iframe" data-toggle="modal" data-target="#media_modal">
                                                <span class="glyphicon glyphicon-picture"></span>
                                                {$lang.btn.select}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_advert_content">
                                <label class="control-label">{$lang.label.advertContent}<span id="msg_advert_content">*</span></label>
                                <textarea name="advert_content" id="advert_content" data-validate class="form-control">{$tplData.advertRow.advert_content}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_advert_begin">
                                <label class="control-label">{$lang.label.advertBegin}<span id="msg_advert_begin">*</span></label>
                                <input type="text" name="advert_begin" id="advert_begin" value="{$tplData.advertRow.advert_begin|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}" data-validate class="form-control input_date">
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_advert_note">
                                <label class="control-label">{$lang.label.note}<span id="msg_advert_note"></span></label>
                                <input type="text" name="advert_note" id="advert_note" value="{$tplData.advertRow.advert_note}" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" class="go_form btn btn-primary">{$lang.btn.save}</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="well">
                    {if $tplData.advertRow.advert_id > 0}
                        <div class="form-group">
                            <label class="control-label">{$lang.label.id}</label>
                            <p class="form-control-static">{$tplData.advertRow.advert_id}</p>
                        </div>
                    {/if}

                    <div class="form-group">
                        <div id="group_advert_status">
                            <label class="control-label">{$lang.label.status}<span id="msg_advert_status">*</span></label>
                            {foreach $status.advert as $key=>$value}
                                <div class="radio_baigo">
                                    <label for="advert_status_{$key}">
                                        <input type="radio" name="advert_status" id="advert_status_{$key}" value="{$key}" {if $tplData.advertRow.advert_status == $key}checked{/if} data-validate="advert_status">
                                        {$value}
                                    </label>
                                </div>
                            {/foreach}
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_advert_put_type">
                            <label class="control-label">{$lang.label.advertPutType}<span id="msg_advert_put_type">*</span></label>
                            <select name="advert_put_type" id="advert_put_type" data-validate class="form-control">
                                <option value="">{$lang.option.please}</option>
                                {foreach $type.put as $key=>$value}
                                    <option {if $tplData.advertRow.advert_put_type == $key}selected{/if} value="{$key}">{$value}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>

                    <div id="opt_date">
                        <div class="form-group">
                            <div id="group_advert_put_date">
                                <label class="control-label">{$lang.label.advertPutDate}<span id="msg_advert_put_date">*</span></label>
                                <input type="text" name="advert_put_opt" id="advert_put_date" value="{$tplData.advertRow.advert_put_opt|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}" data-validate class="form-control input_date">
                            </div>
                        </div>
                    </div>

                    <div id="opt_show">
                        <div class="form-group">
                            <div id="group_advert_put_show">
                                <label class="control-label">{$lang.label.advertPutShow}<span id="msg_advert_put_show">*</span></label>
                                <input type="text" name="advert_put_opt" id="advert_put_show" value="{$tplData.advertRow.advert_put_opt}" data-validate class="form-control">
                            </div>
                        </div>
                    </div>

                    <div id="opt_hit">
                        <div class="form-group">
                            <div id="group_advert_put_hit">
                                <label class="control-label">{$lang.label.advertPutHit}<span id="msg_advert_put_hit">*</span></label>
                                <input type="text" name="advert_put_opt" id="advert_put_hit" value="{$tplData.advertRow.advert_put_opt}" data-validate class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_advert_percent">
                            <label class="control-label">{$lang.label.advertPercent}<span id="msg_advert_percent">*</span></label>
                            <select name="advert_percent" id="advert_percent" data-validate class="form-control">
                                <option value="">{$lang.option.please}</option>
                                {foreach $type.percent as $key=>$value}
                                    <option {if $tplData.advertRow.advert_percent == $key}selected{/if} value="{$key}">{$value}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <div class="modal fade" id="media_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_foot.tpl" cfg=$cfg}

    <script type="text/javascript">
    var opts_validator_form = {
        advert_name: {
            len: { min: 1, max: 30 },
            validate: { type: "str", format: "text", group: "#group_advert_name" },
            msg: { selector: "#msg_advert_name", too_short: "{$alert.x080201}", too_long: "{$alert.x080202}" }
        },
        advert_url: {
            len: { min: 1, max: 3000 },
            validate: { type: "str", format: "text", group: "#group_advert_url" },
            msg: { selector: "#msg_advert_url", too_short: "{$alert.x080205}", too_long: "{$alert.x080206}" }
        },
        advert_posi_id: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_advert_posi_id" },
            msg: { selector: "#msg_advert_posi_id", too_few: "{$alert.x080203}" }
        },
        advert_media_id: {
            len: { min: 1, max: 0 },
            validate: { type: "digit", format: "int" },
            msg: { selector: "#msg_advert_media_id", too_small: "{$alert.x080222}", format_err: "{$alert.x080224}" }
        },
        advert_content: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "text", group: "#group_advert_content" },
            msg: { selector: "#msg_advert_content", too_short: "{$alert.x080226}" }
        },
        advert_put_type: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_advert_put_type" },
            msg: { selector: "#msg_advert_put_type", too_few: "{$alert.x080204}" }
        },
        advert_put_date: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "datetime", group: "#group_advert_put_date" },
            msg: { selector: "#msg_advert_put_date", too_short: "{$alert.x080216}", format_err: "{$alert.x080217}" }
        },
        advert_put_show: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "int", group: "#group_advert_put_show" },
            msg: { selector: "#msg_advert_put_show", too_short: "{$alert.x080218}", format_err: "{$alert.x080219}" }
        },
        advert_put_hit: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "int", group: "#group_advert_put_hit" },
            msg: { selector: "#msg_advert_put_hit", too_short: "{$alert.x080220}", format_err: "{$alert.x080221}" }
        },
        advert_note: {
            len: { min: 0, max: 300 },
            validate: { type: "str", format: "text", group: "#group_advert_note" },
            msg: { selector: "#msg_advert_note", too_long: "{$alert.x080207}" }
        },
        advert_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "[name='advert_status']", type: "radio", group: "#group_advert_status" },
            msg: { selector: "#msg_advert_status", too_few: "{$alert.x080208}" }
        },
        advert_percent: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_advert_percent"},
            msg: { selector: "#msg_advert_percent", too_few: "{$alert.x080209}" }
        },
        advert_begin: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "datetime" },
            msg: { selector: "#msg_advert_begin", too_short: "{$alert.x080214}", format_err: "{$alert.x080215}" }
        }
    };

    var opts_submit_form = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=advert",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    function put_type(_put_type) {
        switch (_put_type) {
            case "show":
                $("#opt_date").hide();
                $("#opt_show").show();
                $("#opt_hit").hide();
                $("#advert_put_date").attr("disabled", true);
                $("#advert_put_show").removeAttr("disabled");
                $("#advert_put_hit").attr("disabled", true);
            break;

            case "hit":
                $("#opt_date").hide();
                $("#opt_show").hide();
                $("#opt_hit").show();
                $("#advert_put_date").attr("disabled", true);
                $("#advert_put_show").attr("disabled", true);
                $("#advert_put_hit").removeAttr("disabled");
            break;

            case "none":
            case "subs":
                $("#opt_date").hide();
                $("#opt_show").hide();
                $("#opt_hit").hide();
                $("#advert_put_date").attr("disabled", true);
                $("#advert_put_show").attr("disabled", true);
                $("#advert_put_hit").attr("disabled", true);
            break;

            default:
                $("#opt_date").show();
                $("#opt_show").hide();
                $("#opt_hit").hide();
                $("#advert_put_date").removeAttr("disabled");
                $("#advert_put_show").attr("disabled", true);
                $("#advert_put_hit").attr("disabled", true);
            break;
        }
    }

    function advert_posi(_posi_id) {
        var posiJSON      = {$tplData.posiJSON}
        var _this_posi    = posiJSON[_posi_id];
        if (typeof _this_posi != "undefined") {
            if (posiJSON[_posi_id].posi_type == "text") {
                $("#group_advert_media_id").hide();
                $("#group_advert_content").show();
            } else {
                $("#group_advert_content").hide();
                $("#group_advert_media_id").show();
            }
            if (_this_posi.posi_is_percent == "enable") {
                $("#advert_percent option:gt(" + (11 - _this_posi.percent_sum) + ")").attr("disabled", true);
            }
        }
    }

    $(document).ready(function(){
        put_type("{$tplData.advertRow.advert_put_type}");
        advert_posi({$tplData.advertRow.advert_posi_id});
        $("#media_modal").on("hidden.bs.modal", function() {
            $(this).removeData("bs.modal");
        });
        var obj_validator_form    = $("#advert_form").baigoValidator(opts_validator_form);
        var obj_submit_form       = $("#advert_form").baigoSubmit(opts_submit_form);
        $(".go_form").click(function(){
            if (obj_validator_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        $("#advert_put_type").change(function(){
            var _put_type = $(this).val();
            put_type(_put_type);
        });
        $("#advert_posi_id").change(function(){
            var _posi_id = $(this).val();
            advert_posi(_posi_id);
        });
        $(".input_date").datetimepicker(opts_datetimepicker);
    });
    </script>

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/html_foot.tpl" cfg=$cfg}
