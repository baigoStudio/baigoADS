<?php $cfg = array(
    'title'         => $lang->get('Installer'),
    'btn'           => $lang->get('Complete'),
    'sub_title'     => $lang->get('Complete installation'),
    'active'        => 'over',
    'pathInclude'   => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'index_head' . GK_EXT_TPL); ?>

    <form name="over_form" id="over_form" action="<?php echo $route_install; ?>index/over-submit/">
        <input type="hidden" name="__token__" value="<?php echo $token; ?>">

        <?php if (!empty($sso_installed)) { ?>
            <div class="alert alert-warning">
                <span class="fas fa-exclamation-triangle"></span>
                <?php echo $lang->get('You have chosen "Full installation", this is the installed information of baigo SSO, please confirm!'); ?>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2"><?php echo $lang->get('Database settings'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (isset($sso_installed['dbconfig'])) { ?>
                            <tr>
                                <td><?php echo $lang->get('Database host'); ?></td>
                                <td class="text-right">
                                    <?php if (isset($sso_installed['dbconfig']['host'])) {
                                        echo $sso_installed['dbconfig']['host'];
                                    } ?>
                                </td>
                            </td>

                            <tr>
                                <td><?php echo $lang->get('Host port'); ?></td>
                                <td class="text-right">
                                    <?php if (isset($sso_installed['dbconfig']['port'])) {
                                        echo $sso_installed['dbconfig']['port'];
                                    } ?>
                                </td>
                            </td>

                            <tr>
                                <td><?php echo $lang->get('Database'); ?></td>
                                <td class="text-right">
                                    <?php if (isset($sso_installed['dbconfig']['name'])) {
                                        echo $sso_installed['dbconfig']['name'];
                                    } ?>
                                </td>
                            </td>

                            <tr>
                                <td><?php echo $lang->get('Username'); ?></td>
                                <td class="text-right">
                                    <?php if (isset($sso_installed['dbconfig']['user'])) {
                                        echo $sso_installed['dbconfig']['user'];
                                    } ?>
                                </td>
                            </td>

                            <tr>
                                <td><?php echo $lang->get('Password'); ?></td>
                                <td class="text-right">
                                    <?php if (isset($sso_installed['dbconfig']['pass'])) {
                                        echo $sso_installed['dbconfig']['pass'];
                                    } ?>
                                </td>
                            </td>

                            <tr>
                                <td><?php echo $lang->get('Charset'); ?></td>
                                <td class="text-right">
                                    <?php if (isset($sso_installed['dbconfig']['charset'])) {
                                        echo $sso_installed['dbconfig']['charset'];
                                    } ?>
                                </td>
                            </td>

                            <tr>
                                <td><?php echo $lang->get('Prefix'); ?></td>
                                <td class="text-right">
                                    <?php if (isset($sso_installed['dbconfig']['prefix'])) {
                                        echo $sso_installed['dbconfig']['prefix'];
                                    } ?>
                                </td>
                            </td>
                        <?php } else { ?>
                            <tr>
                                <td colspan="2">
                                    <?php echo $lang->get('Database not set', 'install.common'); ?>
                                </td>
                            </td>
                        <?php } ?>
                    </tbody>
                </table>

                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2"><?php echo $lang->get('Created data'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($sso_installed['data'])) { ?>
                            <tr>
                                <td><?php echo $lang->get('Name'); ?></td>
                                <td class="text-right"><?php echo $lang->get('Status'); ?></td>
                            </tr>
                            <?php foreach ($sso_installed['data'] as $key=>$value) { ?>
                                <tr>
                                    <td colspan="2"><?php echo $key; ?></td>
                                </tr>
                                <?php foreach ($value as $key_type=>$value_type) {
                                    switch ($value_type['status']) {
                                        case 'y':
                                            $str_class  = 'text-success';
                                            $str_icon   = 'fas fa-check-circle';
                                        break;

                                        default:
                                            $str_class  = 'text-danger';
                                            $str_icon   = 'fas fa-times-circle';
                                        break;
                                    } ?>
                                    <tr>
                                        <td>
                                            <?php echo $key_type; ?>
                                        </td>
                                        <td class="text-right <?php echo $str_class; ?>">
                                            <span class="<?php echo $str_icon; ?>"></span>
                                            <small>
                                                <?php echo $value_type['msg']; ?>
                                            </small>
                                        </td>
                                    </tr>
                                <?php }
                            }
                        } else { ?>
                            <tr>
                                <td colspan="3">
                                    <?php echo $lang->get('No data created', 'install.common'); ?>
                                </td>
                            </td>
                        <?php } ?>
                    </tbody>
                </table>

                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2"><?php echo $lang->get('Administrator'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($sso_installed['admin'])) { ?>
                            <tr>
                                <td><?php echo $lang->get('ID'); ?></td>
                                <td class="text-right"><?php echo $lang->get('Username'); ?></td>
                            </tr>
                            <?php foreach ($sso_installed['admin'] as $key=>$value) { ?>
                                <tr>
                                    <td>
                                        <?php if (isset($value['admin_id'])) {
                                            echo $value['admin_id'];
                                        } ?>
                                    </td>
                                    <td class="text-right">
                                        <?php if (isset($value['admin_name'])) {
                                            echo $value['admin_name'];
                                        } ?>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="2">
                                    <?php echo $lang->get('No administrators created', 'install.common'); ?>
                                </td>
                            </td>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="alert alert-danger">
                <span class="fas fa-exclamation-triangle"></span>
                <?php echo $lang->get('Warning! This is the installed information of baigo SSO!'); ?>
            </div>
        <?php } ?>

        <div class="alert alert-success">
            <span class="fas fa-check-circle"></span>
            <?php echo $lang->get('Last step, complete the installation'); ?>
        </div>

        <?php include($cfg['pathInclude'] . 'install_btn' . GK_EXT_TPL) ?>
    </form>

<?php include($cfg['pathInclude'] . 'install_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    var opts_submit_form = {
        modal: {
            btn_text: {
                close: '<?php echo $lang->get('Close'); ?>',
                ok: '<?php echo $lang->get('OK'); ?>'
            }
        },
        msg_text: {
            submitting: '<?php echo $lang->get('Submitting'); ?>'
        },
        jump: {
            url: '<?php echo $route_console; ?>',
            text: '<?php echo $lang->get('Redirecting'); ?>'
        }
    };

    $(document).ready(function(){
        var obj_submit_form       = $('#over_form').baigoSubmit(opts_submit_form);
        $('#over_form').submit(function(){
            obj_submit_form.formSubmit();
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);