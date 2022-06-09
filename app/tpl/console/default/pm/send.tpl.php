<?php $cfg = array(
  'title'             => $lang->get('Private message', 'console.common') . ' &raquo; ' . $lang->get('Send'),
  'menu_active'       => 'pm',
  'sub_active'        => 'send',
  'baigoValidate'     => 'true',
  'baigoSubmit'       => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <nav class="nav mb-3">
    <a href="<?php echo $hrefRow['index']; ?>" class="nav-link">
      <span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('Back'); ?>
    </a>
  </nav>

  <form name="pm_send" id="pm_send" action="<?php echo $hrefRow['send-submit']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">

    <div class="card">
      <div class="card-body">
        <div class="form-group">
          <label><?php echo $lang->get('Recipient'); ?> <span class="text-danger">*</span></label>
          <input type="text" name="pm_to_name" id="pm_to_name" value="<?php echo $pmRow['fromUser']['user_name']; ?>" class="form-control">
          <small class="form-text" id="msg_pm_to_name"></small>
        </div>

        <div class="form-group">
          <label><?php echo $lang->get('Title'); ?></label>
          <input type="text" name="pm_title" id="pm_title" value="<?php echo $pmRow['pm_title']; ?>" class="form-control">
          <small class="form-text" id="msg_pm_title"></small>
        </div>

        <div class="form-group">
          <label><?php echo $lang->get('Content'); ?> <span class="text-danger">*</span></label>
          <textarea name="pm_content" id="pm_content" class="form-control bg-textarea-md"><?php echo $pmRow['pm_content']; ?></textarea>
          <small class="form-text" id="msg_pm_content"></small>
        </div>

        <div class="bg-validate-box"></div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary"><?php echo $lang->get('Send'); ?></button>
      </div>
    </div>
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_form = {
    rules: {
      pm_to_name: {
        require: true
      },
      pm_title: {
        max: 90
      },
      pm_content: {
        length: '1,900'
      }
    },
    attr_names: {
      pm_to_name: '<?php echo $lang->get('Recipient'); ?>',
      pm_title: '<?php echo $lang->get('Title'); ?>',
      pm_content: '<?php echo $lang->get('Content'); ?>'
    },
    type_msg: {
      require: '<?php echo $lang->get('{:attr} require'); ?>',
      max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>',
      length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>'
    },
    box: {
      msg: '<?php echo $lang->get('Input error'); ?>'
    }
  };

  $(document).ready(function(){
    var obj_validate_form   = $('#pm_send').baigoValidate(opts_validate_form);
    var obj_submit_form     = $('#pm_send').baigoSubmit(opts_submit);

   $('#pm_send').submit(function(){
      if (obj_validate_form.verify()) {
        obj_submit_form.formSubmit();
      }
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
