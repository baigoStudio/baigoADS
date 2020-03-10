    <?php
    if (!isset($lang)) {
        $lang = '';
    }

    if (!isset($str_status)) {
        $str_status = '';
    }

    switch ($str_status) {
        case 'error':
            $_str_css = 'danger';
        break;

        case 'wait':
            $_str_css = 'warning';
        break;

        case 'exists':
        case 'normal':
        case 'enable':
        case 'read':
        case 'show':
        case 'pub':
            $_str_css = 'success';
        break;

        case 'store':
        case 'on':
            $_str_css = 'info';
        break;

        default:
            $_str_css = 'secondary';
        break;
    }
    ?><span class="badge badge-<?php echo $_str_css; ?>"><?php echo $lang->get($str_status); ?></span>

