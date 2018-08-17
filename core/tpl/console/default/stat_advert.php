<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['advert']['main']['title'] . ' &raquo; ' . $this->lang['mod']['page']['stat'],
    'menu_active'    => 'advert',
    'sub_active'     => 'list',
    'baigoCheckall'  => 'true',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'tokenReload'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?m=advert&" . $this->tplData['query'],
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="clearfix mb-3">
        <div class="float-left">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=stat&a=advert&type=year&advert_id=<?php echo $this->tplData['advertRow']['advert_id']; ?>" class="nav-link<?php if ($this->tplData['search']['type'] == 'year') { ?> active<?php } ?>">
                        <?php echo $this->lang['mod']['href']['statYear']; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=stat&a=advert&type=month&advert_id=<?php echo $this->tplData['advertRow']['advert_id']; ?>" class="nav-link<?php if ($this->tplData['search']['type'] == 'month') { ?> active<?php } ?>">
                        <?php echo $this->lang['mod']['href']['statMonth']; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=stat&a=advert&type=day&advert_id=<?php echo $this->tplData['advertRow']['advert_id']; ?>" class="nav-link<?php if ($this->tplData['search']['type'] == 'day') { ?> active<?php } ?>">
                        <?php echo $this->lang['mod']['href']['statDay']; ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="float-right">
            <form name="stat_search" id="stat_search" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get">
                <input type="hidden" name="m" value="stat">
                <input type="hidden" name="a" value="advert">
                <input type="hidden" name="type" value="<?php echo $this->tplData['search']['type']; ?>">
                <input type="hidden" name="advert_id" value="<?php echo $this->tplData['advertRow']['advert_id']; ?>">
                <div class="input-group">
                    <?php switch ($this->tplData['search']['type']) {
                        case 'year':
                            $_str_time    = $this->lang['mod']['label']['statYear'];
                            $_str_format  = "Y";
                        break;

                        case 'month':
                            $_str_time    = $this->lang['mod']['label']['statMonth'];
                            $_str_format  = "Y-m"; ?>
                            <select name="year" class="custom-select">
                                <option value=""><?php echo $this->lang['mod']['option']['allYear']; ?></option>
                                <?php foreach ($this->tplData['yearRows'] as $key=>$value) { ?>
                                    <option <?php if ($this->tplData['search']['year'] == $value['stat_year']) { ?>selected<?php } ?> value="<?php echo $value['stat_year']; ?>"><?php echo $value['stat_year']; ?></option>
                                <?php } ?>
                            </select>
                        <?php break;

                        default:
                            $_str_time    = $this->lang['mod']['label']['statDay'];
                            $_str_format  = "Y-m-d"; ?>
                            <select name="year" class="custom-select">
                                <option value=""><?php echo $this->lang['mod']['option']['allYear']; ?></option>
                                <?php foreach ($this->tplData['yearRows'] as $key=>$value) { ?>
                                    <option <?php if ($this->tplData['search']['year'] == $value['stat_year']) { ?>selected<?php } ?> value="<?php echo $value['stat_year']; ?>"><?php echo $value['stat_year']; ?></option>
                                <?php } ?>
                            </select>
                            <select name="month" class="custom-select">
                                <option value=""><?php echo $this->lang['mod']['option']['allMonth']; ?></option>
                                <?php for ($_iii = 1; $_iii <= 12; $_iii++) {
                                    if ($_iii < 10) {
                                        $_str_month = "0" . $_iii;
                                    } else {
                                        $_str_month = $_iii;
                                    } ?>
                                    <option <?php if ($this->tplData['search']['month'] == $_str_month) { ?>selected<?php } ?> value="<?php echo $_str_month; ?>"><?php echo $_str_month; ?></option>
                                <?php } ?>
                            </select>
                        <?php break;
                    }

                    switch ($this->tplData['search']['type']) {
                        case 'year':

                        break;

                        default: ?>
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-secondary">
                                    <span class="oi oi-magnifying-glass"></span>
                                </button>
                            </span>
                        <?php break;
                    } ?>
                </div>
            </form>
        </div>
    </div>

    <div class="alert alert-warning mb-3">
        <div class="form-group">
            <label><?php echo $this->lang['mod']['label']['advert']; ?></label>
            <div class="form-text">
                <?php if ($this->tplData['advertRow']['posiRow']['posi_type'] == 'attach' && $this->tplData['advertRow']['advert_attach_id'] > 0 && $this->tplData['advertRow']['attachRow']['rcode'] == "y070102") { ?>
                    <img src="<?php echo $this->tplData['advertRow']['attachRow']['attach_url']; ?>" width="img-fluid">
                <?php } else {
                    echo $this->tplData['advertRow']['advert_content'];
                } ?>
            </div>
        </div>

        <div class="form-group">
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapse_advert">
                <?php echo $this->lang['mod']['btn']['more']; ?>
                <span class="oi oi-chevron-bottom"></span>
            </a>
        </div>

        <div class="collapse" id="collapse_advert">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['advertRow']['advert_id']; ?></div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['advertName']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['advertRow']['advert_name']; ?></div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['advertUrl']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['advertRow']['advert_url']; ?></div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['advertBegin']; ?></label>
                        <div class="form-text"><?php echo date(BG_SITE_DATE . ' ' . BG_SITE_TIMESHORT, $this->tplData['advertRow']['advert_begin']); ?></div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['status']; ?></label>
                        <div class="form-text">
                            <?php advert_status_process($this->tplData['advertRow'], $this->lang['mod']['status'], $this->lang); ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
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

                        default: ?>
                            <div class="form-group">
                                <label><?php echo $this->lang['mod']['label']['advertPutHit']; ?></label>
                                <div class="form-text"><?php echo $this->tplData['advertRow']['advert_put_opt']; ?></div>
                            </div>
                        <?php break;
                    } ?>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['advertPercent']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['advertRow']['advert_percent'] * 10; ?>%</div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang['mod']['label']['advertShow']; ?> / <?php echo $this->lang['mod']['label']['advertHit']; ?>
                        </label>
                        <div class="form-text">
                            <?php echo $this->tplData['advertRow']['advert_count_show']; ?> / <?php echo $this->tplData['advertRow']['advert_count_hit']; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['note']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['advertRow']['advert_note']; ?></div>
                    </div>
                </div>
            </div>

            <hr>
            <h5 class="mb-3"><?php echo $this->lang['mod']['label']['posi']; ?></h5>

            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                        <div class="form-text">
                            <?php echo $this->tplData['advertRow']['posiRow']['posi_id']; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['posiName']; ?></label>
                        <div class="form-text">
                            <?php echo $this->tplData['advertRow']['posiRow']['posi_name']; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['contentType']; ?></label>
                        <div class="form-text">
                            <?php echo $this->lang['mod']['type'][$this->tplData['advertRow']['posiRow']['posi_type']]; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover border">
            <thead>
                <tr>
                    <th><?php echo $_str_time; ?></th>
                    <th><?php echo $this->lang['mod']['label']['advertStatShow']; ?></th>
                    <th><?php echo $this->lang['mod']['label']['advertStatHit']; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->tplData['statRows'] as $key=>$value) { ?>
                    <tr>
                        <td>
                            <?php echo date($_str_format, $value['stat_time']); ?>
                        </td>
                        <td>
                            <?php echo $value['stat_count_show']; ?>
                        </td>
                        <td>
                            <?php echo $value['stat_count_hit']; ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="text-right mt-3">
        <?php include($cfg['pathInclude'] . 'page.php'); ?>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php');
include($cfg['pathInclude'] . 'html_foot.php');