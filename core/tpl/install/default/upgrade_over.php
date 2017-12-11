<?php $cfg = array(
    'title'         => $this->lang['mod']['page']['upgrade'] . ' &raquo; ' . $this->lang['mod']['page']['over'],
    'sub_title'     => $this->lang['mod']['page']['over'],
    'pathInclude'   => BG_PATH_TPLSYS . 'install' . DS . 'default' . DS . 'include' . DS,
    'mod_help'      => 'upgrade',
); ?>

<?php include($cfg['pathInclude'] . 'upgrade_head.php'); ?>

    <form name="upgrade_form_over" id="upgrade_form_over">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="act" value="over">

        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok-sign"></span>
            <?php echo $this->lang['mod']['label']['over']; ?>
        </div>

        <div class="bg-submit-box"></div>

        <div class="form-group clearfix">
            <div class="pull-left">
                <div class="btn-group">
                    <a href="<?php echo BG_URL_INSTALL; ?>index.php?mod=upgrade&act=sso" class="btn btn-default"><?php echo $this->lang['mod']['btn']['prev']; ?></a>
                    <?php include($cfg['pathInclude'] . 'upgrade_drop.php'); ?>
                </div>
            </div>

            <div class="pull-right">
                <button type="button" id="go_next" class="btn btn-primary"><?php echo $this->lang['mod']['btn']['over']; ?></button>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'install_foot.php'); ?>

    <script type="text/javascript">
    var opts_submit_form = {
        ajax_url: "<?php BG_URL_INSTALL; ?>request.php?mod=upgrade",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        },
        jump: {
            url: "<?php echo BG_URL_CONSOLE; ?>index.php",
            text: "<?php echo $this->lang['mod']['href']['jumping']; ?>"
        }
    };

    $(document).ready(function(){
        var obj_submit_form = $("#upgrade_form_over").baigoSubmit(opts_submit_form);
        $("#go_next").click(function(){
            obj_submit_form.formSubmit();
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>