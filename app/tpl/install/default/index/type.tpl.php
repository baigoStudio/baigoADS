<?php $cfg = array(
  'title'         => $lang->get('Installer'),
  'btn'           => $lang->get('Save'),
  'sub_title'     => $lang->get('Choose installation type'),
  'active'        => 'type',
);

include($tpl_ctrl . 'head' . GK_EXT_TPL); ?>

  <form name="type_form" id="type_form" action="<?php echo $hrefRow['type-submit']; ?>">
    <input type="hidden" name="act" value="sso">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">

    <div class="alert alert-info">
      <?php echo $lang->get('baigo SSO is an Single Sign On system, baigo ADS dependent on this system.'); ?>
    </div>

    <div class="form-group">
      <div class="form-check mb-3">
        <input type="radio" class="form-check-input" <?php if ($type == 'full') { ?>checked<?php } ?> name="install_type" id="install_type_full" value="full">
        <label class="form-check-label" for="install_type_full">
          <?php echo $lang->get('Full installation (Include baigo SSO)'); ?>
        </label>
      </div>
      <div class="form-check">
        <input type="radio" class="form-check-input" <?php if ($type == 'manually') { ?>checked<?php } ?> name="install_type" id="install_type_manually" value="manually">
        <label class="form-check-label" for="install_type_manually">
          <?php echo $lang->get('Only install baigo ADS (Manually set the baigo SSO)'); ?>
        </label>
      </div>
    </div>

    <div class="collapse <?php if ($type == 'manually') { ?>show<?php } ?>">
      <div class="alert alert-warning">
        <span class="bg-icon"><?php include($tpl_icon . 'exclamation-triangle' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('If you already have installed baigo SSO, you can set the parameters here. If you want to install baigo SSO yourself, please visit the <a href="https://www.baigo.net/sso/" target="_blank">official website</a>.'); ?>
      </div>

      <?php include($tpl_console . 'opt_form' . GK_EXT_TPL); ?>
    </div>

    <?php include($tpl_include . 'install_btn' . GK_EXT_TPL);?>
  </form>

<?php include($tpl_include . 'install_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_form = {
    rules: <?php echo json_encode($_arr_rule); ?>,
    attr_names: <?php echo json_encode($_arr_attr); ?>,
    selector_types: <?php echo json_encode($_arr_selector); ?>,
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

  opts_submit.jump = {
    url: '<?php echo $step['next']['href']; ?>',
    text: '<?php echo $lang->get('Redirecting'); ?>'
  };

  $(document).ready(function(){
    $('[name="install_type"]').click(function(){
      if ($('#install_type_manually').prop('checked')) {
        $('.collapse').collapse('show');
      } else {
        $('.collapse').collapse('hide');
      }
    });

    var obj_validate_form     = $('#type_form').baigoValidate(opts_validate_form);
    var obj_submit_form       = $('#type_form').baigoSubmit(opts_submit);
    $('#type_form').submit(function(){
      if ($('#install_type_manually').prop('checked')) {
      if (obj_validate_form.verify()) {
          obj_submit_form.formSubmit();
        }
      } else {
        obj_submit_form.formSubmit();
      }
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
