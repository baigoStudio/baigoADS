<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Plugin;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------管理员控制器-------------*/
class Advert extends Ctrl {

  protected function c_init($param = array()) {
    parent::c_init();

    $this->mdl_posi      = Loader::model('Posi');
    $this->mdl_attach    = Loader::model('Attach');

    $this->mdl_advert    = Loader::model('Advert');

    $this->configBase    = $this->config['var_extra']['base'];

     $_str_hrefBase = $this->hrefBase . 'advert/';

    $_arr_hrefRow = array(
      'index'         => $_str_hrefBase . 'index/',
      'add'           => $_str_hrefBase . 'form/',
      'show'          => $_str_hrefBase . 'show/id/',
      'edit'          => $_str_hrefBase . 'form/id/',
      'submit'        => $_str_hrefBase . 'submit/',
      'delete'        => $_str_hrefBase . 'delete/',
      'status'        => $_str_hrefBase . 'status/',
      'stat'          => $this->url['route_console'] . 'stat_advert/index/id/',
      'posi-show'     => $this->url['route_console'] . 'posi/show/id/',
      'attach-choose' => $this->url['route_console'] . 'attach/choose/',
    );

    for ($_iii=1;$_iii<=10;++$_iii) {
      $_arr_percent[$_iii] = $_iii * 10 . '%';
    }

    $this->generalData['status']    = $this->mdl_advert->arr_status;
    $this->generalData['type']      = $this->mdl_advert->arr_type;
    $this->generalData['percent']   = $_arr_percent;
    $this->generalData['hrefRow']   = array_replace_recursive($this->generalData['hrefRow'], $_arr_hrefRow);
  }


