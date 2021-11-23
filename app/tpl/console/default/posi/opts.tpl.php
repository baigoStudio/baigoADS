<?php if ($posiRow['posi_id'] > 0) {
  $title_sub    = $lang->get('Edit');
  $str_sub      = 'index';
} else {
  $title_sub    = $lang->get('Add');
  $str_sub      = 'form';
}

$cfg = array(
  'title'             => $lang->get('Ad position', 'console.common') . ' &raquo; ' . $title_sub,
  'menu_active'       => 'posi',
  'sub_active'        => $str_sub,
  'baigoValidate'     => 'true',
  'baigoSubmit'       => 'true',
  'selectInput'       => 'true',
  'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

  <nav class="nav mb-3">
    <a href="<?php echo $route_console; ?>posi/" class="nav-link">
      <span class="bg-icon"><?php include($cfg_global['pathIcon'] . 'chevron-left' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('Back'); ?>
    </a>
  </nav>

  <form name="posi_form" id="posi_form" action="<?php echo $route_console; ?>posi/opts-submit/">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
    <input type="hidden" name="posi_id" id="posi_id" value="<?php echo $posiRow['posi_id']; ?>">

    <div class="row">
      <div class="col-xl-9">
        <div class="card mb-3">
          <?php include($cfg['pathInclude'] . 'posi_menu' . GK_EXT_TPL); ?>
          <div class="card-body">
            <div class="form-group">
              <label><?php echo $lang->get('Ad script'); ?></label>
              <input class="form-control" value="<?php echo $scriptConfig['script_url']; ?>" readonly>
            </div>

            <?php
            $_arr_rule      = array();
            $_arr_attr      = array();
            $_arr_selector  = array();

            foreach ($scriptOpts as $_key=>$_value) {
              if (isset($_value['require'])) {
                $_arr_rule[$_key]['require'] = $_value['require'];
              }

              if (isset($_value['format'])) {
                $_arr_rule[$_key]['format'] = $_value['format'];
              }

              $_arr_attr[$_key]  = $_value['title']; ?>
              <div class="form-group">
                  <?php if ($_value['type'] != 'switch') { ?>
                      <label>
                          <?php echo $_value['title'];

                          if (isset($_value['require']) && $_value['require'] > 0) { ?> <span class="text-danger">*</span><?php } ?>
                      </label>
                  <?php }

                  switch ($_value['type']) {
                    case 'select': ?>
                      <select name="posi_opts[<?php echo $_key; ?>]" id="posi_opts_<?php echo $_key; ?>"  class="form-control">
                        <?php foreach ($_value['option'] as $_key_opt=>$_value_opt) { ?>
                          <option<?php if ($posiRow['posi_opts'][$_key] == $_key_opt) { ?> selected<?php } ?> value="<?php echo $_key_opt; ?>">
                            <?php echo $_value_opt; ?>
                          </option>
                        <?php } ?>
                      </select>
                    <?php break;

                    case 'select_input': ?>
                      <div class="input-group">
                        <input type="text" value="<?php echo $posiRow['posi_opts'][$_key]; ?>" name="posi_opts[<?php echo $_key; ?>]" id="posi_opts_<?php echo $_key; ?>" class="form-control">
                        <span class="input-group-append">
                          <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                            <?php echo $lang->get('Please select'); ?>
                          </button>

                          <div class="dropdown-menu">
                            <?php foreach ($_value['option'] as $_key_opt=>$_value_opt) { ?>
                              <button class="dropdown-item bg-select-input" data-value="<?php echo $_key_opt; ?>" data-target="#posi_opts_<?php echo $_key; ?>" type="button">
                                <?php echo $_value_opt; ?>
                              </button>
                            <?php } ?>
                          </div>
                        </span>
                      </div>
                    <?php break;

                    case 'radio': ?>
                      <div>
                        <?php foreach ($_value['option'] as $_key_opt=>$_value_opt) { ?>
                          <div class="form-check <?php if (!isset($_value_opt['note'])) { ?>form-check-inline<?php } ?>">
                            <input type="radio"<?php if ($posiRow['posi_opts'][$_key] == $_key_opt) { ?> checked<?php } ?> value="<?php echo $_key_opt; ?>" name="posi_opts[<?php echo $_key; ?>]" id="posi_opts_<?php echo $_key; ?>_<?php echo $_key_opt; ?>" class="form-check-input">
                            <label for="posi_opts_<?php echo $_key; ?>_<?php echo $_key_opt; ?>" class="form-check-label">
                              <?php echo $_value_opt['value']; ?>
                            </label>

                            <?php if (isset($_value_opt['note'])) { ?>
                              <small class="form-text"><?php echo $_value_opt['note']; ?></small>
                            <?php } ?>
                          </div>
                        <?php } ?>
                      </div>
                      <?php $_arr_selector[$_key] = 'name';
                    break;

                    case 'switch': ?>
                      <div class="custom-control custom-switch">
                        <input type="checkbox" id="posi_opts_<?php echo $_key; ?>" name="posi_opts[<?php echo $_key; ?>]" <?php if ($posiRow['posi_opts'][$_key] === 'on') { ?>checked<?php } ?> value="on" class="custom-control-input">
                        <label for="posi_opts_<?php echo $_key; ?>" class="custom-control-label">
                          <?php echo $_value['title']; ?>
                        </label>
                      </div>
                    <?php break;

                    case 'textarea': ?>
                      <textarea name="posi_opts[<?php echo $_key; ?>]" id="posi_opts_<?php echo $_key; ?>" class="form-control bg-textarea-md"><?php echo $posiRow['posi_opts'][$_key]; ?></textarea>
                    <?php break;

                    default: ?>
                      <input type="text" value="<?php echo $posiRow['posi_opts'][$_key]; ?>" name="posi_opts[<?php echo $_key; ?>]" id="posi_opts_<?php echo $_key; ?>" class="form-control">
                    <?php break;
                } ?>

                <small class="form-text" id="msg_<?php echo $_key; ?>"></small>

                <?php if (isset($_value['note'])) { ?>
                  <small class="form-text"><?php echo $_value['note']; ?></small>
                <?php } ?>
              </div>
            <?php } ?>

            <div class="bg-validate-box"></div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">
              <?php echo $lang->get('Save'); ?>
            </button>
          </div>
        </div>
      </div>

      <?php include($cfg['pathInclude'] . 'posi_side' . GK_EXT_TPL); ?>
    </div>
  </form>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_form = {
    rules: <?php echo json_encode($_arr_rule); ?>,
    attr_names: <?php echo json_encode($_arr_attr); ?>,
    selector_types: <?php echo json_encode($_arr_selector); ?>,
    type_msg: {
      require: '<?php echo $lang->get('{:attr} require'); ?>'
    },
    format_msg: {
      'int': '<?php echo $lang->get('{:attr} must be integer'); ?>'
    },
    msg: {
      loading: '<?php echo $lang->get('Loading'); ?>'
    },
    box: {
      msg: '<?php echo $lang->get('Input error'); ?>'
    }
  };


  $(document).ready(function(){
    var obj_validate_form  = $('#posi_form').baigoValidate(opts_validate_form);
    var obj_submit_form    = $('#posi_form').baigoSubmit(opts_submit);

    $('#posi_form').submit(function(){
      if (obj_validate_form.verify()) {
        obj_submit_form.formSubmit();
      }
    });
  });
  </script>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);
