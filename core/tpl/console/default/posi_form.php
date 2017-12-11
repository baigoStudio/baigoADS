<?php if ($this->tplData['posiRow']['posi_id'] < 1) {
    $title_sub = $this->lang['mod']['page']['add'];
    $str_sub = "form";
} else {
    $title_sub = $this->lang['mod']['page']['edit'];
    $str_sub = "list";
}

$cfg = array(
    'title'          => $this->lang['consoleMod']['posi']['main']['title'] . ' &raquo; ' . $title_sub,
    'menu_active'    => 'posi',
    'sub_active'     => $str_sub,
    'baigoCheckall'  => 'true',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'tokenReload'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?mod=posi&act=list"
);

include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group clearfix">
        <div class="pull-left">
            <ul class="nav nav-pills bg-nav-pills">
                <li>
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=posi&act=form">
                        <span class="glyphicon glyphicon-plus"></span>
                        <?php echo $this->lang['mod']['href']['add']; ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=posi" target="_blank">
                        <span class="glyphicon glyphicon-question-sign"></span>
                        <?php echo $this->lang['mod']['href']['help']; ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <form name="posi_form" id="posi_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="act" value="submit">
        <input type="hidden" name="posi_id" id="posi_id" value="<?php echo $this->tplData['posiRow']['posi_id']; ?>">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['posiScript']; ?><span id="msg_posi_script">*</span></label>
                            <select name="posi_script" id="posi_script" data-validate class="form-control">
                                <option value=""><?php echo $this->lang['mod']['option']['please']; ?></option>
                                <?php foreach ($this->tplData['scriptRows'] as $key=>$value) { ?>
                                    <option <?php if ($this->tplData['posiRow']['posi_script'] == $value['name']) { ?>selected<?php } ?> data-index="<?php echo $key; ?>" value="<?php echo $value['name']; ?>">
                                        <?php echo $value['name']; ?>
                                        [ <?php echo $value['config']['name']; ?> ]
                                    </option>
                                <?php } ?>
                            </select>
                            <span class="help-block" id="posi_script_note"></span>
                        </div>

                        <div class="form-group">
                            <div id="group_posi_name">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['posiName']; ?><span id="msg_posi_name">*</span></label>
                                <input type="text" name="posi_name" id="posi_name" value="<?php echo $this->tplData['posiRow']['posi_name']; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_posi_plugin">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['posiPlugin']; ?><span id="msg_posi_plugin">*</span></label>
                                <input type="text" name="posi_plugin" id="posi_plugin" value="<?php echo $this->tplData['posiRow']['posi_plugin']; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_posi_selector">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['posiSelector']; ?><span id="msg_posi_selector">*</span></label>
                                <input type="text" name="posi_selector" id="posi_selector" value="<?php echo $this->tplData['posiRow']['posi_selector']; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div id="group_posi_opts">
                            <?php foreach ($this->tplData['posiRow']['posi_opts'] as $key=>$value) { ?>
                                <div class="form-group">
                                    <label class="control-label">
                                        <?php echo $this->lang['mod']['label']['posiOption']; ?>
                                        <?php echo $value['label']; ?>
                                    </label>
                                    <input type="text" name="posi_opts[<?php echo $key; ?>][value]" class="form-control" value="<?php echo $value['value']; ?>">
                                    <input type="hidden" name="posi_opts[<?php echo $key; ?>][field]" value="<?php echo $value['field']; ?>">
                                    <input type="hidden" name="posi_opts[<?php echo $key; ?>][label]" value="<?php echo $value['label']; ?>">
                                </div>
                            <?php } ?>
                        </div>

                        <div class="form-group">
                            <div id="group_posi_note">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['note']; ?><span id="msg_posi_note"></span></label>
                                <input type="text" name="posi_note" id="posi_note" value="<?php echo $this->tplData['posiRow']['posi_note']; ?>" data-validate class="form-control">
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
                    <?php if ($this->tplData['posiRow']['posi_id'] > 0) { ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['id']; ?></label>
                            <div class="form-control-static"><?php echo $this->tplData['posiRow']['posi_id']; ?></div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <div id="group_posi_status">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['status']; ?><span id="msg_posi_status">*</span></label>
                            <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                                <div class="bg-radio">
                                    <label for="posi_status_<?php echo $value; ?>">
                                        <input type="radio" name="posi_status" id="posi_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($this->tplData['posiRow']['posi_status'] == $value) { ?>checked<?php } ?> data-validate="posi_status">
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
                        <div id="group_posi_is_percent">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['isPercent']; ?><span id="msg_posi_is_percent">*</span></label>
                            <?php foreach ($this->tplData['isPercent'] as $key=>$value) { ?>
                                <div class="bg-radio">
                                    <label for="posi_is_percent_<?php echo $value; ?>">
                                        <input type="radio" name="posi_is_percent" id="posi_is_percent_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($this->tplData['posiRow']['posi_is_percent'] == $value) { ?>checked<?php } ?> data-validate="posi_is_percent">
                                        <?php if (isset($this->lang['mod']['isPercent'][$value])) {
                                            echo $this->lang['mod']['isPercent'][$value];
                                        } else {
                                            echo $value;
                                        } ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_posi_type">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['contentType']; ?><span id="msg_posi_type">*</span></label>
                            <?php foreach ($this->tplData['type'] as $key=>$value) { ?>
                                <div class="bg-radio">
                                    <label for="posi_type_<?php echo $value; ?>">
                                        <input type="radio" name="posi_type" id="posi_type_<?php echo $value; ?>" value="<?php echo $value; ?>" data-validate="posi_type" <?php if ($this->tplData['posiRow']['posi_type'] == $value) { ?>checked<?php } ?> data-validate="posi_type">
                                        <?php if (isset($this->lang['mod']['type'][$value])) {
                                            echo $this->lang['mod']['type'][$value];
                                        } else {
                                            echo $value;
                                        } ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_posi_count">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['posiCount']; ?><span id="msg_posi_count">*</span></label>
                            <input type="text" name="posi_count" id="posi_count" value="<?php echo $this->tplData['posiRow']['posi_count']; ?>" data-validate class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var script_json = <?php echo $this->tplData['scriptJSON']; ?>

    var opts_validator_form = {
        posi_name: {
            len: { min: 1, max: 300 },
            validate: { type: "ajax", format: "text", group: "#group_posi_name" },
            msg: { selector: "#msg_posi_name", too_short: "<?php echo $this->lang['rcode']['x040201']; ?>", too_long: "<?php echo $this->lang['rcode']['x040202']; ?>", ajaxIng: "<?php echo $this->lang['rcode']['x030401']; ?>", ajax_err: "<?php echo $this->lang['rcode']['x030402']; ?>" },
            ajax: { url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=posi&act=chkname", key: "posi_name", type: "str", attach_selectors: ["#posi_id"], attach_keys: ["posi_id"] }
        },
        posi_count: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "int", group: "#group_posi_count" },
            msg: { selector: "#msg_posi_count", too_short: "<?php echo $this->lang['rcode']['x040205']; ?>", format_err: "<?php echo $this->lang['rcode']['x040208']; ?>" }
        },
        posi_type: {
            len: { min: 1, max: 0 },
            validate: { selector: "[name='posi_type']", type: "radio", group: "#group_posi_type" },
            msg: { selector: "#msg_posi_type", too_few: "<?php echo $this->lang['rcode']['x040209']; ?>" }
        },
        posi_script: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_posi_script" },
            msg: { selector: "#msg_posi_script", too_few: "<?php echo $this->lang['rcode']['x040215']; ?>" }
        },
        posi_plugin: {
            len: { min: 1, max: 100 },
            validate: { type: "str", format: "text", group: "#group_posi_plugin" },
            msg: { selector: "#msg_posi_plugin", too_short: "<?php echo $this->lang['rcode']['x040216']; ?>", too_long: "<?php echo $this->lang['rcode']['x040217']; ?>" }
        },
        posi_selector: {
            len: { min: 1, max: 100 },
            validate: { type: "str", format: "text", group: "#group_posi_selector" },
            msg: { selector: "#msg_posi_note", too_short: "<?php echo $this->lang['rcode']['x040218']; ?>", too_long: "<?php echo $this->lang['rcode']['x040219']; ?>" }
        },
        posi_is_percent: {
            len: { min: 1, max: 0 },
            validate: { selector: "[name='posi_is_percent']", type: "radio", group: "#group_posi_is_percent" },
            msg: { selector: "#msg_posi_is_percent", too_few: "<?php echo $this->lang['rcode']['x040221']; ?>" }
        },
        posi_note: {
            len: { min: 0, max: 300 },
            validate: { type: "str", format: "text", group: "#group_posi_note" },
            msg: { selector: "#msg_posi_note", too_long: "<?php echo $this->lang['rcode']['x040204']; ?>" }
        },
        posi_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "[name='posi_status']", type: "radio", group: "#group_posi_status" },
            msg: { selector: "#msg_posi_status", too_few: "<?php echo $this->lang['rcode']['x040207']; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=posi",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    function posi_script(_script_index) {
        var _result = script_json[_script_index].config;

        $("#posi_name").val(_result.name);
        $("#posi_plugin").val(_result.plugin);
        $("#posi_selector").val(_result.selector);
        $("#posi_count").val(_result.count);
        $("#posi_is_percent_" + _result.isPercent).prop("checked", "checked");
        $("#posi_type_" + _result.type).prop("checked", "checked");
        $("#posi_script_note").text(_result.note);
        if (typeof _result.opts != "undefined" && _result.opts) {
            var _str_opts = "";
            $.each(_result.opts, function(_key, _value){
                _str_opts += "<div class=\"form-group\">";
                    _str_opts += "<label class=\"control-label\"><?php echo $this->lang['mod']['label']['posiOption']; ?>" + _value.label + "</label>";
                    _str_opts += "<input type=\"text\" name=\"posi_opts[" + _key + "][value]\" class=\"form-control\" value=\"" + _value.value + "\">";
                    _str_opts += "<input type=\"hidden\" name=\"posi_opts[" + _key + "][field]\" value=\"" + _value.field + "\">";
                    _str_opts += "<input type=\"hidden\" name=\"posi_opts[" + _key + "][label]\" value=\"" + _value.label + "\">";
                _str_opts += "</div>";
            });
            $("#group_posi_opts").html(_str_opts);
        }
    }

    $(document).ready(function(){
        var obj_validate_form = $("#posi_form").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#posi_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        $("#posi_script").change(function(){
            var _script_index = $("#posi_script option:selected").attr("data-index");
            if (_script_index) {
                posi_script(_script_index);
            }
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>

