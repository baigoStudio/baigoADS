<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Plugin;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

class Link extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_link    = Loader::model('Link');

        $this->generalData['status']    = $this->mdl_link->arr_status;
    }


    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->adminAllow['link']['browse']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x240301');
        }

        $_arr_searchParam = array(
            'key'       => array('txt', ''),
            'status'    => array('txt', ''),
        );

        $_arr_search = $this->obj_request->param($_arr_searchParam);

        $_num_linkCount   = $this->mdl_link->count($_arr_search); //统计记录数
        $_arr_pageRow     = $this->obj_request->pagination($_num_linkCount); //取得分页数据
        $_arr_linkRows    = $this->mdl_link->lists($this->config['var_default']['perpage'], $_arr_pageRow['except'], $_arr_search); //列出

        $_arr_tplData = array(
            'pageRow'    => $_arr_pageRow,
            'search'     => $_arr_search,
            'linkRows'   => $_arr_linkRows,
            'token'      => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_linkRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function show() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->adminAllow['link']['browse']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x240301');
        }

        $_num_linkId = 0;

        if (isset($this->param['id'])) {
            $_num_linkId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_linkId < 1) {
            return $this->error('Missing ID', 'x240202');
        }

        $_arr_linkRow = $this->mdl_link->read($_num_linkId);

        if ($_arr_linkRow['rcode'] != 'y240102') {
            return $this->error($_arr_linkRow['msg'], $_arr_linkRow['rcode']);
        }

        $_arr_tplData = array(
            'linkRow'  => $_arr_linkRow,
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_linkRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function form() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_linkId = 0;

        if (isset($this->param['id'])) {
            $_num_linkId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_linkId > 0) {
            if (!isset($this->adminAllow['link']['edit']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x240303');
            }

            $_arr_linkRow = $this->mdl_link->read($_num_linkId);

            if ($_arr_linkRow['rcode'] != 'y240102') {
                return $this->error($_arr_linkRow['msg'], $_arr_linkRow['rcode']);
            }
        } else {
            if (!isset($this->adminAllow['link']['add']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x240302');
            }

            $_arr_linkRow = array(
                'link_id'      => 0,
                'link_name'    => '',
                'link_status'  => $this->mdl_link->arr_status[0],
                'link_url'     => '',
                'link_blank'   => '',
            );
        }

        $_arr_tplData = array(
            'linkRow'   => $_arr_linkRow,
            'token'     => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_linkRows);

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

        $_arr_inputSubmit = $this->mdl_link->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y240201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        if ($_arr_inputSubmit['link_id'] > 0) {
            if (!isset($this->adminAllow['link']['edit']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x240303');
            }
        } else {
            if (!isset($this->adminAllow['link']['add']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x240302');
            }
        }

        $_arr_submitResult = $this->mdl_link->submit();
        $this->mdl_link->cache();

        return $this->fetchJson($_arr_submitResult['msg'], $_arr_submitResult['rcode']);
    }


    function order() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->adminAllow['link']['edit']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x240301');
        }

        $_arr_linkRows  = $this->mdl_link->lists(1000, 0); //列出

        $_arr_tplData = array(
            'linkRows'   => $_arr_linkRows,
            'token'      => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_linkRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function orderSubmit() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->adminAllow['link']['edit']) && !$this->isSuper) {
            return $this->fetchJson('You do not have permission', 'x240303');
        }

        $_arr_inputOrder = $this->mdl_link->inputOrder();

        if ($_arr_inputOrder['rcode'] != 'y240201') {
            return $this->fetchJson($_arr_inputOrder['msg'], $_arr_inputOrder['rcode']);
        }

        $_arr_orderResult = $this->mdl_link->order();

        $this->mdl_link->cache();

        return $this->fetchJson($_arr_orderResult['msg'], $_arr_orderResult['rcode']);
    }


    function delete() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->adminAllow['link']['delete']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x240304');
        }

        $_arr_inputDelete = $this->mdl_link->inputDelete();

        if ($_arr_inputDelete['rcode'] != 'y240201') {
            return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
        }

        Plugin::listen('action_console_link_status', $_arr_inputDelete['link_ids']); //删除链接时触发

        $_arr_deleteResult = $this->mdl_link->delete();

        $this->mdl_link->cache();

        $_arr_langReplace = array(
            'count' => $_arr_deleteResult['count'],
        );

        return $this->fetchJson($_arr_deleteResult['msg'], $_arr_deleteResult['rcode'], '', $_arr_langReplace);
    }


    function status() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->adminAllow['link']['edit']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x240303');
        }

        $_arr_inputStatus = $this->mdl_link->inputStatus();

        if ($_arr_inputStatus['rcode'] != 'y240201') {
            return $this->fetchJson($_arr_inputStatus['msg'], $_arr_inputStatus['rcode']);
        }

        $_arr_return = array(
            'link_ids'      => $_arr_inputStatus['link_ids'],
            'link_status'   => $_arr_inputStatus['act'],
        );

        Plugin::listen('action_console_link_status', $_arr_return); //删除链接时触发

        $_arr_statusResult = $this->mdl_link->status();

        $this->mdl_link->cache();

        $_arr_langReplace = array(
            'count' => $_arr_statusResult['count'],
        );

        return $this->fetchJson($_arr_statusResult['msg'], $_arr_statusResult['rcode'], '', $_arr_langReplace);
    }


    function cache() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_arr_inputCommon = $this->mdl_link->inputCommon();

        if ($_arr_inputCommon['rcode'] != 'y240201') {
            return $this->fetchJson($_arr_inputCommon['msg'], $_arr_inputCommon['rcode']);
        }

        $_arr_cacheResult = $this->mdl_link->cache();

        return $this->fetchJson($_arr_cacheResult['msg'], $_arr_cacheResult['rcode']);
    }
}
