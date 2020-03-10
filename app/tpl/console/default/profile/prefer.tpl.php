<?php $cfg = array(
    'title'             => $lang->get('Profile', 'console.common') . ' &raquo; ' . $lang->get('Preferences', 'console.common'),
    'menu_active'       => 'profile',
    'sub_active'        => 'prefer',
    'baigoValidate'    => 'true',
    'baigoSubmit'       => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <form name="profile_form" id="profile_form" action="<?php echo $route_console; ?>profile/prefer-submit/">
        <input type="hidden" name="__token__" value="<?php echo $token; ?>">

        <div class="row">
            <div class="col-xl-9">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $lang->get('Username'); ?></label>
                            <input type="text" value="<?php echo $adminLogged['admin_name']; ?>" readonly class="form-control">
                        </div>
                    </div>

                    <ul class="list-group list-group-flush bg-list-group mb-3">
                        <?php
                        $_arr_rule      = array();
                        $_arr_attr      = array();
                        $_arr_selector  = array();

                        foreach ($preferRows as $key=>$value) { ?>
                            <li class="list-group-item">
                                <h5>
                                    <?php echo $lang->get($value['title']); ?>
                                </h5>
                                <?php foreach ($value['lists'] as $key_s=>$value_s) {
                                    if (isset($value_s['require'])) {
                                        $_arr_rule['admin_prefer_' . $key . '_' . $key_s]['require'] = $value_s['require'];
                                    }

                                    if (isset($value_s['format'])) {
                                        $_arr_rule['admin_prefer_' . $key . '_' . $key_s]['format'] = $value_s['format'];
                                    }

                                    $_arr_attr['admin_prefer_' . $key . '_' . $key_s]  = $lang->get($value_s['title']);
                                    ?>
                                    <div class="form-group">
                                        <?php if ($value_s['type'] != 'switch') { ?>
                                            <label>
                                                <?php echo $lang->get($value_s['title']); ?>
                                            </label>
                                        <?php }

                                        switch($value_s['type']) {
                                            case 'select': ?>
                                                <select name="admin_prefer[<?php echo $key; ?>][<?php echo $key_s; ?>]" id="admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" class="form-control">
                                                    <?php foreach ($value_s['option'] as $key_opt=>$value_opt) { ?>
                                                        <option <?php if ($value_s['this'] == $key_opt) { ?>selected<?php } ?> value="<?php echo $key_opt; ?>">
                                                            <?php echo $lang->get($value_opt); ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            <?php break;

                                            case 'radio': ?>
                                                <div>
                                                    <?php foreach ($value_s['option'] as $key_opt=>$value_opt) { ?>
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" <?php if ($value_s['this'] == $key_opt) { ?>checked<?php } ?> value="<?php echo $key_opt; ?>" data-validate="admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" name="admin_prefer[<?php echo $key; ?>][<?php echo $key_s; ?>]" id="admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>_<?php echo $key_opt; ?>" class="form-check-input">
                                                            <label for="admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>_<?php echo $key_opt; ?>" class="form-check-label">
                                                                <?php echo $lang->get($value_opt['value']);

                                                                if (isset($value_opt['note'])) { ?>
                                                                    <span class="text-muted">(<?php echo $value_opt['note']; ?>)</span>
                                                                <?php } ?>
                                                            </label>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <?php $_arr_selector['admin_prefer_' . $key . '_' . $key_s]   = 'validate';
                                            break;

                                            case 'switch': ?>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="admin_prefer[<?php echo $key; ?>][<?php echo $key_s; ?>]" id="admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" <?php if ($value_s['this'] == 'on') { ?>checked<?php } ?> value="on" class="custom-control-input">
                                                    <label for="admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" class="custom-control-label">
                                                        <?php echo $lang->get($value_s['title']); ?>
                                                    </label>
                                                </div>
                                            <?php break;

                                            case 'textarea': ?>
                                                <textarea name="admin_prefer[<?php echo $key; ?>][<?php echo $key_s; ?>]" id="admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" class="form-control bg-textarea-md">
                                                    <?php echo $value_s['this']; ?>
                                                </textarea>
                                            <?php break;

                                            default: ?>
                                                <input type="text" value="<?php echo $value_s['this']; ?>" name="admin_prefer[<?php echo $key; ?>][<?php echo $key_s; ?>]" id="admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" class="form-control">
                                            <?php break;
                                        }

                                        if (isset($value_s['note'])) { ?><small class="form-text"><?php echo $value_s['note']; ?></small><?php } ?>

                                        <small class="form-text" id="msg_admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>"></small>
                                    </div>
                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>

                    <div class="card-body">
                        <div class="bg-validate-box"></div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $lang->get('Save'); ?>
                        </button>
                    </div>
                </div>
            </div>

            <?php include($cfg['pathInclude'] . 'profile_side' . GK_EXT_TPL); ?>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    var opts_validate_form = {
        rules: <?php echo json_encode($_arr_rule); ?>,
        attr_names: <?php echo json_encode($_arr_attr); ?>,
        selector_types: <?php echo json_encode($_arr_selector); ?>,
        type_msg: {
            require: '<?php echo $lang->get('{:attr} require'); ?>',
            max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>'
        },
        format_msg: {
            'int': '<?php echo $lang->get('{:attr} must be integer'); ?>'
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
        var obj_validate_form  = $('#profile_form').baigoValidate(opts_validate_form);
        var obj_submit_form     = $('#profile_form').baigoSubmit(opts_submit_form);

        $('#profile_form').submit(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);