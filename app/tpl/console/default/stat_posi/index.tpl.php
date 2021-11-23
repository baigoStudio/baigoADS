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

    <div class="table-responsive">
      <table class="table table-striped table-borderless">
        <thead>
          <tr>
            <th><?php echo $lang->get('Year'); ?></th>
            <th><?php echo $lang->get('Display count'); ?></th>
            <th><?php echo $lang->get('Click count'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($yearRows as $key=>$value) { ?>
            <tr>
              <td>
                <?php echo $value['stat_year']; ?>
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
