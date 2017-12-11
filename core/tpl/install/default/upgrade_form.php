<?php
if (fn_isEmpty($GLOBALS['route']['bg_act'])) {
    $GLOBALS['route']['bg_act'] = "base";
}

$cfg = array(
    'title'         => $this->lang['mod']['page']['upgrade'] . ' &raquo; ' . $this->lang['opt'][$GLOBALS['route']['bg_act']]['title'],
    'sub_title'     => $this->lang['opt'][$GLOBALS['route']['bg_act']]['title'],
    'pathInclude'   => BG_PATH_TPLSYS . 'install' . DS . 'default' . DS . 'include' . DS,
    'mod_help'      => 'upgrade'
); ?>

<?php include(BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS . 'function.php'); ?>
<?php include($cfg['pathInclude'] . 'upgrade_head.php'); ?>

    <form name="upgrade_form" id="upgrade_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="act" value="<?php echo $GLOBALS['route']['bg_act']; ?>">

        <?php if ($GLOBALS['route']['bg_act'] == "sso") { ?>
            <div class="alert alert-warning">
                <?php echo $this->lang['mod']['text']['sso']; ?>
            </div>

            <p><a href="<?php echo str_ireplace('api/api.php', "install/index.php?mod=upgrade", BG_SSO_URL); ?>" target="_blank" class="btn btn-info"><?php echo $this->lang['mod']['href']['ssoUpgrade']; ?></a></p>
        <?php }

        $_tplRows       = array();
        $_timezoneLang  = array();
        $_timezoneRows  = array();
        $_timezoneType  = '';

        if ($GLOBALS['route']['bg_act'] == "base") {
            $_tplRows       = $this->tplData['tplRows'];
            $_timezoneLang  = $this->lang['timezone'];
            $_timezoneRows  = $this->tplData['timezoneRows'];
            $_timezoneType  = $this->tplData['timezoneType'];
        }

        $arr_form = opt_form_process($this->opt[$GLOBALS['route']['bg_act']]['list'], $this->lang['opt'][$GLOBALS['route']['bg_act']]['list'], $_tplRows, $_timezoneRows, $_timezoneLang, $_timezoneType, $this->lang['mod']['label'], $this->lang['rcode']); ?>

        <div class="bg-submit-box"></div>

        <div class="form-group clearfix">
            <div class="pull-left">
                <div class="form-group">
                    <div class="btn-group">
                        <a href="<?php echo BG_URL_INSTALL; ?>index.php?mod=upgrade&act=<?php echo $this->tplData['upgrade_step']['prev']; ?>" class="btn btn-default"><?php echo $this->lang['mod']['btn']['prev']; ?></a>
                        <?php include($cfg['pathInclude'] . 'upgrade_drop.php'); ?>
                        <a href="<?php echo BG_URL_INSTALL; ?>index.php?mod=upgrade&act=<?php echo $this->tplData['upgrade_step']['next']; ?>" class="btn btn-default"><?php echo $this->lang['mod']['btn']['skip']; ?></a>
                    </div>
                </div>
            </div>

            <div class="pull-right">
                <div class="form-group">
                    <button type="button" id="go_next" class="btn btn-primary"><?php echo $this->lang['mod']['btn']['save']; ?></button>
                </div>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'install_foot.php'); ?>

    <script type="text/javascript">
    <?php echo $arr_form['json']; ?>

    var opts_submit_form = {
        ajax_url: "<?php BG_URL_INSTALL; ?>request.php?mod=upgrade",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        },
        jump: {
            url: "<?php BG_URL_INSTALL; ?>index.php?mod=upgrade&act=<?php echo $this->tplData['upgrade_step']['next']; ?>",
            text: "<?php echo $this->lang['mod']['href']['jumping']; ?>"
        }
    };

    $(document).ready(function(){
        var obj_validator_form    = $("#upgrade_form").baigoValidator(opts_validator_form);
        var obj_submit_form       = $("#upgrade_form").baigoSubmit(opts_submit_form);
        $("#go_next").click(function(){
            if (obj_validator_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        <?php if ($GLOBALS['route']['bg_act'] == "base") { ?>
            var _timezoneRowsJson = <?php echo $this->tplData['timezoneRowsJson']; ?>;
            var _timezoneLangJson = <?php echo $this->lang['timezoneJson']; ?>;

            $("#timezone_type").change(function(){
                var _type = $(this).val();
                var _str_appent;
                $.each(_timezoneRowsJson[_type].sub, function(_key, _value){
                    _str_appent += "<option";
                    if (_key == "<?php echo BG_SITE_TIMEZONE; ?>") {
                        _str_appent += " selected";
                    }
                    _str_appent += " value='" + _key + "'>";
                    if (typeof _timezoneLangJson[_type].sub[_key] != "undefined") {
                        _str_appent += _timezoneLangJson[_type].sub[_key];
                    } else {
                        _str_appent += _value;
                    }
                    _str_appent += "</option>";
                });
                $("#opt_base_BG_SITE_TIMEZONE").html(_str_appent);
            });
        <?php } ?>
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>
