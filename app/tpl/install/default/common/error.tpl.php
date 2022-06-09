<?php $cfg = array(
  'title'         => $lang->get('Installer', 'install.common'),
  'sub_title'     => $lang->get('Error', 'install.common'),
  'no_loading'    => 'true',
);

include($tpl_include . 'html_head' . GK_EXT_TPL); ?>

  <div class="container">
    <div class="bg-card-md my-lg-5 my-3">
      <div class="row mb-3">
        <div class="col-md-6">
          <img class="mb-3 bg-logo-sm" src="<?php echo $ui_ctrl['logo_install']; ?>">
        </div>
        <h4 class="col-md-6 text-md-right">
          <?php echo $lang->get('Installer', 'install.common'); ?>
        </h4>
      </div>

      <div class="card">
        <div class="card-body">
          <h3 class="text-danger">
            <span class="bg-icon"><?php include($tpl_icon . 'times-circle' . BG_EXT_SVG); ?></span>
            <?php if (isset($msg)) {
              echo $lang->get($msg, 'install.common');
            } ?>
          </h3>
          <div class="text-danger lead">
            <?php if (isset($rcode)) {
              echo $rcode;
            } ?>
          </div>
          <hr>
          <div>
            <?php $_arr_langReplace = array(
              'path_installed'    => $path_installed,
              'route_install'     => $route_install,
            );

            if (isset($rcode)) {
              echo $lang->get($rcode, 'install.common', $_arr_langReplace);
            } ?>
          </div>
        </div>
      </div>

      <?php if (!isset($ui_ctrl['copyright']) || $ui_ctrl['copyright'] === 'on') { ?>
        <div class="mt-3 text-right">
          <span class="d-none d-lg-inline-block">Powered by</span>
          <a href="<?php echo PRD_ADS_URL; ?>" target="_blank"><?php echo PRD_ADS_NAME; ?></a>
          <?php echo PRD_ADS_VER; ?>
        </div>
      <?php } ?>
    </div>
  </div>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
