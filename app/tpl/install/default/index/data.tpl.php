<?php $cfg = array(
  'title'         => $lang->get('Installer'),
  'btn'           => $lang->get('Next'),
  'btn_link'      => true,
  'sub_title'     => $lang->get('Create data'),
  'active'        => 'data',
  'pathInclude'   => $path_tpl . 'include' . DS,
);

if (!empty($sso_data)) {
  switch ($sso_data['rstatus']) {
    case 'y':
      $str_color  = 'success';
      $str_icon   = 'check-circle';
    break;

    default:
      $str_color  = 'danger';
      $str_icon   = 'times-circle';
    break;
  }
}

include($cfg['pathInclude'] . 'index_head' . GK_EXT_TPL);

  include($cfg['pathInclude'] . 'data' . GK_EXT_TPL);

  if (!empty($sso_data)) { ?>
    <div class="alert alert-warning">
      <span class="bg-icon"><?php include($cfg_global['pathIcon'] . 'exclamation-triangle' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('You have chosen "Full installation", this is the result of the data created by baigo SSO, please confirm!'); ?>
    </div>

    <div class="alert alert-<?php echo $str_color; ?>">
      <span class="bg-icon"><?php include($cfg_global['pathIcon'] . $str_icon . BG_EXT_SVG); ?></span>
      <?php echo $lang->get($sso_data['msg']); ?>
    </div>
  <?php }

  include($cfg['pathInclude'] . 'install_btn' . GK_EXT_TPL);

include($cfg['pathInclude'] . 'install_foot' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);
