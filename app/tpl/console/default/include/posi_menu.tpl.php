  <?php if ($posiRow['posi_id'] > 0) { ?>
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
          <a href="<?php echo $route_console; ?>posi/show/id/<?php echo $posiRow['posi_id']; ?>/" class="nav-link<?php if ($route['act'] == 'show') { ?> active<?php } ?>">
            <span class="bg-icon"><?php include($cfg_global['pathIcon'] . 'eye' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Show'); ?>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $route_console; ?>posi/form/id/<?php echo $posiRow['posi_id']; ?>/" class="nav-link<?php if ($route['act'] == 'form') { ?> active<?php } ?>">
            <span class="bg-icon"><?php include($cfg_global['pathIcon'] . 'edit' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Edit'); ?>
          </a>
        </li>
        <?php if ($scriptOpts) { ?>
          <li class="nav-item">
            <a href="<?php echo $route_console; ?>posi/opts/id/<?php echo $posiRow['posi_id']; ?>/" class="nav-link<?php if ($route['act'] == 'opts') { ?> active<?php } ?>">
              <span class="bg-icon"><?php include($cfg_global['pathIcon'] . 'wrench' . BG_EXT_SVG); ?></span>
              <?php echo $lang->get('Option'); ?>
            </a>
          </li>
        <?php } ?>
      </ul>
    </div>
  <?php } ?>
