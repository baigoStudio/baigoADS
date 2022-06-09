<?php $cfg = array(
  'title'             => $lang->get('Advertisement', 'console.common') . ' &raquo; ' . $lang->get('Show'),
  'menu_active'       => 'advert',
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
            <div class="form-text font-weight-bolder"><?php echo $advertRow['advert_name']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Destination URL'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $advertRow['advert_url']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Ad position'); ?></label>
            <div class="form-text font-weight-bolder">
              <a href="<?php echo $hrefRow['posi-show'], $posiRow['posi_id']; ?>">
                <?php echo $posiRow['posi_name']; ?>
              </a>
            </div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Image'); ?></label>
            <div class="form-text font-weight-bolder">
              <img src="<?php echo $attachRow['attach_url']; ?>" class="img-fluid">
            </div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Content'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $advertRow['advert_content']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Note'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $advertRow['advert_note']; ?></div>
          </div>
        </div>
        <div class="card-footer text-right">
          <a href="<?php echo $hrefRow['edit'], $advertRow['advert_id']; ?>">
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
            <div class="form-text font-weight-bolder"><?php echo $advertRow['advert_id']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Status'); ?></label>
            <div class="form-text font-weight-bolder">
              <?php $str_status = $advertRow['advert_status'];
              include($tpl_include . 'status_process' . GK_EXT_TPL); ?>
            </div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Effective time'); ?> <span class="text-danger">*</span></label>
            <div class="form-text font-weight-bolder">
              <?php echo $advertRow['advert_begin_format']['date_time']; ?>
            </div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Placement type'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $lang->get($advertRow['advert_type']); ?></div>
          </div>

          <?php switch ($advertRow['advert_type']) {
            case 'date': ?>
              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('Invalid time'); ?></label>
                <div class="form-text font-weight-bolder">
                  <?php echo $advertRow['advert_opt_time_format']['date_time']; ?>
                </div>
              </div>
            <?php break;

            case 'show': ?>
              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('Display count not exceed'); ?></label>
                <div class="form-text font-weight-bolder">
                  <?php echo $advertRow['advert_opt']; ?>
                </div>
              </div>
            <?php break;

            case 'hit': ?>
              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('Click count not exceed'); ?></label>
                <div class="form-text font-weight-bolder">
                  <?php echo $advertRow['advert_opt']; ?>
                </div>
              </div>
            <?php break;
          } ?>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Percentage'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $advertRow['advert_percent'] * 10; ?>%</div>
          </div>
        </div>
        <div class="card-footer text-right">
          <a href="<?php echo $hrefRow['edit'], $advertRow['advert_id']; ?>">
            <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Edit'); ?>
          </a>
        </div>
      </div>
    </div>
  </div>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);
include($tpl_include . 'html_foot' . GK_EXT_TPL);
