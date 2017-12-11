<?php if ($this->tplData['pmRow']['pm_id'] < 1) {
    $title_sub    = $this->lang['mod']['page']['send'];
} else {
    $title_sub    = $this->lang['mod']['page']['reply'];
}

$cfg = array(
    'title'          => $this->lang['mod']['page']['pm'] . ' &raquo; ' . $title_sub,
    'menu_active'    => "pm",
    'sub_active'     => 'list',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?mod=pm"
);

include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group">
        <?php include($cfg['pathInclude'] . 'pm_menu.php'); ?>
    </div>

    <form name="pm_send" id="pm_send">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="act" value="send">
        <input type="hidden" name="pm_id" id="pm_id" value="<?php echo $this->tplData['pmRow']['pm_id']; ?>">

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <div id="group_pm_to">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['pmTo']; ?><span id="msg_pm_to">*</span></label>
                        <input type="text" name="pm_to" id="pm_to" value="<?php echo $this->tplData['pmRow']['pm_to_user']; ?>" data-validate class="form-control">
                        <span class="help-block"><?php echo $this->lang['mod']['label']['pmToNote']; ?></span>
                    </div>
                </div>

                <div class="form-group">
                    <div id="group_pm_title">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['title']; ?><span id="msg_pm_title"></span></label>
                        <input type="text" name="pm_title" id="pm_title" value="<?php echo fn_htmlcode($this->tplData['pmRow']['pm_title'], "decode", "json"); ?>" data-validate class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <div id="group_pm_content">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['content']; ?><span id="msg_pm_content">*</span></label>
                        <textarea name="pm_content" id="pm_content" data-validate class="form-control bg-textarea-md"><?php echo fn_htmlcode($this->tplData['pmRow']['pm_content'], "decode", "json"); ?></textarea>
                    </div>
                </div>

                <div class="bg-submit-box"></div>
            </div>
            <div class="panel-footer">
                <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['send']; ?></button>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        pm_to: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "text", group: "#group_pm_to" },
            msg: { selector: "#msg_pm_to", too_short: "<?php echo $this->lang['rcode']['x110205']; ?>" }
        },
        pm_title: {
            len: { min: 0, max: 90 },
            validate: { type: "str", format: "text", group: "#group_pm_title" },
            msg: { selector: "#msg_pm_title", too_long: "<?php echo $this->lang['rcode']['x110202']; ?>" }
        },
        pm_content: {
            len: { min: 1, max: 900 },
            validate: { type: "str", format: "text", group: "#group_pm_content" },
            msg: { selector: "#msg_pm_content", too_short: "<?php echo $this->lang['rcode']['x110201']; ?>", too_long: "<?php echo $this->lang['rcode']['x110203']; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=pm",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    }

    $(document).ready(function(){
        var obj_validate_form = $("#pm_send").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#pm_send").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>

