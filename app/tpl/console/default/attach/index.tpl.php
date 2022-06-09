<?php $cfg = array(
  'title'          => $lang->get('Image', 'console.common'),
  'menu_active'    => 'attach',
  'sub_active'     => 'index',
  'baigoCheckall'  => 'true',
  'baigoValidate'  => 'true',
  'baigoSubmit'    => 'true',
  'baigoClear'     => 'true',
  'baigoQuery'     => 'true',
  'baigoDialog'    => 'true',
  'upload'         => 'true',
  'tooltip'        => 'true',
  'popover'        => 'true',
  'imageAsync'     => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <div class="d-flex justify-content-between">
    <nav class="nav mb-3">
      <a href="<?php echo $hrefRow['index']; ?>" class="nav-link<?php if ($search['box'] == 'normal') { ?> disabled<?php } ?>">
        <?php echo $lang->get('All'); ?>
        <span class="badge badge-pill badge-<?php if ($search['box'] == 'normal') { ?>secondary<?php } else { ?>primary<?php } ?>"><?php echo $attachCount['all']; ?></span>
      </a>
      <?php if ($attachCount['recycle'] > 0) { ?>
        <a href="<?php echo $hrefRow['index-box']; ?>recycle" class="nav-link<?php if ($search['box'] == 'recycle') { ?> disabled<?php } ?>">
          <?php echo $lang->get('Recycle'); ?>
          <span class="badge badge-pill badge-<?php if ($search['box'] == 'recycle') { ?>secondary<?php } else { ?>primary<?php } ?>"><?php echo $attachCount['recycle']; ?></span>
        </a>
      <?php }

      if ($adminLogged['admin_type'] == 'super') { ?>
        <a href="<?php echo $hrefRow['index-box']; ?>reserve" class="nav-link<?php if ($search['box'] == 'reserve') { ?> disabled<?php } ?>">
          <?php echo $lang->get('Reserve data'); ?>
          <span class="badge badge-pill badge-<?php if ($search['box'] == 'reserve') { ?>secondary<?php } else { ?>primary<?php } ?>"><?php echo $attachCount['reserve']; ?></span>
        </a>
      <?php } ?>
    </nav>
    <form name="attach_search" id="attach_search" class="d-none d-lg-inline-block" action="<?php echo $hrefRow['index']; ?>">
      <div class="input-group mb-3">
        <input type="text" name="key" class="form-control" value="<?php echo $search['key']; ?>" placeholder="<?php echo $lang->get('Keyword'); ?>">
        <span class="input-group-append">
          <button class="btn btn-outline-secondary" type="submit">
            <span class="bg-icon"><?php include($tpl_icon . 'search' . BG_EXT_SVG); ?></span>
          </button>
          <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-toggle="collapse" data-target="#bg-search-more" >
            <span class="sr-only">Dropdown</span>
          </button>
        </span>
      </div>
      <div class="collapse" id="bg-search-more">
        <div class="input-group mb-3">
          <select name="ext" class="custom-select">
            <option value=""><?php echo $lang->get('All extensions'); ?></option>
            <?php foreach ($extRows as $key=>$value) { ?>
              <option <?php if ($search['ext'] == $value['attach_ext']) { ?>selected<?php } ?> value="<?php echo $value['attach_ext']; ?>"><?php echo $value['attach_ext']; ?></option>
            <?php } ?>
          </select>
          <select name="year" class="custom-select">
            <option value=""><?php echo $lang->get('All years'); ?></option>
            <?php foreach ($yearRows as $key=>$value) { ?>
              <option <?php if ($search['year'] == $value['attach_year']) { ?>selected<?php } ?> value="<?php echo $value['attach_year']; ?>"><?php echo $value['attach_year']; ?></option>
            <?php } ?>
          </select>
          <select name="month" class="custom-select">
            <option value=""><?php echo $lang->get('All months'); ?></option>
            <?php for ($iii = 1 ; $iii <= 12; ++$iii) {
              if ($iii < 10) {
                $str_month = '0' . $iii;
              } else {
                $str_month = $iii;
              } ?>
              <option <?php if ($search['month'] == $str_month) { ?>selected<?php } ?> value="<?php echo $str_month; ?>"><?php echo $str_month; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </form>
  </div>

  <?php if (!empty($search['key']) || !empty($search['ext']) || !empty($search['year']) || !empty($search['month']) || !empty($search['admin'])) { ?>
    <div class="mb-3 text-right">
        <?php if (!empty($search['key'])) { ?>
          <span class="badge badge-info">
            <?php echo $lang->get('Keyword'); ?>:
            <?php echo $search['key']; ?>
          </span>
        <?php }

        if (!empty($search['ext'])) { ?>
          <span class="badge badge-info">
            <?php echo $lang->get('Extension'); ?>:
            <?php echo $lang->get($search['ext']); ?>
          </span>
        <?php }

        if (!empty($search['year'])) { ?>
          <span class="badge badge-info">
            <?php echo $lang->get('Year'); ?>:
            <?php echo $lang->get($search['year']); ?>
          </span>
        <?php }

        if (!empty($search['month'])) { ?>
          <span class="badge badge-info">
            <?php echo $lang->get('Month'); ?>:
            <?php echo $lang->get($search['month']); ?>
          </span>
        <?php }

        if (!empty($search['admin_id'])) { ?>
          <span class="badge badge-info">
            <?php echo $lang->get('Administrator'); ?>:
            <?php echo $lang->get($search['admin']); ?>
          </span>
        <?php } ?>

        <a href="<?php echo $hrefRow['index']; ?>" class="badge badge-danger badge-pill">
          <span class="bg-icon"><?php include($tpl_icon . 'times-circle' . BG_EXT_SVG); ?></span>
          <?php echo $lang->get('Reset'); ?>
        </a>
    </div>
  <?php } ?>

  <div class="card-group mb-3">
    <?php if ($search['box'] != 'recycle') { ?>
      <div class="card">
        <div class="card-body">
          <?php include($tpl_ctrl . 'upload_form' . GK_EXT_TPL); ?>
        </div>
      </div>
    <?php } ?>

    <div class="card bg-light">
      <div class="card-body">
        <?php if ($search['box'] == 'recycle') { ?>
          <div class="alert alert-danger">
            <span class="bg-icon"><?php include($tpl_icon . 'exclamation-triangle' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Warning! This operation is not recoverable!'); ?>
          </div>

          <form name="attach_empty" id="attach_empty" action="<?php echo $hrefRow['empty-recycle']; ?>">
            <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
            <button type="submit" class="btn btn-danger">
              <span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>
              <?php echo $lang->get('Empty'); ?>
            </button>
          </form>
        <?php } else { ?>
          <div class="alert alert-warning">
            <span class="bg-icon"><?php include($tpl_icon . 'exclamation-triangle' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Warning! This operation will take a long time!'); ?>
          </div>

          <form name="attach_clear" id="attach_clear" action="<?php echo $hrefRow['clear']; ?>">
            <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
            <input type="hidden" name="act_clear" id="act_clear" value="clear">
            <button type="submit" class="btn btn-warning">
              <span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>
              <?php echo $lang->get('Clean up attachments'); ?>
            </button>
          </form>
        <?php } ?>
      </div>
    </div>
  </div>

  <form name="attach_list" id="attach_list" action="<?php echo $hrefRow['box']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">

    <div class="table-responsive">
      <table class="table table-striped border bg-white">
        <thead>
          <tr>
            <th class="text-nowrap bg-td-xs">
              <div class="form-check">
                <input type="checkbox" name="chk_all" id="chk_all" data-parent="first" class="form-check-input">
                <label for="chk_all" class="form-check-label">
                  <small><?php echo $lang->get('ID'); ?></small>
                </label>
              </div>
            </th>
            <th><?php echo $lang->get('Detail'); ?></th>
            <th class="d-none d-lg-table-cell bg-td-md">
              <small>
                <?php echo $lang->get('Administrator'); ?>
                /
                <?php echo $lang->get('Note'); ?>
              </small>
            </th>
            <th class="d-none d-lg-table-cell bg-td-md text-right">
              <small>
                <?php echo $lang->get('Size'); ?>
                /
                <?php echo $lang->get('Time'); ?>
              </small>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($attachRows as $key=>$value) { ?>
            <tr class="bg-manage-tr">
              <td class="text-nowrap bg-td-xs">
                <div class="form-check">
                  <input type="checkbox" name="attach_ids[]" value="<?php echo $value['attach_id']; ?>" id="attach_id_<?php echo $value['attach_id']; ?>" data-validate="attach_ids" class="form-check-input attach_id" data-parent="chk_all">
                  <label for="attach_id_<?php echo $value['attach_id']; ?>" class="form-check-label">
                    <small><?php echo $value['attach_id']; ?></small>
                  </label>
                </div>
              </td>
              <td>
                <a class="dropdown-toggle float-right d-block d-lg-none" data-toggle="collapse" href="#td-collapse-<?php echo $value['attach_id']; ?>">
                  <span class="sr-only">Dropdown</span>
                </a>
                <div class="mb-2 text-wrap text-break">
                  <a href="javascript:void(0);" tabindex="0" data-trigger="focus" data-toggle="popover" data-content="<img src='<?php echo $value['attach_url']; ?>' class='img-fluid'>">
                    <?php echo $value['attach_name']; ?>
                  </a>
                </div>
                <div class="bg-manage-menu">
                  <div class="d-flex flex-wrap">
                    <a href="<?php echo $hrefRow['show'], $value['attach_id']; ?>" class="mr-2">
                      <span class="bg-icon"><?php include($tpl_icon . 'eye' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Show'); ?>
                    </a>
                    <?php if ($search['box'] == 'recycle') { ?>
                      <a href="javascript:void(0);" data-id="<?php echo $value['attach_id']; ?>" class="attach_revert mr-2">
                        <span class="bg-icon"><?php include($tpl_icon . 'redo-alt' . BG_EXT_SVG); ?></span>
                        <?php echo $lang->get('Restore'); ?>
                      </a>
                      <a href="javascript:void(0);" data-id="<?php echo $value['attach_id']; ?>" class="text-danger attach_delete mr-2">
                        <span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>
                        <?php echo $lang->get('Delete'); ?>
                      </a>
                    <?php } else { ?>
                      <a href="<?php echo $hrefRow['edit'], $value['attach_id']; ?>" class="mr-2">
                        <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
                        <?php echo $lang->get('Edit'); ?>
                      </a>
                      <?php if ($value['attach_type'] == 'image') { ?>
                        <a href="javascript:void(0);" data-toggle="tooltip" data-placement="right" title="<?php echo $lang->get('Use when the image cannot be displayed'); ?>" data-id="<?php echo $value['attach_id']; ?>" class="mr-2 attach_fix">
                          <span class="bg-icon"><?php include($tpl_icon . 'redo-alt' . BG_EXT_SVG); ?></span>
                          <?php echo $lang->get('Fix it'); ?>
                        </a>
                      <?php } ?>
                      <a href="javascript:void(0);" data-id="<?php echo $value['attach_id']; ?>" class="text-danger attach_recycle">
                        <span class="bg-icon"><?php include($tpl_icon . 'trash' . BG_EXT_SVG); ?></span>
                        <?php echo $lang->get('Recycle'); ?>
                      </a>
                    <?php } ?>
                  </div>
                </div>
                <dl class="row collapse mt-3 mb-0" id="td-collapse-<?php echo $value['attach_id']; ?>">
                  <dt class="col-3">
                    <small><?php echo $lang->get('Administrator'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <small>
                      <?php if (isset($value['adminRow']['admin_name'])) { ?>
                        <a href="<?php echo $hrefRow['index-admin'], $value['attach_admin_id']; ?>"><?php echo $value['adminRow']['admin_name']; ?></a>
                      <?php } else {
                        echo $lang->get('Unknown');
                      } ?>
                    </small>
                  </dd>
                  <dt class="col-3">
                    <small><?php echo $lang->get('Note'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <small><?php echo $value['attach_note']; ?></small>
                  </dd>
                  <dt class="col-3">
                    <small><?php echo $lang->get('Size'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <small><?php echo $value['attach_size_format']; ?></small>
                  </dd>
                  <dt class="col-3">
                    <small><?php echo $lang->get('Time'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <small data-toggle="tooltip" data-placement="bottom" title="<?php echo $value['attach_time_format']['date_time']; ?>"><?php echo $value['attach_time_format']['date_time_short']; ?></small>
                  </dd>
                </dl>
              </td>
              <td class="d-none d-lg-table-cell bg-td-md">
                <small>
                  <div class="mb-2">
                    <?php if (isset($value['adminRow']['admin_name'])) { ?>
                      <a href="<?php echo $hrefRow['index-admin'], $value['attach_admin_id']; ?>"><?php echo $value['adminRow']['admin_name']; ?></a>
                    <?php } else {
                      echo $lang->get('Unknown');
                    } ?>
                  </div>
                  <div><?php echo $value['attach_note']; ?></div>
                </small>
              </td>
              <td class="d-none d-lg-table-cell bg-td-md text-right">
                <div class="mb-2">
                  <small><?php echo $value['attach_size_format']; ?></small>
                </div>
                <div>
                  <small data-toggle="tooltip" data-placement="bottom" title="<?php echo $value['attach_time_format']['date_time']; ?>"><?php echo $value['attach_time_format']['date_time_short']; ?></small>
                </div>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <div class="mb-3">
      <small class="form-text" id="msg_attach_ids"></small>
    </div>

    <div class="clearfix">
      <div class="float-left">
        <div class="input-group mb-3">
          <select name="act" id="act" class="custom-select">
            <option value=""><?php echo $lang->get('Bulk actions'); ?></option>
            <?php if ($search['box'] == 'recycle') { ?>
              <option value="normal"><?php echo $lang->get('Restore'); ?></option>
              <option value="delete"><?php echo $lang->get('Delete'); ?></option>
            <?php } else { ?>
              <option value="recycle"><?php echo $lang->get('Move to recycle'); ?></option>
            <?php } ?>
          </select>
          <span class="input-group-append">
            <button type="submit" class="btn btn-primary"><?php echo $lang->get('Apply'); ?></button>
          </span>
        </div>
        <small id="msg_act" class="form-text"></small>
      </div>
      <div class="float-right">
        <?php include($tpl_include . 'pagination' . GK_EXT_TPL); ?>
      </div>
    </div>
  </form>

  <form name="attach_fix" id="attach_fix" action="<?php echo $hrefRow['fix']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
    <input type="hidden" name="attach_id" id="attach_id" value="0">
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);

  if ($search['box'] != 'recycle') {
    include($tpl_ctrl . 'upload_script' . GK_EXT_TPL);
  } ?>

  <script type="text/javascript">
  var opts_validate_list = {
    rules: {
      attach_ids: {
        checkbox: '1'
      },
      act: {
        require: true
      }
    },
    attr_names: {
      attach_ids: '<?php echo $lang->get('Image'); ?>',
      act: '<?php echo $lang->get('Action'); ?>'
    },
    type_msg: {
      require: '<?php echo $lang->get('Choose at least one {:attr}'); ?>',
      checkbox: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
    },
    selector_types: {
      attach_ids: 'validate'
    }
  };

  $(document).ready(function(){
    var obj_dialog          = $.baigoDialog(opts_dialog);
    var obj_validate_list   = $('#attach_list').baigoValidate(opts_validate_list);
    var obj_submit_list     = $('#attach_list').baigoSubmit(opts_submit);

    $('#attach_list').submit(function(){
      var _act = $('#act').val();
      if (obj_validate_list.verify()) {
        switch (_act) {
          case 'delete':
            obj_dialog.confirm('<?php echo $lang->get('Are you sure to delete?'); ?>', function(result){
              if (result) {
                obj_submit_list.formSubmit('<?php echo $hrefRow['delete']; ?>');
              }
            });
          break;

          case 'recycle':
            obj_dialog.confirm('<?php echo $lang->get('Are you sure move to recycle?'); ?>', function(result){
              if (result) {
                obj_submit_list.formSubmit('<?php echo $hrefRow['box']; ?>');
              }
            });
          break;

          default:
            obj_submit_list.formSubmit('<?php echo $hrefRow['box']; ?>');
          break;
        }
      }
    });

    var obj_submit_fix = $('#attach_fix').baigoSubmit(opts_submit);

    $('.attach_fix').click(function(){
      $('#attach_id').val($(this).data('id'));
      obj_submit_fix.formSubmit();
    });

    $('.attach_revert').click(function(){
      var _attach_id = $(this).data('id');
      $('.attach_id').prop('checked', false);
      $('#attach_id_' + _attach_id).prop('checked', true);
      $('#act').val('normal');
      $('#attach_list').submit();
    });

    $('.attach_delete').click(function(){
      var _attach_id = $(this).data('id');
      $('.attach_id').prop('checked', false);
      $('#attach_id_' + _attach_id).prop('checked', true);
      $('#act').val('delete');
      $('#attach_list').submit();
    });

    $('.attach_recycle').click(function(){
      var _attach_id = $(this).data('id');
      $('.attach_id').prop('checked', false);
      $('#attach_id_' + _attach_id).prop('checked', true);
      $('#act').val('recycle');
      $('#attach_list').submit();
    });

    $('#attach_list').baigoCheckall();

    var obj_empty = $('#attach_empty').baigoClear(opts_clear);
    $('#attach_empty').submit(function(){
      obj_dialog.confirm('<?php echo $lang->get('Warning! This operation is not recoverable!'); ?>', function(result){
        if (result) {
          obj_empty.clearSubmit();
        }
      });
    });

    var obj_clear  = $('#attach_clear').baigoClear(opts_clear);
    $('#attach_clear').submit(function(){
      obj_dialog.confirm('<?php echo $lang->get('Warning! This operation will take a long time!'); ?>', function(result){
        if (result) {
          obj_clear.clearSubmit();
        }
      });
    });

    var obj_query = $('#attach_search').baigoQuery();

    $('#attach_search').submit(function(){
      obj_query.formSubmit();
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
