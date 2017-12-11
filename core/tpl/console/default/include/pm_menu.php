            <div class="form-group">
                <ul class="nav nav-pills bg-nav-pills">
                    <li<?php if ($GLOBALS['route']['bg_act'] == "send") { ?> class="active"<?php } ?>>
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=pm&act=send">
                            <span class="glyphicon glyphicon-edit"></span>
                            <?php echo $this->lang['mod']['href']['send']; ?>
                        </a>
                    </li>
                    <?php foreach ($this->pm['type'] as $key=>$value) {
                        if ($key == "in") {
                            $icon_type = "inbox";
                        } else {
                            $icon_type = "send";
                        } ?>
                        <li<?php if (isset($this->tplData['search']['type']) && $this->tplData['search']['type'] == $key) { ?> class="active"<?php } ?>>
                            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=pm&act=list&type=<?php echo $key; ?>">
                                <span class="glyphicon glyphicon-<?php echo $icon_type; ?>"></span>
                                <?php if (isset($this->lang['common']['pm'][$value])) {
                                    echo $this->lang['common']['pm'][$value];
                                } else {
                                    echo $value;
                                } ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>