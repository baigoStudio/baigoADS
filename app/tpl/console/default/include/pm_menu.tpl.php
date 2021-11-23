  <nav class="nav mb-3">
    <a href="<?php echo $route_console; ?>pm/send/" class="nav-link">
      <span class="bg-icon"><?php include($cfg_global['pathIcon'] . 'paper-plane' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('Send'); ?>
    </a>
    <?php foreach ($pm_type['type'] as $key=>$value) {
      if ($key == 'in') {
        $icon_type = 'inbox';
      } else {
        $icon_type = 'cloud-upload-alt';
      } ?>
      <a href="<?php echo $route_console; ?>pm/index/type/<?php echo $key; ?>/" class="nav-link<?php if (isset($search['type']) && $search['type'] == $key) { ?> disabled<?php } ?>">
        <span class="bg-icon"><?php include($cfg_global['pathIcon'] . $icon_type . BG_EXT_SVG); ?></span>
        <?php echo $value; ?>
      </a>
    <?php } ?>
  </nav>
