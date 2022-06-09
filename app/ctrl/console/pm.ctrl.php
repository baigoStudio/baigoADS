<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Ubbcode;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Pm extends Ctrl {

  protected function c_init($param = array()) {
    parent::c_init();

    $this->obj_pm   = Loader::classes('Pm', 'sso');
    $this->mdl_pm   = Loader::model('Pm');

    $_str_hrefBase = $this->hrefBase . 'pm/';

    $_arr_hrefRow = array(
      'index'       => $_str_hrefBase . 'index/',
      'index-from'  => $_str_hrefBase . 'index/from/',
      'index-to'    => $_str_hrefBase . 'index/to/',
      'show'        => $_str_hrefBase . 'show/id/',
      'reply'       => $_str_hrefBase . 'send/id/',
      'send-submit' => $_str_hrefBase . 'send-submit/',
      'delete'      => $_str_hrefBase . 'delete/',
      'status'      => $_str_hrefBase . 'status/',
      'revoke'      => $_str_hrefBase . 'revoke/',
      'admin-show'  => $this->url['route_console'] . 'admin/show/id/',
    );

    $this->generalData['hrefRow']   = array_replace_recursive($this->generalData['hrefRow'], $_arr_hrefRow);
  }


  public function index() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_searchParam = array(
      'key'       => array('str', ''),
      'status'    => array('str', ''),
      'type'      => array('str', 'in'),
      'page'      => array('int', 1),
    );

    $_arr_search = $this->obj_request->param($_arr_searchParam);

    $_arr_pmSubmit = array(
      'user_access_token' => $this->adminLogged['admin_access_token'],
      'pm_type'           => $_arr_search['type'],
      'pm_status'         => $_arr_search['status'],
      'key'               => $_arr_search['key'],
      'page'              => $_arr_search['page'],
    );
    $_arr_reseult   = $this->obj_pm->lists($this->adminLogged['admin_id'], $_arr_pmSubmit);

    if (!isset($_arr_reseult['pmRows']) || Func::isEmpty($_arr_reseult['pmRows'])) {
      $_arr_reseult = array(
        'pageRow'   => $this->obj_request->pagination(0),
        'pmRows'    => array(),
      );
    }

    $_arr_tplData = array(
      'search'        => $_arr_search,
      'pageRow'       => $_arr_reseult['pageRow'],
      'pmRows'        => $_arr_reseult['pmRows'],
      'token'         => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_pmRows);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function show() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_num_pmId = 0;

    if (isset($this->param['id'])) {
      $_num_pmId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    if ($_num_pmId < 1) {
      return $this->error('Missing ID', 'x110202');
    }

    $_arr_pmSubmit = array(
      'user_access_token' => $this->adminLogged['admin_access_token'],
      'pm_id'             => $_num_pmId,
    );

    $_arr_pmRow = $this->obj_pm->read($this->adminLogged['admin_id'], $_arr_pmSubmit);

    if ($_arr_pmRow['rcode'] != 'y110102') {
      return $this->error($_arr_pmRow['msg'], $_arr_pmRow['msg']);
    }

    $_arr_pmSubmit = array(
      'user_access_token' => $this->adminLogged['admin_access_token'],
      'pm_status'         => 'read',
      'pm_ids'            => array($_num_pmId),
    );

    $this->obj_pm->status($this->adminLogged['admin_id'], $_arr_pmSubmit);

    $_arr_pmRow['pm_title']     = Ubbcode::convert($_arr_pmRow['pm_title']);
    $_arr_pmRow['pm_content']   = Ubbcode::convert($_arr_pmRow['pm_content']);

    $_arr_tplData = array(
      'pmRow' => $_arr_pmRow,
      'token' => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_pmRows);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function send() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_num_pmId = 0;

    if (isset($this->param['id'])) {
      $_num_pmId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    $_arr_pmRow     = array(
      'pm_title'      => '',
      'pm_content'    => '',
      'fromUser' => array(
        'user_name' => '',
      ),
    );

    if ($_num_pmId > 0) {
      $_arr_pmSubmit = array(
        'user_access_token' => $this->adminLogged['admin_access_token'],
        'pm_id'             => $_num_pmId,
      );

      $_arr_pmRow = $this->obj_pm->read($this->adminLogged['admin_id'], $_arr_pmSubmit);

      if ($_arr_pmRow['rcode'] != 'y110102') {
        return $this->error($_arr_pmRow['msg'], $_arr_pmRow['msg']);
      }

      if (!isset($_arr_pmRow['fromUser']['user_name'])) {
        $_arr_pmRow['fromUser']['user_name'] = '';
      }

      $_arr_pmRow['pm_title']   = $this->obj_lang->get('Re') . ': ' . Ubbcode::convert($_arr_pmRow['pm_title']);
      $_arr_pmRow['pm_content'] = PHP_EOL . PHP_EOL . PHP_EOL . '------------------------------------------------' . PHP_EOL . Ubbcode::convert($_arr_pmRow['pm_content']);
    }

    $_arr_tplData = array(
      'pmRow'     => $_arr_pmRow,
      'token'     => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_pmRows);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function sendSubmit() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    $_arr_inputSend = $this->mdl_pm->inputSend();

    if ($_arr_inputSend['rcode'] != 'y110201') {
      return $this->fetchJson($_arr_inputSend['msg'], $_arr_inputSend['rcode']);
    }

    $_arr_pmSubmit = array(
      'user_access_token' => $this->adminLogged['admin_access_token'],
      'pm_to_name'        => $_arr_inputSend['pm_to_name'],
      'pm_title'          => $_arr_inputSend['pm_title'],
      'pm_content'        => $_arr_inputSend['pm_content'],
    );

    $_arr_sendResult = $this->obj_pm->send($this->adminLogged['admin_id'], $_arr_pmSubmit);

    return $this->json($_arr_sendResult);
  }


  public function revoke() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    $_arr_inputRevoke = $this->mdl_pm->inputDelete();

    if ($_arr_inputRevoke['rcode'] != 'y110201') {
      return $this->fetchJson($_arr_inputRevoke['msg'], $_arr_inputRevoke['rcode']);
    }

    $_arr_pmSubmit = array(
      'user_access_token' => $this->adminLogged['admin_access_token'],
      'pm_ids'            => $_arr_inputRevoke['pm_ids'],
    );

    $_arr_revokeResult = $this->obj_pm->revoke($this->adminLogged['admin_id'], $_arr_pmSubmit);

    return $this->json($_arr_revokeResult);
  }


  public function delete() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    $_arr_inputDelete = $this->mdl_pm->inputDelete();

    if ($_arr_inputDelete['rcode'] != 'y110201') {
      return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
    }

    $_arr_pmSubmit = array(
      'user_access_token' => $this->adminLogged['admin_access_token'],
      'pm_ids'            => $_arr_inputDelete['pm_ids'],
    );

    $_arr_deleteResult = $this->obj_pm->delete($this->adminLogged['admin_id'], $_arr_pmSubmit);

    return $this->json($_arr_deleteResult);
  }


  public function status() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    $_arr_inputStatus = $this->mdl_pm->inputStatus();

    if ($_arr_inputStatus['rcode'] != 'y110201') {
      return $this->fetchJson($_arr_inputStatus['msg'], $_arr_inputStatus['rcode']);
    }

    $_arr_pmSubmit = array(
      'user_access_token' => $this->adminLogged['admin_access_token'],
      'pm_ids'            => $_arr_inputStatus['pm_ids'],
      'pm_status'         => $_arr_inputStatus['act'],
    );

    $_arr_statusResult = $this->obj_pm->status($this->adminLogged['admin_id'], $_arr_pmSubmit);

    return $this->json($_arr_statusResult);
  }
}
