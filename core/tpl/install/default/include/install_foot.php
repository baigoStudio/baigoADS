            </div>

            <div class="clearfix mt-3">
                <div class="float-left">
                    <?php echo PRD_ADS_POWERED, ' ';
                    if (BG_DEFAULT_UI == 'default') { ?>
                        <a href="<?php echo PRD_ADS_URL; ?>" target="_blank"><?php echo PRD_ADS_NAME; ?></a>
                    <?php } else {
                        echo BG_DEFAULT_UI, ' ADS ';
                    }
                    echo PRD_ADS_VER; ?>
                </div>
                <div class="float-right">
                    <a href="<?php echo BG_URL_HELP; ?>index.php?m=<?php echo $cfg['mod_help']; ?>&a=<?php echo $cfg['act_help']; ?>" target="_blank">
                        <span class="badge badge-pill badge-primary">
                            <span class="oi oi-question-mark"></span>
                        </span>
                        <?php echo $this->lang['mod']['href']['help']; ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
