{* install_1.tpl 登录界面 *}
{$cfg = [
    sub_title  => $lang.page.installAdmin,
    mod_help   => "install"
]}
{include "{$smarty.const.BG_PATH_TPL}install/default/include/install_head.tpl" cfg=$cfg}

    <form name="install_form_auth" id="install_form_auth">
        <input type="hidden" name="{$common.tokenRow.name_session}" value="{$common.tokenRow.token}">
        <input type="hidden" name="act_post" value="auth">
        <input type="hidden" name="admin_status" value="enable">
        <input type="hidden" name="admin_type" value="super">

        <div class="alert alert-warning">
            <h4>
                <span class="glyphicon glyphicon-warning-sign"></span>
                {$lang.text.installAuth}
            </h4>
        </div>

        <p><a href="{$smarty.const.BG_URL_INSTALL}ctl.php?mod=install&act_get=admin" class="btn btn-info">{$lang.href.adminAdd}</a></p>

        <div class="form-group">
            <label class="control-label">{$lang.label.username}<span id="msg_admin_name">*</span></label>
            <input type="text" name="admin_name" id="admin_name" data-validate class="form-control input-lg">
        </div>

        <div class="form-group">
            <div class="btn-group">
                <button type="button" id="go_next" class="btn btn-primary btn-lg">{$lang.btn.submit}</button>
                {include "{$smarty.const.BG_PATH_TPL}install/default/include/install_drop.tpl" cfg=$cfg}
            </div>
        </div>
    </form>

{include "{$smarty.const.BG_PATH_TPL}install/default/include/install_foot.tpl" cfg=$cfg}

    <script type="text/javascript">
    var opts_validator_form = {
        admin_name: {
            len: { min: 1, max: 30 },
            validate: { type: "ajax", format: "strDigit" },
            msg: { selector: "#msg_admin_name", too_short: "{$alert.x020201}", too_long: "{$alert.x020202}", format_err: "{$alert.x020203}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
            ajax: { url: "{$smarty.const.BG_URL_INSTALL}ajax.php?mod=install&act_get=chkauth", key: "admin_name", type: "str" }
        }
    };
    var opts_submit_form = {
        ajax_url: "{$smarty.const.BG_URL_INSTALL}ajax.php?mod=install",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.stepNext}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$smarty.const.BG_URL_INSTALL}ctl.php?mod=install&act_get=over"
    };

    $(document).ready(function(){
        var obj_validator_form    = $("#install_form_auth").baigoValidator(opts_validator_form);
        var obj_submit_form       = $("#install_form_auth").baigoSubmit(opts_submit_form);
        $("#go_next").click(function(){
            if (obj_validator_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>

{include "{$smarty.const.BG_PATH_TPL}install/default/include/html_foot.tpl" cfg=$cfg}