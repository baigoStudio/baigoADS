<?php $cfg = array(
    'title'             => $lang->get('System settings', 'console.common') . ' &raquo; ' . $lang->get($config['console']['opt'][$route_orig['act']]['title'], 'console.common'),
    'menu_active'       => 'opt',
    'sub_active'        => $route_orig['act'],
    'baigoValidate'     => 'true',
    'baigoSubmit'       => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <form name="opt_form" id="opt_form" action="<?php echo $route_console; ?>opt/submit/">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
        <input type="hidden" name="act" value="<?php echo $route_orig['act']; ?>">

        <div class="card">
            <div class="card-body">
                <?php include($cfg['pathInclude'] . 'opt_form' . GK_EXT_TPL);

                if ($route_orig['act'] == 'base') { ?>
                    <div class="form-group">
                        <label><?php echo $lang->get('Template'); ?> <span class="text-danger">*</span></label>
                        <select name="site_tpl" id="site_tpl" class="form-control">
                            <?php foreach ($tplRows as $_key=>$_value) {
                                if ($_value['type'] == 'dir') { ?>
                                    <option<?php if ($config['var_extra']['base']['site_tpl'] == $_value['name']) { ?> selected<?php } ?> value="<?php echo $_value['name']; ?>"><?php echo $_value['name']; ?></option>
                                <?php }
                           } ?>
                        </select>
                        <small class="form-text" id="msg_site_tpl"></small>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Timezone'); ?> <span class="text-danger">*</span></label>
                        <div class="form-row">
                            <div class="col">
                                <select name="timezone_type" id="timezone_type" class="form-control">
                                    <?php foreach ($timezoneRows as $_key=>$_value) { ?>
                                        <option<?php if ($timezoneType == $_key) { ?> selected<?php } ?> value="<?php echo $_key; ?>">
                                            <?php echo $lang->get($_value['title'], 'console.timezone'); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col">
                                <select name="site_timezone" id="site_timezone" class="form-control">
                                    <?php foreach ($timezoneRows[$timezoneType]['lists'] as $_key=>$_value) { ?>
                                        <option<?php if ($config['var_extra']['base']['site_timezone'] == $_key) { ?> selected<?php } ?> value="<?php echo $_key; ?>">
                                            <?php echo $lang->get($_value, 'console.timezone'); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <small class="form-text" id="msg_site_timezone"></small>
                    </div>
                <?php } ?>

                <div class="bg-validate-box"></div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <?php echo $lang->get('Save'); ?>
                </button>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    var opts_validate_form = {
        rules: <?php echo json_encode($_arr_rule); ?>,
        attr_names: <?php echo json_encode($_arr_attr); ?>,
        selector_types: <?php echo json_encode($_arr_selector); ?>,
        type_msg: {
            require: '<?php echo $lang->get('{:attr} require'); ?>'
        },
        format_msg: {
            'int': '<?php echo $lang->get('{:attr} must be numeric'); ?>',
            url: '<?php echo $lang->get('{:attr} not a valid url'); ?>'
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
        var obj_validate_form  = $('#opt_form').baigoValidate(opts_validate_form);
        var obj_submit_form     = $('#opt_form').baigoSubmit(opts_submit_form);

        $('#opt_form').submit(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });

        <?php if ($route_orig['act'] == 'base') { ?>
            var _timezoneRowsJson = <?php echo $timezoneRowsJson; ?>;
            var _timezoneLangJson = <?php echo $timezoneLangJson; ?>;

            $('#timezone_type').change(function(){
                var _type = $(this).val();
                var _str_appent;
                $.each(_timezoneRowsJson[_type].lists, function(_key, _value){
                    _str_appent += '<option';
                    if (_key == '<?php echo $config['var_extra']['base']['site_timezone']; ?>') {
                        _str_appent += ' selected';
                    }
                    _str_appent += ' value="' + _key + '">';
                    if (typeof _timezoneLangJson[_value] != 'undefined') {
                        _str_appent += _timezoneLangJson[_value];
                    } else {
                        _str_appent += _value;
                    }
                    _str_appent += '</option>';
                });
                $('#site_timezone').html(_str_appent);
            });
        <?php } ?>
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);