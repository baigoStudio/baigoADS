<?php $cfg = array(
    'title'         => $this->lang['mod']['page']['setup'] . ' &raquo; ' . $this->lang['mod']['page']['auth'],
    'sub_title'     => $this->lang['mod']['page']['auth'],
    'pathInclude'   => BG_PATH_TPLSYS . 'install' . DS . 'default' . DS . 'include' . DS,
    'mod_help'      => "install",
    "act_help"      => 'admin#auth',
); ?>
<?php include($cfg['pathInclude'] . 'setup_head.php'); ?>

    <form name="setup_form_auth" id="setup_form_auth">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="act" value="auth">
        <input type="hidden" name="admin_status" value="enable">
        <input type="hidden" name="admin_type" value="super">

        <div class="alert alert-warning">
            <span class="glyphicon glyphicon-warning-sign"></span>
            <?php echo $this->lang['mod']['text']['auth']; ?>
        </div>

        <p><a href="<?php BG_URL_INSTALL; ?>index.php?mod=setup&act=admin" class="btn btn-info"><?php echo $this->lang['mod']['href']['admin']; ?></a></p>

        <div class="form-group">
            <div id="group_admin_name">
                <label class="control-label"><?php echo $this->lang['mod']['label']['username']; ?><span id="msg_admin_name">*</span></label>
                <input type="text" name="admin_name" id="admin_name" data-validate class="form-control">
            </div>
        </div>

        <div class="bg-submit-box"></div>

        <div class="form-group clearfix">
            <div class="pull-left">
                <div class="btn-group">
                    <a href="<?php echo BG_URL_INSTALL; ?>index.php?mod=setup&act=sso" class="btn btn-default"><?php echo $this->lang['mod']['btn']['prev']; ?></a>
                    <?php include($cfg['pathInclude'] . 'setup_drop.php'); ?>
                    <a href="<?php echo BG_URL_INSTALL; ?>index.php?mod=setup&act=over" class="btn btn-default"><?php echo $this->lang['mod']['btn']['skip']; ?></a>
                </div>
            </div>

            <div class="pull-right">
                <button type="button" id="go_next" class="btn btn-primary"><?php echo $this->lang['mod']['btn']['save']; ?></button>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'install_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        admin_name: {
            len: { min: 1, max: 30 },
            validate: { type: "ajax", format: "strDigit", group: "#group_admin_name" },
            msg: { selector: "#msg_admin_name", too_short: "<?php echo $this->lang['rcode']['x010201']; ?>", too_long: "<?php echo $this->lang['rcode']['x010202']; ?>", format_err: "<?php echo $this->lang['rcode']['x010203']; ?>", ajaxIng: "<?php echo $this->lang['rcode']['x030401']; ?>", ajax_err: "<?php echo $this->lang['rcode']['x030402']; ?>" },
            ajax: { url: "<?php BG_URL_INSTALL; ?>request.php?mod=setup&act=chkauth", key: "admin_name", type: "str" }
        }
    };
    var opts_submit_form = {
        ajax_url: "<?php BG_URL_INSTALL; ?>request.php?mod=setup",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        },
        jump: {
            url: "<?php BG_URL_INSTALL; ?>index.php?mod=setup&act=over",
            text: "<?php echo $this->lang['mod']['href']['jumping']; ?>"
        }
    };

    $(document).ready(function(){
        var obj_validator_form    = $("#setup_form_auth").baigoValidator(opts_validator_form);
        var obj_submit_form       = $("#setup_form_auth").baigoSubmit(opts_submit_form);
        $("#go_next").click(function(){
            if (obj_validator_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>