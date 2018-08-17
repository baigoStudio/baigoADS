            </div>
        </div>
    </div>

    <footer class="container-fluid bg-secondary text-light p-3 clearfix mt-3">
        <div class="float-left">
            <img class="img-fluid" src="<?php echo BG_URL_STATIC; ?>console/<?php echo BG_DEFAULT_UI; ?>/image/logo.png">
        </div>
        <div class="float-right">
            <?php echo PRD_ADS_POWERED, ' ';
            if (BG_DEFAULT_UI == 'default') { ?>
                <a href="<?php echo PRD_ADS_URL; ?>" class="text-light" target="_blank"><?php echo PRD_ADS_NAME; ?></a>
            <?php } else {
                echo BG_DEFAULT_UI, ' ADS ';
            }
            echo PRD_ADS_VER; ?>
        </div>
    </footer>