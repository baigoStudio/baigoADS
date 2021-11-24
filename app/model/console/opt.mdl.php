<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\modify\Opt as Opt_Modify;
use ginkgo\Loader;
use ginkgo\Config;
use ginkgo\Func;
use ginkgo\File;
use ginkgo\Http;
use ginkgo\Html;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------设置项模型-------------*/
class Opt extends Opt_Modify {

  public $inputSubmit    = array();
  public $inputUpload    = array();
  public $inputData      = array();

  public function __construct() { //构造函数
    parent::__construct();

    $this->configConsoleOpt = Config::get('opt', 'console');

    $this->pathLatest       = GK_PATH_DATA . 'latest' . GK_EXT_INC;
  }

  public function submit() {
    $_arr_opt = array();

    foreach ($this->configConsoleOpt[$this->inputSubmit['act']]['lists'] as $_key=>$_value) {
      if (isset($this->inputSubmit[$_key])) {
        $_arr_opt[$_key] = Html::decode($this->inputSubmit[$_key], 'url');
      }
    }

    if ($this->inputSubmit['act'] == 'base') {
      $_arr_opt['site_timezone']   = Html::decode($this->inputSubmit['site_timezone'], 'url');
      $_arr_opt['site_tpl']        = Html::decode($this->inputSubmit['site_tpl'], 'url');
    }

    $_num_size = Config::write(GK_APP_CONFIG . 'extra_' . $this->inputSubmit['act'] . GK_EXT_INC, $_arr_opt);

    if ($_num_size > 0) {
      $_str_rcode = 'y030401';
      $_str_msg   = 'Set successfully';
    } else {
      $_str_rcode = 'x030401';
      $_str_msg   = 'Set failed';
    }

    return array(
        'rcode' => $_str_rcode,
        'msg'   => $_str_msg,
    );
  }


  public function upload() {
    $_arr_opt = array(
      'limit_size'    => $this->inputUpload['limit_size'],
      'limit_unit'    => $this->inputUpload['limit_unit'],
      'limit_count'   => $this->inputUpload['limit_count'],
      'url_prefix'    => $this->inputUpload['url_prefix'],
      'ftp_host'      => $this->inputUpload['ftp_host'],
      'ftp_port'      => $this->inputUpload['ftp_port'],
      'ftp_user'      => $this->inputUpload['ftp_user'],
      'ftp_pass'      => $this->inputUpload['ftp_pass'],
      'ftp_path'      => $this->inputUpload['ftp_path'],
      'ftp_pasv'      => $this->inputUpload['ftp_pasv'],
    );

    $_num_size   = Config::write(GK_APP_CONFIG . 'extra_upload' . GK_EXT_INC, $_arr_opt);

    if ($_num_size > 0) {
      $_str_rcode = 'y030401';
      $_str_msg   = 'Set successfully';
    } else {
      $_str_rcode = 'x030401';
      $_str_msg   = 'Set failed';
    }

    return array(
      'rcode' => $_str_rcode,
      'msg'   => $_str_msg,
    );
  }


  public function latest($method = 'auto') {
    $_arr_data = array(
      'name'      => 'baigo ADS',
      'ver'       => PRD_ADS_VER,
      'referer'   => $this->obj_request->root(true),
      'method'    => $method,
    );

    $_arr_ver = Http::instance()->request(PRD_VER_CHECK, $_arr_data, 'post');

    $_num_size   = Config::write($this->pathLatest, $_arr_ver);

    if ($_num_size > 0) {
      $_str_rcode = 'y040402';
      $_str_msg   = 'Check for updates successful';
    } else {
      $_str_rcode = 'x040402';
      $_str_msg   = 'Check for updates failed';
    }

    return array(
      'rcode' => $_str_rcode,
      'msg'   => $_str_msg,
    );
  }

  public function chkver() {
    if (!File::fileHas($this->pathLatest)) {
      $this->latest();
    }

    $_arr_ver = Loader::load($this->pathLatest);

    if (Func::isEmpty($_arr_ver) || !isset($_arr_ver['time']) || $_arr_ver['time'] - GK_NOW > 30 * GK_DAY) {
      $this->latest();
      $_arr_ver = Loader::load($this->pathLatest);
    }

    return $_arr_ver;
  }


  public function inputUpload() {
    $_arr_inputParam = array(
      'limit_size'    => array('num', 200),
      'limit_unit'    => array('txt', 'kb'),
      'limit_count'   => array('num', 10),
      'url_prefix'    => array('txt', ''),
      'ftp_host'      => array('txt', ''),
      'ftp_port'      => array('num', 21),
      'ftp_user'      => array('txt', ''),
      'ftp_pass'      => array('txt', ''),
      'ftp_path'      => array('txt', ''),
      'ftp_pasv'      => array('txt', 'off'),
      '__token__'     => array('txt', ''),
    );

    $_arr_inputUpload = $this->obj_request->post($_arr_inputParam);

    $_is_vld = $this->vld_opt->scene('upload')->verify($_arr_inputUpload);

    if ($_is_vld !== true) {
      $_arr_message = $this->vld_opt->getMessage();
      return array(
        'rcode' => 'x030201',
        'msg'   => end($_arr_message),
      );
    }

    $_arr_inputUpload['rcode'] = 'y030201';

    $this->inputUpload = $_arr_inputUpload;

    return $_arr_inputUpload;
  }


  public function inputSubmit() {
    $_arr_inputParam = array(
      '__token__' => array('txt', ''),
      'act'       => array('txt', ''),
    );

    $_str_act = $this->obj_request->post('act');

    foreach ($this->configConsoleOpt[$_str_act]['lists'] as $_key=>$_value) {
      $_arr_inputParam[$_key] = array('txt', '');
    }

    if ($_str_act == 'base') {
      $_arr_inputParam['site_timezone']   = array('txt', '');
      $_arr_inputParam['site_tpl']        = array('txt', '');
    }

    $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

    $_is_vld = $this->vld_opt->scene($_str_act)->verify($_arr_inputSubmit);

    if ($_is_vld !== true) {
      $_arr_message = $this->vld_opt->getMessage();
      return array(
        'rcode' => 'x030201',
        'msg'   => end($_arr_message),
      );
    }

    $_arr_inputSubmit['rcode'] = 'y030201';

    $this->inputSubmit = $_arr_inputSubmit;

    return $_arr_inputSubmit;
  }


  public function inputData() {
    $_arr_inputParam = array(
      'type'      => array('str', ''),
      'model'     => array('str', ''),
      '__token__' => array('str', ''),
    );

    $_arr_inputData = $this->obj_request->post($_arr_inputParam);

    $_is_vld = $this->vld_opt->scene('data')->verify($_arr_inputData);

    if ($_is_vld !== true) {
      $_arr_message = $this->vld_opt->getMessage();
      return array(
        'rcode' => 'x030201',
        'msg'   => end($_arr_message),
      );
    }

    $_arr_inputData['rcode'] = 'y030201';

    $this->inputData = $_arr_inputData;

    return $_arr_inputData;
  }
}
