<?php if ($advertRow['advert_id'] > 0) {
    $title_sub    = $lang->get('Edit');
    $str_sub      = 'index';
} else {
    $title_sub    = $lang->get('Add');
    $str_sub      = 'form';
}

$cfg = array(
    'title'             => $lang->get('Advertisement', 'console.common') . ' &raquo; ' . $title_sub,
    'menu_active'       => 'advert',
    'sub_active'        => $str_sub,
    'baigoValidate'     => 'true',
    'baigoSubmit'       => 'true',
    'tooltip'           => 'true',
    'upload'            => 'true',
    'datetimepicker'    => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>advert/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <form name="advert_form" id="advert_form" action="<?php echo $route_console; ?>advert/submit/">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
        <input type="hidden" name="advert_id" id="advert_id" value="<?php echo $advertRow['advert_id']; ?>">
        <input type="hidden" name="advert_attach_id" id="advert_attach_id" value="<?php echo $advertRow['advert_attach_id']; ?>">

        <div class="row">
            <div class="col-xl-9">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $lang->get('Name'); ?> <span class="text-danger">*</span></label>
                            <input type="text" name="advert_name" id="advert_name" value="<?php echo $advertRow['advert_name']; ?>" class="form-control">
                            <small class="form-text" id="msg_advert_name"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Destination URL'); ?> <span class="text-danger">*</span></label>
                            <input type="text" name="advert_url" id="advert_url" value="<?php echo $advertRow['advert_url']; ?>" class="form-control">
                            <small class="form-text" id="msg_advert_url"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Ad position'); ?> <span class="text-danger">*</span></label>
                            <select name="advert_posi_id" id="advert_posi_id" class="form-control">
                                <option value=""><?php echo $lang->get('Please select'); ?></option>
                                <?php foreach ($posiRows as $key=>$value) { ?>
                                    <option <?php if ($advertRow['advert_posi_id'] == $value['posi_id']) { ?>selected<?php } ?> value="<?php echo $value['posi_id']; ?>">
                                        <?php echo $value['posi_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <small class="form-text" id="msg_advert_posi_id"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Image'); ?></label>
                            <div class="input-group mb-3">
                                <input type="text" id="advert_attach_src" readonly value="<?php echo $attachRow['attach_url']; ?>" class="form-control">
                                <div class="input-group-append" id="button-addon4">
                                    <button type="button" class="btn btn-outline-secondary" data-target="#attach_modal" data-toggle="modal">
                                        <span class="fas fa-picture"></span>
                                        <?php echo $lang->get('Select'); ?>
                                    </button>
                                </div>
                            </div>

                            <div id="advert_attach_img">
                                <?php if (!empty($attachRow['attach_url'])) { ?>
                                    <img src="<?php echo $attachRow['attach_url']; ?>" class="img-fluid">
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Content'); ?></label>
                            <textarea name="advert_content" id="advert_content" class="form-control"><?php echo $advertRow['advert_content']; ?></textarea>
                            <small class="form-text" id="msg_advert_content"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Note'); ?></label>
                            <input type="text" name="advert_note" id="advert_note" value="<?php echo $advertRow['advert_note']; ?>" class="form-control">
                            <small class="form-text" id="msg_advert_note"></small>
                        </div>

                        <div class="bg-validate-box"></div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $lang->get('Save'); ?>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <?php if ($advertRow['advert_id'] > 0) { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('ID'); ?></label>
                                <input type="text" value="<?php echo $advertRow['advert_id']; ?>" class="form-control-plaintext" readonly>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
                            <?php foreach ($status as $key=>$value) { ?>
                                <div class="form-check">
                                    <input type="radio" name="advert_status" id="advert_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($advertRow['advert_status'] == $value) { ?>checked<?php } ?> class="form-check-input">
                                    <label for="advert_status_<?php echo $value; ?>" class="form-check-label">
                                        <?php echo $lang->get($value); ?>
                                    </label>
                                </div>
                            <?php } ?>
                            <small class="form-text" id="msg_advert_status"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Effective time'); ?> <span class="text-danger">*</span></label>
                            <input type="text" name="advert_begin_format" id="advert_begin_format" value="<?php echo $advertRow['advert_begin_format']['date_time']; ?>" class="form-control input_date">
                            <small class="form-text" id="msg_advert_begin"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Placement type'); ?> <span class="text-danger">*</span></label>
                            <select name="advert_type" id="advert_type" class="form-control">
                                <option value=""><?php echo $lang->get('Please select'); ?></option>
                                <?php foreach ($type as $key=>$value) { ?>
                                    <option <?php if ($advertRow['advert_type'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                                        <?php echo $lang->get($value); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <small class="form-text" id="msg_advert_type"></small>
                        </div>

                        <div class="form-group">
                            <div class="tab-content">
                                <div class="tab-pane <?php if ($advertRow['advert_type'] == 'date') { ?>active<?php } ?>" id="opts_date">
                                    <label><?php echo $lang->get('Invalid time'); ?> <span class="text-danger">*</span></label>
                                    <input type="text" name="advert_opt_time_format" id="advert_opt_time_format" value="<?php echo $advertRow['advert_opt_time_format']['date_time']; ?>" class="form-control input_date">
                                    <small class="form-text" id="msg_advert_opt_time_format"></small>
                                </div>
                                <div class="tab-pane <?php if ($advertRow['advert_type'] == 'show') { ?>active<?php } ?>" id="opts_show">
                                    <label><?php echo $lang->get('Display count'); ?> <span class="text-danger">*</span></label>
                                    <input type="text" name="advert_opt_show" id="advert_opt_show" value="<?php echo $advertRow['advert_opt']; ?>" class="form-control">
                                    <small class="form-text" id="msg_advert_opt_show"><?php echo $lang->get('Display count not exceed'); ?></small>
                                </div>
                                <div class="tab-pane <?php if ($advertRow['advert_type'] == 'hit') { ?>active<?php } ?>" id="opts_hit">
                                    <label><?php echo $lang->get('Click count'); ?> <span class="text-danger">*</span></label>
                                    <input type="text" name="advert_opt_hit" id="advert_opt_hit" value="<?php echo $advertRow['advert_opt']; ?>" class="form-control">
                                    <small class="form-text" id="msg_advert_opt_hit"><?php echo $lang->get('Click count not exceed'); ?></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Percentage'); ?></label>
                            <select name="advert_percent" id="advert_percent" class="form-control">
                                <option value=""><?php echo $lang->get('Please select'); ?></option>
                                <?php foreach ($percent as $key=>$value) { ?>
                                    <option <?php if ($advertRow['advert_percent'] == $key) { ?>selected<?php } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $lang->get('Save'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="attach_modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    var opts_validate_form = {
        rules: {
            advert_name: {
                length: '1,300'
            },
            advert_url: {
                length: '1,900'
            },
            advert_posi_id: {
                require: true
            },
            advert_note: {
                max: 300
            },
            advert_begin_format: {
                require: true,
                format: 'date_time'
            },
            advert_type: {
                require: true
            },
            advert_status: {
                require: true
            }
        },
        attr_names: {
            advert_name: '<?php echo $lang->get('Name'); ?>',
            advert_url: '<?php echo $lang->get('Destination URL'); ?>',
            advert_posi_id: '<?php echo $lang->get('Ad position'); ?>',
            advert_note: '<?php echo $lang->get('Note'); ?>',
            advert_begin_format: '<?php echo $lang->get('Effective time'); ?>',
            advert_type: '<?php echo $lang->get('Placement type'); ?>',
            advert_status: '<?php echo $lang->get('Status'); ?>'
        },
        selector_types: {
            advert_status: 'name'
        },
        type_msg: {
            require: '<?php echo $lang->get('{:attr} require'); ?>',
            max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>',
            length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>'
        },
        format_msg: {
            date_time: '<?php echo $lang->get('{:attr} not a valid datetime'); ?>'
        },
        msg: {
            loading: '<?php echo $lang->get('Loading'); ?>'
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

    function putType(_put_type) {
        switch (_put_type) {
            case 'show':
                $('#opts_date').hide();
                $('#opts_show').show();
                $('#opts_hit').hide();
            break;

            case 'hit':
                $('#opts_date').hide();
                $('#opts_show').hide();
                $('#opts_hit').show();
            break;

            case 'none':
            case 'backup':
                $('#opts_date').hide();
                $('#opts_show').hide();
                $('#opts_hit').hide();
            break;

            default:
                $('#opts_date').show();
                $('#opts_show').hide();
                $('#opts_hit').hide();
            break;
        }
    }


    function advertPosi(_posi_id) {
        var posiJson      = <?php echo $posiJson; ?>;
        var _this_posi    = posiJson[_posi_id];
        if (typeof _this_posi != 'undefined') {
            if (_this_posi.posi_is_percent == 'enable') {
                //alert(_this_posi.percent_sum);
                $('#advert_percent option:gt(' + (10 - _this_posi.percent_sum) + ')').attr('disabled', true);
            } else {
                $('#advert_percent').attr('disabled', true);
            }
        }
    }

    $(document).ready(function(){
        $('#attach_modal').on('shown.bs.modal', function() {
            $('#attach_modal .modal-content').load('<?php echo $route_console; ?>attach/choose/view/modal');
    	}).on('hidden.bs.modal', function(){
        	$('#attach_modal .modal-content').empty();
    	});

        var obj_validate_form   = $('#advert_form').baigoValidate(opts_validate_form);
        var obj_submit_form     = $('#advert_form').baigoSubmit(opts_submit_form);

        $('#advert_form').submit(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        $('#advert_type').change(function(){
            var _put_type = $(this).val();
            putType(_put_type);
        });
        $('#advert_posi_id').change(function(){
            var _posi_id = $(this).val();
            advertPosi(_posi_id);
        });
        $('.input_date').datetimepicker(opts_datetimepicker);
    });
    </script>
<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);