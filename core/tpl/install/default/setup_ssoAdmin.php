<?php $cfg = array(
    'title'         => $this->lang['mod']['page']['setup'] . ' &raquo; ' . $this->lang['mod']['page']['ssoAdmin'],
    'sub_title'     => $this->lang['mod']['page']['ssoAdmin'],
    'pathInclude'   => BG_PATH_TPLSYS . 'install' . DS . 'default' . DS . 'include' . DS,
    'mod_help'      => 'install',
    "act_help"      => 'admin#sso',
); ?>
<?php include($cfg['pathInclude'] . 'setup_head.php'); ?>

    <form name="setup_form_admin" id="setup_form_admin" autocomplete="off">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="act" value="ssoAdmin">
        <input type="hidden" name="admin_status" value="enable">
        <input type="hidden" name="admin_type" value="super">

        <div class="alert alert-warning">
            <span class="glyphicon glyphicon-warning-sign"></span>
            <?php echo $this->lang['mod']['text']['ssoAdmin']; ?>
        </div>

        <div class="form-group">
            <div id="group_admin_name">
                <label class="control-label"><?php echo $this->lang['mod']['label']['username']; ?><span id="msg_admin_name">*</span></label>
                <input type="text" name="admin_name" id="admin_name" data-validate class="form-control">
            </div>
        </div>

        <div class="form-group">
            <div id="group_admin_pass">
                <label class="control-label"><?php echo $this->lang['mod']['label']['password']; ?><span id="msg_admin_pass">*</span></label>
                <input type="password" name="admin_pass" id="admin_pass" data-validate class="form-control">
            </div>
        </div>

        <div class="form-group">
            <div id="group_admin_pass_confirm">
                <label class="control-label"><?php echo $this->lang['mod']['label']['passConfirm']; ?><span id="msg_admin_pass_confirm">*</span></label>
                <input type="password" name="admin_pass_confirm" id="admin_pass_confirm" data-validate class="form-control">
            </div>
        </div>

        <div class="form-group">
            <div id="group_admin_nick">
                <label class="control-label"><?php echo $this->lang['mod']['label']['nick']; ?><span id="msg_admin_nick"></span></label>
                <input type="text" name="admin_nick" id="admin_nick" data-validate class="form-control">
            </div>
        </div>

        <div class="bg-submit-box"></div>

        <div class="form-group clearfix">
            <div class="pull-left">
                <div class="btn-group">
                    <a href="<?php echo BG_URL_INSTALL; ?>index.php?mod=setup&act=ssoAuto" class="btn btn-default"><?php echo $this->lang['mod']['btn']['prev']; ?></a>
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
            validate: { type: "text", format: "strDigit", group: "#group_admin_name" },
            msg: { selector: "#msg_admin_name", too_short: "<?php echo $this->lang['rcode']['x010201']; ?>", too_long: "<?php echo $this->lang['rcode']['x010202']; ?>", format_err: "<?php echo $this->lang['rcode']['x010203']; ?>" }
        },
        admin_pass: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "text", group: "#group_admin_pass" },
            msg: { selector: "#msg_admin_pass", too_short: "<?php echo $this->lang['rcode']['x010212']; ?>" }
        },
        admin_pass_confirm: {
            len: { min: 1, max: 0 },
            validate: { type: "confirm", target: "#admin_pass", group: "#group_admin_pass_confirm" },
            msg: { selector: "#msg_admin_pass_confirm", too_short: "<?php echo $this->lang['rcode']['x010224']; ?>", not_match: "<?php echo $this->lang['rcode']['x010225']; ?>" }
        },
        admin_nick: {
            len: { min: 0, max: 30 },
            validate: { type: "str", format: "text", group: "#group_admin_nick" },
            msg: { selector: "#msg_admin_nick", too_long: "<?php echo $this->lang['rcode']['x010214']; ?>" }
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
        var obj_validator_form    = $("#setup_form_admin").baigoValidator(opts_validator_form);
        var obj_submit_form       = $("#setup_form_admin").baigoSubmit(opts_submit_form);
        $("#go_next").click(function(){
            if (obj_validator_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>