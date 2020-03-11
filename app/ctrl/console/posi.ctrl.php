<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Plugin;
use ginkgo\File;
use ginkgo\Json;
use ginkgo\Func;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

class Posi extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->obj_file         = File::instance();

        $this->mdl_attach  = Loader::model('Attach');
        $this->mdl_advert  = Loader::model('Advert');

        $this->mdl_posi    = Loader::model('Posi');

        $this->generalData['status']        = $this->mdl_posi->arr_status;
        $this->generalData['is_percent']    = $this->mdl_posi->arr_isPercent;
    }


    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->adminAllow['posi']['browse']) && !$this->isSuper) {
            return $this->error('You do not have permission', 'x040301');
        }

        $_arr_searchParam = array(
            'key'       => array('txt', ''),
            'status'    => array('txt', ''),
        );

        $_arr_search = $this->obj_request->param($_arr_searchParam);

        $_num_posiCount   = $this->mdl_posi->count($_arr_search); //统计记录数
        $_arr_pageRow     = $this->obj_request->pagination($_num_posiCount); //取得分页数据
        $_arr_posiRows    = $this->mdl_posi->lists($this->config['var_default']['perpage'], $_arr_pageRow['except'], $_arr_search); //列出

        foreach ($_arr_posiRows as $_key=>$_value) {
            $_arr_scriptConfigList = $this->mdl_posi->scriptConfigProcess($_value['posi_script']);

            $_mix_scriptOpts = Func::isFile($_arr_scriptConfigList['opts_path']);

            $_mix_scriptOpts = $this->mdl_posi->scriptOptsProcess($_arr_scriptConfigList['opts_path']);

            if (Func::isEmpty($_mix_scriptOpts)) {
                $_mix_scriptOpts = false;
            }

            $_arr_posiRows[$_key]['script_opts'] = $_mix_scriptOpts;
        }

        $_arr_tplData = array(
            'pageRow'    => $_arr_pageRow,
            'search'     => $_arr_search,
            'posiRows'   => $_arr_posiRows,
            'token'      => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_posiRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function show() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->adminAllow['posi']['browse']) && !$this->isSuper) {
            return $this->error('You do not have permission', 'x040301');
        }

        $_num_posiId = 0;

        if (isset($this->param['id'])) {
            $_num_posiId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_posiId < 1) {
            return $this->error('Missing ID', 'x040202');
        }

        $_arr_posiRow = $this->mdl_posi->read($_num_posiId);

        if ($_arr_posiRow['rcode'] != 'y040102') {
            return $this->error($_arr_posiRow['msg'], $_arr_posiRow['rcode']);
        }

        $_arr_adverts     = array();
        $_arr_advertRows  = $this->mdl_advert->lists($_num_posiId);

        if (Func::isEmpty($_arr_advertRows)) {
            $_arr_adverts = $this->mdl_advert->lists($_num_posiId, 'backup');
        } else {
            if ($_arr_posiRow['posi_is_percent'] == 'enable') {
                foreach ($_arr_advertRows as $key=>$value) {
                    $arr_adverts[$value['advert_id']] = $value['advert_percent'];
                }

                for ($_iii = 1; $_iii<=$_arr_posiRow['posi_count']; $_iii++) {
                    $arr_ids[] = $this->mdl_advert->listsRand($arr_adverts); //根据概率获取广告id
                }

                foreach ($arr_ids as $_key=>$_value) {
                    $_arr_adverts[$_key] = $this->mdl_advert->read($_value);
                }
            } else {
                $_arr_adverts = $_arr_advertRows;
            }
        }

        foreach ($_arr_adverts as $_key=>$_value) {
            $_arr_attachRow = $this->mdl_attach->read($_value['advert_attach_id']);
            if (!isset($_arr_attachRow['attach_url'])) {
                $_arr_attachRow['attach_url'] = '';
            }
            $_arr_adverts[$_key]['attachRow'] = $_arr_attachRow;
        }

        $_arr_scriptConfig = $this->mdl_posi->scriptConfigProcess($_arr_posiRow['posi_script']);

        $_arr_scriptConfig['script_url']  = $this->url['dir_advert'] . $_arr_scriptConfig['script_url_name'];
        $_arr_scriptConfig['css_url']     = $this->url['dir_advert'] . $_arr_scriptConfig['css_url_name'];

        $_mix_scriptOpts = Func::isFile($_arr_scriptConfig['opts_path']);

        $_mix_scriptOpts = $this->mdl_posi->scriptOptsProcess($_arr_scriptConfig['opts_path']);

        if (Func::isEmpty($_mix_scriptOpts)) {
            $_mix_scriptOpts = false;
        }

        $_arr_optsJosn = array(
            'data_url' => $_arr_posiRow['posi_data_url'],
        );

        if (is_array($_mix_scriptOpts) && !Func::isEmpty($_mix_scriptOpts)) {
            foreach ($_mix_scriptOpts as $_key=>$_value) {
                if (isset($_arr_posiRow['posi_opts'][$_key])) {
                    $_arr_optsJosn[$_key] = $_arr_posiRow['posi_opts'][$_key];
                }
            }
        }

        //print_r($_mix_scriptOpts);

        $_arr_tplData = array(
            'scriptOpts'    => $_mix_scriptOpts,
            'scriptConfig'  => $_arr_scriptConfig,
            'optsJson'      => Json::encode($_arr_optsJosn),
            'posiRow'       => $_arr_posiRow,
            'advertRows'    => $_arr_adverts,
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_posiRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function form() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_posiId = 0;

        if (isset($this->param['id'])) {
            $_num_posiId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        $_arr_scripts       = array();
        $_mix_scriptOpts    = false;
        $_arr_scriptConfig  = array(
            'script_url' => '',
        );

        if ($_num_posiId > 0) {
            if (!isset($this->adminAllow['posi']['edit']) && !$this->isSuper) {
                return $this->error('You do not have permission', 'x040303');
            }
            $_arr_posiRow = $this->mdl_posi->read($_num_posiId);

            if ($_arr_posiRow['rcode'] != 'y040102') {
                return $this->error($_arr_posiRow['msg'], $_arr_posiRow['rcode']);
            }

            $_str_configPath = BG_PATH_ADVERT . $_arr_posiRow['posi_script'] . DS . 'config' . GK_EXT_INC;

            if (Func::isFile($_str_configPath)) {
                $_arr_scriptConfig = Loader::load($_str_configPath); //定义配置
            } else {
                $_arr_scriptConfig = array();
            }

            $_arr_scriptConfig = $this->mdl_posi->scriptConfigProcess($_arr_posiRow['posi_script']);

            if (!Func::isFile($_arr_scriptConfig['script_path'])) {
                return $this->error('Ad script not found', 'x040102');
            }

            $_arr_scriptConfig['script_url']  = $this->url['dir_advert'] . $_arr_scriptConfig['script_url_name'];
            $_arr_scriptConfig['css_url']     = $this->url['dir_advert'] . $_arr_scriptConfig['css_url_name'];

            $_mix_scriptOpts = Func::isFile($_arr_scriptConfig['opts_path']);

            $_mix_scriptOpts = $this->mdl_posi->scriptOptsProcess($_arr_scriptConfig['opts_path']);

            if (Func::isEmpty($_mix_scriptOpts)) {
                $_mix_scriptOpts = false;
            }
        } else {
            if (!isset($this->adminAllow['posi']['add']) && !$this->isSuper) {
                return $this->error('You do not have permission', 'x040302');
            }

            $_str_dir = '';

            if (isset($this->param['script'])) {
                $_str_dir = $this->obj_request->input($this->param['script'], 'str', '');
            }

            $_arr_posiRow = array(
                'posi_id'           => 0,
                'posi_name'         => '',
                'posi_count'        => 1,
                'posi_status'       => $this->mdl_posi->arr_status[0],
                'posi_script'       => $_str_dir,
                'posi_box_perfix'   => '',
                'posi_is_percent'   => $this->mdl_posi->arr_isPercent[0],
                'posi_loading'      => '',
                'posi_close'        => '',
                'posi_note'         => '',
            );

            if (!Func::isEmpty($_str_dir)) {
                $_arr_scriptConfig = $this->mdl_posi->scriptConfigProcess($_str_dir);

                if (!Func::isFile($_arr_scriptConfig['script_path'])) {
                    return $this->error('Ad script not found', 'x040102');
                }

                $_arr_scriptConfig['script_url']    = $this->url['dir_advert'] . $_arr_scriptConfig['script_url_name'];

                $_arr_posiRow['posi_count']         = $_arr_scriptConfig['count'];
                $_arr_posiRow['posi_box_perfix']    = $_arr_scriptConfig['box_perfix'];
                $_arr_posiRow['posi_is_percent']    = $_arr_scriptConfig['is_percent'];
                $_arr_posiRow['posi_loading']       = $_arr_scriptConfig['loading'];
                $_arr_posiRow['posi_close']         = $_arr_scriptConfig['close'];
            }

            $_arr_scriptRows = $this->obj_file->dirList(BG_PATH_ADVERT);

            foreach ($_arr_scriptRows as $_key=>$_value) {
                if ($_value['type'] != 'file') {
                    $_arr_scriptConfigList = $this->mdl_posi->scriptConfigProcess($_value['name']);

                    $_arr_scriptConfigList['script_url']  = $this->url['dir_advert'] . $_arr_scriptConfigList['script_url_name'];

                    if (Func::isFile($_arr_scriptConfigList['script_path'])) {
                        $_arr_scripts[$_value['name']] = $_arr_scriptConfigList;
                    }
                }
            }
        }

        //print_r($_arr_scriptConfig);

        $_arr_tplData = array(
            'scriptOpts'     => $_mix_scriptOpts,
            'scriptConfig'   => $_arr_scriptConfig,
            'posiRow'        => $_arr_posiRow,
            'scriptRows'     => $_arr_scripts,
            'scriptJson'     => Json::encode($_arr_scripts),
            'token'          => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_posiRows);

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

        $_arr_inputSubmit = $this->mdl_posi->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y040201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        if ($_arr_inputSubmit['posi_id'] > 0) {
            if (!isset($this->adminAllow['posi']['edit']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x040303');
            }
        } else {
            if (!isset($this->adminAllow['posi']['add']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x040302');
            }
        }

        $_arr_submitResult = $this->mdl_posi->submit();

        $this->cacheProcess();

        return $this->fetchJson($_arr_submitResult['msg'], $_arr_submitResult['rcode']);
    }


    function opts() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_posiId = 0;

        if (isset($this->param['id'])) {
            $_num_posiId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_posiId < 1) {
            return $this->error('Missing ID', 'x040202');
        }

        if (!isset($this->adminAllow['posi']['edit']) && !$this->isSuper) {
            return $this->error('You do not have permission', 'x040303');
        }
        $_arr_posiRow = $this->mdl_posi->read($_num_posiId);

        if ($_arr_posiRow['rcode'] != 'y040102') {
            return $this->error($_arr_posiRow['msg'], $_arr_posiRow['rcode']);
        }

        $_arr_scriptConfig = $this->mdl_posi->scriptConfigProcess($_arr_posiRow['posi_script']);

        if (!Func::isFile($_arr_scriptConfig['script_path'])) {
            return $this->error('Ad script not found', 'x040102');
        }

        $_arr_scriptConfig['script_url']  = $this->url['dir_advert'] . $_arr_scriptConfig['script_url_name'];
        $_arr_scriptConfig['css_url']     = $this->url['dir_advert'] . $_arr_scriptConfig['css_url_name'];

        if (!Func::isFile($_arr_scriptConfig['opts_path'])) {
            return $this->error('There are no options to set', 'x040402');
        }

        $_arr_scriptOpts = $this->mdl_posi->scriptOptsProcess($_arr_scriptConfig['opts_path']);

        if (Func::isEmpty($_arr_scriptOpts)) {
            return $this->error('There are no options to set', 'x040402');
        }

        foreach ($_arr_scriptOpts as $_key=>$_value) {
            if (!isset($_arr_posiRow['posi_opts'][$_key])) {
                $_arr_posiRow['posi_opts'][$_key] = '';
            }
        }

        //print_r($_arr_posiRow);

        $_arr_tplData = array(
            'scriptConfig'  => $_arr_scriptConfig,
            'scriptOpts'    => $_arr_scriptOpts,
            'posiRow'       => $_arr_posiRow,
            'token'         => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_posiRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function optsSubmit() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_arr_inputOpts = $this->mdl_posi->inputOpts();

        if ($_arr_inputOpts['rcode'] != 'y040201') {
            return $this->fetchJson($_arr_inputOpts['msg'], $_arr_inputOpts['rcode']);
        }

        if (!isset($this->adminAllow['posi']['edit']) && !$this->isSuper) {
            return $this->fetchJson('You do not have permission', 'x040303');
        }

        $_arr_optsResult = $this->mdl_posi->opts();

        $this->cacheProcess();

        return $this->fetchJson($_arr_optsResult['msg'], $_arr_optsResult['rcode']);
    }


    function delete() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->adminAllow['posi']['delete']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x040304');
        }

        $_arr_inputDelete = $this->mdl_posi->inputDelete();

        if ($_arr_inputDelete['rcode'] != 'y040201') {
            return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
        }

        Plugin::listen('action_console_posi_delete', $_arr_inputDelete['posi_ids']); //删除链接时触发

        $_arr_deleteResult = $this->mdl_posi->delete();

        $this->cacheProcess();

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

        if (!isset($this->adminAllow['posi']['edit']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x040303');
        }

        $_arr_inputStatus = $this->mdl_posi->inputStatus();

        if ($_arr_inputStatus['rcode'] != 'y040201') {
            return $this->fetchJson($_arr_inputStatus['msg'], $_arr_inputStatus['rcode']);
        }

        $_arr_return = array(
            'posi_ids'      => $_arr_inputStatus['posi_ids'],
            'posi_status'   => $_arr_inputStatus['act'],
        );

        Plugin::listen('action_console_posi_status', $_arr_return); //删除链接时触发

        $_arr_statusResult = $this->mdl_posi->status();

        $this->cacheProcess();

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

        $_arr_inputCommon = $this->mdl_posi->inputCommon();

        if ($_arr_inputCommon['rcode'] != 'y040201') {
            return $this->fetchJson($_arr_inputCommon['msg'], $_arr_inputCommon['rcode']);
        }

        $_arr_cacheResult = $this->cacheProcess();

        return $this->fetchJson($_arr_cacheResult['msg'], $_arr_cacheResult['rcode']);
    }


    private function cacheProcess() {
        $_arr_search['status']  = 'enable';
        $_arr_posiRows          = $this->mdl_posi->lists(1000, 0, $_arr_search);

        $_num_cacheSize = 0;

        foreach ($_arr_posiRows as $_key=>$_value) {
            $_num_cacheSize = $this->mdl_posi->cacheProcess($_value['posi_id']);
        }

        $_num_cacheListsSize = $this->mdl_posi->cacheListsProcess();

        if ($_num_cacheSize > 0 && $_num_cacheListsSize > 0) {
            $_str_rcode = 'y040110';
            $_str_msg   = 'Refresh cache successfully';
        } else {
            $_str_rcode = 'x040110';
            $_str_msg   = 'Refresh cache failed';
        }

        return array(
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }
}
