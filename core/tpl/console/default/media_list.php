<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['media']['main']['title'],
    'menu_active'    => 'media',
    'sub_active'     => 'list',
    'baigoCheckall'  => 'true',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    "baigoClear"     => 'true',
    "upload"         => 'true',
    'tokenReload'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . 'index.php?mod=media&' . $this->tplData['query'],
);

include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group clearfix">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills bg-nav-pills">
                    <li <?php if ($this->tplData['search']['box'] == "normal") { ?>class="active"<?php } ?>>
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=media">
                            <?php echo $this->lang['mod']['href']['all']; ?>
                            <span class="badge"><?php echo $this->tplData['mediaCount']['all']; ?></span>
                        </a>
                    </li>
                    <?php if ($this->tplData['mediaCount']['recycle'] > 0) { ?>
                        <li <?php if ($this->tplData['search']['box'] == "recycle") { ?>class="active"<?php } ?>>
                            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=media&box=recycle">
                                <?php echo $this->lang['mod']['href']['recycle']; ?>
                                <span class="badge"><?php echo $this->tplData['mediaCount']['recycle']; ?></span>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=media" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            <?php echo $this->lang['mod']['href']['help']; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pull-right">
            <form name="media_search" id="media_search" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get" class="form-inline">
                <input type="hidden" name="mod" value="media">
                <input type="hidden" name="act" value="list">
                <div class="form-group hidden-sm hidden-xs">
                    <select name="year" class="form-control input-sm">
                        <option value=""><?php echo $this->lang['mod']['option']['allYear']; ?></option>
                        <?php foreach ($this->tplData['yearRows'] as $key=>$value) { ?>
                            <option <?php if ($this->tplData['search']['year'] == $value['media_year']) { ?>selected<?php } ?> value="<?php echo $value['media_year']; ?>"><?php echo $value['media_year']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group hidden-sm hidden-xs">
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
                <div class="form-group hidden-sm hidden-xs">
                    <select name="ext" class="form-control input-sm">
                        <option value=""><?php echo $this->lang['mod']['option']['allExt']; ?></option>
                        <?php foreach ($this->tplData['extRows'] as $key=>$value) { ?>
                            <option <?php if ($this->tplData['search']['ext'] == $value['media_ext']) { ?>selected<?php } ?> value="<?php echo $value['media_ext']; ?>"><?php echo $value['media_ext']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-sm">
                        <input type="text" name="key" class="form-control" value="<?php echo $this->tplData['search']['key']; ?>" placeholder="<?php echo $this->lang['mod']['label']['key']; ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?php include($cfg['pathInclude'] . 'upload.php'); ?>

            <div class="well">
                <?php if ($this->tplData['search']['box'] == "recycle") { ?>
                    <form name="media_empty" id="media_empty">
                        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
                        <input type="hidden" name="act" id="act_empty" value="empty">
                        <div class="form-group">
                            <button type="button" class="btn btn-warning" id="go_empty">
                                <span class="glyphicon glyphicon-trash"></span>
                                <?php echo $this->lang['mod']['btn']['empty']; ?>
                            </button>
                        </div>
                        <div class="form-group">
                            <div class="baigoClear progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped active"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="baigoClearMsg">

                            </div>
                        </div>
                    </form>
                <?php } else { ?>
                    <form name="media_clear" id="media_clear">
                        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
                        <input type="hidden" name="act" id="act_clear" value="clear">
                        <div class="form-group">
                            <button type="button" class="btn btn-warning" id="go_clear">
                                <span class="glyphicon glyphicon-trash"></span>
                                <?php echo $this->lang['mod']['btn']['mediaClear']; ?>
                            </button>
                        </div>
                        <div class="form-group">
                            <div class="baigoClear progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped active"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="baigoClearMsg">

                            </div>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>

        <div class="col-md-9">
            <form name="media_list" id="media_list" class="form-inline">
                <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">

                <div class="panel panel-default">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-nowrap bg-td-xs">
                                        <label for="chk_all" class="checkbox-inline">
                                            <input type="checkbox" name="chk_all" id="chk_all" data-parent="first">
                                            <?php echo $this->lang['mod']['label']['all']; ?>
                                        </label>
                                    </th>
                                    <th class="text-nowrap bg-td-xs"><?php echo $this->lang['mod']['label']['id']; ?></th>
                                    <th><?php echo $this->lang['mod']['label']['mediaInfo']; ?></th>
                                    <th class="text-nowrap bg-td-md"><?php echo $this->lang['mod']['label']['status']; ?> / <?php echo $this->lang['mod']['label']['admin']; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->tplData['mediaRows'] as $key=>$value) {
                                    if ($value['media_box'] == "normal") {
                                        $_css_status = "success";
                                    } else {
                                        $_css_status = "default";
                                    } ?>
                                    <tr>
                                        <td class="text-nowrap bg-td-xs"><input type="checkbox" name="media_ids[]" value="<?php echo $value['media_id']; ?>" id="media_id_<?php echo $value['media_id']; ?>" data-validate="media_id" data-parent="chk_all"></td>
                                        <td class="text-nowrap bg-td-xs"><?php echo $value['media_id']; ?></td>
                                        <td>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <a href="javascript:void(0);" role="button" tabindex="0" data-trigger="focus" data-toggle="popover" data-placement="right" data-content="<a href='<?php echo $value['media_url']; ?>' target='_blank'><img src='<?php echo $value['media_url']; ?>' class='img-responsive'></a>"><?php echo $value['media_name']; ?></a>
                                                </li>
                                                <li>
                                                    <abbr data-toggle="tooltip" data-placement="bottom" title="<?php echo date(BG_SITE_DATE . ' ' . BG_SITE_TIME, $value['media_time']); ?>"><?php echo date(BG_SITE_DATE, $value['media_time']); ?></abbr>
                                                </li>
                                                <?php if ($value['media_size'] > 1024) {
                                                    $_num_mediaSize = $value['media_size'] / 1024;
                                                    $_str_mediaUnit = "KB";
                                                } else if ($value['media_size'] > 1024 * 1024) {
                                                    $_num_mediaSize = $value['media_size'] / 1024 / 1024;
                                                    $_str_mediaUnit = "MB";
                                                } else if ($value['media_size'] > 1024 * 1024 * 1024) {
                                                    $_num_mediaSize = $value['media_size'] / 1024 / 1024 / 1024;
                                                    $_str_mediaUnit = "GB";
                                                } else {
                                                    $_num_mediaSize = $value['media_size'];
                                                    $_str_mediaUnit = "B";
                                                } ?>
                                                <li>
                                                    <?php echo number_format($_num_mediaSize, 2); ?>
                                                    <?php echo $_str_mediaUnit; ?>
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="text-nowrap bg-td-md">
                                            <ul class="list-unstyled">
                                                <li>
                                                    <span class="label label-<?php echo $_css_status; ?> bg-label"><?php echo $this->lang['mod']['label'][$value['media_box']]; ?></span>
                                                </li>
                                                <li>
                                                    <?php if (isset($value['adminRow']['admin_name'])) { ?>
                                                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=media&admin_id=<?php echo $value['media_admin_id']; ?>"><?php echo $value['adminRow']['admin_name']; ?></a>
                                                    <?php } else {
                                                        echo $this->lang['mod']['label']['unknown'];
                                                    } ?>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                        <span id="msg_media_id"></span>
                                    </td>
                                    <td colspan="3">
                                        <div class="bg-submit-box"></div>

                                        <div class="form-group">
                                            <div id="group_act">
                                                <select name="act" id="act" data-validate class="form-control input-sm">
                                                    <option value=""><?php echo $this->lang['mod']['option']['batch']; ?></option>
                                                    <?php if ($this->tplData['search']['box'] == "recycle") { ?>
                                                        <option value="normal"><?php echo $this->lang['mod']['option']['revert']; ?></option>
                                                        <option value="del"><?php echo $this->lang['mod']['option']['del']; ?></option>
                                                    <?php } else { ?>
                                                        <option value="recycle"><?php echo $this->lang['mod']['option']['recycle']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-sm bg-submit"><?php echo $this->lang['mod']['btn']['submit']; ?></button>
                                        </div>
                                        <div class="form-group">
                                            <span id="msg_act"></span>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </form>

            <div class="text-right">
                <?php include($cfg['pathInclude'] . 'page.php'); ?>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_list = {
        media_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='media_id']", type: "checkbox" },
            msg: { selector: "#msg_media_id", too_few: "<?php echo $this->lang['rcode']['x030202']; ?>" }
        },
        act: {
            len: { min: 1, "max": 0 },
            validate: { type: "select", group: "#group_act" },
            msg: { selector: "#msg_act", too_few: "<?php echo $this->lang['rcode']['x030203']; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=media",
        confirm: {
            selector: "#act",
            val: "del",
            msg: "<?php echo $this->lang['mod']['confirm']['del']; ?>"
        },
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    var opts_empty = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=media",
        confirm: {
            selector: "#act_empty",
            val: "empty",
            msg: "<?php echo $this->lang['mod']['confirm']['empty']; ?>",
        },
        msg: {
            loading: "<?php echo $this->lang['rcode']['x070408']; ?>",
            complete: "<?php echo $this->lang['rcode']['y070408']; ?>"
        }
    };

    var opts_clear = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=media",
        confirm: {
            selector: "#act_clear",
            val: "clear",
            msg: "<?php echo $this->lang['mod']['confirm']['clear']; ?>"
        },
        msg: {
            loading: "<?php echo $this->lang['rcode']['x070407']; ?>",
            complete: "<?php echo $this->lang['rcode']['y070407']; ?>"
        }
    };


    $(document).ready(function(){
        var obj_validate_list = $("#media_list").baigoValidator(opts_validator_list);
        var obj_submit_list   = $("#media_list").baigoSubmit(opts_submit_list);
        $(".bg-submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        var obj_empty = $("#media_empty").baigoClear(opts_empty);
        $("#go_empty").click(function(){
            obj_empty.clearSubmit();
        });
        var obj_clear  = $("#media_clear").baigoClear(opts_clear);
        $("#go_clear").click(function(){
            obj_clear.clearSubmit();
        });
        $("#media_list").baigoCheckall();
        $("[data-toggle='tooltip']").tooltip({
            html: true
        });
        $("[data-toggle='popover']").popover({
            html: true
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>