    <div class="modal-header">
        <div class="modal-title"><?php echo $this->lang['consoleMod']['link']['sub']['list'], ' &raquo; ', $this->lang['mod']['page']['order']; ?></div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form name="link_order" id="link_order" class="form_input">
            <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
            <input type="hidden" name="a" value="order">
            <input type="hidden" name="link_id" value="<?php echo $this->tplData['linkRow']['link_id']; ?>">

            <div class="form-group">
                <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                <div class="form-text"><?php echo $this->tplData['linkRow']['link_id']; ?></div>
            </div>

            <div class="form-group">
                <label><?php echo $this->lang['mod']['label']['linkName']; ?></label>
                <div class="form-text"><?php echo $this->tplData['linkRow']['link_name']; ?></div>
            </div>

            <label><?php echo $this->lang['mod']['label']['order']; ?> <span class="text-danger">*</span></label>
            <div class="form-group">
                <label for="order_first" class="d-block">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio" name="order_type" id="order_first" value="order_first" checked data-validate="order_type">
                            </div>
                        </div>
                        <input type="text" readonly class="form-control bg-light" value="<?php echo $this->lang['mod']['label']['orderFirst']; ?>">
                    </div>
                </label>

                <label for="order_last" class="d-block">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio" name="order_type" id="order_last" value="order_last" data-validate="order_type">
                            </div>
                        </div>
                        <input type="text" readonly class="form-control bg-light" value="<?php echo $this->lang['mod']['label']['orderLast']; ?>">
                    </div>
                </label>

                <label for="order_after" class="d-block">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio" name="order_type" id="order_after" value="order_after" data-validate="order_type">
                            </div>
                        </div>
                        <input type="text" name="order_target" class="form-control" placeholder="<?php echo $this->lang['mod']['label']['orderAfter']; ?>">
                    </div>
                </label>
                <small class="form-text" id="msg_order_type"></small>
            </div>
        </form>

        <div class="bg-submit-box bg-submit-box-modal"></div>
        <div class="bg-validator-box mt-3 bg-validator-box-modal"></div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary bg-submit-modal"><?php echo $this->lang['mod']['btn']['save']; ?></button>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><?php echo $this->lang['common']['btn']['close']; ?></button>
    </div>

    <script type="text/javascript">
    var opts_validator_order = {
        order_type: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='order_type']", type: "radio" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x120213']; ?>" }
        }
    };

    var options_validator_order = {
        msg_global:{
            selector: {
                parent: "#bg-validator-box-modal"
            },
            msg: "<?php echo $this->lang['common']['label']['errInput']; ?>"
        }
    };

    var opts_submit_order = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=link&c=request",
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
        var obj_validate_order = $("#link_order").baigoValidator(opts_validator_order, options_validator_order);
        var obj_submit_order   = $("#link_order").baigoSubmit(opts_submit_order);
        $(".bg-submit-modal").click(function(){
            if (obj_validate_order.verify()) {
                obj_submit_order.formSubmit();
            }
        });
    });
    </script>