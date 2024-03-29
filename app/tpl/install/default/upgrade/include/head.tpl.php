<?php include($tpl_include . 'html_head' . GK_EXT_TPL); ?>

  <div class="container">
    <div class="bg-card-md my-lg-5 my-3">
      <div class="row mb-3">
        <div class="col-md-6">
          <img class="mb-3 bg-logo-sm" src="<?php echo $ui_ctrl['logo_install']; ?>">
        </div>
        <h4 class="col-md-6 text-md-right">
          <?php echo $lang->get('Upgrader'); ?>
        </h4>
      </div>

      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-4">
              <ul class="nav flex-column">
                <?php foreach ($config['install']['upgrade'] as $key_opt=>$value_opt) { ?>
                  <li class="nav-item">
                    <a class="nav-link<?php if ($cfg['active'] == $key_opt) { ?> disabled<?php } ?>" href="<?php echo $value_opt['href']; ?>">
                      <?php echo $lang->get($value_opt['title']); ?>
                    </a>
                  </li>
                <?php } ?>
              </ul>
            </div>
            <div class="col-lg-8">
              <h4><?php echo $cfg['sub_title']; ?></h4>
              <hr>

              <div class="alert alert-warning">
                <h5>
                  <?php echo $lang->get('Upgrading'); ?>
                  <span class="badge badge-warning"><?php echo $installed['prd_installed_ver']; ?></span>
                  <?php echo $lang->get('To'); ?>
                  <span class="badge badge-warning"><?php echo PRD_ADS_VER; ?></span>
                </h5>
                <div>
                  <span class="bg-icon"><?php include($tpl_icon . 'exclamation-triangle' . BG_EXT_SVG); ?></span>
                  <?php echo $lang->get('Warning! Please backup the data before upgrading.'); ?>
                </div>
              </div>
