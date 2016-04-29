{* opt_dbconfig.tpl 系统设置界面 *}
{$cfg = [
    title          => "{$lang.page.opt} - {$lang.page.installDbConfig}",
    menu_active    => "opt",
    sub_active     => "dbconfig",
    baigoValidator => "true",
    baigoSubmit    => "true",
    tokenReload    => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=opt"
]}

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=opt&act_get=base">{$lang.page.opt}</a></li>
    <li>{$lang.page.installDbConfig}</li>

    {include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <ul class="nav nav-pills nav_baigo">
            <li>
                <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=opt" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    {$lang.href.help}
                </a>
            </li>
        </ul>
    </div>

    <form name="opt_dbconfig" id="opt_dbconfig">
        <input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
        <input type="hidden" name="act_post" value="dbconfig">

        <div class="panel panel-default">
            <div class="panel-body">

                <div class="form-group">
                    <div id="group_db_host">
                        <label class="control-label">{$lang.label.dbHost}<span id="msg_db_host">*</span></label>
                        <input type="text" value="{$smarty.const.BG_DB_HOST}" name="db_host" id="db_host" data-validate class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <div id="group_db_name">
                        <label class="control-label">{$lang.label.dbName}<span id="msg_db_name">*</span></label>
                        <input type="text" value="{$smarty.const.BG_DB_NAME}" name="db_name" id="db_name" data-validate class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <div id="group_db_port">
                        <label class="control-label">{$lang.label.dbPort}<span id="msg_db_port">*</span></label>
                        <input type="text" value="{$smarty.const.BG_DB_PORT}" name="db_port" id="db_port" data-validate class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <div id="group_db_user">
                        <label class="control-label">{$lang.label.dbUser}<span id="msg_db_user">*</span></label>
                        <input type="text" value="{$smarty.const.BG_DB_USER}" name="db_user" id="db_user" data-validate class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <div id="group_db_pass">
                        <label class="control-label">{$lang.label.dbPass}<span id="msg_db_pass">*</span></label>
                        <input type="text" value="{$smarty.const.BG_DB_PASS}" name="db_pass" id="db_pass" data-validate class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <div id="group_db_charset">
                        <label class="control-label">{$lang.label.dbCharset}<span id="msg_db_charset">*</span></label>
                        <input type="text" value="{$smarty.const.BG_DB_CHARSET}" name="db_charset" id="db_charset" data-validate class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <div id="group_db_table">
                        <label class="control-label">{$lang.label.dbTable}<span id="msg_db_table">*</span></label>
                        <input type="text" value="{$smarty.const.BG_DB_TABLE}" name="db_table" id="db_table" data-validate class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <button type="button" id="go_submit" class="btn btn-primary">{$lang.btn.save}</button>
                </div>

            </div>
        </div>

    </form>

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/admin_foot.tpl" cfg=$cfg}

    <script type="text/javascript">
    var opts_validator_form = {
        db_host: {
            len: { min: 1, max: 900 },
            validate: { type: "str", format: "text", group: "#group_db_host" },
            msg: { selector: "#msg_db_host", too_short: "{$alert.x060204}", too_long: "{$alert.x060205}" }
        },
        db_name: {
            len: { min: 1, max: 900 },
            validate: { type: "str", format: "text", group: "#group_db_name" },
            msg: { selector: "#msg_db_name", too_short: "{$alert.x060206}", too_long: "{$alert.x060207}" }
        },
        db_port: {
            len: { min: 1, max: 900 },
            validate: { type: "str", format: "text", group: "#group_db_port" },
            msg: { selector: "#msg_db_port", too_short: "{$alert.x060208}", too_long: "{$alert.x060209}" }
        },
        db_user: {
            len: { min: 1, max: 900 },
            validate: { type: "str", format: "text", group: "#group_db_user" },
            msg: { selector: "#msg_db_user", too_short: "{$alert.x060210}", too_long: "{$alert.x060211}" }
        },
        db_pass: {
            len: { min: 1, max: 900 },
            validate: { type: "str", format: "text", group: "#group_db_pass" },
            msg: { selector: "#msg_db_pass", too_short: "{$alert.x060212}", too_long: "{$alert.x060213}" }
        },
        db_charset: {
            len: { min: 1, max: 900 },
            validate: { type: "str", format: "text", group: "#group_db_charset" },
            msg: { selector: "#msg_db_charset", too_short: "{$alert.x060214}", too_long: "{$alert.x060215}" }
        },
        db_table: {
            len: { min: 1, max: 900 },
            validate: { type: "str", format: "text", group: "#group_db_table" },
            msg: { selector: "#msg_db_table", too_short: "{$alert.x060216}", too_long: "{$alert.x060217}" }
        }
    };

    var opts_submit_form = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=opt",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    $(document).ready(function(){
        var obj_validate_form = $("#opt_dbconfig").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#opt_dbconfig").baigoSubmit(opts_submit_form);
        $("#go_submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    })
    </script>

{include "{$smarty.const.BG_PATH_TPL}admin/default/include/html_foot.tpl" cfg=$cfg}

