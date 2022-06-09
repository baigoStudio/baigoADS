<?php $cfg = array(
  'title'             => $lang->get('Image', 'console.common') . ' &raquo; ' . $lang->get('Show'),
  'menu_active'       => 'attach',
  'sub_active'        => 'index',
  'baigoSubmit'       => 'true',
  'tooltip'           => 'true',
  'imageAsync'        => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <nav class="nav mb-3">
    <a href="<?php echo $hrefRow['index']; ?>" class="nav-link">
      <span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('Back'); ?>
    </a>
  </nav>

  <div class="row">
    <div class="col-xl-9">
      <div class="card mb-3">
        <div class="card-body">
          <?php include($tpl_ctrl . 'head' . GK_EXT_TPL); ?>
        </div>
        <div class="card-footer text-right">
          <a href="<?php echo $hrefRow['edit'], $attachRow['attach_id']; ?>">
            <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Edit'); ?>
          </a>
        </div>
      </div>
    </div>

    <div class="col-xl-3">
      <div class="card bg-light">
        <div class="card-body">
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('ID'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $attachRow['attach_id']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Original name'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $attachRow['attach_name']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Extension'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $attachRow['attach_ext']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('MIME'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $attachRow['attach_mime']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Note'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $attachRow['attach_note']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Status'); ?></label>
            <div class="form-text font-weight-bolder">
              <?php $str_status = $attachRow['attach_box'];
              include($tpl_include . 'status_process' . GK_EXT_TPL); ?>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <a href="<?php echo $hrefRow['edit'], $attachRow['attach_id']; ?>">
            <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Edit'); ?>
          </a>
        </div>
      </div>
    </div>
  </div>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);
  include($tpl_ctrl . 'foot' . GK_EXT_TPL);
include($tpl_include . 'html_foot' . GK_EXT_TPL);
