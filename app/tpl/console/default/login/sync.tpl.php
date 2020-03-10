<?php $cfg = array(
    'title'             => $lang->get('Login'),
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'login_head' . GK_EXT_TPL); ?>

        <h4>
            <span class="oi oi-loop-circular bg-spin"></span>
            <?php echo $lang->get('Redirecting'); ?>
        </h4>
        <div class="mb-3">
            <?php echo $lang->get('If there is no redirect for a long time, please click the "Redirect Now" button!'); ?>
        </div>
        <div class="mb-3">
            <a href="<?php echo $forward; ?>" class="btn btn-primary"><?php echo $lang->get('Redirect immediately'); ?></a>
        </div>

<?php include($cfg['pathInclude'] . 'login_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    $(document).ready(function(){
        <?php if (isset($sync['urlRows']) && !empty($sync['urlRows'])) {
            foreach ($sync['urlRows'] as $key=>$value) { ?>
                $.ajax({
                    url: '<?php echo $value; ?>', //url
                    dataType: 'jsonp' //数据格式为 jsonp 支持跨域提交
                });
            <?php } ?>

            $(this).ajaxStop(function(){
                setTimeout(function(){
                    window.location.href = '<?php echo $forward; ?>';
                }, 1000);
            });
        <?php } else { ?>
            setTimeout(function(){
                window.location.href = '<?php echo $forward; ?>';
            }, 1000);
        <?php } ?>
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);