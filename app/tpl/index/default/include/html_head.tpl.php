<?php use ginkgo\Plugin; ?>
<!DOCTYPE html>
<html lang="<?php echo $lang->getCurrent(); ?>">
<head>
  <?php Plugin::listen('action_pub_head_before'); //后台界面头部之前 ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="expires" content="-1">
  <title>
    <?php if (isset($cfg['title'])) {
      echo $cfg['title'];
    }

    if (isset($config['var_extra']['base']['site_name'])) {
      echo ' - ', $config['var_extra']['base']['site_name'];
    } ?>
  </title>

  <link href="{:DIR_STATIC}image/favicon.png" rel="shortcut icon">
  <link href="{:DIR_STATIC}lib/bootstrap/4.6.0/css/bootstrap.min.css" type="text/css" rel="stylesheet">

  <link href="{:DIR_STATIC}css/common.css" type="text/css" rel="stylesheet">
  <link href="{:DIR_STATIC}ads/css/index.css" type="text/css" rel="stylesheet">

  <?php Plugin::listen('action_pub_head_after'); //后台界面头部之后 ?>
</head>
<body class="bg-light">
