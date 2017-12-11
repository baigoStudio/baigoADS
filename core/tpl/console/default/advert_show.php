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
    'str_url'        => BG_URL_CONSOLE . "index.php?mod=advert",
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=advert&act=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <?php echo $this->lang['common']['href']['back']; ?>
                </a>
            </li>
            <li>
                <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=advert#form" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    <?php echo $this->lang['mod']['href']['help']; ?>
                </a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['advertName']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['advertRow']['advert_name']; ?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['advertUrl']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['advertRow']['advert_url']; ?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['posi']; ?></label>
                        <div class="form-control-static">
                            <?php echo $this->tplData['advertRow']['posiRow']['posi_name']; ?>
                            [ <?php echo $this->lang['mod']['type'][$this->tplData['advertRow']['posiRow']['posi_type']]; ?> ]
                        </div>
                    </div>

                    <?php if ($this->tplData['advertRow']['posiRow']['posi_type'] == "media" && $this->tplData['advertRow']['advert_media_id'] > 0 && $this->tplData['advertRow']['mediaRow']['rcode'] == "y070102") { ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['advertMedia']; ?></label>
                            <div class="form-control-static">
                                <img src="<?php echo $this->tplData['advertRow']['mediaRow']['media_url']; ?>" width="100%">
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['advertContent']; ?></label>
                            <div class="form-control-static"><?php echo $this->tplData['advertRow']['advert_content']; ?></div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['advertBegin']; ?></label>
                        <div class="form-control-static"><?php echo date(BG_SITE_DATE . ' ' . BG_SITE_TIMESHORT, $this->tplData['advertRow']['advert_begin']); ?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['note']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['advertRow']['advert_note']; ?></div>
                    </div>

                    <div class="form-group">
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=advert&act=form&advert_id=<?php echo $this->tplData['advertRow']['advert_id']; ?>">
                            <span class="glyphicon glyphicon-edit"></span>
                            <?php echo $this->lang['mod']['href']['edit']; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="well">
                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['id']; ?></label>
                    <div class="form-control-static"><?php echo $this->tplData['advertRow']['advert_id']; ?></div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['status']; ?></label>
                    <div class="form-control-static">
                        <?php advert_status_process($this->tplData['advertRow'], $this->lang['mod']['status'], $this->lang); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['advertPutType']; ?></label>
                    <div class="form-control-static"><?php echo $this->lang['mod']['putType'][$this->tplData['advertRow']['advert_put_type']]; ?></div>
                </div>

                <?php switch ($this->tplData['advertRow']['advert_put_type']) {
                    case "date": ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['advertPutDate']; ?></label>
                            <div class="form-control-static"><?php echo date(BG_SITE_DATE . ' ' . BG_SITE_TIMESHORT, $this->tplData['advertRow']['advert_put_opt']); ?></div>
                        </div>
                    <?php break;

                    case "show": ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['advertPutShow']; ?></label>
                            <div class="form-control-static"><?php echo $this->tplData['advertRow']['advert_put_opt']; ?></div>
                        </div>
                    <?php break;

                    case "hit": ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['advertPutHit']; ?></label>
                            <div class="form-control-static"><?php echo $this->tplData['advertRow']['advert_put_opt']; ?></div>
                        </div>
                    <?php break;
                } ?>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['advertPercent']; ?></label>
                    <div class="form-control-static"><?php echo $this->tplData['advertRow']['advert_percent'] * 10; ?>%</div>
                </div>

                <div class="form-group">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=advert&act=form&advert_id=<?php echo $this->tplData['advertRow']['advert_id']; ?>">
                        <span class="glyphicon glyphicon-edit"></span>
                        <?php echo $this->lang['mod']['href']['edit']; ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php');
include($cfg['pathInclude'] . 'html_foot.php'); ?>
