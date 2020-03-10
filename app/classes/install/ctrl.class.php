<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\classes\install;

use app\classes\Ctrl as Ctrl_Base;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Config;
use ginkgo\Plugin;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');


/*-------------安装通用控制器-------------*/
class Ctrl extends Ctrl_Base {

    private $configInstalled;
    protected $mdl_opt;

    protected function c_init($param = array()) {
        parent::c_init();

        $this->configInstalled = 'installed' . GK_EXT_INC;

        Plugin::listen('action_install_init'); //管理后台初始化时触发

        $this->mdl_opt     = Loader::model('Opt');
    }


    protected function init($is_install = true, $chk_php = true) {
        if ($is_install) {
            $_arr_chkResult = $this->chkInstall();
        } else {
            $_arr_chkResult = $this->chkUpgrade();
        }

        $_arr_data = array(
            'installed'         => Config::get('installed'),
            'path_installed'    => $this->configInstalled,
            'step'              => $this->stepProcess(),
        );

        $this->generalData = array_replace_recursive($this->generalData, $_arr_data);

        if (!Func::isEmpty($_arr_chkResult['rcode'])) {
            return $_arr_chkResult;
        }

        $_arr_phpResult = $this->chkPhplib();

        if ($chk_php) {
            if (!Func::isEmpty($_arr_phpResult['rcode'])) {
                return $_arr_phpResult;
            }
        }

        if ($is_install) {
            $this->obj_sso = Loader::classes('Install', 'sso');

            return $this->obj_sso->securityProcess();
        } else {
            return true;
        }
    }


    private function chkPhplib() {
        $_str_rcode     = '';
        $_str_msg       = '';

        $_num_errCount  = 0;

        foreach ($this->phplib as $_key=>&$_value) {
            if (extension_loaded($_key)) {
                $_value['installed'] = true;
            } else {
                ++$_num_errCount;
            }
        }

        $_arr_data = array(
            'phplib'    => $this->phplib,
            'err_count' => $_num_errCount,
        );

        $this->generalData = array_replace_recursive($this->generalData, $_arr_data);

        if ($_num_errCount > 0) {
            $_str_rcode     = 'x030405';
            $_str_msg       = 'Missing PHP extensions';
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $this->obj_lang->get($_str_msg, $this->route['mod'] . '.common'),
        );
    }


    private function chkInstall() {
        $_str_rcode     = '';
        $_str_jump      = '';
        $_str_msg       = '';

        if (Func::isFile(GK_APP_CONFIG . $this->configInstalled)) {
            $_arr_installed = Config::load(GK_APP_CONFIG . $this->configInstalled, 'installed');
            $_str_rcode     = 'x030412';
            $_str_msg       = 'System already installed';

            if (isset($_arr_installed['prd_installed_pub']) && PRD_ADS_PUB > $_arr_installed['prd_installed_pub']) { //如果小于当前版本
                $_str_rcode     = 'x030404';
                $_str_msg       = 'Need to execute the upgrader';
                $_str_jump      = $this->url['route_install'] . 'upgrade/';
            }
        }

        if (!Func::isEmpty($_str_jump) && !$this->isAjaxPost) {
            return $this->redirect($_str_jump)->send();
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $this->obj_lang->get($_str_msg, $this->route['mod'] . '.common'),
        );
    }

    private function chkUpgrade() {
        $_str_rcode     = '';
        $_str_jump      = '';
        $_str_msg       = '';

        if (Func::isFile(GK_APP_CONFIG . $this->configInstalled)) {
            $_arr_installed = Config::load(GK_APP_CONFIG . $this->configInstalled, 'installed');

            if (!isset($_arr_installed['prd_installed_pub'])) {
                $_str_rcode     = 'x030403';
                $_str_msg       = 'Need to execute the installer';
                $_str_jump      = $this->url['route_install'];
            } else if (PRD_ADS_PUB <= $_arr_installed['prd_installed_pub']) { //如果小于当前版本
                $_str_rcode     = 'x030412';
                $_str_msg       = 'System already installed';
            }
        } else {
            $_str_rcode     = 'x030403';
            $_str_msg       = 'Need to execute the installer';
            $_str_jump      = $this->url['route_install'];
        }

        if (!Func::isEmpty($_str_jump) && !$this->isAjaxPost) {
            return $this->redirect($_str_jump)->send();
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $this->obj_lang->get($_str_msg, $this->route['mod'] . '.common'),
        );
    }


