                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=pm&a=send" class="nav-link<?php if ($GLOBALS['route']['bg_act'] == 'send') { ?> active<?php } ?>">
                            <span class="oi oi-pencil"></span>
                            <?php echo $this->lang['common']['href']['pmNew']; ?>
                        </a>
                    </li>
                    <?php foreach ($this->pm['type'] as $key=>$value) {
                        if ($value == 'in') {
                            $icon_type = "inbox";
                        } else {
                            $icon_type = "cloud-upload";
                        } ?>
                        <li class="nav-item">
                            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=pm&a=list&type=<?php echo $value; ?>" class="nav-link<?php if (isset($this->tplData['search']['type']) && $this->tplData['search']['type'] == $value) { ?> active<?php } ?>">
                                <span class="oi oi-<?php echo $icon_type; ?>"></span>
                                <?php if (isset($this->lang['common']['pm'][$value])) {
                                    echo $this->lang['common']['pm'][$value];
                                } else {
                                    echo $value;
                                } ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
