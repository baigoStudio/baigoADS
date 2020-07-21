<?php if ($posiRow['posi_id'] > 0) {
    $title_sub    = $lang->get('Edit');
    $str_sub      = 'index';
} else {
    $title_sub    = $lang->get('Add');
    $str_sub      = 'form';
}

$cfg = array(
    'title'             => $lang->get('Ad position', 'console.common') . ' &raquo; ' . $title_sub,
    'menu_active'       => 'posi',
    'sub_active'        => $str_sub,
    'baigoValidate'     => 'true',
    'baigoSubmit'       => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>posi/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <form name="posi_form" id="posi_form" action="<?php echo $route_console; ?>posi/submit/">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
        <input type="hidden" name="posi_id" id="posi_id" value="<?php echo $posiRow['posi_id']; ?>">

        <div class="row">
            <div class="col-xl-9">
                <div class="card mb-3">
                    <?php include($cfg['pathInclude'] . 'posi_menu' . GK_EXT_TPL); ?>
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $lang->get('Ad script'); ?> <span class="text-danger">*</span></label>

                            <div class="input-group">
                                <input class="form-control" value="<?php echo $scriptConfig['script_url']; ?>" readonly>
                                <?php if ($posiRow['posi_id'] < 1) { ?>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                            <?php if (isset($scriptConfig['name'])) {
                                                echo $posiRow['posi_script'], ' [ ', $scriptConfig['name'], ' ]';
                                            } else {
                                                echo $lang->get('Please select');
                                            } ?>
                                        </button>
                                        <div class="dropdown-menu">
                                            <?php foreach ($scriptRows as $key=>$value) { ?>
                                                <a href="<?php echo $route_console; ?>posi/form/script/<?php echo $key; ?>" class="dropdown-item">
                                                    <?php echo $key, ' [ ', $value['name'], ' ]'; ?>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <input type="hidden" value="<?php echo $posiRow['posi_script']; ?>" name="posi_script" id="posi_script">

                            <small class="form-text" id="msg_posi_script"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Name'); ?> <span class="text-danger">*</span></label>
                            <input type="text" name="posi_name" id="posi_name" value="<?php echo $posiRow['posi_name']; ?>" class="form-control">
                            <small class="form-text" id="msg_posi_name"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
                            <div>
                                <?php foreach ($status as $key=>$value) { ?>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="posi_status" id="posi_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($posiRow['posi_status'] == $value) { ?>checked<?php } ?> class="form-check-input">
                                        <label for="posi_status_<?php echo $value; ?>" class="form-check-label">
                                            <?php echo $lang->get($value); ?>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                            <small class="form-text" id="msg_posi_status"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('By percentage'); ?> <span class="text-danger">*</span></label>
                            <div>
                                <?php foreach ($is_percent as $key=>$value) { ?>
                                    <div class="form-check form-check-inline">
                                        <label for="posi_is_percent_<?php echo $value; ?>" class="form-check-label">
                                            <input type="radio" name="posi_is_percent" id="posi_is_percent_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($posiRow['posi_is_percent'] == $value) { ?>checked<?php } ?> class="form-check-input">
                                            <?php echo $lang->get($value); ?>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                            <small class="form-text" id="msg_posi_is_percent"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Ad count'); ?> <span class="text-danger">*</span></label>
                            <input type="text" name="posi_count" id="posi_count" value="<?php echo $posiRow['posi_count']; ?>" class="form-control">
                            <small class="form-text" id="msg_posi_count"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Ad container perfix'); ?></label>
                            <input type="text" name="posi_box_perfix" id="posi_box_perfix" value="<?php echo $posiRow['posi_box_perfix']; ?>" class="form-control">
                            <small class="form-text" id="msg_posi_box_perfix"><?php echo $lang->get('Support ID or class selectors, if only characters are filled in, it will be converted to an ID selector.'); ?></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Text of loading'); ?></label>
                            <input type="text" name="posi_loading" id="posi_loading" value="<?php echo $posiRow['posi_loading']; ?>" class="form-control">
                            <small class="form-text" id="msg_posi_loading"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Text of close'); ?></label>
                            <input type="text" name="posi_close" id="posi_close" value="<?php echo $posiRow['posi_close']; ?>" class="form-control">
                            <small class="form-text" id="msg_posi_close"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Note'); ?></label>
                            <input type="text" name="posi_note" id="posi_note" value="<?php echo $posiRow['posi_note']; ?>" class="form-control">
                            <small class="form-text" id="msg_posi_note"></small>
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

            <?php include($cfg['pathInclude'] . 'posi_side' . GK_EXT_TPL); ?>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    var script_json = <?php echo $scriptJson; ?>

    var opts_validate_form = {
        rules: {
            posi_name: {
                length: '1,300'
            },
            posi_count: {
                require: true,
                format: 'int'
            },
            posi_note: {
                max: 300
            },
            posi_status: {
                require: true
            },
            posi_script: {
                require: true
            },
            posi_box_perfix: {
                length: '0,300'
            },
            posi_loading: {
                length: '0,300'
            },
            posi_close: {
                length: '0,300'
            },
            posi_is_percent: {
                require: true
            }
        },
        attr_names: {
            posi_name: '<?php echo $lang->get('Name'); ?>',
            posi_note: '<?php echo $lang->get('Note'); ?>',
            posi_status: '<?php echo $lang->get('Status'); ?>',
            posi_script: '<?php echo $lang->get('Ad script'); ?>',
            posi_box_perfix: '<?php echo $lang->get('Ad container perfix'); ?>',
            posi_loading: '<?php echo $lang->get('Text of loading'); ?>',
            posi_close: '<?php echo $lang->get('Text of close'); ?>',
            posi_is_percent: '<?php echo $lang->get('By percentage'); ?>'
        },
        selector_types: {
            posi_is_percent: 'name',
            posi_status: 'name'
        },
        type_msg: {
            require: '<?php echo $lang->get('{:attr} require'); ?>',
            max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>',
            length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>'
        },
        format_msg: {
            'int': '<?php echo $lang->get('{:attr} must be integer'); ?>'
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

    <?php if ($posiRow['posi_id'] < 1) { ?>
        function posiScript(_script_index) {
            var _result = script_json[_script_index];

            $('#posi_name').val(_result.name);
            $('#posi_box_perfix').val(_result.box_perfix);
            $('#posi_loading').val(_result.loading);
            $('#posi_close').val(_result.close);
            $('#posi_count').val(_result.count);
            $('#script_url').val(_result.script_url);
            $('#posi_is_percent_' + _result.is_percent).prop('checked', 'checked');
            $('#posi_note').val(_result.note);
        }
    <?php } ?>

    $(document).ready(function(){
        var obj_validate_form  = $('#posi_form').baigoValidate(opts_validate_form);
        var obj_submit_form    = $('#posi_form').baigoSubmit(opts_submit_form);

        $('#posi_form').submit(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });

        <?php if ($posiRow['posi_id'] < 1) { ?>
            $('#posi_script').change(function(){
                var _script_index = $('#posi_script option:selected').data('index');
                if (_script_index) {
                    posiScript(_script_index);
                }
            });
        <?php } ?>
    });
    </script>
<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);