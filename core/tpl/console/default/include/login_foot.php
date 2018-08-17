                </div>
                <div class="card-footer clearfix">
                    <div class="float-left">
                        <ul class="bg-nav-line">
                            <?php if (isset($cfg['active']) && $cfg['active'] == "login") { ?>
                                <li>
                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=forgot"><?php echo $this->lang['mod']['href']['forgot']; ?></a>
                                </li>
                            <?php } else { ?>
                                <li>
                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php"><?php echo $this->lang['mod']['href']['login']; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>

                    <div class="float-right">
                        <a href="<?php echo BG_URL_HELP; ?>index.php" target="_blank">
                            <span class="badge badge-pill badge-primary">
                                <span class="oi oi-question-mark"></span>
                            </span>
                            <?php echo $this->lang['mod']['href']['help']; ?>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-3 text-right">
                <?php echo PRD_ADS_POWERED, ' ';
                if (BG_DEFAULT_UI == 'default') { ?>
                    <a href="<?php echo PRD_ADS_URL; ?>" target="_blank"><?php echo PRD_ADS_NAME; ?></a>
                <?php } else {
                    echo BG_DEFAULT_UI, ' ADS ';
                }
                echo PRD_ADS_VER; ?>
            </div>
        </div>
    </div>