  /*============列出管理员界面============
  无返回
  */
  public function index() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->adminAllow['advert']['browse']) && !$this->isSuper) {
      return $this->error('You do not have permission', 'x080301');
    }

    $_arr_searchParam = array(
      'key'       => array('txt', ''),
      'status'    => array('txt', ''),
      'posi'      => array('int', 0),
    );

    $_arr_search = $this->obj_request->param($_arr_searchParam);

    $_arr_posiRow  = array();

    if ($_arr_search['posi'] > 0) {
      $_arr_posiRow = $this->mdl_posi->read($_arr_search['posi']);
      if (isset($_arr_posiRow['posi_id'])) {
        $_arr_search['posi_id'] = $_arr_search['posi'];
      }
    }

    $_arr_getData    = $this->mdl_advert->lists($this->config['var_default']['perpage'], $_arr_search); //列出

    $_arr_searchPosi    = array(
      'status'    => 'enable'
    );

    $_arr_posiRows  = $this->mdl_posi->lists(array(1000, 'limit'), $_arr_searchPosi);

    $_arr_tplData = array(
      'search'        => $_arr_search,
      'pageRow'       => $_arr_getData['pageRow'],
      'advertRows'    => $_arr_getData['dataRows'],
      'posiRow'       => $_arr_posiRow,
      'posiRows'      => $_arr_posiRows,
      'token'         => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  /*============编辑管理员界面============
  返回提示
  */
  public function show() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->adminAllow['advert']['browse']) && !$this->isSuper) {
      return $this->error('You do not have permission', 'x080301');
    }

    $_num_advertId = 0;

    if (isset($this->param['id'])) {
      $_num_advertId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    if ($_num_advertId < 1) {
      return $this->error('Missing ID', 'x080202');
    }

    $_arr_advertRow = $this->mdl_advert->read($_num_advertId);
    if ($_arr_advertRow['rcode'] != 'y080102') {
      return $this->error($_arr_advertRow['msg'], $_arr_advertRow['rcode']);
    }

    $_arr_posiRow = $this->mdl_posi->read($_arr_advertRow['advert_posi_id']);

    $_arr_attachRow = array(
      'attach_url' => '',
    );

    if ($_arr_posiRow['rcode'] == 'y040102' && $_arr_advertRow['advert_attach_id'] > 0) {
      $_arr_attachRow = $this->mdl_attach->read($_arr_advertRow['advert_attach_id']);
    }

    if (!isset($_arr_attachRow['attach_url'])) {
      $_arr_attachRow['attach_url'] = '';
    }

    $_arr_tplData = array(
      'attachRow'     => $_arr_attachRow,
      'posiRow'       => $_arr_posiRow,
      'advertRow'     => $_arr_advertRow,
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }

  /*============编辑管理员界面============
  返回提示
  */
  public function form() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_num_advertId = 0;

    if (isset($this->param['id'])) {
      $_num_advertId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    $_arr_attachRow = array(
      'attach_url' => '',
    );

    $_arr_posiRow = array();

    $_arr_advertRow = $this->mdl_advert->read($_num_advertId);

    if ($_num_advertId > 0) {
      if (!isset($this->adminAllow['advert']['edit']) && !$this->isSuper) {
        return $this->error('You do not have permission', 'x080303');
      }

      if ($_arr_advertRow['rcode'] != 'y080102') {
        return $this->error($_arr_advertRow['msg'], $_arr_advertRow['rcode']);
      }

      $_arr_posiRow = $this->mdl_posi->read($_arr_advertRow['advert_posi_id']);

      if ($_arr_posiRow['rcode'] == 'y040102' && $_arr_advertRow['advert_attach_id'] > 0) {
        $_arr_attachRow = $this->mdl_attach->read($_arr_advertRow['advert_attach_id']);
      }
    } else {
      if (!isset($this->adminAllow['advert']['add']) && !$this->isSuper) {
        return $this->error('You do not have permission', 'x080302');
      }
    }

    $_arr_search    = array(
      'status'    => 'enable'
    );

    $_arr_posiRows  = $this->mdl_posi->lists(array(1000, 'limit'), $_arr_search);

    if (Func::isEmpty($_arr_posiRows)) {
      return $this->error('Ad position has not created', 'x080401');
    }

    //print_r($_arr_posiRows);

    foreach ($_arr_posiRows as $_key=>$_value) {
      $_arr_posiJson[$_value['posi_id']] = $_value;

      $_arr_searchSum = array(
        'posi_id'   => $_value['posi_id'],
        'status'    => 'enable',
        'is_enable' => true,
        'not_ids'   => array($_arr_advertRow['advert_id']),
      );

      $_arr_posiJson[$_value['posi_id']]['percent_sum'] = $this->mdl_advert->sum($_arr_searchSum);
    }

    if (!isset($_arr_attachRow['attach_url'])) {
        $_arr_attachRow['attach_url'] = '';
    }

    $_arr_tplData = array(
      'posiRow'   => $_arr_posiRow,
      'attachRow' => $_arr_attachRow,
      'advertRow' => $_arr_advertRow,
      'posiRows'  => $_arr_posiRows,
      'posiJson'  => json_encode($_arr_posiJson),
      'token'     => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function submit() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    $_arr_inputSubmit = $this->mdl_advert->inputSubmit();

    if ($_arr_inputSubmit['rcode'] != 'y080201') {
      return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
    }

    if ($_arr_inputSubmit['advert_id'] > 0) {
      if (!isset($this->adminAllow['advert']['edit']) && !$this->isSuper) {
        return $this->fetchJson('You do not have permission', 'x080303');
      }
    } else {
      if (!isset($this->adminAllow['advert']['add']) && !$this->isSuper) {
        return $this->fetchJson('You do not have permission', 'x080302');
      }
    }

    if (!isset($this->adminAllow['advert']['approve']) && !$this->isSuper) {
      $this->mdl_advert->inputSubmit['advert_status'] = 'wait';
    }

    $this->mdl_advert->inputSubmit['advert_admin_id'] = $this->adminLogged['admin_id'];

    $_arr_submitResult = $this->mdl_advert->submit();

    return $this->fetchJson($_arr_submitResult['msg'], $_arr_submitResult['rcode']);
  }


  public function delete() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (!isset($this->adminAllow['advert']['delete']) && !$this->isSuper) { //判断权限
      return $this->fetchJson('You do not have permission', 'x080304');
    }

    $_arr_inputDelete = $this->mdl_advert->inputDelete();

    if ($_arr_inputDelete['rcode'] != 'y080201') {
      return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
    }

    Plugin::listen('action_console_advert_delete', $_arr_inputDelete['advert_ids']); //删除链接时触发

    $_arr_deleteResult = $this->mdl_advert->delete();

    $_arr_langReplace = array(
      'count' => $_arr_deleteResult['count'],
    );

    return $this->fetchJson($_arr_deleteResult['msg'], $_arr_deleteResult['rcode'], '', $_arr_langReplace);
  }


  public function status() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (!isset($this->adminAllow['advert']['edit']) && !$this->isSuper) { //判断权限
      return $this->fetchJson('You do not have permission', 'x080303');
    }

    $_arr_inputStatus = $this->mdl_advert->inputStatus();

    if ($_arr_inputStatus['rcode'] != 'y080201') {
      return $this->fetchJson($_arr_inputStatus['msg'], $_arr_inputStatus['rcode']);
    }

    $_arr_return = array(
      'advert_ids'      => $_arr_inputStatus['advert_ids'],
      'advert_status'   => $_arr_inputStatus['act'],
    );

    Plugin::listen('action_console_advert_status', $_arr_return); //删除链接时触发

    $_arr_statusResult = $this->mdl_advert->status();

    $_arr_langReplace = array(
      'count' => $_arr_statusResult['count'],
    );

    return $this->fetchJson($_arr_statusResult['msg'], $_arr_statusResult['rcode'], '', $_arr_langReplace);
  }
}
