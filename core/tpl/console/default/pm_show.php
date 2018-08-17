    <?php include(BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS . 'function.php');
    $_arr_status = pm_status_process($this->tplData['pmRow'], $this->lang['common']['pm'], $this->lang['mod'], $this->tplData['pmRow']['pm_type']); ?>
    <div class="modal-header">
        <div class="modal-title"><?php echo $this->lang['mod']['page']['pm'], ' &raquo; ', $this->lang['mod']['page']['show']; ?></div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form name="pm_form" id="pm_form">
            <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
            <?php if ($this->tplData['pmRow']['pm_type'] == 'out') { ?>
                <input type="hidden" name="pm_id" id="pm_id" value="<?php echo $this->tplData['pmRow']['pm_send_id']; ?>">
            <?php } ?>
            <input type="hidden" name="a" value="revoke">

            <div class="form-group">
                <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                <div class="form-text"><?php echo $this->tplData['pmRow']['pm_id']; ?></div>
            </div>

            <div class="form-group">
                <label><?php echo $this->lang['mod']['label']['title']; ?></label>
                <div class="form-text"><?php echo $this->tplData['pmRow']['pm_title']; ?></div>
            </div>

            <div class="form-group">
                <label><?php echo $this->lang['mod']['label']['content']; ?></label>
                <div class="bg-content"><?php echo $this->tplData['pmRow']['pm_content']; ?></div>
            </div>

            <div class="form-group">
                <label><?php echo $this->lang['mod']['label']['status']; ?></label>
                <div class="form-text">
                    <span class="badge badge-<?php echo $_arr_status['css_label']; ?>"><?php echo $_arr_status['str_text']; ?></span>
                </div>
            </div>

        </form>

        <div class="bg-submit-box bg-submit-box-modal"></div>
    </div>
    <div class="modal-footer">
        <?php if ($this->tplData['pmRow']['pm_type'] == 'out') { ?>
            <button type="button" class="btn btn-info bg-submit-modal"><?php echo $this->lang['mod']['btn']['revoke']; ?></button>
        <?php } ?>
        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=pm&a=send&pm_id=<?php echo $this->tplData['pmRow']['pm_id']; ?>" class="btn btn-primary"><?php echo $this->lang['mod']['href']['reply']; ?></a>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><?php echo $this->lang['common']['btn']['close']; ?></button>
    </div>

    <script type="text/javascript">
    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=pm&c=request",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        },
        box: {
            selector: ".bg-submit-box-modal"
        },
        selector: {
            submit_btn: ".bg-submit-modal"
        }
    };

    $(document).ready(function(){
        var obj_submit_form   = $("#pm_form").baigoSubmit(opts_submit_form);
        $(".bg-submit-modal").click(function(){
            obj_submit_form.formSubmit();
        });
    });
    </script>