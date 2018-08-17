<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['advert']['main']['title'] . ' &raquo; ' . $this->lang['mod']['page']['show'],
    'menu_active'    => 'advert',
    'sub_active'     => 'list',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'tokenReload'    => 'true',
    "datepicker"     => 'true',
    "upload"         => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?m=advert",
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=advert&a=list" class="nav-link">
                <span class="oi oi-chevron-left"></span>
                <?php echo $this->lang['common']['href']['back']; ?>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo BG_URL_HELP; ?>index.php?m=console&a=advert#form" class="nav-link" target="_blank">
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
                <div class="card-body">
                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['advertName']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['advertRow']['advert_name']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['advertUrl']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['advertRow']['advert_url']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['posi']; ?></label>
                        <div class="form-text">
                            <?php echo $this->tplData['advertRow']['posiRow']['posi_name']; ?>
                            [ <?php echo $this->lang['mod']['type'][$this->tplData['advertRow']['posiRow']['posi_type']]; ?> ]
                        </div>
                    </div>

                    <?php if ($this->tplData['advertRow']['posiRow']['posi_type'] == 'attach' && $this->tplData['advertRow']['advert_attach_id'] > 0 && $this->tplData['advertRow']['attachRow']['rcode'] == "y070102") { ?>
                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['advertAttach']; ?></label>
                            <div class="form-text">
                                <img src="<?php echo $this->tplData['advertRow']['attachRow']['attach_url']; ?>" width="100%">
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['advertContent']; ?></label>
                            <div class="form-text"><?php echo $this->tplData['advertRow']['advert_content']; ?></div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['advertBegin']; ?></label>
                        <div class="form-text"><?php echo date(BG_SITE_DATE . ' ' . BG_SITE_TIMESHORT, $this->tplData['advertRow']['advert_begin']); ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['note']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['advertRow']['advert_note']; ?></div>
                    </div>

                    <div class="form-group">
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=advert&a=form&advert_id=<?php echo $this->tplData['advertRow']['advert_id']; ?>">
                            <span class="oi oi-pencil"></span>
                            <?php echo $this->lang['mod']['href']['edit']; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                    <div class="form-text"><?php echo $this->tplData['advertRow']['advert_id']; ?></div>
                </div>

                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['status']; ?></label>
                    <div class="form-text">
                        <?php advert_status_process($this->tplData['advertRow'], $this->lang['mod']['status'], $this->lang); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['advertPutType']; ?></label>
                    <div class="form-text"><?php echo $this->lang['mod']['putType'][$this->tplData['advertRow']['advert_put_type']]; ?></div>
                </div>

                <?php switch ($this->tplData['advertRow']['advert_put_type']) {
                    case "date": ?>
                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['advertPutDate']; ?></label>
                            <div class="form-text"><?php echo date(BG_SITE_DATE . ' ' . BG_SITE_TIMESHORT, $this->tplData['advertRow']['advert_put_opt']); ?></div>
                        </div>
                    <?php break;

                    case "show": ?>
                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['advertPutShow']; ?></label>
                            <div class="form-text"><?php echo $this->tplData['advertRow']['advert_put_opt']; ?></div>
                        </div>
                    <?php break;

                    case "hit": ?>
                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['advertPutHit']; ?></label>
                            <div class="form-text"><?php echo $this->tplData['advertRow']['advert_put_opt']; ?></div>
                        </div>
                    <?php break;
                } ?>

                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['advertPercent']; ?></label>
                    <div class="form-text"><?php echo $this->tplData['advertRow']['advert_percent'] * 10; ?>%</div>
                </div>

                <div class="form-group">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=advert&a=form&advert_id=<?php echo $this->tplData['advertRow']['advert_id']; ?>">
                        <span class="oi oi-pencil"></span>
                        <?php echo $this->lang['mod']['href']['edit']; ?>
                    </a>
                </div>
            </div>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php');
include($cfg['pathInclude'] . 'html_foot.php');
