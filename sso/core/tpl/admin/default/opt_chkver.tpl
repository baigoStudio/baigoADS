{* opt_chkver.tpl 系统设置界面 *}
{$cfg = [
    title          => "{$lang.page.opt} - {$lang.page.chkver}",
    menu_active    => "opt",
    sub_active     => "chkver",
    baigoValidator => "true",
    baigoSubmit    => "true",
    tokenReload    => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=opt&act_get=chkver"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=opt&act_get=chkver">{$lang.page.opt}</a></li>
    <li>{$lang.page.chkver}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <ul class="nav nav-pills nav_baigo">
            <li>
                <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=opt#chkver" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    {$lang.href.help}
                </a>
            </li>
        </ul>
    </div>

    <form name="opt_chkver" id="opt_chkver">

        <input type="hidden" name="{$common.tokenRow.name_session}" value="{$common.tokenRow.token}">
        <input type="hidden" name="act_post" value="chkver">
        <p>
            <button type="button" class="btn btn-info" id="go_form">{$lang.btn.chkver}</button>
        </p>
    </form>

    {if $smarty.const.BG_INSTALL_PUB < $tplData.latest_ver.prd_pub}
        <p class="alert alert-danger">
            {$lang.text.haveNewVer}
        </p>
    {else}
        <p class="alert alert-success">
            {$lang.text.isNewVer}
        </p>
    {/if}

    <div class="panel panel-default">
        <table class="table">
            <thead>
                <tr>
                    <th colspan="2">{$lang.label.installVer}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="nowrap td_bg">{$lang.label.installVer}</td>
                    <td>{$smarty.const.BG_INSTALL_VER}</td>
                </tr>
                <tr>
                    <td class="nowrap td_bg">{$lang.label.pubTime}</td>
                    <td>{$tplData.install_pub|date_format:$smarty.const.BG_SITE_DATE}</td>
                </tr>
                <tr>
                    <td class="nowrap td_bg">{$lang.label.installTime}</td>
                    <td>{$smarty.const.BG_INSTALL_TIME|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {if $smarty.const.BG_INSTALL_PUB < $tplData.latest_ver.prd_pub}
        <div class="panel panel-default">
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="2">{$lang.label.latestVer}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="nowrap td_bg">{$lang.label.latestVer}</td>
                        <td>{$tplData.latest_ver.prd_ver}</td>
                    </tr>
                    <tr>
                        <td class="nowrap td_bg">{$lang.label.pubTime}</td>
                        <td>{$tplData.latest_ver.prd_pub}</td>
                    </tr>
                    <tr>
                        <td class="nowrap td_bg">{$lang.label.announcement}</td>
                        <td><a href="{$tplData.latest_ver.prd_announcement}" target="_blank">{$tplData.latest_ver.prd_announcement}</a></td>
                    </tr>
                    <tr>
                        <td class="nowrap td_bg">{$lang.label.downloadUrl}</td>
                        <td><a href="{$tplData.latest_ver.prd_download}" target="_blank">{$tplData.latest_ver.prd_download}</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    {/if}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl" cfg=$cfg}

    <script type="text/javascript">
    var opts_submit_form = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=opt",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    $(document).ready(function(){
        var obj_submit_form       = $("#opt_chkver").baigoSubmit(opts_submit_form);
        $("#go_form").click(function(){
            obj_submit_form.formSubmit();
        });
    });
    </script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}
