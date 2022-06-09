<?php $cfg = array(
  'title'         => $lang->get('Advertisement', 'console.common') . ' &raquo; ' . $lang->get('Statistics'),
  'menu_active'   => 'advert',
  'sub_active'    => 'index',
  'baigoQuery'    => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL);

  include($tpl_ctrl . 'show' . GK_EXT_TPL); ?>

  <div class="card">
    <?php include($tpl_ctrl . 'menu' . GK_EXT_TPL); ?>

    <div class="card-body">
      <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
          <?php echo $search['year']; ?>
        </button>
        <?php if (!empty($yearRows)) { ?>
          <div class="dropdown-menu">
            <?php foreach ($yearRows as $key=>$value) {

              $_arr_src = array('{:id}', '{:year}');
              $_arr_dst = array($advertRow['advert_id'], $value['stat_year']); ?>

              <a class="dropdown-item <?php if ($search['year'] == $value['stat_year']) { ?>active<?php } ?>" href="<?php echo str_replace($_arr_src, $_arr_dst, $hrefRow['month']); ?>">
                <?php echo $value['stat_year']; ?>
              </a>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-borderless">
        <thead>
          <tr>
            <th><?php echo $lang->get('Month'); ?></th>
            <th><?php echo $lang->get('Display count'); ?></th>
            <th><?php echo $lang->get('Click count'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($monthRows as $key=>$value) { ?>
            <tr>
              <td>
                <?php echo $value['stat_month']; ?>
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

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  $(document).ready(function(){
    var obj_query = $('#stat_search').baigoQuery();

    $('#stat_search').submit(function(){
      obj_query.formSubmit();
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
