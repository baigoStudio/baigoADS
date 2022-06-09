<?php $cfg = array(
  'title'             => $lang->get('Private message', 'console.common'),
  'menu_active'       => 'pm',
  'sub_active'        => 'index',
  'baigoValidate'     => 'true',
  'baigoSubmit'       => 'true',
  'baigoCheckall'     => 'true',
  'baigoQuery'        => 'true',
  'baigoDialog'       => 'true',
  'tooltip'           => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <div class="d-flex justify-content-between">
    <nav class="nav mb-3">
      <a href="<?php echo $hrefRow['pm-send']; ?>" class="nav-link">
        <span class="bg-icon"><?php include($tpl_icon . 'paper-plane' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('Send'); ?>
      </a>
      <?php foreach ($pm_type['type'] as $key=>$value) {
        if ($key == 'in') {
          $icon_type = 'inbox';
        } else {
          $icon_type = 'cloud-upload-alt';
        } ?>
        <a href="<?php echo $value['href']; ?>" class="nav-link<?php if (isset($search['type']) && $search['type'] == $key) { ?> disabled<?php } ?>">
          <span class="bg-icon"><?php include($tpl_icon . $icon_type . BG_EXT_SVG); ?></span>
          <?php echo $value['title']; ?>
        </a>
      <?php } ?>
    </nav>

    <form name="pm_search" id="pm_search" class="d-none d-lg-inline-block" action="<?php echo $hrefRow['index']; ?>">
      <div class="input-group mb-3">
        <input type="text" name="key" value="<?php echo $search['key']; ?>" placeholder="<?php echo $lang->get('Keyword'); ?>" class="form-control">
        <span class="input-group-append">
          <button class="btn btn-outline-secondary" type="submit">
            <span class="bg-icon"><?php include($tpl_icon . 'search' . BG_EXT_SVG); ?></span>
          </button>
        </span>
      </div>
    </form>
  </div>

  <form name="pm_list" id="pm_list" action="<?php echo $hrefRow['status']; ?>">
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
            <th>
              <?php echo $lang->get('Private message'); ?>
            </th>
            <th class="d-none d-lg-table-cell bg-td-md">

            </th>
            <th class="d-none d-lg-table-cell bg-td-md text-right">
              <small>
                <?php echo $lang->get('Status'); ?>
                /
                <?php echo $lang->get('Time'); ?>
              </small>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pmRows as $key=>$value) { ?>
            <tr class="bg-manage-tr">
              <td class="text-nowrap bg-td-xs">
                <div class="form-check">
                  <input type="checkbox" name="pm_ids[]" value="<?php echo $value['pm_id']; ?>" id="pm_id_<?php echo $value['pm_id']; ?>" data-parent="chk_all" data-validate="pm_ids" class="form-check-input pm_id">
                  <label for="pm_id_<?php echo $value['pm_id']; ?>" class="form-check-label">
                    <small><?php echo $value['pm_id']; ?></small>
                  </label>
                </div>
              </td>
              <td>
                <a class="dropdown-toggle float-right d-block d-lg-none" data-toggle="collapse" href="#td-collapse-<?php echo $value['pm_id']; ?>">
                  <span class="sr-only">Dropdown</span>
                </a>
                <div class="mb-2 text-wrap text-break">
                  <a href="#modal_lg" data-toggle="modal" data-href="<?php echo $hrefRow['show'], $value['pm_id']; ?>">
                    <?php echo $value['pm_title']; ?>
                  </a>
                </div>
                <div class="bg-manage-menu">
                  <div class="d-flex flex-wrap">
                    <a href="#modal_lg" data-toggle="modal" data-href="<?php echo $hrefRow['show'], $value['pm_id']; ?>" class="mr-2">
                      <span class="bg-icon"><?php include($tpl_icon . 'eye' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Show'); ?>
                    </a>
                    <a href="javascript:void(0);" data-id="<?php echo $value['pm_id']; ?>" class="pm_delete text-danger">
                      <span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Delete'); ?>
                    </a>
                  </div>
                </div>
                <dl class="row collapse mt-3 mb-0" id="td-collapse-<?php echo $value['pm_id']; ?>">
                  <dt class="col-3">
                    <small><?php echo $lang->get('Sender'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <small>
                      <a href="<?php echo $hrefRow['index-from'], $value['pm_from']; ?>">
                        <?php if ($value['pm_from'] == -1) {
                          echo $lang->get('System');
                        } else if (isset($value['fromUser']['user_name'])) {
                          echo $value['fromUser']['user_name'];
                        } else {
                          echo $lang->get('Unknown');
                        } ?>
                      </a>
                    </small>
                  </dd>
                  <dt class="col-3">
                      <small><?php echo $lang->get('Recipient'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <small>
                      <a href="<?php echo $hrefRow['index-to'], $value['pm_to']; ?>">
                        <?php if (isset($value['toUser']['user_name'])) {
                          echo $value['toUser']['user_name'];
                        } else {
                          echo $lang->get('Unknown');
                        } ?>
                      </a>
                    </small>
                  </dd>
                  <dt class="col-3">
                    <small><?php echo $lang->get('Status'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <?php $arr_pmRow = $value;
                    $search_type = $search['type'];
                    include($tpl_ctrl . 'status_process' . GK_EXT_TPL); ?>
                  </dd>
                  <dt class="col-3">
                    <small><?php echo $lang->get('Time'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <small data-toggle="tooltip" data-placement="bottom" title="<?php echo $value['pm_time_format']['date_time']; ?>"><?php echo $value['pm_time_format']['date_time_short']; ?></small>
                  </dd>
                </dl>
              </td>
              <td class="d-none d-lg-table-cell bg-td-md">
                <div>
                  <small>
                    <?php echo $lang->get('Sender'); ?>:
                    <a href="<?php echo $hrefRow['index-from'], $value['pm_from']; ?>">
                      <?php if ($value['pm_from'] == -1) {
                        echo $lang->get('System');
                      } else if (isset($value['fromUser']['user_name'])) {
                        echo $value['fromUser']['user_name'];
                      } else {
                        echo $lang->get('Unknown');
                      } ?>
                    </a>
                  </small>
                </div>
                <div>
                  <small>
                    <?php echo $lang->get('Recipient'); ?>:
                    <a href="<?php echo $hrefRow['index-to'], $value['pm_to']; ?>">
                      <?php if (isset($value['toUser']['user_name'])) {
                        echo $value['toUser']['user_name'];
                      } else {
                        echo $lang->get('Unknown');
                      } ?>
                    </a>
                  </small>
                </div>
              </td>
              <td class="d-none d-lg-table-cell bg-td-md text-right">
                <div>
                  <?php $arr_pmRow = $value;
                  $search_type = $search['type'];
                  include($tpl_ctrl . 'status_process' . GK_EXT_TPL); ?>
                </div>
                <div>
                  <small data-toggle="tooltip" data-placement="bottom" title="<?php echo $value['pm_time_format']['date_time']; ?>"><?php echo $value['pm_time_format']['date_time_short']; ?></small>
                </div>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <div class="mb-3">
      <small class="form-text" id="msg_pm_ids"></small>
    </div>

    <div class="clearfix">
      <div class="float-left">
        <div class="input-group mb-3">
          <select name="act" id="act" class="custom-select">
            <option value=""><?php echo $lang->get('Bulk actions'); ?></option>
            <?php foreach ($pm_type['status'] as $key=>$value) { ?>
              <option value="<?php echo $key; ?>">
                <?php echo $value; ?>
              </option>
            <?php } ?>
            <option value="delete"><?php echo $lang->get('Delete'); ?></option>
          </select>
          <span class="input-group-append">
            <button type="submit" class="btn btn-primary">
              <?php echo $lang->get('Apply'); ?>
            </button>
          </span>
        </div>
        <small id="msg_act" class="form-text"></small>
      </div>
      <div class="float-right">
        <?php include($tpl_include . 'pagination' . GK_EXT_TPL); ?>
      </div>
    </div>
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);

  include($tpl_include . 'modal_lg' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_list = {
    rules: {
      pm_ids: {
        checkbox: '1'
      },
      act: {
        require: true
      }
    },
    attr_names: {
      pm_ids: '<?php echo $lang->get('Pm'); ?>',
      act: '<?php echo $lang->get('Action'); ?>'
    },
    type_msg: {
      require: '<?php echo $lang->get('Choose at least one {:attr}'); ?>',
      checkbox: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
    },
    selector_types: {
      pm_ids: 'validate'
    }
  };

  $(document).ready(function(){
    var obj_dialog          = $.baigoDialog(opts_dialog);
    var obj_validate_list   = $('#pm_list').baigoValidate(opts_validate_list);
    var obj_submit_list     = $('#pm_list').baigoSubmit(opts_submit);

    $('#pm_list').submit(function(){
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

          default:
            obj_submit_list.formSubmit('<?php echo $hrefRow['status']; ?>');
          break;
        }
      }
    });

    $('.pm_delete').click(function(){
      var _pm_id = $(this).data('id');
      $('.pm_id').prop('checked', false);
      $('#pm_id_' + _pm_id).prop('checked', true);
      $('#act').val('delete');
      $('#pm_list').submit();
    });

    $('#pm_list').baigoCheckall();

    var obj_query = $('#pm_search').baigoQuery();

    $('#pm_search').submit(function(){
      obj_query.formSubmit();
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
