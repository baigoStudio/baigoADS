<?php $cfg = array(
  'title'         => $lang->get('Ad position', 'console.common') . ' &raquo; ' . $lang->get('Statistics'),
  'menu_active'   => 'posi',
  'sub_active'    => 'index',
  'baigoQuery'    => 'true',
  'pathInclude'   => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL);

  include($cfg['pathInclude'] . 'stat_posi_show' . GK_EXT_TPL); ?>

  <div class="card">
    <?php include($cfg['pathInclude'] . 'stat_posi_menu' . GK_EXT_TPL); ?>

    <div class="card-body">
      <div class="btn-group">
        <div class="btn-group">
          <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
            <?php echo $search['year']; ?>
          </button>
          <?php if (!empty($yearRows)) { ?>
            <div class="dropdown-menu">
              <?php foreach ($yearRows as $key=>$value) { ?>
                <a class="dropdown-item <?php if ($search['year'] == $value['stat_year']) { ?>active<?php } ?>" href="<?php echo $route_console; ?>stat_posi/day/id/<?php echo $posiRow['posi_id']; ?>/year/<?php echo $value['stat_year']; ?>/">
                  <?php echo $value['stat_year']; ?>
                </a>
              <?php } ?>
            </div>
          <?php } ?>
        </div>
        <div class="btn-group">
          <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
            <?php echo $search['month']; ?>
          </button>
          <?php if (!empty($monthRows)) { ?>
            <div class="dropdown-menu">
              <?php foreach ($monthRows as $key=>$value) { ?>
                <a class="dropdown-item <?php if ($search['month'] == $value['stat_month']) { ?>active<?php } ?>" href="<?php echo $route_console; ?>stat_posi/day/id/<?php echo $posiRow['posi_id']; ?>/year/<?php echo $search['year']; ?>/month/<?php echo $value['stat_month']; ?>/">
                  <?php echo $value['stat_month']; ?>
                </a>
              <?php } ?>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-borderless">
        <thead>
          <tr>
            <th><?php echo $lang->get('Day'); ?></th>
            <th><?php echo $lang->get('Display count'); ?></th>
            <th><?php echo $lang->get('Click count'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($dayRows as $key=>$value) { ?>
            <tr>
              <td>
                <?php echo $value['stat_day']; ?>
              </td>
              <td>
                <?php echo $value['stat_count_show']; ?>
              </td>
              <td>
                <?php echo $value['stat_count_hit']; ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  $(document).ready(function(){
    var obj_query = $('#stat_search').baigoQuery();

    $('#stat_search').submit(function(){
      obj_query.formSubmit();
    });
  });
  </script>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);
