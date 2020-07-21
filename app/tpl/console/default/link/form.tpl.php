<?php if ($linkRow['link_id'] > 0) {
    $title_sub    = $lang->get('Edit');
    $str_sub      = 'index';
} else {
    $title_sub    = $lang->get('Add');
    $str_sub      = 'form';
}

$cfg = array(
    'title'             => $lang->get('Link', 'console.common') . ' &raquo; ' . $title_sub,
    'menu_active'       => 'link',
    'sub_active'        => $str_sub,
    'baigoValidate'     => 'true',
    'baigoSubmit'       => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>link/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <form name="link_form" id="link_form" action="<?php echo $route_console; ?>link/submit/">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
        <input type="hidden" name="link_id" id="link_id" value="<?php echo $linkRow['link_id']; ?>">

        <div class="row">
            <div class="col-xl-9">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $lang->get('Name'); ?> <span class="text-danger">*</span></label>
                            <input type="text" name="link_name" id="link_name" value="<?php echo $linkRow['link_name']; ?>" class="form-control">
                            <small class="form-text" id="msg_link_name"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Link'); ?> <span class="text-danger">*</span></label>
                            <input type="text" name="link_url" id="link_url" value="<?php echo $linkRow['link_url']; ?>" class="form-control">
                            <small class="form-text" id="msg_link_url"><?php echo $lang->get('Start with <code>http://</code> or <code>https://</code>'); ?></small>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" id="link_blank" name="link_blank" <?php if ($linkRow['link_blank'] > 0) { ?>checked<?php } ?> value="1" class="custom-control-input">
                                <label for="link_blank" class="custom-control-label">
                                    <?php echo $lang->get('Open in blank window'); ?>
                                </label>
                            </div>
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
                        <?php if ($linkRow['link_id'] > 0) { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('ID'); ?></label>
                                <input type="text" value="<?php echo $linkRow['link_id']; ?>" class="form-control-plaintext" readonly>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
                            <?php foreach ($status as $key=>$value) { ?>
                                <div class="form-check">
                                    <input type="radio" name="link_status" id="link_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($linkRow['link_status'] == $value) { ?>checked<?php } ?> class="form-check-input">
                                    <label for="link_status_<?php echo $value; ?>" class="form-check-label">
                                        <?php echo $lang->get($value); ?>
                                    </label>
                                </div>
                            <?php } ?>
                            <small class="form-text" id="msg_link_status"></small>
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

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    var opts_validate_form = {
        rules: {
            link_name: {
                length: '1,300'
            },
            link_url: {
                length: '1,900'
            },
            link_status: {
                require: true
            }
        },
        attr_names: {
            link_name: '<?php echo $lang->get('Name'); ?>',
            link_url: '<?php echo $lang->get('Link'); ?>',
            link_status: '<?php echo $lang->get('Status'); ?>'
        },
        selector_types: {
            link_status: 'name'
        },
        type_msg: {
            require: '<?php echo $lang->get('{:attr} require'); ?>',
            max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>',
            length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>'
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

    $(document).ready(function(){
        var obj_validate_form  = $('#link_form').baigoValidate(opts_validate_form);
        var obj_submit_form     = $('#link_form').baigoSubmit(opts_submit_form);

        $('#link_form').submit(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>
<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);