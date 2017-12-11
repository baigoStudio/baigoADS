<?php $cfg = array(
    'title'         => $this->lang['mod']['page']['setup'] . ' &raquo; ' . $this->lang['mod']['page']['ssoAuto'],
    'sub_title'     => $this->lang['mod']['page']['ssoAuto'],
    'pathInclude'   => BG_PATH_TPLSYS . 'install' . DS . 'default' . DS . 'include' . DS,
    'mod_help'      => "install",
    "act_help"      => 'sso#auto',
); ?>
<?php include($cfg['pathInclude'] . 'setup_head.php'); ?>

    <form name="setup_form_ssoauto" id="setup_form_ssoauto">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="act" value="ssoAuto">

        <div class="alert alert-warning">
            <span class="glyphicon glyphicon-warning-sign"></span>
            <?php echo $this->lang['mod']['text']['ssoAuto']; ?>
        </div>

        <div class="bg-submit-box"></div>

        <div class="form-group clearfix">
            <div class="pull-left">
                <div class="btn-group">
                    <a href="<?php echo BG_URL_INSTALL; ?>index.php?mod=setup&act=sso" class="btn btn-default"><?php echo $this->lang['mod']['btn']['prev']; ?></a>
                    <?php include($cfg['pathInclude'] . 'setup_drop.php'); ?>
                    <a href="<?php echo BG_URL_INSTALL; ?>index.php?mod=setup&act=ssoAdmin" class="btn btn-default"><?php echo $this->lang['mod']['btn']['skip']; ?></a>
                </div>
            </div>

            <div class="pull-right">
                <button type="button" id="go_next" class="btn btn-primary"><?php echo $this->lang['mod']['btn']['save']; ?></button>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'install_foot.php'); ?>

    <script type="text/javascript">
    var opts_submit_form = {
        ajax_url: "<?php BG_URL_INSTALL; ?>request.php?mod=setup",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        },
        jump: {
            url: "<?php BG_URL_INSTALL; ?>index.php?mod=setup&act=ssoAdmin",
            text: "<?php echo $this->lang['mod']['href']['jumping']; ?>"
        }
    };

    $(document).ready(function(){
        var obj_submit_form = $("#setup_form_ssoauto").baigoSubmit(opts_submit_form);
        $("#go_next").click(function(){
            obj_submit_form.formSubmit();
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>