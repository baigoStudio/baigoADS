<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Admin extends Ctrl {

  protected function c_init($param = array()) {
    parent::c_init();

    $this->obj_user     = Loader::classes('User', 'sso');
    $this->obj_reg      = Loader::classes('Reg', 'sso');

    $this->mdl_admin    = Loader::model('Admin');

    $_str_hrefBase = $this->hrefBase . 'admin/';

    $_arr_hrefRow = array(
      'index'        => $_str_hrefBase . 'index/',
      'add'          => $_str_hrefBase . 'form/',
      'show'         => $_str_hrefBase . 'show/id/',
      'edit'         => $_str_hrefBase . 'form/id/',
      'submit'       => $_str_hrefBase . 'submit/',
      'delete'       => $_str_hrefBase . 'delete/',
      'status'       => $_str_hrefBase . 'status/',
      'chkname'      => $_str_hrefBase . 'chkname/',
      'chkmail'      => $_str_hrefBase . 'chkmail/',
      'auth'         => $this->url['route_console'] . 'auth/form/',
    );

    $this->generalData['status']    = $this->mdl_admin->arr_status;
    $this->generalData['type']      = $this->mdl_admin->arr_type;
    $this->generalData['hrefRow']   = array_replace_recursive($this->generalData['hrefRow'], $_arr_hrefRow);
  }


  public function index() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->adminAllow['admin']['browse']) && !$this->isSuper) { //判断权限
      return $this->error('You do not have permission', 'x020301');
    }

    $_arr_searchParam = array(
      'key'       => array('txt', ''),
      'status'    => array('txt', ''),
      'type'      => array('txt', ''),
    );

    $_arr_search    = $this->obj_request->param($_arr_searchParam);
    $_arr_getData   = $this->mdl_admin->lists($this->config['var_default']['perpage'], $_arr_search); //列出

    $_arr_tplData = array(
      'search'     => $_arr_search,
      'pageRow'    => $_arr_getData['pageRow'],
      'adminRows'  => $_arr_getData['dataRows'],
      'token'      => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function show() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->adminAllow['admin']['browse']) && !$this->isSuper) { //判断权限
      return $this->error('You do not have permission', 'x020301');
    }

    $_num_adminId = 0;

    if (isset($this->param['id'])) {
      $_num_adminId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    if ($_num_adminId < 1) {
      return $this->error('Missing ID', 'x020202');
    }

    $_arr_userRow = $this->obj_user->read($_num_adminId);

    if ($_arr_userRow['rcode'] != 'y010102') {
      return $this->error($_arr_userRow['msg'], $_arr_userRow['rcode']);
    }

    $_arr_adminRow = $this->mdl_admin->read($_num_adminId);

    if ($_arr_adminRow['rcode'] != 'y020102') {
      return $this->error($_arr_adminRow['msg'], $_arr_adminRow['rcode']);
    }

    $_arr_tplData = array(
      'userRow'   => $_arr_userRow,
      'adminRow'  => $_arr_adminRow,
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function form() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_num_adminId = 0;

    if (isset($this->param['id'])) {
      $_num_adminId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    $_arr_userRow  = $this->obj_user->read($_num_adminId);
    $_arr_adminRow = $this->mdl_admin->read($_num_adminId);

    if ($_num_adminId > 0) {
      if (!isset($this->adminAllow['admin']['edit']) && !$this->isSuper) { //判断权限
        return $this->error('You do not have permission', 'x020303');
      }
      if ($_num_adminId == $this->adminLogged['admin_id'] && !$this->isSuper) {
        return $this->error('Prohibit editing yourself', 'x020306');
      }

      if ($_arr_userRow['rcode'] != 'y010102') {
        return $this->error($_arr_userRow['msg'], $_arr_userRow['rcode']);
      }

      if ($_arr_adminRow['rcode'] != 'y020102') {
        return $this->error($_arr_adminRow['msg'], $_arr_adminRow['rcode']);
      }
    } else {
      if (!isset($this->adminAllow['admin']['add']) && !$this->isSuper) { //判断权限
        return $this->error('You do not have permission', 'x020302');
      }

      $_arr_userRow = array(
        'user_mail' => '',
      );
    }

    //print_r($_arr_adminRow);


    $_arr_tplData = array(
      'userRow'   => $_arr_userRow,
      'adminRow'  => $_arr_adminRow,
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

    $_arr_inputSubmit = $this->mdl_admin->inputSubmit();

    if ($_arr_inputSubmit['rcode'] != 'y020201') {
      return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
    }

    if ($_arr_inputSubmit['admin_id'] > 0) {
      if (!isset($this->adminAllow['admin']['edit']) && !$this->isSuper) {
        return $this->fetchJson('You do not have permission', 'x020303');
      }

      if ($_arr_inputSubmit['admin_id'] == $this->adminLogged['admin_id'] && !$this->isSuper) {
        return $this->fetchJson('Prohibit editing yourself', 'x020306');
      }

      $_arr_userSubmit = array();

      if (Func::notEmpty($_arr_inputSubmit['admin_mail_new'])) {
        $_arr_userSubmit['user_mail_new'] = $_arr_inputSubmit['admin_mail_new'];
      }

      if (Func::notEmpty($_arr_inputSubmit['admin_pass'])) {
        $_arr_userSubmit['user_pass'] = $_arr_inputSubmit['admin_pass'];
      }

      if (Func::notEmpty($_arr_userSubmit)) {
        $_arr_editResult = $this->obj_user->edit($_arr_inputSubmit['admin_id'], $_arr_userSubmit);
      }
    } else {
      if (!isset($this->adminAllow['admin']['add']) && !$this->isSuper) {
        return $this->fetchJson('You do not have permission', 'x020302');
      }

      $_arr_userSubmit = array(
        'user_name' => $_arr_inputSubmit['admin_name'],
        'user_pass' => $_arr_inputSubmit['admin_pass'],
        'user_mail' => $_arr_inputSubmit['admin_mail'],
        'user_nick' => $_arr_inputSubmit['admin_nick'],
      );

      $_arr_regResult = $this->obj_reg->reg($_arr_userSubmit);

      $this->mdl_admin->inputSubmit['admin_id'] = $_arr_regResult['user_id'];
    }

    $_arr_submitResult = $this->mdl_admin->submit();

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

    if (!isset($this->adminAllow['admin']['delete']) && !$this->isSuper) { //判断权限
      return $this->fetchJson('You do not have permission', 'x020304');
    }

    $_arr_inputDelete = $this->mdl_admin->inputDelete();

    if ($_arr_inputDelete['rcode'] != 'y020201') {
      return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
    }

    $_arr_deleteResult = $this->mdl_admin->delete();

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

    if (!isset($this->adminAllow['admin']['edit']) && !$this->isSuper) { //判断权限
      return $this->fetchJson('You do not have permission', 'x020303');
    }

    $_arr_inputStatus = $this->mdl_admin->inputStatus();

    if ($_arr_inputStatus['rcode'] != 'y020201') {
      return $this->fetchJson($_arr_inputStatus['msg'], $_arr_inputStatus['rcode']);
    }

    $_arr_statusResult = $this->mdl_admin->status();

    $_arr_langReplace = array(
      'count' => $_arr_statusResult['count'],
    );

    return $this->fetchJson($_arr_statusResult['msg'], $_arr_statusResult['rcode'], '', $_arr_langReplace);
  }


  public function chkname() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_return = array(
      'msg' => '',
    );

    $_str_adminName = $this->obj_request->get('admin_name');

    if (Func::notEmpty($_str_adminName)) {
      $_arr_userRow   = $this->obj_reg->chkname($_str_adminName);

      if ($_arr_userRow['rcode'] == 'x010404') {
        $_arr_adminRow = $this->mdl_admin->check($_arr_userRow['user_id']);
        if ($_arr_adminRow['rcode'] == 'y020102') {
          $_arr_return = array(
            'rcode'     => 'x020404',
            'error_msg' => $this->obj_lang->get('Administrator already exists'),
          );
        } else {
          $_arr_return = array(
            'rcode'     => $_arr_userRow['rcode'],
            'error_msg' => $this->obj_lang->get('User already exists, please use authorization as administrator'),
          );
        }
      }
    }

    return $this->json($_arr_return);
  }


  public function chkmail() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_return = array(
      'msg' => '',
    );

    $_str_adminMail = $this->obj_request->get('admin_mail');

    if (Func::notEmpty($_str_adminMail)) {
      $_arr_userRow   = $this->obj_reg->chkmail($_str_adminMail);

      if ($_arr_userRow['rcode'] == 'x010404') {
        $_arr_adminRow = $this->mdl_admin->check($_arr_userRow['user_id']);
        if ($_arr_adminRow['rcode'] == 'y020102') {
          $_arr_return = array(
            'rcode'     => 'x020404',
            'error_msg' => $this->obj_lang->get('Administrator already exists'),
          );
        } else {
          $_arr_return = array(
            'rcode'     => $_arr_userRow['rcode'],
            'error_msg' => $this->obj_lang->get('User already exists, please use authorization as administrator'),
          );
        }
      }
    }

    return $this->json($_arr_return);
  }
}
