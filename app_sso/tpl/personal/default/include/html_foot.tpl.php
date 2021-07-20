    <?php use ginkgo\Plugin;

    Plugin::listen('action_personal_foot_before'); //后台界面底部触发

    if (isset($cfg['baigoValidate'])) { ?>
        <!--表单验证 js-->
        <script src="{:DIR_STATIC}lib/baigoValidate/3.1.0/baigoValidate.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['baigoSubmit'])) { ?>
        <!--表单 ajax 提交 js-->
        <script src="{:DIR_STATIC}lib/baigoSubmit/2.1.3/baigoSubmit.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['baigoQuery'])) { ?>
        <!--全选 js-->
        <script src="{:DIR_STATIC}lib/baigoQuery/1.0.0/baigoQuery.min.js" type="text/javascript"></script>
    <?php } ?>

    <script type="text/javascript">
    <?php if (isset($cfg['captchaReload'])) { ?>
        function captchaReload(id) {
            var imgSrc = '<?php echo $route_misc; ?>captcha/index/';

            if (typeof id != 'undefined') {
                imgSrc += 'id/' + id + '/';
            }

            imgSrc += new Date().getTime() + '/' + Math.random() + '/';

            $('.bg-captcha-img').attr('src', imgSrc);
        }
    <?php } ?>

    $(document).ready(function(){
        <?php if (isset($cfg['captchaReload'])) { ?>
            /*重新载入图片 js*/
            $('.bg-captcha-img').click(function(){
                var _id = $(this).data('id');

                captchaReload(_id);
            });
        <?php } ?>

        $('#loading_mask').fadeOut();
    });
    </script>

    <script src="{:DIR_STATIC}lib/bootstrap/4.5.2/js/bootstrap.bundle.min.js" type="text/javascript"></script>

    <!-- Powered by <?php echo PRD_SSO_NAME, ' ', PRD_SSO_VER; ?> -->

    <?php Plugin::listen('action_personal_foot_after'); //个人界面底部触发 ?>
</body>
</html>
