                        <div class="form-group">
                            <label><?php echo $lang->get('Path'); ?></label>
                            <div>
                                <img src="{:DIR_STATIC}image/loading.gif" data-src="<?php echo $attachRow['attach_url']; ?>" data-toggle="async" alt="<?php echo $value['attach_name']; ?>" class="img-fluid">
                            </div>

                            <div>
                                <a href="<?php echo $attachRow['attach_url']; ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" title="<?php echo $attachRow['attach_path']; ?>">
                                    <?php echo $attachRow['attach_url']; ?>
                                </a>
                                <?php $str_status = $attachRow['attach_exists'];
                                include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
                            </div>
                        </div>

                        <form name="attach_fix" id="attach_fix" action="<?php echo $route_console; ?>attach/fix/">
                            <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
                            <input type="hidden" name="attach_id" id="attach_id" value="<?php echo $attachRow['attach_id']; ?>">

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <span class="fas fa-redo-alt"></span>
                                    <?php echo $lang->get('Fix it'); ?>
                                </button>
                                <small class="form-text"><?php echo $lang->get('If the path or thumbnail is not found, you can try to fix it.'); ?></small>
                            </div>
                        </form>

                        <script type="text/javascript">
                        var opts_submit_fix = {
                            modal: {
                                btn_text: {
                                    close: '<?php echo $lang->get('Close'); ?>',
                                    ok: '<?php echo $lang->get('OK'); ?>'
                                }
                            },
                            msg_text: {
                                submitting: '<?php echo $lang->get('Submitting'); ?>'
                            }
                        };

                        $(document).ready(function(){
                            var obj_submit_fix = $('#attach_fix').baigoSubmit(opts_submit_fix);

                            $('#attach_fix').submit(function(){
                                obj_submit_fix.formSubmit();
                            });
                        });
                        </script>

                        <div class="form-group">
                            <label><?php echo $lang->get('Size'); ?></label>
                            <div class="form-text"><?php echo $attachRow['attach_size_format']; ?></div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Time'); ?></label>
                            <div class="form-text"><?php echo $attachRow['attach_time_format']['date_time']; ?></div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Administrator'); ?></label>
                            <div class="form-text">
                                <?php if (isset($adminRow['admin_name'])) { ?>
                                    <a href="<?php echo $route_console; ?>admin/show/id/<?php echo $attachRow['attach_admin_id']; ?>/" target="_blank"><?php echo $adminRow['admin_name']; ?></a>
                                <?php } else {
                                    echo $lang->get('Unknown');
                                } ?>
                            </div>
                        </div>