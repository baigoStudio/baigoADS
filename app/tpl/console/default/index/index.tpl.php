<?php
if (!function_exists('status_process')) {
  function status_process($str_status, $echo = '') {
    switch ($str_status) {
      case 'error':
        $_str_color = 'danger';
      break;

      case 'wait':
        $_str_color = 'warning';
      break;

      case 'exists':
      case 'normal':
      case 'enable':
      case 'read':
      case 'show':
      case 'pub':
        $_str_color = 'success';
      break;

      case 'store':
      case 'on':
        $_str_color = 'info';
      break;

      default:
        $_str_color = 'secondary';
      break;
    } ?>
    <span class="badge badge-pill badge-<?php echo $_str_color; ?>">
      <?php echo $echo; ?>
    </span>
  <?php }
}

$cfg = array(
  'title'             => $lang->get('Dashboard', 'console.common'),
  'menu_active'       => 'dashboard',
  'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

  <div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
      <span><?php echo $lang->get('Shortcut', 'console.common'); ?></span>
      <span>
        <a href="<?php echo $route_console; ?>index/setting/">
          <span class="bg-icon"><?php include($cfg_global['pathIcon'] . 'wrench' . BG_EXT_SVG); ?></span>
          <?php echo $lang->get('Setting'); ?>
        </a>
      </span>
    </div>
    <div class="card-body">
      <?php foreach ($adminLogged['admin_shortcut'] as $key_m=>$value_m) { ?>
        <a class="btn btn-primary m-2" href="<?php echo $route_console, $value_m['ctrl']; ?>/<?php echo $value_m['act']; ?>/">
          <?php echo $value_m['title']; ?>
        </a>
      <?php } ?>
    </div>
  </div>

  <div class="card-columns">
    <?php foreach ($countLists as $key=>$value) { ?>
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span><?php echo $lang->get($value['title']); ?></span>
          <span><?php echo $lang->get('Count'); ?></span>
        </div>
        <ul class="list-group list-group-flush">
          <?php foreach ($countRows[$key] as $key_sub=>$value_sub) {
            if ($key_sub == 'total') {
              $_str_title = 'Total';
            } else {
              $_str_title = $key_sub;
            } ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>
                  <?php echo $lang->get($_str_title); ?>
                </span>
                <?php status_process($key_sub, $value_sub); ?>
            </li>
          <?php } ?>
        </ul>
      </div>
    <?php } ?>
  </div>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);
