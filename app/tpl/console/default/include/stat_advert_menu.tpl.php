  <div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
      <li class="nav-item">
        <a href="<?php echo $route_console; ?>stat_advert/index/id/<?php echo $advertRow['advert_id']; ?>" class="nav-link<?php if ($route['act'] == 'index') { ?> active<?php } ?>">
          <?php echo $lang->get('Years'); ?>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo $route_console; ?>stat_advert/month/id/<?php echo $advertRow['advert_id']; ?>" class="nav-link<?php if ($route['act'] == 'month') { ?> active<?php } ?>">
          <?php echo $lang->get('Months'); ?>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo $route_console; ?>stat_advert/day/id/<?php echo $advertRow['advert_id']; ?>" class="nav-link<?php if ($route['act'] == 'day') { ?> active<?php } ?>">
          <?php echo $lang->get('Days'); ?>
        </a>
      </li>
    </ul>
  </div>
