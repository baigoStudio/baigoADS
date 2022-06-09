## 获取广告代码与使用

开发工作完成后，请将文件上传至 `./public/advert/` 目录，然后在管理后台创建（编辑）广告位，选择新上传的脚本，保存成功后，点击 “查看”，将示例代码复制到需要显示广告的网页即可。

为了更灵活的运用，您也可以自行修改代码，以便达到您需要的目的。

建议将 JavaScript 和 CSS 放置在 `<head>` 之间，广告容器 放置在需要显示的位置。注意：如果脚本依赖 JS 库，如 jQuery、Bootstrap 等，还需要引入这些库。

示例代码

``` markup
<!DOCTYPE html>
<html lang="zh_CN">
  <head>
    <title>advert</title>

    <!-- 依赖 - 0 begin -->
    <script src="/ads/public/static/lib/1.11.1/jquery.min.js" type="text/javascript"></script>
    <!-- 依赖 - 0 end -->

    <!-- 广告 CSS begin -->
    <link href="/ads/public/install/couplet/couplet.css" type="text/css" rel="stylesheet">
    <!-- 广告 CSS end -->

    <!-- 广告脚本 begin -->
    <script src="/ads/public/install/couplet/couplet.min.js" type="text/javascript"></script>
    <!-- 广告脚本 end -->
  </head>
  <body>

    <!-- 广告容器 begin -->
    <div id="adsCouplet_12"></div>
    <!-- 广告容器 end -->

    <!-- 初始化 begin -->
    <script type="text/javascript">
    opts_ad_12 = {"data_url":"/ads/public/index.php/posi/12","remain":"top","top":"50px","bottom":"50px","left":"10px","right":"10px"};

    $(document).ready(function(){
      $('#adsCouplet_12').adsCouplet(opts_ad_12);
    });
    </script>
    <!-- 初始化 end -->

  </body>
</html>
```
