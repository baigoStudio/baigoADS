<?php $cfg = array(
  'title'             => $lang->get('Link', 'console.common') . ' &raquo; ' . $lang->get('Show'),
  'menu_active'       => 'link',
  'sub_active'        => 'index',
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
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Name'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $linkRow['link_name']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Link'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $linkRow['link_url']; ?></div>
          </div>

          <div class="form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" <?php if ($linkRow['link_blank'] > 0) { ?>checked<?php } ?> class="custom-control-input" disabled>
              <label for="link_blank" class="custom-control-label">
                <?php echo $lang->get('Open in blank window'); ?>
              </label>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <a href="<?php echo $hrefRow['edit'], $linkRow['link_id']; ?>">
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
            <div class="form-text font-weight-bolder"><?php echo $linkRow['link_id']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Status'); ?></label>
            <div class="form-text font-weight-bolder">
              <?php $str_status = $linkRow['link_status'];
              include($tpl_include . 'status_process' . GK_EXT_TPL); ?>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <a href="<?php echo $hrefRow['edit'], $linkRow['link_id']; ?>">
            <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Edit'); ?>
          </a>
        </div>
      </div>
    </div>
  </div>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);
include($tpl_include . 'html_foot' . GK_EXT_TPL);
