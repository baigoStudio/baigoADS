<?php if ($adminRow['admin_id'] > 0) {
  $title_sub    = $lang->get('Edit');
  $str_sub      = 'index';
} else {
  $title_sub    = $lang->get('Add');
  $str_sub      = 'form';
}

$cfg = array(
  'title'             => $lang->get('Administrator', 'console.common') . ' &raquo; ' . $title_sub,
  'menu_active'       => 'admin',
  'sub_active'        => $str_sub,
  'baigoValidate'     => 'true',
  'baigoSubmit'       => 'true',
  'baigoCheckall'     => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <nav class="nav mb-3">
    <a href="<?php echo $hrefRow['index']; ?>" class="nav-link">
      <span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('Back'); ?>
    </a>
  </nav>

  <form name="admin_form" id="admin_form" autocomplete="off" action="<?php echo $hrefRow['submit']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
    <input type="hidden" name="admin_id" id="admin_id" value="<?php echo $adminRow['admin_id']; ?>">

    <div class="row">
      <div class="col-xl-9">
        <div class="card mb-3">
          <div class="card-body">
            <?php if ($adminRow['admin_id'] > 0) { ?>
              <div class="form-group">
                <label><?php echo $lang->get('Username'); ?></label>
                <input type="text" name="admin_name" id="admin_name" value="<?php echo $adminRow['admin_name']; ?>" class="form-control" readonly>
              </div>

              <div class="form-group">
                <label><?php echo $lang->get('Password'); ?></label>
                <input type="text" name="admin_pass" id="admin_pass" class="form-control" placeholder="<?php echo $lang->get('Enter only when you need to modify'); ?>">
              </div>

              <div class="form-group">
                <label><?php echo $lang->get('Email'); ?></label>
                <input type="text" name="admin_mail_new" id="admin_mail_new" value="<?php echo $userRow['user_mail']; ?>" class="form-control">
                <small class="form-text" id="msg_admin_mail_new"></small>
              </div>
            <?php } else { ?>
              <div class="form-group">
                <label><?php echo $lang->get('Username'); ?> <span class="text-danger">*</span></label>
                <input type="text" name="admin_name" id="admin_name" class="form-control">
                <small class="form-text" id="msg_admin_name"></small>
              </div>

              <div class="form-group">
                <label><?php echo $lang->get('Password'); ?> <span class="text-danger">*</span></label>
                <input type="text" name="admin_pass" id="admin_pass" class="form-control">
                <small class="form-text" id="msg_admin_pass"></small>
              </div>

              <div class="form-group">
                <label><?php echo $lang->get('Email'); ?></label>
                <input type="text" name="admin_mail" id="admin_mail" class="form-control">
                <small class="form-text" id="msg_admin_mail"></small>
              </div>
            <?php } ?>

            <div class="form-group">
              <label><?php echo $lang->get('Nickname'); ?></label>
              <input type="text" name="admin_nick" id="admin_nick" value="<?php echo $adminRow['admin_nick']; ?>" class="form-control">
              <small class="form-text" id="msg_admin_nick"></small>
            </div>

            <div class="form-group">
              <label><?php echo $lang->get('Permission'); ?> <span class="text-danger">*</span></label>

              <?php include($tpl_include . 'allow_list' . GK_EXT_TPL); ?>
              <small class="form-text" id="msg_admin_allow"></small>
            </div>

            <div class="form-group">
              <label><?php echo $lang->get('Note'); ?></label>
              <input type="text" name="admin_note" id="admin_note" value="<?php echo $adminRow['admin_note']; ?>" class="form-control">
              <small class="form-text" id="msg_admin_note"></small>
            </div>

            <div class="bg-validate-box"></div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">
              <?php echo $lang->get('Save'); ?>
            </button>
          </div>
        </div>
      </div>

      <div class="col-xl-3">
        <div class="card bg-light">
          <div class="card-body">
            <?php if ($adminRow['admin_id'] > 0) { ?>
              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('ID'); ?></label>
                <div class="form-text font-weight-bolder"><?php echo $adminRow['admin_id']; ?></div>
              </div>
            <?php } ?>

            <div class="form-group">
              <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
              <?php foreach ($status as $key=>$value) { ?>
                <div class="form-check">
                  <input type="radio" name="admin_status" id="admin_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($adminRow['admin_status'] == $value) { ?>checked<?php } ?> class="form-check-input">
                  <label for="admin_status_<?php echo $value; ?>" class="form-check-label">
                    <?php echo $lang->get($value); ?>
                  </label>
                </div>
              <?php } ?>
              <small class="form-text" id="msg_admin_status"></small>
            </div>

            <div class="form-group">
              <label><?php echo $lang->get('Type'); ?> <span class="text-danger">*</span></label>
              <?php foreach ($type as $key=>$value) { ?>
                <div class="form-check">
                  <input type="radio" name="admin_type" id="admin_type_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($adminRow['admin_type'] == $value) { ?>checked<?php } ?> class="form-check-input">
                  <label for="admin_type_<?php echo $value; ?>" class="form-check-label">
                    <?php echo $lang->get($value); ?>
                  </label>
                </div>
              <?php } ?>
              <small class="form-text" id="msg_admin_type"></small>
            </div>

            <div class="form-group">
              <label><?php echo $lang->get('Personal permission'); ?></label>
              <?php foreach ($config['console']['profile_mod'] as $key=>$value) { ?>
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="admin_allow_profile[<?php echo $key; ?>]" id="admin_allow_profile_<?php echo $key; ?>" value="1" <?php if (isset($adminRow['admin_allow_profile'][$key])) { ?>checked<?php } ?> class="custom-control-input">
                  <label for="admin_allow_profile_<?php echo $key; ?>" class="custom-control-label">
                    <?php echo $lang->get('Not allowed to edit'), '&nbsp;', $lang->get($value['title'], 'console.common'); ?>
                  </label>
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">
              <?php echo $lang->get('Save'); ?>
            </button>
          </div>
        </div>

        <?php if ($adminRow['admin_id'] > 0) {
          include($tpl_ctrl . 'user_info' . GK_EXT_TPL);
        } ?>
      </div>
    </div>
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_form = {
    rules: {
      <?php if ($adminRow['admin_id'] > 0) { ?>
        admin_mail_new: {
          max: 300,
          format: 'email',
          ajax: {
            url: '<?php echo $hrefRow['chkmail']; ?>'
          }
        },
      <?php } else { ?>
        admin_name: {
          length: '1,30',
          format: 'alpha_dash',
          ajax: {
            url: '<?php echo $hrefRow['chkname']; ?>'
          }
        },
        admin_pass: {
          require: true
        },
        admin_mail: {
          max: 300,
          format: 'email',
          ajax: {
            url: '<?php echo $hrefRow['chkmail']; ?>'
          }
        },
      <?php } ?>
      admin_nick: {
        max: 30
      },
      admin_note: {
        max: 30
      },
      admin_type: {
        require: true
      },
      admin_status: {
        require: true
      }
    },
    attr_names: {
      admin_name: '<?php echo $lang->get('Username'); ?>',
      admin_pass: '<?php echo $lang->get('Password'); ?>',
      admin_mail: '<?php echo $lang->get('Email'); ?>',
      admin_mail_new: '<?php echo $lang->get('Email'); ?>',
      admin_nick: '<?php echo $lang->get('Nickname'); ?>',
      admin_note: '<?php echo $lang->get('Note'); ?>',
      admin_type: '<?php echo $lang->get('Type'); ?>',
      admin_status: '<?php echo $lang->get('Status'); ?>'
    },
    selector_types: {
      admin_type: 'name',
      admin_status: 'name'
    },
    type_msg: {
      require: '<?php echo $lang->get('{:attr} require'); ?>',
      max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>',
      length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>'
    },
    format_msg: {
      alpha_dash: '<?php echo $lang->get('{:attr} must be alpha-numeric, dash, underscore'); ?>',
      email: '<?php echo $lang->get('{:attr} not a valid email address'); ?>'
    },
    msg: {
      loading: '<?php echo $lang->get('Loading'); ?>',
      ajax_err: '<?php echo $lang->get('Server side error'); ?>'
    },
    box: {
      msg: '<?php echo $lang->get('Input error'); ?>'
    }
  };

  $(document).ready(function(){
    var obj_validate_form   = $('#admin_form').baigoValidate(opts_validate_form);
    var obj_submit_form     = $('#admin_form').baigoSubmit(opts_submit);

    $('#admin_form').submit(function(){
      if (obj_validate_form.verify()) {
        obj_submit_form.formSubmit();
      }
    });
    $('#admin_form').baigoCheckall();
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
