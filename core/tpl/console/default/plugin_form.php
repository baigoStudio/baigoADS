<?php if ($this->tplData['pluginRow']['plugin_id'] < 1) {
    $title_sub    = $this->lang['mod']['page']['add'];
} else {
    $title_sub    = $this->lang['mod']['page']['edit'];
}

$cfg = array(
    'title'          => $this->lang['consoleMod']['plugin']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['plugin']['sub']['list'] . ' &raquo; ' . $title_sub,
    'menu_active'    => 'plugin',
    'sub_active'     => 'list',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?m=plugin"
);

include($cfg['pathInclude'] . 'console_head.php'); ?>

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=plugin&a=list" class="nav-link">
                <span class="oi oi-chevron-left"></span>
                <?php echo $this->lang['common']['href']['back']; ?>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo BG_URL_HELP; ?>index.php?m=console&a=plugin#form" class="nav-link" target="_blank">
                <span class="badge badge-pill badge-primary">
                    <span class="oi oi-question-mark"></span>
                </span>
                <?php echo $this->lang['mod']['href']['help']; ?>
            </a>
        </li>
    </ul>

    <form name="plugin_form" id="plugin_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="a" value="submit">
        <input type="hidden" name="plugin_id" id="plugin_id" value="<?php echo $this->tplData['pluginRow']['plugin_id']; ?>">

        <div class="row">
            <div class="col-md-9">
                <div class="card mb-3 mb-lg-0">
                    <?php if ($this->tplData['pluginRow']['plugin_id'] > 0) {
                        include($cfg['pathInclude'] . 'plugin_menu.php');
                    } ?>

                    <div class="card-body">
                        <?php if ($this->tplData['pluginRow']['plugin_id'] > 0) { ?>
                            <div class="form-group">
                                <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                                <div class="form-text"><?php echo $this->tplData['pluginRow']['plugin_id']; ?></div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['status']; ?> <span class="text-danger">*</span></label>
                            <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                                <div class="form-check">
                                    <label for="plugin_status_<?php echo $value; ?>" class="form-check-label">
                                        <input type="radio" name="plugin_status" id="plugin_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($value == 'enable') { ?>checked<?php } ?> data-validate="plugin_status" class="form-check-input">
                                        <?php if (isset($this->lang['mod']['status'][$value])) {
                                            echo $this->lang['mod']['status'][$value];
                                        } else {
                                            echo $value;
                                        } ?>
                                    </label>
                                </div>
                            <?php } ?>
                            <small class="form-text" id="msg_plugin_status"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['pluginDir']; ?> <span class="text-danger">*</span></label>
                            <input type="text" name="plugin_dir" id="plugin_dir" readonly value="<?php echo $this->tplData['pluginRow']['plugin_dir']; ?>" data-validate class="form-control">
                            <small class="form-text" id="msg_plugin_dir"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['note']; ?></label>
                            <input type="text" name="plugin_note" id="plugin_note" value="<?php echo $this->tplData['pluginRow']['plugin_note']; ?>" data-validate class="form-control">
                            <small class="form-text" id="msg_plugin_note"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['detail']; ?></label>
                            <p class="bg-content">
                                <?php if (isset($this->tplData['pluginRow']['detail'])) {
                                    echo $this->tplData['pluginRow']['detail'];
                                } ?>
                            </p>
                        </div>

                        <div class="bg-submit-box"></div>
                        <div class="bg-validator-box mt-3"></div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['submit']; ?></button>
                    </div>
                </div>
            </div>

            <?php include($cfg['pathInclude'] . 'plugin_side.php'); ?>
        </div>

    </form>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        plugin_dir: {
            len: { min: 1, max: 300 },
            validate: { type: "str", format: "alphabetDigit" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x190207']; ?>", too_long: "<?php echo $this->lang['rcode']['x190208']; ?>", format_err: "<?php echo $this->lang['rcode']['x190209']; ?>" }
        },
        plugin_note: {
            len: { min: 0, max: 300 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x190205']; ?>" }
        },
        plugin_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='plugin_status']", type: "radio" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x190206']; ?>" }
        }
    };

    var options_validator_form = {
        msg_global:{
            msg: "<?php echo $this->lang['common']['label']['errInput']; ?>"
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=plugin&c=request",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    $(document).ready(function(){
        var obj_validator_form    = $("#plugin_form").baigoValidator(opts_validator_form, options_validator_form);
        var obj_submit_form       = $("#plugin_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validator_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>

<?php include('include' . DS . 'html_foot.php');