    <ul class="pagination">
        <?php if ($this->tplData['pageRow']['page'] > 1) { ?>
            <li class="page-item">
                <a href="<?php echo $cfg['str_url']; ?>&page=1" title="<?php echo $this->lang['common']['href']['pageFirst']; ?>" class="page-link"><?php echo $this->lang['common']['href']['pageFirst']; ?></a>
            </li>
        <?php }

        if ($this->tplData['pageRow']['p'] * 10 > 0) { ?>
            <li class="page-item">
                <a href="<?php echo $cfg['str_url']; ?>&page=<?php echo $this->tplData['pageRow']['p'] * 10; ?>" title="<?php echo $this->lang['common']['href']['pagePrevList']; ?>" class="page-link">...</a>
            </li>
        <?php } ?>

        <li class="page-item<?php if ($this->tplData['pageRow']['page'] <= 1) { ?> disabled<?php } ?>">
            <?php if ($this->tplData['pageRow']['page'] <= 1) { ?>
                <span title="<?php echo $this->lang['common']['href']['pagePrev']; ?>" class="page-link"><span class="oi oi-chevron-left"></span></span>
            <?php } else { ?>
                <a href="<?php echo $cfg['str_url']; ?>&page=<?php echo $this->tplData['pageRow']['page'] - 1; ?>" title="<?php echo $this->lang['common']['href']['pagePrev']; ?>" class="page-link"><span class="oi oi-chevron-left"></span></a>
            <?php } ?>
        </li>

        <?php for ($_iii = $this->tplData['pageRow']['begin']; $_iii <= $this->tplData['pageRow']['end']; $_iii++) { ?>
            <li class="page-item<?php if ($_iii == $this->tplData['pageRow']['page']) { ?> active<?php } ?>">
                <?php if ($_iii == $this->tplData['pageRow']['page']) { ?>
                    <span class="page-link"><?php echo $_iii; ?></span>
                <?php } else { ?>
                    <a href="<?php echo $cfg['str_url']; ?>&page=<?php echo $_iii; ?>" title="<?php echo $_iii; ?>" class="page-link"><?php echo $_iii; ?></a>
                <?php } ?>
            </li>
        <?php } ?>

        <li class="page-item<?php if ($this->tplData['pageRow']['page'] >= $this->tplData['pageRow']['total']) { ?> disabled<?php } ?>">
            <?php if ($this->tplData['pageRow']['page'] >= $this->tplData['pageRow']['total']) { ?>
                <span title="<?php echo $this->lang['common']['href']['pageNext']; ?>" class="page-link"><span class="oi oi-chevron-right"></span></span>
            <?php } else { ?>
                <a href="<?php echo $cfg['str_url']; ?>&page=<?php echo $this->tplData['pageRow']['page'] + 1; ?>" title="<?php echo $this->lang['common']['href']['pageNext']; ?>" class="page-link"><span class="oi oi-chevron-right"></span></a>
            <?php } ?>
        </li>

        <?php if ($_iii < $this->tplData['pageRow']['total']) { ?>
            <li class="page-item">
                <a href="<?php echo $cfg['str_url']; ?>&page=<?php echo $_iii; ?>" title="<?php echo $this->lang['common']['href']['pageNextList']; ?>" class="page-link">...</a>
            </li>
        <?php }

        if ($this->tplData['pageRow']['page'] < $this->tplData['pageRow']['total']) { ?>
            <li class="page-item">
                <a href="<?php echo $cfg['str_url']; ?>&page=<?php echo $this->tplData['pageRow']['total']; ?>" title="<?php echo $this->lang['common']['href']['pageLast']; ?>" class="page-link"><?php echo $this->lang['common']['href']['pageLast']; ?></a>
            </li>
        <?php } ?>
    </ul>
