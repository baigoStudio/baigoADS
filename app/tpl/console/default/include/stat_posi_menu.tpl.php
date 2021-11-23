  <div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
      <li class="nav-item">
        <a href="<?php echo $route_console; ?>stat_posi/index/id/<?php echo $posiRow['posi_id']; ?>" class="nav-link<?php if ($route['act'] == 'index') { ?> active<?php } ?>">
          <?php echo $lang->get('Years'); ?>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo $route_console; ?>stat_posi/month/id/<?php echo $posiRow['posi_id']; ?>" class="nav-link<?php if ($route['act'] == 'month') { ?> active<?php } ?>">
          <?php echo $lang->get('Months'); ?>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo $route_console; ?>stat_posi/day/id/<?php echo $posiRow['posi_id']; ?>" class="nav-link<?php if ($route['act'] == 'day') { ?> active<?php } ?>">
          <?php echo $lang->get('Days'); ?>
        </a>
      </li>
    </ul>
  </div>
