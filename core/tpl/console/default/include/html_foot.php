    <?php $GLOBALS['obj_plugin']->trigger('action_console_foot_before'); //后台界面底部触发

    if (isset($cfg['baigoValidator'])) { ?>
        <!--表单验证 js-->
        <script src="<?php echo BG_URL_STATIC; ?>lib/baigoValidator/2.2.5/baigoValidator.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['baigoSubmit'])) { ?>
        <!--表单 ajax 提交 js-->
        <script src="<?php echo BG_URL_STATIC; ?>lib/baigoSubmit/2.0.5/baigoSubmit.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['reloadImg'])) { ?>
        <!--重新载入图片 js-->
        <script type="text/javascript">
        $(document).ready(function(){
            $(".captchaBtn").click(function(){
                var imgSrc = "<?php echo BG_URL_CONSOLE; ?>index.php?m=captcha&a=make&" + new Date().getTime() + "at" + Math.random();
                $(".captchaImg").attr('src', imgSrc);
            });
        });
        </script>
    <?php }

    if (isset($cfg['baigoCheckall'])) { ?>
        <!--全选 js-->
        <script src="<?php echo BG_URL_STATIC; ?>lib/baigoCheckall/1.0.3/baigoCheckall.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['baigoClear'])) { ?>
        <!--表单 ajax 提交 js-->
        <script src="<?php echo BG_URL_STATIC; ?>lib/baigoClear/1.0.8/baigoClear.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['upload'])) { ?>
        <script src="<?php echo BG_URL_STATIC; ?>lib/webuploader/0.1.5/webuploader.html5only.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['prism'])) { ?>
        <script src="<?php echo BG_URL_STATIC; ?>lib/prism/prism.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['datepicker'])) { ?>
        <!--日历插件-->
        <script src="<?php echo BG_URL_STATIC; ?>lib/datetimepicker/2.3.0/jquery.datetimepicker.js" type="text/javascript"></script>
        <script type="text/javascript">
        var opts_datetimepicker = {
            lang: "<?php echo $this->config['lang']; ?>",
            i18n: {
                <?php echo $this->config['lang']; ?>: {
                    months: ["<?php echo $this->lang['common']['date'][1] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][2] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][3] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][4] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][5] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][6] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][7] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][8] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][9] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][10] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][10] . $this->lang['common']['date'][1] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][10] . $this->lang['common']['date'][2] . $this->lang['common']['label']['month']; ?>"],
            monthsShort: ["<?php echo $this->lang['common']['date'][1]; ?>", "<?php echo $this->lang['common']['date'][2]; ?>", "<?php echo $this->lang['common']['date'][3]; ?>", "<?php echo $this->lang['common']['date'][4]; ?>", "<?php echo $this->lang['common']['date'][5]; ?>", "<?php echo $this->lang['common']['date'][6]; ?>", "<?php echo $this->lang['common']['date'][7]; ?>", "<?php echo $this->lang['common']['date'][8]; ?>", "<?php echo $this->lang['common']['date'][9]; ?>", "<?php echo $this->lang['common']['date'][10]; ?>", "<?php echo $this->lang['common']['date'][10] . $this->lang['common']['date'][1]; ?>", "<?php echo $this->lang['common']['date'][10] . $this->lang['common']['date'][2]; ?>"],
                    dayOfWeek: ["<?php echo $this->lang['common']['date'][0]; ?>", "<?php echo $this->lang['common']['date'][1]; ?>", "<?php echo $this->lang['common']['date'][2]; ?>", "<?php echo $this->lang['common']['date'][3]; ?>", "<?php echo $this->lang['common']['date'][4]; ?>", "<?php echo $this->lang['common']['date'][5]; ?>", "<?php echo $this->lang['common']['date'][6]; ?>"]
                }
            },
            //timepicker: false,
            format: "Y-m-d H:i",
            step: 30,
            mask: true
        };
        var opts_datepicker = {
            lang: "<?php echo $this->config['lang']; ?>",
            i18n: {
                <?php echo $this->config['lang']; ?>: {
                    months: ["<?php echo $this->lang['common']['date'][1] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][2] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][3] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][4] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][5] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][6] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][7] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][8] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][9] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][10] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][10] . $this->lang['common']['date'][1] . $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][10] . $this->lang['common']['date'][2] . $this->lang['common']['label']['month']; ?>"],
            monthsShort: ["<?php echo $this->lang['common']['date'][1]; ?>", "<?php echo $this->lang['common']['date'][2]; ?>", "<?php echo $this->lang['common']['date'][3]; ?>", "<?php echo $this->lang['common']['date'][4]; ?>", "<?php echo $this->lang['common']['date'][5]; ?>", "<?php echo $this->lang['common']['date'][6]; ?>", "<?php echo $this->lang['common']['date'][7]; ?>", "<?php echo $this->lang['common']['date'][8]; ?>", "<?php echo $this->lang['common']['date'][9]; ?>", "<?php echo $this->lang['common']['date'][10]; ?>", "<?php echo $this->lang['common']['date'][10] . $this->lang['common']['date'][1]; ?>", "<?php echo $this->lang['common']['date'][10] . $this->lang['common']['date'][2]; ?>"],
                    dayOfWeek: ["<?php echo $this->lang['common']['date'][0]; ?>", "<?php echo $this->lang['common']['date'][1]; ?>", "<?php echo $this->lang['common']['date'][2]; ?>", "<?php echo $this->lang['common']['date'][3]; ?>", "<?php echo $this->lang['common']['date'][4]; ?>", "<?php echo $this->lang['common']['date'][5]; ?>", "<?php echo $this->lang['common']['date'][6]; ?>"]
                }
            },
            timepicker: false,
            format: "Y-m-d",
            mask: true
        };
        </script>
    <?php }

    if (isset($cfg['tooltip'])) { ?>
        <script type="text/javascript">
        $(document).ready(function(){
            $("[data-toggle='tooltip']").tooltip({
                html: true,
                template: "<div class='tooltip bg-tooltip'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>"
            });
        });
        </script>
    <?php }

    if (isset($this->tplData['adminLogged']['rcode']) && $this->tplData['adminLogged']['rcode'] == 'y020102' && !isset($cfg['noToken'])) { ?>
        <div class="modal fade" id="msg_token">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                            <?php echo $this->lang['common']['btn']['ok']; ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
        function tokenReload() {
            $.getJSON("<?php echo BG_URL_CONSOLE; ?>index.php?m=token&c=request&a=make", function(result){
                if (result.rcode == 'y020102') {
                    $("#box_pm_new").text(result.pm_count);
                } else {
                    $("#msg_token .modal-body").text(result.msg);
                    $("#msg_token").modal("show");
                }
            });
        }

        $(document).ready(function(){
            tokenReload();
            setInterval(function(){
                tokenReload();
            }, <?php echo BG_DEFAULT_TOKEN_RELOAD; ?>);
        });
        </script>
    <?php } ?>

    <script type="text/javascript">
    $(document).ready(function(){
        $(".bg-accordion .collapse").on("shown.bs.collapse", function(){
            var _key = $(this).data("key");
            $("#bg-caret-" + _key).attr("class", "oi oi-chevron-right");
        });

        $(".bg-accordion .collapse").on("hidden.bs.collapse", function(){
            var _key = $(this).data("key");
            $("#bg-caret-" + _key).attr("class", "oi oi-chevron-bottom");
        });
    });
    </script>

    <script src="<?php echo BG_URL_STATIC; ?>lib/popper/1.12.9/popper.min.js" type="text/javascript"></script>
    <script src="<?php echo BG_URL_STATIC; ?>lib/bootstrap/4.1.3/js/bootstrap.min.js" type="text/javascript"></script>

    <!--
        <?php echo PRD_ADS_POWERED, ' ';
        if (BG_DEFAULT_UI == 'default') {
            echo PRD_ADS_NAME;
        } else {
            echo BG_DEFAULT_UI, ' ADS ';
        }
        echo PRD_ADS_VER; ?>
    -->

    <?php $GLOBALS['obj_plugin']->trigger('action_console_foot_after'); //后台界面底部触发 ?>
</body>
</html>