<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

require(__DIR__ . DIRECTORY_SEPARATOR . 'base.php'); //载入基础引导文件

ginkgo\App::run()->send('boot'); //运行并输出
