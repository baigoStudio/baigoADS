<?php $cfg = array(
    'title'             => $lang->get('Image', 'console.common') . ' &raquo; ' . $lang->get('Show'),
    'menu_active'       => 'attach',
    'sub_active'        => 'index',
    'baigoSubmit'       => 'true',
    'tooltip'           => 'true',
    'imageAsync'        => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>attach/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <div class="row">
        <div class="col-xl-9">
            <div class="card mb-3">
                <div class="card-body">
                    <?php include($cfg['pathInclude'] . 'attach_show' . GK_EXT_TPL); ?>
                </div>
                <div class="card-footer text-right">
                    <a href="<?php echo $route_console; ?>attach/form/id/<?php echo $attachRow['attach_id']; ?>/">
                        <span class="fas fa-edit"></span>
                        <?php echo $lang->get('Edit'); ?>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="form-group">
                        <label><?php echo $lang->get('ID'); ?></label>
                        <div class="form-text"><?php echo $attachRow['attach_id']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Original name'); ?></label>
                        <div class="form-text"><?php echo $attachRow['attach_name']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Extension'); ?></label>
                        <div class="form-text"><?php echo $attachRow['attach_ext']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('MIME'); ?></label>
                        <div class="form-text"><?php echo $attachRow['attach_mime']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Note'); ?></label>
                        <div class="form-text"><?php echo $attachRow['attach_note']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Status'); ?></label>
                        <div class="form-text">
                            <?php $str_status = $attachRow['attach_box'];
                            include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="<?php echo $route_console; ?>attach/form/id/<?php echo $attachRow['attach_id']; ?>/">
                        <span class="fas fa-edit"></span>
                        <?php echo $lang->get('Edit'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);
