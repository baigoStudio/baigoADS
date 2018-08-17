<?php if ($this->tplData['linkRow']['link_id'] < 1) {
    $title_sub  = $this->lang['mod']['page']['add'];
} else {
    $title_sub = $this->lang['mod']['page']['edit'];
}

$cfg = array(
    'title'          => $this->lang['consoleMod']['link']['sub']['list'] . ' &raquo; ' . $title_sub,
    'menu_active'    => 'link',
    'sub_active'     => "list",
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?m=link"
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=link&a=list" class="nav-link">
                <span class="oi oi-chevron-left"></span>
                <?php echo $this->lang['common']['href']['back']; ?>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo BG_URL_HELP; ?>index.php?m=console&a=link" class="nav-link" target="_blank">
                <span class="badge badge-pill badge-primary">
                    <span class="oi oi-question-mark"></span>
                </span>
                <?php echo $this->lang['mod']['href']['help']; ?>
            </a>
        </li>
    </ul>

    <form name="link_form" id="link_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="link_id" id="link_id" value="<?php echo $this->tplData['linkRow']['link_id']; ?>">
        <input type="hidden" name="a" value="submit">

        <div class="row">
            <div class="col-md-9">
                <div class="card mb-3 mb-lg-0">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['linkName']; ?> <span class="text-danger">*</span></label>
                            <input type="text" name="link_name" id="link_name" value="<?php echo $this->tplData['linkRow']['link_name']; ?>" data-validate class="form-control">
                            <small class="form-text" id="msg_link_name"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['linkUrl']; ?> <span class="text-danger">*</span></label>
                            <input type="text" name="link_url" id="link_url" value="<?php echo $this->tplData['linkRow']['link_url']; ?>" data-validate class="form-control">
                            <small class="form-text" id="msg_link_url"></small>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <label for="link_blank" class="form-check-label">
                                    <input type="checkbox" id="link_blank" name="link_blank" <?php if ($this->tplData['linkRow']['link_blank'] > 0) { ?>checked<?php } ?> value="1" class="form-check-input">
                                    <?php echo $this->lang['mod']['label']['isBlank']; ?>
                                </label>
                            </div>
                        </div>

                        <div class="bg-submit-box"></div>
                        <div class="bg-validator-box mt-3"></div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['save']; ?></button>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <?php if ($this->tplData['linkRow']['link_id'] > 0) { ?>
                            <div class="form-group">
                                <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                                <div class="form-text"><?php echo $this->tplData['linkRow']['link_id']; ?></div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['status']; ?> <span class="text-danger">*</span></label>
                            <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                                <div class="form-check">
                                    <label for="link_status_<?php echo $value; ?>" class="form-check-label">
                                        <input type="radio" name="link_status" id="link_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($this->tplData['linkRow']['link_status'] == $value) { ?>checked<?php } ?> data-validate="link_status" class="form-check-input">
                                        <?php if (isset($this->lang['mod']['status'][$value])) {
                                            echo $this->lang['mod']['status'][$value];
                                        } else {
                                            echo $value;
                                        } ?>
                                    </label>
                                </div>
                            <?php } ?>
                            <small class="form-text" id="msg_link_status"></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        link_name: {
            len: { min: 1, max: 300 },
            validate: { type: "str", format: "text" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x120201']; ?>", too_long: "<?php echo $this->lang['rcode']['x120202']; ?>" }
        },
        link_url: {
            len: { min: 1, max: 900 },
            validate: { type: "str", format: "url" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x120203']; ?>", too_long: "<?php echo $this->lang['rcode']['x120204']; ?>", format_err: "<?php echo $this->lang['rcode']['x120205']; ?>" }
        },
        link_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='link_status']", type: "radio" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x120207']; ?>" }
        },
        link_cate_id: {
            len: { min: 1, max: 0 },
            validate: { type: "select" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x120208']; ?>" }
        }
    };

    var options_validator_form = {
        msg_global:{
            msg: "<?php echo $this->lang['common']['label']['errInput']; ?>"
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=link&c=request",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    $(document).ready(function(){
        var obj_validate_form = $("#link_form").baigoValidator(opts_validator_form, options_validator_form);
        var obj_submit_form   = $("#link_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>

<?php include('include' . DS . 'html_foot.php');