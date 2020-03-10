                <?php
                $_arr_rule      = array();
                $_arr_attr      = array();
                $_arr_selector  = array();

                foreach ($consoleOpt as $_key=>$_value) {
                    if (isset($_value['require'])) {
                        $_arr_rule[$_key]['require'] = $_value['require'];
                    }

                    if (isset($_value['format'])) {
                        $_arr_rule[$_key]['format'] = $_value['format'];
                    }

                    $_arr_attr[$_key]  = $lang->get($_value['title']);
                    ?>
                    <div class="form-group">
                        <?php if ($_value['type'] != 'switch') { ?>
                            <label>
                                <?php echo $lang->get($_value['title']);

                                if (isset($_value['require']) && $_value['require'] > 0) { ?> <span class="text-danger">*</span><?php } ?>
                            </label>
                        <?php }

                        switch ($_value['type']) {
                            case 'select': ?>
                                <select name="<?php echo $_key; ?>" id="<?php echo $_key; ?>"  class="form-control">
                                    <?php foreach ($_value['option'] as $_key_opt=>$_value_opt) { ?>
                                        <option<?php if ($_value['this'] == $_key_opt) { ?> selected<?php } ?> value="<?php echo $_key_opt; ?>">
                                            <?php $_arr_langReplace = array(
                                                'option' => $_key_opt,
                                            );
                                            echo $lang->get($_value_opt, '', $_arr_langReplace); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            <?php break;

                            case 'select_input': ?>
                                <div class="input-group">
                                    <input type="text" value="<?php echo $_value['this']; ?>" name="<?php echo $_key; ?>" id="<?php echo $_key; ?>" class="form-control">
                                    <span class="input-group-append">
                                        <select id="select_<?php echo $_key; ?>" class="custom-select bg-custom-select">
                                            <?php foreach ($_value['option'] as $_key_opt=>$_value_opt) { ?>
                                                <option<?php if ($_value['this'] == $_key_opt) { ?> selected<?php } ?> value="<?php echo $_key_opt; ?>">
                                                    <?php $_arr_langReplace = array(
                                                        'option' => $_key_opt,
                                                    );
                                                    echo $lang->get($_value_opt, '', $_arr_langReplace); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </span>
                                </div>
                            <?php break;

                            case 'radio': ?>
                                <div>
                                    <?php foreach ($_value['option'] as $_key_opt=>$_value_opt) { ?>
                                        <div class="form-check <?php if (!isset($_value_opt['note'])) { ?>form-check-inline<?php } ?>">
                                            <input type="radio"<?php if ($_value['this'] == $_key_opt) { ?> checked<?php } ?> value="<?php echo $_key_opt; ?>" name="<?php echo $_key; ?>" id="<?php echo $_key; ?>_<?php echo $_key_opt; ?>" class="form-check-input">
                                            <label for="<?php echo $_key; ?>_<?php echo $_key_opt; ?>" class="form-check-label">
                                                <?php echo $lang->get($_value_opt['value']); ?>
                                            </label>

                                            <?php if (isset($_value_opt['note'])) {
                                                $_arr_langReplace = array(
                                                    'visit_default' => 'http://baigo.net/index.php/aritcle/' . date('Y') . '/' . date('m') . '/123/',
                                                    'visit_pstatic' => 'http://baigo.net/aritcle/' . date('Y') . '/' . date('m') . '/123/',
                                                    'visit_static'  => 'http://baigo.net/aritcle/' . date('Y') . '/' . date('m') . '/123.html',
                                                ); ?>
                                                <small class="form-text"><?php echo $lang->get($_value_opt['note'], '', $_arr_langReplace); ?></small>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php $_arr_selector[$_key] = 'name';
                            break;

                            case 'switch': ?>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" id="<?php echo $_key; ?>" name="<?php echo $_key; ?>" <?php if ($_value['this'] == 'on') { ?>checked<?php } ?> value="on" class="custom-control-input">
                                    <label for="<?php echo $_key; ?>" class="custom-control-label">
                                        <?php echo $lang->get($_value['title']); ?>
                                    </label>
                                </div>
                            <?php break;

                            case 'textarea': ?>
                                <textarea name="<?php echo $_key; ?>" id="<?php echo $_key; ?>" class="form-control bg-textarea-md"><?php echo $_value['this']; ?></textarea>
                            <?php break;

                            default: ?>
                                <input type="text" value="<?php echo $_value['this']; ?>" name="<?php echo $_key; ?>" id="<?php echo $_key; ?>" class="form-control">
                            <?php break;
                        } ?>

                        <small class="form-text" id="msg_<?php echo $_key; ?>"></small>

                        <?php if (isset($_value['note'])) {
                            $_arr_langReplace = array(
                                'site_url'   => 'http://' . $_SERVER['SERVER_NAME'],
                            ); ?>
                            <small class="form-text"><?php echo $lang->get($_value['note'], '', $_arr_langReplace); ?></small>
                        <?php } ?>
                    </div>
                <?php } ?>

                <script type="text/javascript">
                $(document).ready(function(){
                    <?php foreach ($consoleOpt as $_key=>$_value) {
                        switch ($_value['type']) {
                            case 'select_input': ?>
                                $('#select_<?php echo $_key; ?>').change(function(){
                                    var _val_<?php echo $_key; ?> = $(this).val();
                                    $('#<?php echo $_key; ?>').val(_val_<?php echo $_key; ?>);
                                });
                            <?php break;
                        }
                    } ?>
                });
                </script>