  <?php
  if (!isset($arr_pmRow)) {
    $arr_pmRow = array(
      'pm_status'         => 'wait',
      'pm_send_status'    => 'wait',
    );
  }

  $_bold_begin    = '';
  $_bold_end      = '';
  $_str_status    = '';
  $_str_color     = '';

  if ($search_type == 'in') {
    if ($arr_pmRow['pm_status'] == 'wait') {
      $_bold_begin    = '<strong>';
      $_bold_end      = '</strong>';
      $_str_color     = 'warning';
    } else {
      $_str_color     = 'success';
    }

    $_str_status = $arr_pmRow['pm_status'];
  } else {
    switch ($arr_pmRow['pm_send_status']) {
      case 'wait':
        $_bold_begin    = '<strong>';
        $_bold_end      = '</strong>';
        $_str_color     = 'warning';
        $_str_status    = $arr_pmRow['pm_send_status'];
      break;

      case 'revoke':
        $_str_status    = 'revoke';
        $_str_color     = 'secondary';
      break;

      default:
        $_str_color     = 'success';
        $_str_status    = $arr_pmRow['pm_send_status'];
      break;
    }
  }

  ?><span class="badge badge-<?php echo $_str_color; ?>"><?php echo $_bold_begin, $lang->get($_str_status), $_bold_end; ?></span>
