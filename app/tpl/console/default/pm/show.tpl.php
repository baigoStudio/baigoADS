    <div class="modal-header">
        <?php echo $lang->get('Private message', 'console.common'), ' &raquo; ', $lang->get('Show'); ?>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <ul class="list-inline">
            <li class="list-inline-item"><?php echo $lang->get('Sender'); ?>:</li>
            <li class="list-inline-item">
                <a href="<?php echo $route_console; ?>admin/show/id/<?php echo $pmRow['pm_from']; ?>/">
                    <?php if ($pmRow['pm_from'] == -1) {
                        echo $lang->get('System');
                    } else if (isset($pmRow['fromUser']['user_name'])) {
                        echo $pmRow['fromUser']['user_name'];
                    } else {
                        echo $lang->get('Unknown');
                    } ?>
                </a>
            </li>
            <li class="list-inline-item"><?php echo $lang->get('Recipient'); ?>:</li>
            <li class="list-inline-item">
                <a href="<?php echo $route_console; ?>admin/show/id/<?php echo $pmRow['pm_to']; ?>/">
                    <?php if (isset($pmRow['toUser']['user_name'])) {
                        echo $pmRow['toUser']['user_name'];
                    } else {
                        echo $lang->get('Unknown');
                    } ?>
                </a>
            </li>
            <li class="list-inline-item">
                <small><?php echo $pmRow['pm_time_format']['date_time']; ?></small>
            </li>
        </ul>


        <h5><?php echo $pmRow['pm_title']; ?></h5>

        <div class="text-wrap text-break"><?php echo $pmRow['pm_content']; ?></div>

        <ul class="list-inline">
            <li class="list-inline-item">
                <?php $str_status = $pmRow['pm_status'];
                include($path_tpl . 'include' . DS . 'status_process' . GK_EXT_TPL); ?>
            </li>
            <li class="list-inline-item">
                <small><?php echo $lang->get($pmRow['pm_type']); ?></small>
            </li>
        </div>

    </div>
    <div class="modal-footer">
        <?php if ($pmRow['pm_type'] == 'out') { ?>
            <form name="pm_form" id="pm_form" action="<?php echo $route_console; ?>pm/revoke/">
                <input type="hidden" name="act" id="act" value="revoke">
                <input type="hidden" name="pm_ids[]" id="pm_id_0" value="<?php echo $pmRow['pm_send_id']; ?>">
                <input type="hidden" name="__token__" value="<?php echo $token; ?>">
                <button type="submit" class="btn btn-info btn-sm"><?php echo $lang->get('Revoke'); ?></button>
            </form>
        <?php } ?>
        <a href="<?php echo $route_console; ?>pm/send/id/<?php echo $pmRow['pm_id']; ?>/" class="btn btn-primary btn-sm"><?php echo $lang->get('Reply'); ?></a>
        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
            <?php echo $lang->get('Close'); ?>
        </button>
    </div>

    <script type="text/javascript">
    var opts_dialog = {
        btn_text: {
            cancel: '<?php echo $lang->get('Cancel'); ?>',
            confirm: '<?php echo $lang->get('Confirm'); ?>'
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
            submitting: '<?php echo $lang->get('Revoking'); ?>'
        }
    };

    $(document).ready(function(){
        var obj_dialog      = $.baigoDialog(opts_dialog);
        var obj_submit_form = $('#pm_form').baigoSubmit(opts_submit_form);

        $('#pm_form').submit(function(){
            obj_dialog.confirm('<?php echo $lang->get('Are you sure to revoke?'); ?>', function(result){
                if (result) {
                    obj_submit_form.formSubmit();
                }
            });
        });
    });
    </script>