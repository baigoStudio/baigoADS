<?php if ($this->tplData['linkRow']['link_id'] < 1) {
    $title_sub  = $this->lang['mod']['page']['add'];
} else {
    $title_sub = $this->lang['mod']['page']['edit'];
}

$cfg = array(
    'title'          => $this->lang['consoleMod']['link']['sub']['list'] . ' &raquo; ' . $title_sub,
    'menu_active'    => "link",
    'sub_active'     => 'list',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?mod=link"
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group clearfix">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills bg-nav-pills">
                    <li>
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=link&act=list">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                            <?php echo $this->lang['common']['href']['back']; ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=link" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            <?php echo $this->lang['mod']['href']['help']; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <form name="link_form" id="link_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="link_id" id="link_id" value="<?php echo $this->tplData['linkRow']['link_id']; ?>">
        <input type="hidden" name="act" value="submit">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div id="group_link_name">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['linkName']; ?><span id="msg_link_name">*</span></label>
                                <input type="text" name="link_name" id="link_name" value="<?php echo $this->tplData['linkRow']['link_name']; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_link_url">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['linkUrl']; ?><span id="msg_link_url">*</span></label>
                                <input type="text" name="link_url" id="link_url" value="<?php echo $this->tplData['linkRow']['link_url']; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label for="link_blank">
                                    <input type="checkbox" id="link_blank" name="link_blank" <?php if ($this->tplData['linkRow']['link_blank'] > 0) { ?>checked<?php } ?> value="1">
                                    <?php echo $this->lang['mod']['label']['isBlank']; ?>
                                </label>
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
                    <?php if ($this->tplData['linkRow']['link_id'] > 0) { ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['id']; ?></label>
                            <div class="form-control-static"><?php echo $this->tplData['linkRow']['link_id']; ?></div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <div id="group_link_status">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['status']; ?><span id="msg_link_status">*</span></label>
                            <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                                <div class="bg-radio">
                                    <label for="link_status_<?php echo $value; ?>">
                                        <input type="radio" name="link_status" id="link_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($this->tplData['linkRow']['link_status'] == $value) { ?>checked<?php } ?> data-validate="link_status">
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
                </div>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        link_name: {
            len: { min: 1, max: 300 },
            validate: { type: "str", format: "text", group: "#group_link_name" },
            msg: { selector: "#msg_link_name", too_short: "<?php echo $this->lang['rcode']['x120201']; ?>", too_long: "<?php echo $this->lang['rcode']['x120202']; ?>" }
        },
        link_url: {
            len: { min: 1, max: 900 },
            validate: { type: "str", format: "url", group: "#group_link_url" },
            msg: { selector: "#msg_link_url", too_short: "<?php echo $this->lang['rcode']['x120203']; ?>", too_long: "<?php echo $this->lang['rcode']['x120204']; ?>", format_err: "<?php echo $this->lang['rcode']['x120205']; ?>" }
        },
        link_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='link_status']", type: "radio", group: "#group_link_status" },
            msg: { selector: "#msg_link_status", too_few: "<?php echo $this->lang['rcode']['x120207']; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=link",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    $(document).ready(function(){
        var obj_validate_form = $("#link_form").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#link_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>