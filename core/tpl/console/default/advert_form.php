<?php if ($this->tplData['advertRow']['advert_id'] < 1) {
    $title_sub = $this->lang['mod']['page']['add'];
    $str_sub = 'form';
} else {
    $title_sub = $this->lang['mod']['page']['edit'];
    $str_sub = 'list';
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
    'str_url'        => BG_URL_CONSOLE . "index.php?m=advert",
);

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

    <form name="advert_form" id="advert_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="a" value="submit">
        <input type="hidden" name="advert_id" value="<?php echo $this->tplData['advertRow']['advert_id']; ?>">

        <div class="row">
            <div class="col-md-9">
                <div class="card mb-3 mb-lg-0">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['advertName']; ?> <span class="text-danger">*</span></label>
                            <input type="text" name="advert_name" id="advert_name" value="<?php echo $this->tplData['advertRow']['advert_name']; ?>" data-validate class="form-control">
                            <small class="form-text" id="msg_advert_name"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['advertUrl']; ?> <span class="text-danger">*</span></label>
                            <input type="text" name="advert_url" id="advert_url" value="<?php echo $this->tplData['advertRow']['advert_url']; ?>" data-validate class="form-control">
                            <small class="form-text" id="msg_advert_url"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['posi']; ?> <span class="text-danger">*</span></label>
                            <select name="advert_posi_id" id="advert_posi_id" data-validate class="form-control">
                                <option value=""><?php echo $this->lang['mod']['option']['please']; ?></option>
                                <?php foreach ($this->tplData['posiRows'] as $key=>$value) { ?>
                                    <option <?php if ($this->tplData['advertRow']['advert_posi_id'] == $value['posi_id']) { ?>selected<?php } ?> value="<?php echo $value['posi_id']; ?>">
                                        <?php echo $value['posi_name'];
                                        if (isset($this->lang['mod']['type'][$value['posi_type']])) { ?>
                                            [ <?php echo $this->lang['mod']['type'][$value['posi_type']]; ?> ]
                                        <?php } ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <small class="form-text" id="msg_advert_posi_id"></small>
                        </div>

                        <div id="group_advert_attach_id">
                            <div class="form-group">
                                <label><?php echo $this->lang['mod']['label']['advertAttach']; ?> <span class="text-danger">*</span></label>
                                <div class="card bg-card-dashed">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="img-thumbnail">
                                                <?php if ($this->tplData['advertRow']['advert_attach_id'] > 0 && $this->tplData['advertRow']['attachRow']['rcode'] == "y070102") {
                                                    $str_attachUrl = $this->tplData['advertRow']['attachRow']['attach_url'];
                                                } else {
                                                    $str_attachUrl = BG_URL_STATIC . "image/image.png";
                                                } ?>
                                                <img id="advert_attach" src="<?php echo $str_attachUrl; ?>" class="img-fluid">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" name="advert_attach_id" id="advert_attach_id" value="<?php echo $this->tplData['advertRow']['advert_attach_id']; ?>" data-validate class="form-control">
                                            <small class="form-text"><?php echo $this->lang['mod']['label']['advertAttachNote']; ?></small>
                                        </div>

                                        <div class="form-group">
                                            <a class="btn btn-success" href="#attach_modal" data-toggle="modal">
                                                <span class="oi oi-picture"></span>
                                                <?php echo $this->lang['mod']['btn']['select']; ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="group_advert_content">
                            <div class="form-group">
                                <label><?php echo $this->lang['mod']['label']['advertContent']; ?> <span class="text-danger">*</span></label>
                                <textarea name="advert_content" id="advert_content" data-validate class="form-control"><?php echo $this->tplData['advertRow']['advert_content']; ?></textarea>
                                <small class="form-text" id="msg_advert_content"></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['note']; ?></label>
                            <input type="text" name="advert_note" id="advert_note" value="<?php echo $this->tplData['advertRow']['advert_note']; ?>" data-validate class="form-control">
                            <small class="form-text" id="msg_advert_note"></small>
                        </div>

                        <div class="bg-submit-box"></div>
                        <div class="bg-validator-box mt-3"></div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['save']; ?></button>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <?php if ($this->tplData['advertRow']['advert_id'] > 0) { ?>
                            <div class="form-group">
                                <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                                <div class="form-text"><?php echo $this->tplData['advertRow']['advert_id']; ?></div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['status']; ?> <span class="text-danger">*</span></label>
                            <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                                <div class="form-check">
                                    <label for="advert_status_<?php echo $value; ?>" class="form-check-label">
                                        <input type="radio" name="advert_status" id="advert_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($this->tplData['advertRow']['advert_status'] == $value) { ?>checked<?php } ?> data-validate="advert_status" class="form-check-input">
                                        <?php if (isset($this->lang['mod']['status'][$value])) {
                                            echo $this->lang['mod']['status'][$value];
                                        } else {
                                            echo $value;
                                        } ?>
                                    </label>
                                </div>
                            <?php } ?>
                            <small class="form-text" id="msg_advert_status"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['advertBegin']; ?> <span class="text-danger">*</span></label>
                            <input type="text" name="advert_begin" id="advert_begin" value="<?php echo date(BG_SITE_DATE . ' ' . BG_SITE_TIMESHORT, $this->tplData['advertRow']['advert_begin']); ?>" data-validate class="form-control input_date">
                            <small class="form-text" id="msg_advert_begin"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['advertPutType']; ?> <span class="text-danger">*</span></label>
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
                            <small class="form-text" id="msg_advert_put_type"></small>
                        </div>

                        <div id="opt_date">
                            <div class="form-group">
                                <label><?php echo $this->lang['mod']['label']['advertPutDate']; ?> <span class="text-danger">*</span></label>
                                <input type="text" name="advert_put_opt" id="advert_put_date" value="<?php if (!fn_isEmpty($this->tplData['advertRow']['advert_put_opt'])) { echo date(BG_SITE_DATE . ' ' . BG_SITE_TIMESHORT, $this->tplData['advertRow']['advert_put_opt']); } ?>" data-validate class="form-control input_date">
                                <small class="form-text" id="msg_advert_put_date"></small>
                            </div>
                        </div>

                        <div id="opt_show">
                            <div class="form-group">
                                <label><?php echo $this->lang['mod']['label']['advertPutShow']; ?> <span class="text-danger">*</span></label>
                                <input type="text" name="advert_put_opt" id="advert_put_show" value="<?php echo $this->tplData['advertRow']['advert_put_opt']; ?>" data-validate class="form-control">
                                <small class="form-text" id="msg_advert_put_show"></small>
                            </div>
                        </div>

                        <div id="opt_hit">
                            <div class="form-group">
                                <label><?php echo $this->lang['mod']['label']['advertPutHit']; ?> <span class="text-danger">*</span></label>
                                <input type="text" name="advert_put_opt" id="advert_put_hit" value="<?php echo $this->tplData['advertRow']['advert_put_opt']; ?>" data-validate class="form-control">
                                <small class="form-text" id="msg_advert_put_hit"></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['advertPercent']; ?> <span class="text-danger">*</span></label>
                            <select name="advert_percent" id="advert_percent" data-validate class="form-control">
                                <option value=""><?php echo $this->lang['mod']['option']['please']; ?></option>
                                <?php foreach ($this->percent as $key=>$value) { ?>
                                    <option <?php if ($this->tplData['advertRow']['advert_percent'] == $key) { ?>selected<?php } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                            <small class="form-text" id="msg_advert_percent"></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <div class="modal fade" id="attach_modal">
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
            validate: { type: "str", format: "text" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x080201']; ?>", too_long: "<?php echo $this->lang['rcode']['x080202']; ?>" }
        },
        advert_url: {
            len: { min: 1, max: 3000 },
            validate: { type: "str", format: "text" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x080205']; ?>", too_long: "<?php echo $this->lang['rcode']['x080206']; ?>" }
        },
        advert_posi_id: {
            len: { min: 1, max: 0 },
            validate: { type: "select" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x080203']; ?>" }
        },
        advert_attach_id: {
            len: { min: 1, max: 0 },
            validate: { type: "digit", format: "int" },
            msg: { too_small: "<?php echo $this->lang['rcode']['x080222']; ?>", format_err: "<?php echo $this->lang['rcode']['x080224']; ?>" }
        },
        advert_content: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "text" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x080226']; ?>" }
        },
        advert_put_type: {
            len: { min: 1, max: 0 },
            validate: { type: "select" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x080204']; ?>" }
        },
        advert_put_date: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "datetime" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x080216']; ?>", format_err: "<?php echo $this->lang['rcode']['x080217']; ?>" }
        },
        advert_put_show: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "int" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x080218']; ?>", format_err: "<?php echo $this->lang['rcode']['x080219']; ?>" }
        },
        advert_put_hit: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "int" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x080220']; ?>", format_err: "<?php echo $this->lang['rcode']['x080221']; ?>" }
        },
        advert_note: {
            len: { min: 0, max: 300 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x080207']; ?>" }
        },
        advert_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "[name='advert_status']", type: "radio" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x080208']; ?>" }
        },
        advert_percent: {
            len: { min: 1, max: 0 },
            validate: { type: "select" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x080209']; ?>" }
        },
        advert_begin: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "datetime" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x080214']; ?>", format_err: "<?php echo $this->lang['rcode']['x080215']; ?>" }
        }
    };

    var options_validator_form = {
        msg_global:{
            msg: "<?php echo $this->lang['common']['label']['errInput']; ?>"
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=advert&c=request",
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
            case "backup":
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
                $("#group_advert_attach_id").hide();
                $("#group_advert_content").show();
            } else {
                $("#group_advert_content").hide();
                $("#group_advert_attach_id").show();
            }
            if (_this_posi.posi_is_percent == 'enable') {
                //alert(_this_posi.percent_sum);
                $("#advert_percent option:gt(" + (10 - _this_posi.percent_sum) + ")").attr("disabled", true);
            }
        }
    }

    $(document).ready(function(){
        put_type("<?php echo $this->tplData['advertRow']['advert_put_type']; ?>");
        advert_posi(<?php echo $this->tplData['advertRow']['advert_posi_id']; ?>);

        $("#attach_modal").on("shown.bs.modal", function() {
            $("#attach_modal .modal-content").load("<?php echo BG_URL_CONSOLE; ?>index.php?m=attach&a=form&view=iframe");
    	}).on("hidden.bs.modal", function(){
        	$("#attach_modal .modal-content").empty();
    	});

        var obj_validator_form    = $("#advert_form").baigoValidator(opts_validator_form, options_validator_form);
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

<?php include($cfg['pathInclude'] . 'html_foot.php');