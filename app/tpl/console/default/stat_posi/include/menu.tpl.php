  <?php
  $_arr_src = array('{:id}', '{:year}', '{:month}');
  $_arr_dst = array($posiRow['posi_id'], 0, 0);
  ?>
  <div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
      <li class="nav-item">
        <a href="<?php echo str_replace($_arr_src, $_arr_dst, $hrefRow['index']); ?>" class="nav-link<?php if ($route['act'] == 'index') { ?> active<?php } ?>">
          <?php echo $lang->get('Years'); ?>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo str_replace($_arr_src, $_arr_dst, $hrefRow['month']); ?>" class="nav-link<?php if ($route['act'] == 'month') { ?> active<?php } ?>">
          <?php echo $lang->get('Months'); ?>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo str_replace($_arr_src, $_arr_dst, $hrefRow['day']); ?>" class="nav-link<?php if ($route['act'] == 'day') { ?> active<?php } ?>">
          <?php echo $lang->get('Days'); ?>
        </a>
      </li>
    </ul>
  </div>
