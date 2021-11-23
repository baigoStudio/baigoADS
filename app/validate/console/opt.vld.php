<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\validate\console;

use ginkgo\Config;
use ginkgo\Func;
use app\validate\Opt as Opt_Base;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------设置项模型-------------*/
class Opt extends Opt_Base {

  protected function v_init() { //构造函数
    parent::v_init();

    $_arr_rule = array(
      'limit_size'    => array(
        'require' => true,
        'format'  => 'int'
      ),
      'limit_unit'    => array(
        'require' => true
      ),
      'limit_count'   => array(
        'require' => true,
        'format'  => 'int'
      ),
      'ftp_port'      => array(
        'format'  => 'int'
      ),
      'site_timezone' => array(
        'require' => true
      ),
      'site_tpl' => array(
        'require' => true
      ),
      '__token__' => array(
        'require' => true,
        'token'   => true,
      ),
    );

    $_arr_scene = array(
      'upload' => array(
        'limit_size',
        'limit_unit',
        'limit_count',
        'ftp_port',
        '__token__',
      ),
    );

    $_arr_attrName = array(
      'limit_size'    => $this->obj_lang->get('Upload size limit'),
      'limit_unit'    => $this->obj_lang->get('Upload size unit'),
      'limit_count'   => $this->obj_lang->get('Count per upload'),
      'ftp_port'      => $this->obj_lang->get('Host port'),
      '__token__'     => $this->obj_lang->get('Token'),
    );

    $_arr_formatMsg = array(
      'url' => $this->obj_lang->get('{:attr} not a valid url'),
    );

    $_arr_config = Config::get('opt', 'console');

    foreach ($_arr_config as $_key=>$_value) {
      $_arr_scene[$_key][] = '__token__';

      if ($_key == 'base') {
        $_arr_scene[$_key][] = 'site_timezone';
        $_arr_scene[$_key][] = 'site_tpl';
      }

      if (isset($_value['lists']) && Func::notEmpty($_value['lists'])) {
        foreach ($_value['lists'] as $_key_list=>$_value_list) {
          $_arr_rule[$_key_list]['require'] = $_value_list['require'];

          if (isset($_value_list['format'])) {
            $_arr_rule[$_key_list]['format'] = $_value_list['format'];
          }

          $_arr_scene[$_key][] = $_key_list;
          $_arr_attrName[$_key_list]  = $this->obj_lang->get($_value_list['title']);
        }
      }
    }

    $this->rule($_arr_rule);
    $this->setScene($_arr_scene);
    $this->setAttrName($_arr_attrName);
    $this->setFormatMsg($_arr_formatMsg);
  }
}