    protected function pathProcess() {
        parent::pathProcess();

        $_str_tplPath         = Config::get('path', 'tpl');

        $_str_pathTplConsole = GK_PATH_TPL;

        if (!Func::isEmpty($_str_tplPath)) {
            $_str_pathTplConsole = GK_APP_TPL . 'console' . DS . $_str_tplPath . DS;
        }

        $_arr_url = array(
            'path_tpl_console'  => $_str_pathTplConsole,
        );

        $this->url = array_replace_recursive($this->url, $_arr_url);

        $this->generalData = array_replace_recursive($this->generalData, $_arr_url);
    }


    protected function configProcess() {
        parent::configProcess();

        $_str_configPhplib  = BG_PATH_CONFIG . 'install' . DS . 'phplib' . GK_EXT_INC;
        $this->phplib       = Config::load($_str_configPhplib, 'phplib');

        $_str_configOpt     = BG_PATH_CONFIG . 'console' . DS . 'opt' . GK_EXT_INC;
        $_arr_consoleOpt    = Config::load($_str_configOpt, 'opt', 'console');

        $_str_ssoUrl = Config::get('sso_url', 'install');

        if (Func::isEmpty($_str_ssoUrl)) {
            $_str_ssoUrl = $this->obj_request->root(true) . 'sso.php/api';

            Config::set('sso_url', $_str_ssoUrl, 'install');
        }
    }

    private function stepProcess() {
        $_arr_install       = $this->config['install'][$this->route['ctrl']];
        $_arr_installKeys   = array_keys($_arr_install);
        $_str_act           = str_ireplace('auth', 'admin', $this->route['act']);
        $_index             = array_search($_str_act, $_arr_installKeys);

        //print_r($_arr_install);

        $_arr_prev     = array_slice($_arr_install, $_index - 1, -1);
        if (Func::isEmpty($_arr_prev)) {
            $_key_prev = 'index';
        } else {
            $_key_prev = key($_arr_prev);
        }

        $_arr_next     = array_slice($_arr_install, $_index + 1, 1);
        if (Func::isEmpty($_arr_next)) {
            $_key_next = 'over';
        } else {
            $_key_next = key($_arr_next);
        }

        return array(
            'prev' => $_key_prev,
            'next' => $_key_next,
        );
    }


    protected function createTable($table) {
        $_mdl_table          = Loader::model($table);
        $_arr_createResult   = $_mdl_table->createTable();

       return array(
            'rcode'   => $_arr_createResult['rcode'],
            'msg'     => $_arr_createResult['msg'],
        );
    }


    protected function createIndex($index) {
        $_mdl_index          = Loader::model($index);
        $_arr_createResult   = $_mdl_index->createIndex();

        return array(
            'rcode'   => $_arr_createResult['rcode'],
            'msg'     => $_arr_createResult['msg'],
        );
    }


    protected function createView($view) {
        $_mdl_view           = Loader::model($view);
        $_arr_createResult   = $_mdl_view->createView();

        return array(
            'rcode'   => $_arr_createResult['rcode'],
            'msg'     => $_arr_createResult['msg'],
        );
    }


    protected function alterTable($table) {
        $_mdl_table          = Loader::model($table);
        $_arr_alterResult    = $_mdl_table->alterTable();

       return array(
            'rcode'   => $_arr_alterResult['rcode'],
            'msg'     => $_arr_alterResult['msg'],
        );
    }


    protected function copyTable($table) {
        $_mdl_table         = Loader::model($table);
        $_arr_copyResult    = $_mdl_table->copyTable();

       return array(
            'rcode'   => $_arr_copyResult['rcode'],
            'msg'     => $_arr_copyResult['msg'],
        );
    }


    protected function renameTable($table) {
        $_mdl_table          = Loader::model($table);
        $_arr_renmaeResult   = $_mdl_table->renameTable();

       return array(
            'rcode'   => $_arr_renmaeResult['rcode'],
            'msg'     => $_arr_renmaeResult['msg'],
        );
    }


    protected function dropColumn($table) {
        $_mdl_table          = Loader::model($table);
        $_arr_dropResult   = $_mdl_table->dropColumn();

       return array(
            'rcode'   => $_arr_dropResult['rcode'],
            'msg'     => $_arr_dropResult['msg'],
        );
    }
}
