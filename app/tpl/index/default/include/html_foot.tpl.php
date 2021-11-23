  <?php use ginkgo\Plugin;

  Plugin::listen('action_pub_foot_before'); ?>

  <!-- Powered by <?php echo PRD_ADS_NAME, ' ', PRD_ADS_VER; ?> -->

  <?php Plugin::listen('action_pub_foot_after'); //后台界面底部触发 ?>
</body>
</html>
