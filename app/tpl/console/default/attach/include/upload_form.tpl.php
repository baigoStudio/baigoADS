  <?php $_arr_langReplace = array(
    'size'  => $config['var_extra']['upload']['limit_size'] . ' ' . $config['var_extra']['upload']['limit_unit'],
    'count' => $config['var_extra']['upload']['limit_count'],
  ); ?>
  <div class="mb-3">
    <button type="button" class="btn btn-outline-secondary fileinput-button" id="upload_select">
      <?php echo $lang->get('Browse'); ?>...
    </button>

    <button id="upload_begin" class="btn btn-primary">
      <span class="bg-icon"><?php include($tpl_icon . 'cloud-upload-alt' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('Upload'); ?>
    </button>
  </div>

  <!--用来存放文件信息-->
  <div id="upload_list"></div>
