<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\install;

use app\classes\install\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Upgrade extends Ctrl {

  public function index() {
    $_mix_init = $this->init(false, false);

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_tplData = array(
      'token' => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }

  public function admin() {
    $_mix_init = $this->init(false);

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_tplData = array(
      'token' => $this->obj_request->token(),
    );

    //print_r($this->generalData);

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }

  public function adminCheck() {
    $_mix_init = $this->init(false);

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_return    = array(
      'msg' => '',
    );

    $_str_adminName = $this->obj_request->get('admin_name');

    if (Func::notEmpty($_str_adminName)) {
      $_obj_reg      = Loader::classes('Reg', 'sso', 'console');
      $_mdl_admin    = Loader::model('Admin');

      $_arr_userRow   = $_obj_reg->chkname($_str_adminName);

      if ($_arr_userRow['rcode'] == 'x010404') {
        $_arr_adminRow = $_mdl_admin->check($_arr_userRow['user_id']);
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

  public function adminSubmit() {
    $_mix_init = $this->init(false);

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    $_mdl_admin  = Loader::model('Admin');

    $_arr_inputSubmit = $_mdl_admin->inputSubmit();

    if ($_arr_inputSubmit['rcode'] != 'y020201') {
      return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
    }

    $_obj_reg = Loader::classes('Reg', 'sso', 'console');

    $_arr_userSubmit = array(
      'user_name' => $_arr_inputSubmit['admin_name'],
      'user_pass' => $_arr_inputSubmit['admin_pass'],
      'user_mail' => $_arr_inputSubmit['admin_mail'],
      'user_nick' => $_arr_inputSubmit['admin_nick'],
    );

    $_arr_regResult = $_obj_reg->reg($_arr_userSubmit);

    if ($_arr_regResult['rcode'] != 'y010101') {
      return $this->fetchJson($_arr_regResult['msg'], $_arr_regResult['rcode']);
    }

    $_mdl_admin->inputSubmit['admin_id'] = $_arr_regResult['user_id'];

    $_arr_submitResult = $_mdl_admin->submit();

    return $this->fetchJson($_arr_submitResult['msg'], $_arr_submitResult['rcode']);
  }


  public function auth() {
    $_mix_init = $this->init(false);

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_tplData = array(
      'token' => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function authCheck() {
    $_mix_init = $this->init(false);

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_return    = array(
      'msg' => '',
    );

    $_str_adminName = $this->obj_request->get('admin_name');

    if (Func::notEmpty($_str_adminName)) {
      $_obj_reg      = Loader::classes('Reg', 'sso', 'console');
      $_mdl_admin    = Loader::model('Admin');

      $_arr_userRow  = $_obj_reg->chkname($_str_adminName);

      //print_r($_arr_userRow);

      if ($_arr_userRow['rcode'] == 'x010404') {
        $_arr_adminRow = $_mdl_admin->check($_arr_userRow['user_id']);

        if ($_arr_adminRow['rcode'] == 'y020102') {
          $_arr_return = array(
            'rcode'     => 'x020404',
            'error_msg' => $this->obj_lang->get('Administrator already exists'),
          );
        }
      } else {
        $_arr_return = array(
          'rcode'     => 'x010102',
          'error_msg' => $this->obj_lang->get('User not found, please use add administrator'),
        );
      }
    }

    return $this->json($_arr_return);
  }


  public function authSubmit() {
    $_mix_init = $this->init(false);

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    $_obj_reg    = Loader::classes('Reg', 'sso', 'console');
    $_mdl_admin  = Loader::model('Admin');

    $_arr_inputSubmit = $_mdl_admin->inputAuth();

    if ($_arr_inputSubmit['rcode'] != 'y020201') {
      return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
    }

    //检验用户名是否存在
    $_arr_userRow = $_obj_reg->chkname($_arr_inputSubmit['admin_name']);

    if ($_arr_userRow['rcode'] != 'x010404') {
      return $this->fetchJson('User not found, please use add administrator', 'x010102');
    }

    $_arr_adminRow = $_mdl_admin->check($_arr_userRow['user_id']);
    if ($_arr_adminRow['rcode'] == 'y020102') {
      return $this->fetchJson('Administrator already exists', 'x020404');
    }

    $_mdl_admin->inputSubmit['admin_id']   = $_arr_userRow['user_id'];

    $_arr_authResult = $_mdl_admin->submit();

    return $this->fetchJson($_arr_authResult['msg'], $_arr_authResult['rcode']);
  }


  public function over() {
    $_mix_init = $this->init(false);

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_tplData = array(
      'token' => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }

  public function overSubmit() {
    $_mix_init = $this->init(false);

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    $_arr_inputOver = $this->mdl_opt->inputCommon();

    if ($_arr_inputOver['rcode'] != 'y030201') {
      return $this->fetchJson($_arr_inputOver['msg'], $_arr_inputOver['rcode']);
    }

    $_arr_overResult = $this->mdl_opt->over();

    return $this->fetchJson($_arr_overResult['msg'], $_arr_overResult['rcode']);
  }


  public function data() {
    $_mix_init = $this->init(false);

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_tplData = array(
      'token' => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function dataSubmit() {
    $_mix_init = $this->init(false);

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    $_arr_inputData = $this->mdl_opt->inputData();

    if ($_arr_inputData['rcode'] != 'y030201') {
      return $this->fetchJson($_arr_inputData['msg'], $_arr_inputData['rcode']);
    }

    switch ($_arr_inputData['type']) {
      case 'index':
        $_arr_dataResult = $this->createIndex($_arr_inputData['model']);
      break;

      case 'view':
        $_arr_dataResult = $this->createView($_arr_inputData['model']);
      break;

      case 'alter':
        $_arr_dataResult = $this->alterTable($_arr_inputData['model']);
      break;

      case 'rename':
        $_arr_dataResult = $this->renameTable($_arr_inputData['model']);
      break;

      case 'copy':
        $_arr_dataResult = $this->copyTable($_arr_inputData['model']);
      break;

      default:
        $_arr_dataResult = $this->createTable($_arr_inputData['model']);
      break;
    }

    return $this->fetchJson($_arr_dataResult['msg'], $_arr_dataResult['rcode']);
  }
}
