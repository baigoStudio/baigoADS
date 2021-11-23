  <div class="alert alert-warning mb-3">
    <h5><?php echo $lang->get('Advertisement'); ?></h5>
    <div class="mb-2">
      <img src="<?php echo $attachRow['attach_url']; ?>" class="img-fluid">
      <?php echo $advertRow['advert_content']; ?>
    </div>

    <div class="form-group">
      <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapse_advert">
        <?php echo $lang->get('More'); ?>
        <span class="bg-icon"><?php include($cfg_global['pathIcon'] . 'chevron-down' . BG_EXT_SVG); ?></span>
      </a>
    </div>

    <div class="collapse" id="collapse_advert">
      <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('ID'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $advertRow['advert_id']; ?></div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Name'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $advertRow['advert_name']; ?></div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Destination URL'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $advertRow['advert_url']; ?></div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Effective time'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $advertRow['advert_begin_format']['date_time']; ?></div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Status'); ?></label>
            <div>
              <?php $str_status = $advertRow['advert_status'];
              include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="form-group">
            <?php switch ($advertRow['advert_type']) {
              case 'date': ?>
                <label class="text-muted font-weight-light"><?php echo $lang->get('Invalid time'); ?></label>
                <div class="form-text font-weight-bolder"><?php echo $advertRow['advert_opt_time_format']['date_time']; ?></div>
              <?php break;

              case 'show': ?>
                <label class="text-muted font-weight-light"><?php echo $lang->get('Display count not exceed'); ?></label>
                <div class="form-text font-weight-bolder"><?php echo $advertRow['advert_opt']; ?></div>
              <?php break;

              default: ?>
                <label class="text-muted font-weight-light"><?php echo $lang->get('Click count not exceed'); ?></label>
                <div class="form-text font-weight-bolder"><?php echo $advertRow['advert_opt']; ?></div>
              <?php break;
            } ?>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Percentage'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $advertRow['advert_percent'] * 10; ?>%</div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Note'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $advertRow['advert_note']; ?></div>
          </div>
        </div>
      </div>

      <hr>
      <h5 class="mb-3"><?php echo $lang->get('Ad position'); ?></h5>

      <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('ID'); ?></label>
            <div class="form-text font-weight-bolder">
              <?php echo $posiRow['posi_id']; ?>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Name'); ?></label>
            <div class="form-text font-weight-bolder">
              <?php echo $posiRow['posi_name']; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
