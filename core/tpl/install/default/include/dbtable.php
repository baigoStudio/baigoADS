    <ul class="list-group list-group-flush bg-list-group mb-3">
        <?php foreach ($this->tplData['db_rcode'] as $key=>$value) {
            if ($value['status'] == 'y') {
                $str_css   = 'success';
                $str_icon  = 'circle-check';
            } else {
                $str_css   = 'danger';
                $str_icon  = 'circle-x';
            } ?>
            <li class="list-group-item d-flex justify-content-between">
                <span>
                    <span class="oi oi-<?php echo $str_icon; ?> text-<?php echo $str_css; ?>"></span>
                    <?php echo $this->lang['rcode'][$value['rcode']]; ?>
                </span>
                <span class="badge badge-<?php echo $str_css; ?>">
                    <?php echo $value['rcode']; ?>
                </span>
            </li>
        <?php } ?>
    </ul>