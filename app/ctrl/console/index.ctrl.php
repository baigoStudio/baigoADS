<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

class Index extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_profile  = Loader::model('Profile');

        $this->mdl_advert   = Loader::model('Advert');
        $this->mdl_posi     = Loader::model('Posi');
        $this->mdl_admin    = Loader::model('Admin');
        $this->mdl_attach   = Loader::model('Attach');
        $this->mdl_link     = Loader::model('Link');

        $this->generalData['status_advert'] = $this->mdl_advert->arr_status;
        $this->generalData['status_posi']   = $this->mdl_posi->arr_status;
        $this->generalData['status_admin']  = $this->mdl_admin->arr_status;
        $this->generalData['type_admin']    = $this->mdl_admin->arr_type;
        $this->generalData['status_link']   = $this->mdl_link->arr_status;
    }

    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_posiCount['total'] = $this->mdl_posi->count();

        foreach ($this->mdl_posi->arr_status as $_key=>$_value) {
            $_arr_search = array(
                'status' => $_value,
            );
            $_arr_posiCount[$_value] = $this->mdl_posi->count($_arr_search);
        }

        $_arr_advertCount['total'] = $this->mdl_advert->count();

        foreach ($this->mdl_advert->arr_status as $_key=>$_value) {
            $_arr_search = array(
                'status' => $_value,
            );
            $_arr_advertCount[$_value] = $this->mdl_advert->count($_arr_search);
        }

        $_arr_search = array(
            'box' => 'normal',
        );
        $_arr_attachCount['total'] = $this->mdl_attach->count($_arr_search);

        $_arr_adminCount['total'] = $this->mdl_admin->count();

        foreach ($this->mdl_admin->arr_status as $_key=>$_value) {
            $_arr_search = array(
                'status' => $_value,
            );
            $_arr_adminCount[$_value] = $this->mdl_admin->count($_arr_search);
        }

        foreach ($this->mdl_admin->arr_type as $_key=>$_value) {
            $_arr_search = array(
                'type' => $_value,
            );
            $_arr_adminCount[$_value] = $this->mdl_admin->count($_arr_search);
        }

        $_arr_linkCount['total'] = $this->mdl_link->count();

        foreach ($this->mdl_link->arr_status as $_key=>$_value) {
            $_arr_search = array(
                'status' => $_value,
            );
            $_arr_linkCount[$_value] = $this->mdl_link->count($_arr_search);
        }

        $_arr_tplData = array(
            'admin_count'   => $_arr_adminCount,
            'attach_count'  => $_arr_attachCount,
            'link_count'    => $_arr_linkCount,
            'advert_count'  => $_arr_advertCount,
            'posi_count'    => $_arr_posiCount,
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function setting() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_tplData = array(
            'token'     => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function submit() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_arr_inputShortcut = $this->mdl_profile->inputShortcut();

        if ($_arr_inputShortcut['rcode'] != 'y020201') {
            return $this->fetchJson($_arr_inputShortcut['msg'], $_arr_inputShortcut['rcode']);
        }

        $this->mdl_profile->inputShortcut['admin_id'] = $this->adminLogged['admin_id'];

        $_arr_submitResult = $this->mdl_profile->shortcut();

        return $this->fetchJson($_arr_submitResult['msg'], $_arr_submitResult['rcode']);
    }
}
