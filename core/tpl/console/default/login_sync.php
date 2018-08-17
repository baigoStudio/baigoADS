<?php $cfg = array(
    'title'          => $this->lang['mod']['page']['login'],
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
);

include($cfg['pathInclude'] . 'login_head.php'); ?>

        <h4>
            <span class="oi oi-loop-circular bg-spin"></span>
            <?php echo $this->lang['mod']['label']['submitting']; ?>
        </h4>
        <div class="mb-3">
            <?php echo $this->lang['mod']['text']['notForward']; ?>
        </div>
        <div class="mb-3">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php" class="btn btn-primary"><?php echo $this->lang['mod']['href']['forward']; ?></a>
        </div>

<?php include($cfg['pathInclude'] . 'login_foot.php'); ?>

    <script type="text/javascript">
    $(document).ready(function(){
        <?php if (isset($this->tplData['sync']['urlRows']) && !fn_isEmpty($this->tplData['sync']['urlRows'])) {
            foreach ($this->tplData['sync']['urlRows'] as $key=>$value) { ?>
                $.ajax({
                    url: "<?php echo $value; ?>", //url
                    dataType: "jsonp" //数据格式为 jsonp 支持跨域提交
                });
            <?php } ?>

            $(this).ajaxStop(function(){
                setTimeout(function(){
                    window.location.href = "<?php echo $this->tplData['forward']; ?>";
                }, 1000);
            });
        <?php } else { ?>
            setTimeout(function(){
                window.location.href = "<?php echo $this->tplData['forward']; ?>";
            }, 1000);
        <?php } ?>
    });
    </script>

<?php include('include' . DS . 'html_foot.php');