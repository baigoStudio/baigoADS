<?php use ginkgo\Plugin; ?>
        </div>
      </div>
    </div>
  </div>

  <?php Plugin::listen('action_console_foot_before'); //后台界面底部触发 ?>

  <footer class="container-fluid text-light p-3 clearfix bg-secondary mt-3">
    <div class="float-left">
      <img class="img-fluid bg-foot-logo" src="<?php echo $ui_ctrl['logo_console_foot']; ?>">
    </div>
    <?php if (!isset($ui_ctrl['copyright']) || $ui_ctrl['copyright'] === 'on') { ?>
      <div class="float-right">
        <span class="d-none d-lg-inline-block">Powered by</span>
        <a href="<?php echo PRD_ADS_URL; ?>" target="_blank" class="text-reset"><?php echo PRD_ADS_NAME; ?></a>
        <?php echo PRD_ADS_VER; ?>
      </div>
    <?php } ?>
  </footer>

  <?php Plugin::listen('action_console_foot_after'); //后台界面底部触发

  if (isset($adminLogged['rcode']) && $adminLogged['rcode'] == 'y020102' && !isset($cfg['no_token'])) { ?>
    <div class="modal fade" id="msg_token">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
              <?php echo $lang->get('OK', 'console.common'); ?>
            </button>
          </div>
        </div>
      </div>
    </div>
  <?php }

include($cfg['pathInclude'] . 'script_foot' . GK_EXT_TPL);
