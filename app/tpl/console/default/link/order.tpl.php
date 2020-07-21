<?php $cfg = array(
    'title'         => $lang->get('Link', 'console.common') . ' &raquo; ' . $lang->get('Sort'),
    'menu_active'   => 'link',
    'sub_active'    => 'index',
    'baigoSubmit'   => 'true',
    'dad'           => 'true',
    'pathInclude'   => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>link/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <form name="link_order" id="link_order" action="<?php echo $route_console; ?>link/order-submit/">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">

        <div class="card">
            <div class="card-body">
                <div class="bg-drag">
                    <?php foreach ($linkRows as $key=>$value) { ?>
                        <div class="drag drag-box alert alert-secondary" data-id="<?php echo $value['link_id']; ?>">
                             <input type="hidden" name="link_order[<?php echo $value['link_id']; ?>]" id="link_order_<?php echo $value['link_id']; ?>" value="<?php echo $value['link_order']; ?>">

                             <div class="d-flex justify-content-between">
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item">
                                        <?php echo $lang->get('ID'), ': ', $value['link_id']; ?>
                                    </li>
                                    <li class="list-inline-item">
                                        <?php echo $lang->get('Name'), ': ';

                                        if (empty($value['link_name'])) {
                                            echo $lang->get('Unnamed');
                                        } else {
                                            echo $value['link_name'];
                                        } ?>
                                    </li>
                                </ul>
                                <span>
                                    <?php $str_status = $value['link_status'];
                                    include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
                                </span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <?php echo $lang->get('Apply'); ?>
                </button>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    var opts_submit_list = {
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

    function sortProcess() {
        $('.bg-drag > .dads-children').each(function(_key, _value){
            var _id  = $(this).data('id');
            $('#link_order_' + _id).val(_key);
        });
    }

    $(document).ready(function(){
        $('.bg-drag').dad({
            target: '.drag-box',
            callback: function(ele) {
                sortProcess();
            }
        });

        var obj_submit_list = $('#link_order').baigoSubmit(opts_submit_list);

        $('#link_order').submit(function(){
            obj_submit_list.formSubmit();
        });
    });
    </script>
<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);