<?php $str_sub = 'index';
$title = $lang->get('Image', 'console.common') . ' &raquo; ';

if ($attachRow['attach_id'] > 0) {
    $title  .= $lang->get('Edit');
} else {
    $title  .= $lang->get('Upload');
    $str_sub = 'form';
}

$cfg = array(
    'title'             => $title,
    'menu_active'       => 'attach',
    'sub_active'        => $str_sub,
    'baigoValidate'     => 'true',
    'baigoSubmit'       => 'true',
    'tooltip'           => 'true',
    'upload'            => 'true',
    'typeahead'         => 'true',
    'imageAsync'        => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>attach/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <div class="row">
        <div class="col-xl-9">
            <div class="card mb-3">
                <div class="card-body">
                    <?php if ($attachRow['attach_id'] > 0) {
                        include($cfg['pathInclude'] . 'attach_show' . GK_EXT_TPL);
                    } else {
                        include($cfg['pathInclude'] . 'upload' . GK_EXT_TPL);
                    } ?>
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <?php if ($attachRow['attach_id'] > 0) { ?>
                <form name="attach_form" id="attach_form" action="<?php echo $route_console; ?>attach/submit/">
                    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
                    <input type="hidden" name="attach_id" id="attach_id" value="<?php echo $attachRow['attach_id']; ?>">

                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="form-group">
                                <label><?php echo $lang->get('ID'); ?></label>
                                <input type="text" value="<?php echo $attachRow['attach_id']; ?>" class="form-control-plaintext" readonly>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Original name'); ?></label>
                                <input type="text" value="<?php echo $attachRow['attach_name']; ?>" readonly class="form-control">
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Extension'); ?> <span class="text-danger">*</span></label>
                                <input type="text" name="attach_ext" id="attach_ext" value="<?php echo $attachRow['attach_ext']; ?>" class="form-control">
                                <small class="form-text" id="msg_attach_ext"></small>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('MIME'); ?></label>
                                <input type="text" name="attach_mime" id="attach_mime" value="<?php echo $attachRow['attach_mime']; ?>" class="form-control">
                                <small class="form-text" id="msg_attach_mime"></small>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Note'); ?></label>
                                <input type="text" name="attach_note" id="attach_note" value="<?php echo $attachRow['attach_note']; ?>" class="form-control">
                                <small class="form-text" id="msg_attach_note"></small>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
                                <?php foreach ($box as $key=>$value) { ?>
                                    <div class="form-check">
                                        <input type="radio" name="attach_box" id="attach_box_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($attachRow['attach_box'] == $value) { ?>checked<?php } ?> class="form-check-input">
                                        <label for="attach_box_<?php echo $value; ?>" class="form-check-label">
                                            <?php echo $lang->get($value); ?>
                                        </label>
                                    </div>
                                <?php } ?>
                                <small class="form-text" id="msg_attach_box"></small>
                            </div>

                            <div class="bg-validate-box"></div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <?php echo $lang->get('Save'); ?>
                            </button>
                        </div>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    var opts_validate_form = {
        rules: {
            attach_note: {
                max: 1000
            },
            attach_ext: {
                length: '1,5'
            },
            attach_mime: {
                length: '1,100'
            },
            attach_box: {
                require: true
            }
        },
        attr_names: {
            attach_note: '<?php echo $lang->get('Note'); ?>',
            attach_ext: '<?php echo $lang->get('Extension'); ?>',
            attach_mime: '<?php echo $lang->get('MIME'); ?>',
            attach_box: '<?php echo $lang->get('Status'); ?>'
        },
        type_msg: {
            require: '<?php echo $lang->get('{:attr} require'); ?>',
            length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>'
        },
        msg: {
            loading: '<?php echo $lang->get('Loading'); ?>',
            ajax_err: '<?php echo $lang->get('Server side error'); ?>'
        },
        box: {
            msg: '<?php echo $lang->get('Input error'); ?>'
        }
    };

    var opts_submit_form = {
        modal: {
            btn_text: {
                close: '<?php echo $lang->get('Close'); ?>',
                ok: '<?php echo $lang->get('OK'); ?>'
            }
        },
        msg_text: {
            submitting: '<?php echo $lang->get('Saving'); ?>'
        }
    };

    $(document).ready(function(){
        var obj_validate_form   = $('#attach_form').baigoValidate(opts_validate_form);
        var obj_submit_form     = $('#attach_form').baigoSubmit(opts_submit_form);

        $('#attach_form').submit(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>
<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);
