  <?php if ($posiRow['posi_id'] > 0) { ?>
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
          <a href="<?php echo $hrefRow['show'], $posiRow['posi_id']; ?>" class="nav-link<?php if ($route['act'] == 'show') { ?> active<?php } ?>">
            <span class="bg-icon"><?php include($tpl_icon . 'eye' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Show'); ?>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $hrefRow['edit'], $posiRow['posi_id']; ?>" class="nav-link<?php if ($route['act'] == 'form') { ?> active<?php } ?>">
            <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Edit'); ?>
          </a>
        </li>
        <?php if ($scriptOpts) { ?>
          <li class="nav-item">
            <a href="<?php echo $hrefRow['opts'], $posiRow['posi_id']; ?>" class="nav-link<?php if ($route['act'] == 'opts') { ?> active<?php } ?>">
              <span class="bg-icon"><?php include($tpl_icon . 'wrench' . BG_EXT_SVG); ?></span>
              <?php echo $lang->get('Option'); ?>
            </a>
          </li>
        <?php } ?>
      </ul>
    </div>
  <?php } ?>
