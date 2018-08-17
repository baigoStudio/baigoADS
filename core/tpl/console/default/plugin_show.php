<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['plugin']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['plugin']['sub']['list'] . ' &raquo; ' . $this->lang['mod']['page']['show'],
    'menu_active'    => 'plugin',
    'sub_active'     => 'list',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?m=plugin"
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=plugin&a=list" class="nav-link">
                <span class="oi oi-chevron-left"></span>
                <?php echo $this->lang['common']['href']['back']; ?>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo BG_URL_HELP; ?>index.php?m=console&a=plugin#form" class="nav-link" target="_blank">
                <span class="badge badge-pill badge-primary">
                    <span class="oi oi-question-mark"></span>
                </span>
                <?php echo $this->lang['mod']['href']['help']; ?>
            </a>
        </li>
    </ul>

    <div class="row">
        <div class="col-md-9">
            <div class="card mb-3 mb-lg-0">
                <?php include($cfg['pathInclude'] . 'plugin_menu.php'); ?>
                <div class="card-body">
                    <?php echo $this->lang['mod']['label']['installed']; ?>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['pluginRow']['plugin_id']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['status']; ?></label>
                        <div class="form-text">
                            <?php plugin_status_process($this->tplData['pluginRow']['plugin_status'], $this->lang['mod']['status']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['pluginDir']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['pluginRow']['plugin_dir']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['note']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['pluginRow']['plugin_note']; ?></div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=plugin&a=form&plugin_id=<?php echo $this->tplData['pluginRow']['plugin_id']; ?>">
                        <span class="oi oi-pencil"></span>
                        <?php echo $this->lang['mod']['href']['edit']; ?>
                    </a>
                </div>
            </div>
        </div>

        <?php include($cfg['pathInclude'] . 'plugin_side.php'); ?>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php');
include('include' . DS . 'html_foot.php');