<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['plugin']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['plugin']['sub']['list'] . ' &raquo; ' . $this->lang['mod']['page']['opt'],
    'menu_active'    => 'plugin',
    'sub_active'     => 'list',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?m=plugin"
);

include($cfg['pathInclude'] . 'function.php');
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
        <input type="hidden" name="a" value="opt">
        <input type="hidden" name="plugin_id" id="plugin_id" value="<?php echo $this->tplData['pluginRow']['plugin_id']; ?>">

        <div class="row">
            <div class="col-md-9">
                <div class="card mb-3 mb-lg-0">
                    <?php include($cfg['pathInclude'] . 'plugin_menu.php'); ?>
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                            <div class="form-text"><?php echo $this->tplData['pluginRow']['plugin_id']; ?></div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['status']; ?></label>
                            <div class="form-text">
                                <?php plugin_status_process($this->tplData['pluginRow']['plugin_status'], $this->lang['mod']['status']); ?>
                            </div>
                        </div>

                        <?php $_str_json = 'var opts_validator_form = {';

                        $_count = 1;

                        if (isset($this->tplData['pluginOpts']) && !fn_isEmpty($this->tplData['pluginOpts'])) {
                            foreach ($this->tplData['pluginOpts'] as $_key=>$_value) {
                                //form
                                if (isset($this->tplData['pluginOptsJSON'][$_key]) && !fn_isEmpty($this->tplData['pluginOptsJSON'][$_key])) {
                                    $_this_value = $this->tplData['pluginOptsJSON'][$_key];
                                } else {
                                    $_this_value = $_value['default'];
                                } ?>
                                <div class="form-group">
                                    <label>
                                        <?php if (isset($_value['label'])) {
                                            $_label = $_value['label'];
                                        } else {
                                            $_label = $_key;
                                        }

                                        echo $_label; ?>
                                    </label>

                                    <?php switch ($_value['type']) {
                                        case 'select': ?>
                                            <select name="plugin_opts[<?php echo $_key; ?>]" id="plugin_opts_<?php echo $_key; ?>" data-validate="plugin_opts_<?php echo $_key; ?>" class="form-control">
                                                <?php foreach ($_value['option'] as $_key_opts=>$_value_opts) { ?>
                                                    <option<?php if ($_this_value == $_key_opts) { ?> selected<?php } ?> value="<?php echo $_key_opts; ?>">
                                                        <?php echo $_value_opts; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        <?php break;

                                        case 'radio':
                                            foreach ($_value['option'] as $_key_opts=>$_value_opts) { ?>
                                                <div class="form-check">
                                                    <label for="plugin_opts_<?php echo $_key; ?>_<?php echo $_key_opts; ?>" class="form-check-label">
                                                        <input type="radio"<?php if ($_this_value == $_key_opts) { ?> checked<?php } ?> value="<?php echo $_key_opts; ?>" data-validate="plugin_opts_<?php echo $_key; ?>" name="plugin_opts[<?php echo $_key; ?>]" id="plugin_opts_<?php echo $_key; ?>_<?php echo $_key_opts; ?>" class="form-check-input">
                                                        <?php echo $_value_opts['value']; ?>
                                                    </label>
                                                </div>
                                                <?php
                                                    if (isset($_value_opts['note']) && !fn_isEmpty($_value_opts['note'])) { ?>
                                                    <small class="form-text"><?php echo $_value_opts['note']; ?></small>
                                                <?php }
                                            }
                                        break;

                                        case 'textarea': ?>
                                            <textarea name="plugin_opts[<?php echo $_key; ?>]" id="plugin_opts_<?php echo $_key; ?>" data-validate="plugin_opts_<?php echo $_key; ?>" class="form-control bg-textarea-md"><?php echo $_this_value; ?></textarea>
                                        <?php break;

                                        default: ?>
                                            <input type="text" value="<?php echo $_this_value; ?>" name="plugin_opts[<?php echo $_key; ?>]" id="plugin_opts_<?php echo $_key; ?>" data-validate="plugin_opts_<?php echo $_key; ?>" class="form-control">
                                        <?php break;
                                    }

                                    if (isset($_value['note']) && !fn_isEmpty($_value['note'])) { ?>
                                        <small class="form-text"><?php echo $_value['note']; ?></small>
                                    <?php } ?>
                                    <small class="form-text" id="msg_<?php echo $_key; ?>"></small>
                                </div>

                                <?php //json
                                if ($_value['type'] == 'str' || $_value['type'] == 'textarea') {
                                    $str_msg_min = 'too_short';
                                    $str_msg_max = 'too_long';
                                } else {
                                    $str_msg_min = 'too_few';
                                    $str_msg_max = 'too_many';
                                }
                                $_str_json .= 'plugin_opts_' . $_key . ': {
                                    len: { min: ' . $_value['min'] . ', max: 900 },
                                    validate: { selector: "[data-validate=\'plugin_opts_' . $_key . '\']", type: "' . $_value['type'] . '",';
                                    if (isset($_value['format'])) {
                                        $_str_json .= ' format: "' . $_value['format'] . '",';
                                    }
                                    $_str_json .= ' },
                                    msg: { selector: "#msg_' . $_key . '", ' . $str_msg_min . ': "' . $this->lang['rcode']['x060201'] . $_label . '", ' . $str_msg_max . ': "' . $_label . $this->lang['rcode']['x060202'] . '", format_err: "' . $_label . $this->lang['rcode']['x060203'] . '" }
                                }';
                                if ($_count < count($this->tplData['pluginOpts'])) {
                                    $_str_json .= ',';
                                }

                                $_count++;
                            }
                        }

                        $_str_json .= '};'; ?>

                        <div class="bg-submit-box"></div>
                        <div class="bg-validator-box mt-3"></div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['save']; ?></button>
                    </div>
                </div>
            </div>

            <?php include($cfg['pathInclude'] . 'plugin_side.php'); ?>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>
    <script type="text/javascript">
    <?php echo $_str_json; ?>

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=plugin&c=request",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    var options_validator_form = {
        msg_global:{
            msg: "<?php echo $this->lang['common']['label']['errInput']; ?>"
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