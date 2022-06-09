<?php $cfg = array(
  'title'             => $lang->get('System settings', 'console.common') . ' &raquo; ' . $lang->get('Upload settings', 'console.common'),
  'menu_active'       => 'opt',
  'sub_active'        => 'upload',
  'baigoValidate'     => 'true',
  'baigoSubmit'       => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <form name="opt_form" id="opt_form" action="<?php echo $hrefRow['upload-submit']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">

    <div class="card">
      <div class="card-body">
        <div class="form-group">
          <label>
            <?php echo $lang->get('Upload size limit'); ?> <span class="text-danger">*</span>
          </label>
          <div class="form-row">
            <div class="col-xl-11 col-8">
                <input type="text" value="<?php echo $config['var_extra']['upload']['limit_size']; ?>" name="limit_size" id="limit_size" class="form-control">
            </div>
            <div class="col-xl-1 col-4">
              <select name="limit_unit" id="limit_unit"  class="form-control">
                <option<?php if ($config['var_extra']['upload']['limit_unit'] == 'kb') { ?> selected<?php } ?> value="kb">
                  <?php echo $lang->get('KB'); ?>
                </option>
                <option<?php if ($config['var_extra']['upload']['limit_unit'] == 'mb') { ?> selected<?php } ?> value="mb">
                  <?php echo $lang->get('MB'); ?>
                </option>
              </select>
            </div>
          </div>
          <small class="form-text" id="msg_limit_size"></small>
          <small class="form-text" id="msg_limit_count"></small>
        </div>

        <div class="form-group">
          <label>
            <?php echo $lang->get('Count per upload'); ?> <span class="text-danger">*</span>
          </label>
          <input type="text" value="<?php echo $config['var_extra']['upload']['limit_count']; ?>" name="limit_count" id="limit_count" class="form-control">
          <small class="form-text" id="msg_limit_count"></small>
        </div>

        <?php if (isset($ftp_open)) { ?>
          <div class="form-group">
            <label>
              <?php echo $lang->get('URL Prefix'); ?>
            </label>
            <input type="text" value="<?php echo $config['var_extra']['upload']['url_prefix']; ?>" name="url_prefix" id="url_prefix" class="form-control">
            <small class="form-text" id="msg_url_prefix"><?php echo $lang->get('Do not add a slash <kbd>/</kbd> at the end'); ?></small>
          </div>

          <div class="form-group">
            <label>
              <?php echo $lang->get('FTP Host'); ?>
            </label>
            <input type="text" value="<?php echo $config['var_extra']['upload']['ftp_host']; ?>" name="ftp_host" id="ftp_host" class="form-control">
            <small class="form-text" id="msg_ftp_host"></small>
          </div>

          <div class="form-group">
            <label>
              <?php echo $lang->get('Host port'); ?>
            </label>
            <input type="text" value="<?php echo $config['var_extra']['upload']['ftp_port']; ?>" name="ftp_port" id="ftp_port" class="form-control">
            <small class="form-text" id="msg_ftp_port"></small>
          </div>

          <div class="form-group">
            <label>
              <?php echo $lang->get('Username'); ?>
            </label>
            <input type="text" value="<?php echo $config['var_extra']['upload']['ftp_user']; ?>" name="ftp_user" id="ftp_user" class="form-control">
            <small class="form-text" id="msg_ftp_user"></small>
          </div>

          <div class="form-group">
            <label>
              <?php echo $lang->get('Password'); ?>
            </label>
            <input type="text" value="<?php echo $config['var_extra']['upload']['ftp_pass']; ?>" name="ftp_pass" id="ftp_pass" class="form-control">
            <small class="form-text" id="msg_ftp_pass"></small>
          </div>

          <div class="form-group">
            <label>
              <?php echo $lang->get('Remote path'); ?>
            </label>
            <input type="text" value="<?php echo $config['var_extra']['upload']['ftp_path']; ?>" name="ftp_path" id="ftp_path" class="form-control">
            <small class="form-text" id="msg_ftp_path"><?php echo $lang->get('Do not add a slash <kbd>/</kbd> at the end'); ?></small>
          </div>

          <div class="form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" id="ftp_pasv" name="ftp_pasv" <?php if ($config['var_extra']['upload']['ftp_pasv'] === 'on') { ?>checked<?php } ?> value="on" class="custom-control-input">
              <label for="ftp_pasv" class="custom-control-label">
                <?php echo $lang->get('Passive mode'); ?>
              </label>
            </div>
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
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_form = {
    rules: {
      limit_size: {
        require: true,
        format: 'int'
      },
      limit_unit: {
        require: true
      },
      limit_count: {
        require: true,
        format: 'int'
      },
      ftp_port: {
        format: 'int'
      }
    },
    attr_names: {
      limit_size: '<?php echo $lang->get('Upload size limit'); ?>',
      limit_unit: '<?php echo $lang->get('Upload size unit'); ?>',
      limit_count: '<?php echo $lang->get('Count per upload'); ?>',
      ftp_port: '<?php echo $lang->get('Host port'); ?>'
    },
    type_msg: {
      require: '<?php echo $lang->get('{:attr} require'); ?>'
    },
    format_msg: {
      'int': '<?php echo $lang->get('{:attr} must be numeric'); ?>'
    },
    box: {
      msg: '<?php echo $lang->get('Input error'); ?>'
    }
  };

  $(document).ready(function(){
    var obj_validate_form   = $('#opt_form').baigoValidate(opts_validate_form);
    var obj_submit_form     = $('#opt_form').baigoSubmit(opts_submit);

    $('#opt_form').submit(function(){
      if (obj_validate_form.verify()) {
        obj_submit_form.formSubmit();
      }
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
