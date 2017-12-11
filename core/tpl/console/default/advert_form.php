<?php if ($this->tplData['advertRow']['advert_id'] < 1) {
    $title_sub = $this->lang['mod']['page']['add'];
    $str_sub = "form";
} else {
    $title_sub = $this->lang['mod']['page']['edit'];
    $str_sub = "list";
}

$cfg = array(
    'title'          => $this->lang['consoleMod']['advert']['main']['title'] . ' &raquo; ' . $title_sub,
    'menu_active'    => 'advert',
    'sub_active'     => $str_sub,
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'tokenReload'    => 'true',
    "datepicker"     => 'true',
    "upload"         => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?mod=advert",
);

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

    <form name="advert_form" id="advert_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="act" value="submit">
        <input type="hidden" name="advert_id" value="<?php echo $this->tplData['advertRow']['advert_id']; ?>">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div id="group_advert_name">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['advertName']; ?><span id="msg_advert_name">*</span></label>
                                <input type="text" name="advert_name" id="advert_name" value="<?php echo $this->tplData['advertRow']['advert_name']; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_advert_url">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['advertUrl']; ?><span id="msg_advert_url">*</span></label>
                                <input type="text" name="advert_url" id="advert_url" value="<?php echo $this->tplData['advertRow']['advert_url']; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_advert_posi_id">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['posi']; ?><span id="msg_advert_posi_id">*</span></label>
                                <select name="advert_posi_id" id="advert_posi_id" data-validate class="form-control">
                                    <option value=""><?php echo $this->lang['mod']['option']['please']; ?></option>
                                    <?php foreach ($this->tplData['posiRows'] as $key=>$value) { ?>
                                        <option <?php if ($this->tplData['advertRow']['advert_posi_id'] == $value['posi_id']) { ?>selected<?php } ?> value="<?php echo $value['posi_id']; ?>">
                                            <?php echo $value['posi_name']; ?>
                                            [ <?php echo $this->lang['mod']['type'][$value['posi_type']]; ?> ]
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div id="group_advert_media_id">
                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['advertMedia']; ?><span id="msg_advert_media_id">*</span></label>
                                <div class="panel panel-default bg-panel-dashed">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="img-thumbnail">
                                                <?php if ($this->tplData['advertRow']['advert_media_id'] > 0 && $this->tplData['advertRow']['mediaRow']['rcode'] == "y070102") {
                                                    $str_mediaUrl = $this->tplData['advertRow']['mediaRow']['media_url'];
                                                } else {
                                                    $str_mediaUrl = BG_URL_STATIC . "image/image.png";
                                                } ?>
                                                <img id="advert_media" src="<?php echo $str_mediaUrl; ?>" class="img-responsive">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" name="advert_media_id" id="advert_media_id" value="<?php echo $this->tplData['advertRow']['advert_media_id']; ?>" data-validate class="form-control">
                                            <span class="help-block"><?php echo $this->lang['mod']['label']['advertMediaNote']; ?></span>
                                        </div>

                                        <div class="form-group">
                                            <a class="btn btn-success" href="#media_modal" data-toggle="modal">
                                                <span class="glyphicon glyphicon-picture"></span>
                                                <?php echo $this->lang['mod']['btn']['select']; ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_advert_content">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['advertContent']; ?><span id="msg_advert_content">*</span></label>
                                <textarea name="advert_content" id="advert_content" data-validate class="form-control"><?php echo $this->tplData['advertRow']['advert_content']; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_advert_note">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['note']; ?><span id="msg_advert_note"></span></label>
                                <input type="text" name="advert_note" id="advert_note" value="<?php echo $this->tplData['advertRow']['advert_note']; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="bg-submit-box"></div>

                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['save']; ?></button>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="well">
                    <?php if ($this->tplData['advertRow']['advert_id'] > 0) { ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['id']; ?></label>
                            <div class="form-control-static"><?php echo $this->tplData['advertRow']['advert_id']; ?></div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <div id="group_advert_status">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['status']; ?><span id="msg_advert_status">*</span></label>
                            <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                                <div class="bg-radio">
                                    <label for="advert_status_<?php echo $value; ?>">
                                        <input type="radio" name="advert_status" id="advert_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($this->tplData['advertRow']['advert_status'] == $value) { ?>checked<?php } ?> data-validate="advert_status">
                                        <?php if (isset($this->lang['mod']['status'][$value])) {
                                            echo $this->lang['mod']['status'][$value];
                                        } else {
                                            echo $value;
                                        } ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_advert_begin">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['advertBegin']; ?><span id="msg_advert_begin">*</span></label>
                            <input type="text" name="advert_begin" id="advert_begin" value="<?php echo date(BG_SITE_DATE . ' ' . BG_SITE_TIMESHORT, $this->tplData['advertRow']['advert_begin']); ?>" data-validate class="form-control input_date">
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_advert_put_type">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['advertPutType']; ?><span id="msg_advert_put_type">*</span></label>
                            <select name="advert_put_type" id="advert_put_type" data-validate class="form-control">
                                <option value=""><?php echo $this->lang['mod']['option']['please']; ?></option>
                                <?php foreach ($this->tplData['putType'] as $key=>$value) { ?>
                                    <option <?php if ($this->tplData['advertRow']['advert_put_type'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                                        <?php if (isset($this->lang['mod']['putType'][$value])) {
                                            echo $this->lang['mod']['putType'][$value];
                                        } else {
                                            echo $value;
                                        } ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div id="opt_date">
                        <div class="form-group">
                            <div id="group_advert_put_date">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['advertPutDate']; ?><span id="msg_advert_put_date">*</span></label>
                                <input type="text" name="advert_put_opt" id="advert_put_date" value="<?php if (!fn_isEmpty($this->tplData['advertRow']['advert_put_opt'])) { echo date(BG_SITE_DATE . ' ' . BG_SITE_TIMESHORT, $this->tplData['advertRow']['advert_put_opt']); } ?>" data-validate class="form-control input_date">
                            </div>
                        </div>
                    </div>

                    <div id="opt_show">
                        <div class="form-group">
                            <div id="group_advert_put_show">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['advertPutShow']; ?><span id="msg_advert_put_show">*</span></label>
                                <input type="text" name="advert_put_opt" id="advert_put_show" value="<?php echo $this->tplData['advertRow']['advert_put_opt']; ?>" data-validate class="form-control">
                            </div>
                        </div>
                    </div>

                    <div id="opt_hit">
                        <div class="form-group">
                            <div id="group_advert_put_hit">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['advertPutHit']; ?><span id="msg_advert_put_hit">*</span></label>
                                <input type="text" name="advert_put_opt" id="advert_put_hit" value="<?php echo $this->tplData['advertRow']['advert_put_opt']; ?>" data-validate class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_advert_percent">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['advertPercent']; ?><span id="msg_advert_percent">*</span></label>
                            <select name="advert_percent" id="advert_percent" data-validate class="form-control">
                                <option value=""><?php echo $this->lang['mod']['option']['please']; ?></option>
                                <?php foreach ($this->percent as $key=>$value) { ?>
                                    <option <?php if ($this->tplData['advertRow']['advert_percent'] == $key) { ?>selected<?php } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <div class="modal fade" id="media_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        advert_name: {
            len: { min: 1, max: 30 },
            validate: { type: "str", format: "text", group: "#group_advert_name" },
            msg: { selector: "#msg_advert_name", too_short: "<?php echo $this->lang['rcode']['x080201']; ?>", too_long: "<?php echo $this->lang['rcode']['x080202']; ?>" }
        },
        advert_url: {
            len: { min: 1, max: 3000 },
            validate: { type: "str", format: "text", group: "#group_advert_url" },
            msg: { selector: "#msg_advert_url", too_short: "<?php echo $this->lang['rcode']['x080205']; ?>", too_long: "<?php echo $this->lang['rcode']['x080206']; ?>" }
        },
        advert_posi_id: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_advert_posi_id" },
            msg: { selector: "#msg_advert_posi_id", too_few: "<?php echo $this->lang['rcode']['x080203']; ?>" }
        },
        advert_media_id: {
            len: { min: 1, max: 0 },
            validate: { type: "digit", format: "int" },
            msg: { selector: "#msg_advert_media_id", too_small: "<?php echo $this->lang['rcode']['x080222']; ?>", format_err: "<?php echo $this->lang['rcode']['x080224']; ?>" }
        },
        advert_content: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "text", group: "#group_advert_content" },
            msg: { selector: "#msg_advert_content", too_short: "<?php echo $this->lang['rcode']['x080226']; ?>" }
        },
        advert_put_type: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_advert_put_type" },
            msg: { selector: "#msg_advert_put_type", too_few: "<?php echo $this->lang['rcode']['x080204']; ?>" }
        },
        advert_put_date: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "datetime", group: "#group_advert_put_date" },
            msg: { selector: "#msg_advert_put_date", too_short: "<?php echo $this->lang['rcode']['x080216']; ?>", format_err: "<?php echo $this->lang['rcode']['x080217']; ?>" }
        },
        advert_put_show: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "int", group: "#group_advert_put_show" },
            msg: { selector: "#msg_advert_put_show", too_short: "<?php echo $this->lang['rcode']['x080218']; ?>", format_err: "<?php echo $this->lang['rcode']['x080219']; ?>" }
        },
        advert_put_hit: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "int", group: "#group_advert_put_hit" },
            msg: { selector: "#msg_advert_put_hit", too_short: "<?php echo $this->lang['rcode']['x080220']; ?>", format_err: "<?php echo $this->lang['rcode']['x080221']; ?>" }
        },
        advert_note: {
            len: { min: 0, max: 300 },
            validate: { type: "str", format: "text", group: "#group_advert_note" },
            msg: { selector: "#msg_advert_note", too_long: "<?php echo $this->lang['rcode']['x080207']; ?>" }
        },
        advert_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "[name='advert_status']", type: "radio", group: "#group_advert_status" },
            msg: { selector: "#msg_advert_status", too_few: "<?php echo $this->lang['rcode']['x080208']; ?>" }
        },
        advert_percent: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_advert_percent"},
            msg: { selector: "#msg_advert_percent", too_few: "<?php echo $this->lang['rcode']['x080209']; ?>" }
        },
        advert_begin: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "datetime" },
            msg: { selector: "#msg_advert_begin", too_short: "<?php echo $this->lang['rcode']['x080214']; ?>", format_err: "<?php echo $this->lang['rcode']['x080215']; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=advert",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    function put_type(_put_type) {
        switch (_put_type) {
            case "show":
                $("#opt_date").hide();
                $("#opt_show").show();
                $("#opt_hit").hide();
                $("#advert_put_date").attr("disabled", true);
                $("#advert_put_show").removeAttr("disabled");
                $("#advert_put_hit").attr("disabled", true);
            break;

            case "hit":
                $("#opt_date").hide();
                $("#opt_show").hide();
                $("#opt_hit").show();
                $("#advert_put_date").attr("disabled", true);
                $("#advert_put_show").attr("disabled", true);
                $("#advert_put_hit").removeAttr("disabled");
            break;

            case "none":
            case "subs":
                $("#opt_date").hide();
                $("#opt_show").hide();
                $("#opt_hit").hide();
                $("#advert_put_date").attr("disabled", true);
                $("#advert_put_show").attr("disabled", true);
                $("#advert_put_hit").attr("disabled", true);
            break;

            default:
                $("#opt_date").show();
                $("#opt_show").hide();
                $("#opt_hit").hide();
                $("#advert_put_date").removeAttr("disabled");
                $("#advert_put_show").attr("disabled", true);
                $("#advert_put_hit").attr("disabled", true);
            break;
        }
    }

    function advert_posi(_posi_id) {
        var posiJSON      = <?php echo $this->tplData['posiJSON']; ?>;
        var _this_posi    = posiJSON[_posi_id];
        if (typeof _this_posi != "undefined") {
            if (posiJSON[_posi_id].posi_type == "text") {
                $("#group_advert_media_id").hide();
                $("#group_advert_content").show();
            } else {
                $("#group_advert_content").hide();
                $("#group_advert_media_id").show();
            }
            if (_this_posi.posi_is_percent == "enable") {
                //alert(_this_posi.percent_sum);
                $("#advert_percent option:gt(" + (10 - _this_posi.percent_sum) + ")").attr("disabled", true);
            }
        }
    }

    $(document).ready(function(){
        put_type("<?php echo $this->tplData['advertRow']['advert_put_type']; ?>");
        advert_posi(<?php echo $this->tplData['advertRow']['advert_posi_id']; ?>);

        $("#media_modal").on("shown.bs.modal", function() {
            $("#media_modal .modal-content").load("<?php echo BG_URL_CONSOLE; ?>index.php?mod=media&act=form&view=iframe");
    	}).on("hidden.bs.modal", function(){
        	$("#media_modal .modal-content").empty();
    	});

        var obj_validator_form    = $("#advert_form").baigoValidator(opts_validator_form);
        var obj_submit_form       = $("#advert_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validator_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        $("#advert_put_type").change(function(){
            var _put_type = $(this).val();
            put_type(_put_type);
        });
        $("#advert_posi_id").change(function(){
            var _posi_id = $(this).val();
            advert_posi(_posi_id);
        });
        $(".input_date").datetimepicker(opts_datetimepicker);
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>
