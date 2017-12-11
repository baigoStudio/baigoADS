<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['advert']['main']['title'] . ' &raquo; ' . $this->lang['mod']['page']['stat'],
    'menu_active'    => 'advert',
    'sub_active'     => 'list',
    'baigoCheckall'  => 'true',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'tokenReload'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?mod=advert&" . $this->tplData['query'],
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group clearfix">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills bg-nav-pills">
                    <li <?php if ($this->tplData['search']['type'] == "year") { ?>class="active"<?php } ?>>
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=stat&act=advert&type=year&advert_id=<?php echo $this->tplData['advertRow']['advert_id']; ?>">
                            <?php echo $this->lang['mod']['href']['statYear']; ?>
                        </a>
                    </li>
                    <li <?php if ($this->tplData['search']['type'] == "month") { ?>class="active"<?php } ?>>
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=stat&act=advert&type=month&advert_id=<?php echo $this->tplData['advertRow']['advert_id']; ?>">
                            <?php echo $this->lang['mod']['href']['statMonth']; ?>
                        </a>
                    </li>
                    <li <?php if ($this->tplData['search']['type'] == "day") { ?>class="active"<?php } ?>>
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=stat&act=advert&type=day&advert_id=<?php echo $this->tplData['advertRow']['advert_id']; ?>">
                            <?php echo $this->lang['mod']['href']['statDay']; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pull-right">
            <form name="stat_search" id="stat_search" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get" class="form-inline">
                <input type="hidden" name="mod" value="stat">
                <input type="hidden" name="act" value="advert">
                <input type="hidden" name="type" value="<?php echo $this->tplData['search']['type']; ?>">
                <input type="hidden" name="advert_id" value="<?php echo $this->tplData['advertRow']['advert_id']; ?>">

                <?php switch ($this->tplData['search']['type']) {
                    case "year":
                        $_str_time    = $this->lang['mod']['label']['statYear'];
                        $_str_format  = "Y";
                    break;

                    case "month":
                        $_str_time    = $this->lang['mod']['label']['statMonth'];
                        $_str_format  = "Y-m"; ?>
                        <div class="form-group">
                            <select name="year" class="form-control input-sm">
                                <option value=""><?php echo $this->lang['mod']['option']['allYear']; ?></option>
                                <?php foreach ($this->tplData['yearRows'] as $key=>$value) { ?>
                                    <option <?php if ($this->tplData['search']['year'] == $value['stat_year']) { ?>selected<?php } ?> value="<?php echo $value['stat_year']; ?>"><?php echo $value['stat_year']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </div>
                    <?php break;

                    default:
                        $_str_time    = $this->lang['mod']['label']['statDay'];
                        $_str_format  = "Y-m-d"; ?>
                        <div class="form-group">
                            <select name="year" class="form-control input-sm">
                                <option value=""><?php echo $this->lang['mod']['option']['allYear']; ?></option>
                                <?php foreach ($this->tplData['yearRows'] as $key=>$value) { ?>
                                    <option <?php if ($this->tplData['search']['year'] == $value['stat_year']) { ?>selected<?php } ?> value="<?php echo $value['stat_year']; ?>"><?php echo $value['stat_year']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="month" class="form-control input-sm">
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
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </div>
                    <?php break;
                } ?>
            </form>
        </div>
    </div>

    <div class="well">
        <div class="form-group">
            <label class="control-label"><?php echo $this->lang['mod']['label']['advert']; ?></label>
            <div class="form-control-static">
                <?php if ($this->tplData['advertRow']['posiRow']['posi_type'] == "media" && $this->tplData['advertRow']['advert_media_id'] > 0 && $this->tplData['advertRow']['mediaRow']['rcode'] == "y070102") { ?>
                    <img src="<?php echo $this->tplData['advertRow']['mediaRow']['media_url']; ?>" width="100%">
                <?php } else {
                    echo $this->tplData['advertRow']['advert_content'];
                } ?>
            </div>
        </div>

        <div class="form-group">
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapse_advert">
                <?php echo $this->lang['mod']['btn']['more']; ?>
                <span class="caret"></span>
            </a>
        </div>

        <div class="collapse" id="collapse_advert">

            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['id']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['advertRow']['advert_id']; ?></div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['advertName']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['advertRow']['advert_name']; ?></div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['advertUrl']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['advertRow']['advert_url']; ?></div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['posi']; ?></label>
                        <div class="form-control-static">
                            <?php echo $this->tplData['advertRow']['posiRow']['posi_name']; ?>
                            [
                                <?php echo $this->lang['mod']['type'][$this->tplData['advertRow']['posiRow']['posi_type']]; ?>
                            ]
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['advertBegin']; ?></label>
                        <div class="form-control-static"><?php echo date(BG_SITE_DATE . ' ' . BG_SITE_TIMESHORT, $this->tplData['advertRow']['advert_begin']); ?></div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['status']; ?></label>
                        <div class="form-control-static">
                            <?php advert_status_process($this->tplData['advertRow'], $this->lang['mod']['status'], $this->lang); ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
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

                        default: ?>
                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['advertPutHit']; ?></label>
                                <div class="form-control-static"><?php echo $this->tplData['advertRow']['advert_put_opt']; ?></div>
                            </div>
                        <?php break;
                    } ?>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['advertPercent']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['advertRow']['advert_percent'] * 10; ?>%</div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="control-label">
                            <?php echo $this->lang['mod']['label']['advertShow']; ?> / <?php echo $this->lang['mod']['label']['advertHit']; ?>
                        </label>
                        <div class="form-control-static">
                            <?php echo $this->tplData['advertRow']['advert_count_show']; ?> / <?php echo $this->tplData['advertRow']['advert_count_hit']; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['note']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['advertRow']['advert_note']; ?></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
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
    </div>

    <div class="text-right">
        <?php include($cfg['pathInclude'] . 'page.php'); ?>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php');
include($cfg['pathInclude'] . 'html_foot.php'); ?>