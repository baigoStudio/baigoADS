<?php $cfg = array(
  'title'             => $lang->get('Link', 'console.common'),
  'menu_active'       => 'link',
  'sub_active'        => 'index',
  'baigoValidate'     => 'true',
  'baigoSubmit'       => 'true',
  'baigoCheckall'     => 'true',
  'baigoQuery'        => 'true',
  'baigoDialog'       => 'true',
  'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

  <div class="d-flex justify-content-between">
    <nav class="nav mb-3">
      <a href="<?php echo $route_console; ?>link/form/" class="nav-link">
        <span class="bg-icon"><?php include($cfg_global['pathIcon'] . 'plus' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('Add'); ?>
      </a>
      <a href="<?php echo $route_console; ?>link/order/" class="nav-link">
        <span class="bg-icon"><?php include($cfg_global['pathIcon'] . 'sort-alpha-up' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('Sort'); ?>
      </a>
    </nav>
    <form name="link_search" id="link_search" class="d-none d-lg-block" action="<?php echo $route_console; ?>link/index/">
      <div class="input-group mb-3">
        <input type="text" name="key" value="<?php echo $search['key']; ?>" placeholder="<?php echo $lang->get('Keyword'); ?>" class="form-control">
        <span class="input-group-append">
          <button class="btn btn-outline-secondary" type="submit">
            <span class="bg-icon"><?php include($cfg_global['pathIcon'] . 'search' . BG_EXT_SVG); ?></span>
          </button>
          <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-toggle="collapse" data-target="#bg-search-more" >
            <span class="sr-only">Dropdown</span>
          </button>
        </span>
      </div>
      <div class="collapse" id="bg-search-more">
        <div class="input-group mb-3">
          <select name="status" class="custom-select">
            <option value=""><?php echo $lang->get('All status'); ?></option>
            <?php foreach ($status as $key=>$value) { ?>
              <option <?php if ($search['status'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                <?php echo $lang->get($value); ?>
              </option>
            <?php } ?>
          </select>
        </div>
      </div>
    </form>
  </div>

  <?php if (!empty($search['key']) || !empty($search['status'])) { ?>
    <div class="mb-3 text-right">
      <?php if (!empty($search['key'])) { ?>
        <span class="badge badge-info">
          <?php echo $lang->get('Keyword'); ?>:
          <?php echo $search['key']; ?>
        </span>
      <?php }

      if (!empty($search['status'])) { ?>
        <span class="badge badge-info">
          <?php echo $lang->get('Status'); ?>:
          <?php echo $lang->get($search['status']); ?>
        </span>
      <?php } ?>

      <a href="<?php echo $route_console; ?>link/index/" class="badge badge-danger badge-pill">
        <span class="bg-icon"><?php include($cfg_global['pathIcon'] . 'times-circle' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('Reset'); ?>
      </a>
    </div>
  <?php } ?>

  <div class="card bg-light mb-3">
    <div class="card-body">
      <form name="link_cache" id="link_cache" action="<?php echo $route_console; ?>link/cache/">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
        <button type="submit" class="btn btn-primary">
          <span class="bg-icon"><?php include($cfg_global['pathIcon'] . 'redo-alt' . BG_EXT_SVG); ?></span>
          <?php echo $lang->get('Refresh cache'); ?>
        </button>
      </form>
    </div>
  </div>

  <form name="link_list" id="link_list" action="<?php echo $route_console; ?>link/status/">
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
              <?php echo $lang->get('Link'); ?>
            </th>
            <th class="d-none d-lg-table-cell bg-td-md text-right">
              <small>
                <?php echo $lang->get('Status'); ?>
              </small>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($linkRows as $key=>$value) { ?>
            <tr class="bg-manage-tr">
              <td class="text-nowrap bg-td-xs">
                <div class="form-check">
                  <input type="checkbox" name="link_ids[]" value="<?php echo $value['link_id']; ?>" id="link_id_<?php echo $value['link_id']; ?>" data-parent="chk_all" data-validate="link_ids" class="form-check-input link_id">
                  <label for="link_id_<?php echo $value['link_id']; ?>" class="form-check-label">
                    <small><?php echo $value['link_id']; ?></small>
                  </label>
                </div>
              </td>
              <td>
                <a class="dropdown-toggle float-right d-block d-lg-none" data-toggle="collapse" href="#td-collapse-<?php echo $value['link_id']; ?>">
                  <span class="sr-only">Dropdown</span>
                </a>
                <div class="mb-2 text-wrap text-break">
                  <a href="<?php echo $route_console; ?>link/form/id/<?php echo $value['link_id']; ?>/">
                    <?php echo $value['link_name']; ?>
                  </a>
                </div>
                <div class="bg-manage-menu">
                  <div class="d-flex flex-wrap">
                    <a href="<?php echo $route_console; ?>link/show/id/<?php echo $value['link_id']; ?>/" class="mr-2">
                      <span class="bg-icon"><?php include($cfg_global['pathIcon'] . 'eye' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Show'); ?>
                    </a>
                    <a href="<?php echo $route_console; ?>link/form/id/<?php echo $value['link_id']; ?>/" class="mr-2">
                      <span class="bg-icon"><?php include($cfg_global['pathIcon'] . 'edit' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Edit'); ?>
                    </a>
                    <a href="javascript:void(0);" data-id="<?php echo $value['link_id']; ?>" class="link_delete text-danger">
                      <span class="bg-icon"><?php include($cfg_global['pathIcon'] . 'trash-alt' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Delete'); ?>
                    </a>
                  </div>
                </div>
                <dl class="row collapse mt-3 mb-0" id="td-collapse-<?php echo $value['link_id']; ?>">
                  <dt class="col-3">
                    <small><?php echo $lang->get('Status'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <?php $str_status = $value['link_status'];
                    include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
                  </dd>
                </dl>
              </td>
              <td class="d-none d-lg-table-cell bg-td-md text-right">
                <?php $str_status = $value['link_status'];
                include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <div class="mb-3">
      <small class="form-text" id="msg_link_ids"></small>
    </div>

    <div class="clearfix">
      <div class="float-left">
        <div class="input-group mb-3">
          <select name="act" id="act" class="custom-select">
            <option value=""><?php echo $lang->get('Bulk actions'); ?></option>
            <?php foreach ($status as $key=>$value) { ?>
              <option value="<?php echo $value; ?>">
                <?php echo $lang->get($value); ?>
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
        <?php include($cfg['pathInclude'] . 'pagination' . GK_EXT_TPL); ?>
      </div>
    </div>
  </form>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_list = {
    rules: {
      link_ids: {
        checkbox: '1'
      },
      act: {
        require: true
      }
    },
    attr_names: {
      link_ids: '<?php echo $lang->get('Link'); ?>',
      act: '<?php echo $lang->get('Action'); ?>'
    },
    type_msg: {
      require: '<?php echo $lang->get('Choose at least one {:attr}'); ?>',
      checkbox: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
    },
    selector_types: {
      link_ids: 'validate'
    }
  };

  $(document).ready(function(){
    var obj_dialog          = $.baigoDialog(opts_dialog);
    var obj_validate_list   = $('#link_list').baigoValidate(opts_validate_list);
    var obj_submit_list     = $('#link_list').baigoSubmit(opts_submit);

    $('#link_list').submit(function(){
      var _act = $('#act').val();
      if (obj_validate_list.verify()) {
        switch (_act) {
          case 'delete':
            obj_dialog.confirm('<?php echo $lang->get('Are you sure to delete?'); ?>', function(result){
              if (result) {
                obj_submit_list.formSubmit('<?php echo $route_console; ?>link/delete/');
              }
            });
          break;

          default:
            obj_submit_list.formSubmit('<?php echo $route_console; ?>link/status/');
          break;
        }
      }
    });

    var obj_cache = $('#link_cache').baigoSubmit(opts_submit);
    $('#link_cache').submit(function(){
      obj_cache.formSubmit();
    });

    $('.link_delete').click(function(){
      var _link_id = $(this).data('id');
      $('.link_id').prop('checked', false);
      $('#link_id_' + _link_id).prop('checked', true);
      $('#act').val('delete');
      $('#link_list').submit();
    });

    $('#link_list').baigoCheckall();

    var obj_query = $('#link_search').baigoQuery();

    $('#link_search').submit(function(){
      obj_query.formSubmit();
    });
  });
  </script>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);
