    <?php use ginkgo\Plugin;

    Plugin::listen('action_pub_foot_before'); ?>

    <script src="{:DIR_STATIC}lib/bootstrap/4.3.1/js/bootstrap.bundle.min.js" type="text/javascript"></script>

    <!-- Powered by <?php echo PRD_ADS_NAME, ' ', PRD_ADS_VER; ?> -->

    <?php Plugin::listen('action_pub_foot_after'); //后台界面底部触发 ?>
</body>
</html>