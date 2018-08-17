<?php $cfg = array(
    'title'         => $this->lang['mod']['page']['setup'] . ' &raquo; ' . $this->lang['mod']['page']['ssoAuto'],
    'sub_title'     => $this->lang['mod']['page']['ssoAuto'],
    'mod_help'      => 'setup',
    'act_help'      => "sso#auto",
    'pathInclude'   => BG_PATH_TPLSYS . 'install' . DS . 'default' . DS . 'include' . DS,
);

include($cfg['pathInclude'] . 'setup_head.php'); ?>

    <form name="upgrade_form_ssoauto" id="upgrade_form_ssoauto">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="a" value="ssoAuto">

        <div class="card-body">
            <div class="alert alert-warning">
                <span class="oi oi-warning"></span>
                <?php echo $this->lang['mod']['label']['ssoAuto']; ?>
            </div>

            <div class="bg-submit-box"></div>
        </div>

        <div class="card-footer">
            <div class="btn-toolbar justify-content-between">
                <div class="btn-group">
                    <a href="<?php echo BG_URL_INSTALL; ?>index.php?m=setup&a=sso" class="btn btn-outline-secondary"><?php echo $this->lang['mod']['btn']['prev']; ?></a>
                    <?php include($cfg['pathInclude'] . 'setup_drop.php'); ?>
                    <a href="<?php echo BG_URL_INSTALL; ?>index.php?m=setup&a=ssoAdmin" class="btn btn-secondary"><?php echo $this->lang['mod']['btn']['skip']; ?></a>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['save']; ?></button>
                </div>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'install_foot.php'); ?>

    <script type="text/javascript">
    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_INSTALL; ?>index.php?m=setup&c=request",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        },
        jump: {
            url: "<?php echo BG_URL_INSTALL; ?>index.php?m=setup&a=ssoAdmin",
            text: "<?php echo $this->lang['mod']['href']['jumping']; ?>"
        }
    };

    $(document).ready(function(){
        var obj_submit_form = $("#upgrade_form_ssoauto").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            obj_submit_form.formSubmit();
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php');