    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=plugin&a=form&plugin_id=<?php echo $this->tplData['pluginRow']['plugin_id']; ?>" class="nav-link<?php if ($GLOBALS['route']['bg_act'] == 'form') { ?> active<?php } ?>">
                    <span class="oi oi-pencil"></span>
                    <?php echo $this->lang['mod']['href']['edit']; ?>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=plugin&a=opt&plugin_id=<?php echo $this->tplData['pluginRow']['plugin_id']; ?>" class="nav-link<?php if ($GLOBALS['route']['bg_act'] == 'opt') { ?> active<?php } ?>">
                    <span class="oi oi-wrench"></span>
                    <?php echo $this->lang['mod']['href']['opt']; ?>
                </a>
            </li>
        </ul>
    </div>