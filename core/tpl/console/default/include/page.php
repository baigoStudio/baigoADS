    <ul class="pagination pagination-sm">
        <?php if ($this->tplData['pageRow']['page'] > 1) { ?>
            <li>
                <a href="<?php echo $cfg['str_url']; ?>&page=1" title="<?php echo $this->lang['common']['href']['pageFirst']; ?>"><?php echo $this->lang['common']['href']['pageFirst']; ?></a>
            </li>
        <?php }

        if ($this->tplData['pageRow']['p'] * 10 > 0) { ?>
            <li>
                <a href="<?php echo $cfg['str_url']; ?>&page=<?php echo $this->tplData['pageRow']['p'] * 10; ?>" title="<?php echo $this->lang['common']['href']['pagePrevList']; ?>">...</a>
            </li>
        <?php } ?>

        <li class="<?php if ($this->tplData['pageRow']['page'] <= 1) { ?>disabled<?php } ?>">
            <?php if ($this->tplData['pageRow']['page'] <= 1) { ?>
                <span title="<?php echo $this->lang['common']['href']['pagePrev']; ?>"><span class="glyphicon glyphicon-menu-left"></span></span>
            <?php } else { ?>
                <a href="<?php echo $cfg['str_url']; ?>&page=<?php echo $this->tplData['pageRow']['page'] - 1; ?>" title="<?php echo $this->lang['common']['href']['pagePrev']; ?>"><span class="glyphicon glyphicon-menu-left"></span></a>
            <?php } ?>
        </li>

        <?php for ($_iii = $this->tplData['pageRow']['begin']; $_iii <= $this->tplData['pageRow']['end']; $_iii++) { ?>
            <li class="<?php if ($_iii == $this->tplData['pageRow']['page']) { ?>active<?php } ?>">
                <?php if ($_iii == $this->tplData['pageRow']['page']) { ?>
                    <span><?php echo $_iii; ?></span>
                <?php } else { ?>
                    <a href="<?php echo $cfg['str_url']; ?>&page=<?php echo $_iii; ?>" title="<?php echo $_iii; ?>"><?php echo $_iii; ?></a>
                <?php } ?>
            </li>
        <?php } ?>

        <li class="<?php if ($this->tplData['pageRow']['page'] >= $this->tplData['pageRow']['total']) { ?>disabled<?php } ?>">
            <?php if ($this->tplData['pageRow']['page'] >= $this->tplData['pageRow']['total']) { ?>
                <span title="<?php echo $this->lang['common']['href']['pageNext']; ?>"><span class="glyphicon glyphicon-menu-right"></span></span>
            <?php } else { ?>
                <a href="<?php echo $cfg['str_url']; ?>&page=<?php echo $this->tplData['pageRow']['page'] + 1; ?>" title="<?php echo $this->lang['common']['href']['pageNext']; ?>"><span class="glyphicon glyphicon-menu-right"></span></a>
            <?php } ?>
        </li>

        <?php if ($_iii < $this->tplData['pageRow']['total']) { ?>
            <li>
                <a href="<?php echo $cfg['str_url']; ?>&page=<?php echo $_iii; ?>" title="<?php echo $this->lang['common']['href']['pageNextList']; ?>">...</a>
            </li>
        <?php }

        if ($this->tplData['pageRow']['page'] < $this->tplData['pageRow']['total']) { ?>
            <li>
                <a href="<?php echo $cfg['str_url']; ?>&page=<?php echo $this->tplData['pageRow']['total']; ?>" title="<?php echo $this->lang['common']['href']['pageLast']; ?>"><?php echo $this->lang['common']['href']['pageLast']; ?></a>
            </li>
        <?php } ?>
    </ul>
