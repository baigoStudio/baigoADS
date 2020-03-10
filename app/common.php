<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿编辑
-----------------------------------------------------------------*/

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

define('PRD_ADS_NAME', 'baigo ADS');
define('PRD_ADS_URL', 'http://www.baigo.net/ads/');
define('PRD_ADS_VER', '3.0-beta-1');
define('PRD_ADS_PUB', 20200310);
define('PRD_ADS_HELP', 'http://doc.baigo.net/ads/');
define('PRD_VER_CHECK', 'http://www.baigo.net/ver_check/check.php');

defined('BG_TPL_INDEX') or define('BG_TPL_INDEX', GK_APP_TPL . 'index' . DS); //前台模板
defined('BG_PATH_CONFIG') or define('BG_PATH_CONFIG', GK_PATH_APP . GK_NAME_CONFIG . DS); //配置文件
defined('BG_PATH_ADVERT') or define('BG_PATH_ADVERT', GK_PATH_PUBLIC . 'advert' . DS); //配置文件

//error_reporting(E_ALL);
