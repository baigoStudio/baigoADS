<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Config;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Profile extends Ctrl {

  protected function c_init($param = array()) {
    parent::c_init();

    $this->obj_user     = Loader::classes('User', 'sso');
    $this->obj_profile  = Loader::classes('Profile', 'sso');
    $this->mdl_profile  = Loader::model('Profile');

    $_str_hrefBase = $this->hrefBase . 'profile/';

    $_arr_hrefRow = array(
      'secqa-submit'   => $_str_hrefBase . 'secqa-submit/',
      'prefer-submit'  => $_str_hrefBase . 'prefer-submit/',
      'info-submit'    => $_str_hrefBase . 'info-submit/',
      'mailbox-submit' => $_str_hrefBase . 'mailbox-submit/',
      'pass-submit'    => $_str_hrefBase . 'pass-submit/',
    );

    $this->generalData['hrefRow']   = array_replace_recursive($this->generalData['hrefRow'], $_arr_hrefRow);
  }


  public function info() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (isset($this->adminLogged['admin_allow_profile']['info'])) {
      return $this->error('You do not have permission', 'x020305');
    }

    $_arr_tplData = array(
      'token'     => $this->obj_request->token(),
    );

    //print_r($_arr_tplData['timezoneType']);

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function infoSubmit() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (isset($this->adminLogged['admin_allow_profile']['info'])) {
      return $this->fetchJson('You do not have permission', 'x020305');
    }

    $_arr_inputInfo = $this->mdl_profile->inputInfo();

    if ($_arr_inputInfo['rcode'] != 'y020201') {
      return $this->fetchJson($_arr_inputInfo['msg'], $_arr_inputInfo['rcode']);
    }

    $_arr_adminRow = $this->mdl_profile->check($this->adminLogged['admin_id']);
    if ($_arr_adminRow['rcode'] != 'y020102') {
      return $this->fetchJson($_arr_adminRow['msg'], $_arr_adminRow['rcode']);
    }

    $_arr_userSubmit = array(
      'user_pass' => $_arr_inputInfo['admin_pass'],
      'user_nick' => $_arr_inputInfo['admin_nick'],
    );
    $_arr_infoResult = $this->obj_profile->info($this->adminLogged['admin_id'], $_arr_userSubmit);

    if ($_arr_infoResult['rcode'] != 'y010103' && $_arr_infoResult['rcode'] != 'x010103') {
      return $this->fetchJson($_arr_infoResult['msg'], $_arr_infoResult['rcode']);
    }

    $this->mdl_profile->inputInfo['admin_id'] = $this->adminLogged['admin_id'];

    $_arr_infoResult = $this->mdl_profile->info();

    return $this->fetchJson($_arr_infoResult['msg'], $_arr_infoResult['rcode']);
  }


  public function prefer() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (isset($this->adminLogged['admin_allow_profile']['prefer'])) {
      return $this->error('You do not have permission', 'x020305');
    }

    $_arr_preferRows    = Config::get('prefer', 'console.profile');

    foreach ($_arr_preferRows as $_key=>&$_value) {
      foreach ($_value['lists'] as $_key_s=>&$_value_s) {
        if (isset($this->adminLogged['admin_prefer'][$_key][$_key_s])) {
          $_value_s['this'] = $this->adminLogged['admin_prefer'][$_key][$_key_s];
        } else {
          $_value_s['this'] = $this->config['var_prefer'][$_key][$_key_s];
        }
      }
    }

    $_arr_tplData = array(
      'preferRows'    => $_arr_preferRows,
      'token'         => $this->obj_request->token(),
    );

    //print_r($_arr_tplData['timezoneType']);

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function preferSubmit() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (isset($this->adminLogged['admin_allow_profile']['prefer'])) {
      return $this->fetchJson('You do not have permission', 'x020305');
    }

    $_arr_inputPrefer = $this->mdl_profile->inputPrefer();

    if ($_arr_inputPrefer['rcode'] != 'y020201') {
      return $this->fetchJson($_arr_inputPrefer['msg'], $_arr_inputPrefer['rcode']);
    }

    $this->mdl_profile->inputPrefer['admin_id'] = $this->adminLogged['admin_id'];

    $_arr_preferResult = $this->mdl_profile->prefer();

    return $this->fetchJson($_arr_preferResult['msg'], $_arr_preferResult['rcode']);
  }


  public function pass() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (isset($this->adminLogged['admin_allow_profile']['pass'])) {
      return $this->error('You do not have permission', 'x020305');
    }

    $_arr_tplData = array(
      'token'     => $this->obj_request->token(),
    );

    //print_r($_arr_tplData['timezoneType']);

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function passSubmit() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (isset($this->adminLogged['admin_allow_profile']['pass'])) {
      return $this->fetchJson('You do not have permission', 'x020305');
    }

    $_arr_inputPass = $this->mdl_profile->inputPass();

    if ($_arr_inputPass['rcode'] != 'y020201') {
      return $this->fetchJson($_arr_inputPass['msg'], $_arr_inputPass['rcode']);
    }

    $_arr_userSubmit = array(
      'user_pass'     => $_arr_inputPass['admin_pass'],
      'user_pass_new' => $_arr_inputPass['admin_pass_new'],
    );
    $_arr_passResult = $this->obj_profile->pass($this->adminLogged['admin_id'], $_arr_userSubmit);

    return $this->json($_arr_passResult);
  }


  public function secqa() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (isset($this->adminLogged['admin_allow_profile']['secqa'])) {
      return $this->error('You do not have permission', 'x020305');
    }

    $_arr_secqaRows    = Config::get('secqa', 'console.profile');

    $_arr_userRow = $this->obj_user->read($this->adminLogged['admin_id']);

    //print_r($_arr_userRow);

    if (!isset($_arr_userRow['user_sec_ques']) || Func::isEmpty($_arr_userRow['user_sec_ques'])) {
      $_arr_userRow['user_sec_ques'] = array();
    }

    $_arr_tplData = array(
      'userRow'   => $_arr_userRow,
      'secqaRows' => $_arr_secqaRows,
      'token'     => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function secqaSubmit() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (isset($this->adminLogged['admin_allow_profile']['secqa'])) {
      return $this->fetchJson('You do not have permission', 'x020305');
    }

    $_arr_inputSecqa = $this->mdl_profile->inputSecqa();

    if ($_arr_inputSecqa['rcode'] != 'y020201') {
      return $this->fetchJson($_arr_inputSecqa['msg'], $_arr_inputSecqa['rcode']);
    }

    $_arr_userSubmit = array(
      'user_pass'     => $_arr_inputSecqa['admin_pass'],
      'user_sec_ques' => $_arr_inputSecqa['admin_sec_ques'],
      'user_sec_answ' => $_arr_inputSecqa['admin_sec_answ'],
    );
    $_arr_secqaResult = $this->obj_profile->secqa($this->adminLogged['admin_id'], $_arr_userSubmit);

    return $this->json($_arr_secqaResult);
  }


  public function mailbox() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (isset($this->adminLogged['admin_allow_profile']['mailbox'])) {
      return $this->error('You do not have permission', 'x020305');
    }

    $_arr_userRow = $this->obj_user->read($this->adminLogged['admin_id']);

    $_arr_tplData = array(
      'userRow'   => $_arr_userRow,
      'token'     => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function mailboxSubmit() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (isset($this->adminLogged['admin_allow_profile']['mailbox'])) {
      return $this->fetchJson('You do not have permission', 'x020305');
    }

    $_arr_inputMailbox = $this->mdl_profile->inputMailbox();

    if ($_arr_inputMailbox['rcode'] != 'y020201') {
      return $this->fetchJson($_arr_inputMailbox['msg'], $_arr_inputMailbox['rcode']);
    }

    $_arr_userSubmit = array(
      'user_pass'     => $_arr_inputMailbox['admin_pass'],
      'user_mail_new' => $_arr_inputMailbox['admin_mail_new'],
    );
    $_arr_mailboxResult = $this->obj_profile->mailbox($this->adminLogged['admin_id'], $_arr_userSubmit);

    return $this->json($_arr_mailboxResult);
  }
}
