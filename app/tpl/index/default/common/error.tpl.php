<?php $cfg = array(
  'title'         => $lang->get('Error', 'index.common'),
);

include($tpl_ctrl . 'head' . GK_EXT_TPL);; ?>

  <nav class="nav mb-3">
    <a href="javascript:history.go(-1);" class="nav-link">
      <span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('Back', 'index.common'); ?>
    </a>
  </nav>

  <div class="card">
    <div class="card-body">
      <h3 class="text-danger">
        <span class="bg-icon"><?php include($tpl_icon . 'times-circle' . BG_EXT_SVG); ?></span>
        <?php if (isset($msg)) {
          echo $lang->get($msg);
        } ?>
      </h3>

      <div class="text-danger lead">
        <?php if (isset($rcode)) {
          echo $rcode;
        } ?>
      </div>
      <?php if (isset($rcode)) { ?>
        <hr>
        <div>
          <?php echo $lang->get($rcode, '', '', false); ?>
        </div>
      <?php } ?>
    </div>
  </div>

<?php include($tpl_include . 'index_foot' . GK_EXT_TPL);
include($tpl_include . 'html_foot' . GK_EXT_TPL);
