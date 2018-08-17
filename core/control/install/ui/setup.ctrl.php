<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}


class CONTROL_INSTALL_UI_SETUP {

    private $obj_tpl;

    function __construct() { //构造函数
        $this->config   = $GLOBALS['obj_base']->config;

        $this->general_install   = new GENERAL_INSTALL();
        $this->obj_tpl      = $this->general_install->obj_tpl;

        $this->obj_file  = new CLASS_FILE(); //初始化目录对象
        $this->obj_file->dir_mk(BG_PATH_CACHE . 'ssin');

        $this->setup_init();
    }


    function ctrl_phplib() {
        $this->obj_tpl->tplDisplay('setup_phplib', $this->tplData);
    }


    function ctrl_dbconfig() {
        $this->obj_tpl->tplDisplay('setup_dbconfig', $this->tplData);
    }


    /**
     * install_2 function.
     *
     * @access public
     * @return void
     */
    function ctrl_dbtable() {
        $this->check_db();

        $this->table_admin();
        $this->table_advert();
        $this->table_attach();
        $this->table_posi();
        $this->table_stat();
        $this->table_session();
        $this->table_link();
        $this->table_plugin();

        $GLOBALS['obj_plugin']->trigger('action_setup_dbtable_complete');

        $this->obj_tpl->tplDisplay('setup_dbtable', $this->tplData);
    }


    function ctrl_form() {
        $this->check_db();

        if ($this->act == 'base') {
            $this->tplData['tplRows']     = $this->obj_file->dir_list(BG_PATH_TPL . 'advert' . DS);

            $_arr_timezoneRows  = fn_include(BG_PATH_INC . 'timezone.inc.php');

            $this->obj_tpl->lang['timezone']        = fn_include(BG_PATH_LANG . $this->config['lang'] . DS . 'timezone.php');
            $this->obj_tpl->lang['timezoneJson']    = json_encode($this->obj_tpl->lang['timezone']);

            $_arr_timezone[] = '';

            if (stristr(BG_SITE_TIMEZONE, '/')) {
                $_arr_timezone = explode('/', BG_SITE_TIMEZONE);
            }

            $this->tplData['timezoneRows']      = $_arr_timezoneRows;
            $this->tplData['timezoneRowsJson']  = json_encode($_arr_timezoneRows);
            $this->tplData['timezoneType']      = $_arr_timezone[0];
        }

        $this->obj_tpl->tplDisplay('setup_form', $this->tplData);
    }


    function ctrl_ssoAuto() {
        $this->check_db();

        if (!file_exists(BG_PATH_SSO . 'api' . DS . 'api.php')) {
            $_arr_tplData = array(
                'rcode' => 'x030420',
            );
            $this->obj_tpl->tplDisplay('error', $_arr_tplData);
        }

        if (file_exists(BG_PATH_SSO . 'config' . DS . 'installed.php')) {
            $_arr_tplData = array(
                'rcode' => 'x030408',
            );
            $this->obj_tpl->tplDisplay('error', $_arr_tplData);
        }

        $this->obj_tpl->tplDisplay('setup_ssoAuto', $this->tplData);
    }


    function ctrl_ssoAdmin() {
        $this->check_db();

        if (!file_exists(BG_PATH_SSO . 'api' . DS . 'api.php')) {
            $_arr_tplData = array(
                'rcode' => 'x030421',
            );
            $this->obj_tpl->tplDisplay('error', $_arr_tplData);
        }

        if (file_exists(BG_PATH_SSO . 'config' . DS . 'installed.php')) {
            $_arr_tplData = array(
                'rcode' => 'x030408',
            );
            $this->obj_tpl->tplDisplay('error', $_arr_tplData);
        }

        $this->obj_tpl->tplDisplay('setup_ssoAdmin', $this->tplData);
    }


    function ctrl_auth() {
        $this->check_db();

        $this->obj_tpl->tplDisplay('setup_auth', $this->tplData);
    }


    /**
     * ctrl_admin function.
     *
     * @access public
     * @return void
     */
    function ctrl_admin() {
        $this->check_db();

        $this->obj_tpl->tplDisplay('setup_admin', $this->tplData);
    }


    function ctrl_over() {
        $this->check_db();

        $this->obj_tpl->tplDisplay('setup_over', $this->tplData);
    }


    private function check_db() {
        if (!defined('BG_DB_HOST') || fn_isEmpty(BG_DB_HOST) || !defined('BG_DB_NAME') || fn_isEmpty(BG_DB_NAME) || !defined('BG_DB_PASS') || fn_isEmpty(BG_DB_PASS) || !defined('BG_DB_CHARSET') || fn_isEmpty(BG_DB_CHARSET)) {
            $_arr_tplData = array(
                'rcode' => 'x030404',
            );
            $this->obj_tpl->tplDisplay('error', $_arr_tplData);
        }
    }


    private function setup_init() {
        $_str_rcode = '';
        $_str_jump  = '';

        if (file_exists(BG_PATH_CONFIG . 'installed.php')) { //如果新文件存在
            fn_include(BG_PATH_CONFIG . 'installed.php');  //载入
            $_str_rcode = 'x030403';
        } else if (file_exists(BG_PATH_CONFIG . 'is_install.php')) { //如果旧文件存在
            $this->obj_file->file_copy(BG_PATH_CONFIG . 'is_install.php', BG_PATH_CONFIG . 'installed.php'); //拷贝
            fn_include(BG_PATH_CONFIG . 'installed.php');  //载入
            $_str_rcode = 'x030403';
        }

        if (defined('BG_INSTALL_PUB') && PRD_ADS_PUB > BG_INSTALL_PUB) {
            $_str_rcode = 'x030416';
            $_str_jump  = BG_URL_INSTALL . 'index.php?m=upgrade';
        }

        if (!fn_isEmpty($_str_rcode)) {
            if (!fn_isEmpty($_str_jump)) {
                header('Location: ' . $_str_jump);
            }

            $_arr_tplData = array(
                'rcode' => $_str_rcode,
            );
            $this->obj_tpl->tplDisplay('error', $_arr_tplData);
        }

        $_arr_phplibRow      = get_loaded_extensions();
        $this->errCount   = 0;

        foreach ($this->obj_tpl->phplib as $_key=>$_value) {
            if (!in_array($_key, $_arr_phplibRow)) {
                $this->errCount++;
            }
        }

        $this->act = fn_getSafe(fn_get('a'), 'txt', 'phplib');

        $this->tplData = array(
            'errCount'      => $this->errCount,
            'phplibRow'     => $_arr_phplibRow,
            'act'           => $this->act,
            'setup_step'    => $this->setup_step($this->act),
        );
    }


    private function setup_step($act) {
        $_arr_optKeys = array_keys($this->obj_tpl->opt);
        $_index       = array_search($act, $_arr_optKeys);

        $_arr_prev     = array_slice($this->obj_tpl->opt, $_index - 1, -1);
        if (fn_isEmpty($_arr_prev)) {
            $_key_prev = 'dbtable';
        } else {
            $_key_prev = key($_arr_prev);
        }

        $_arr_next     = array_slice($this->obj_tpl->opt, $_index + 1, 1);
        if (fn_isEmpty($_arr_next)) {
            $_key_next = 'admin';
        } else {
            $_key_next = key($_arr_next);
        }

        return array(
            'prev' => $_key_prev,
            'next' => $_key_next,
        );
    }


    private function table_admin() {
        $_mdl_admin                 = new MODEL_ADMIN();
        $_arr_adminCteateTable      = $_mdl_admin->mdl_create_table();

        $this->tplData['db_rcode']['admin_create_table'] = array(
            'rcode'   => $_arr_adminCteateTable['rcode'],
            'status'  => substr($_arr_adminCteateTable['rcode'], 0, 1),
        );
    }


    private function table_advert() {
        $_mdl_advert                    = new MODEL_ADVERT();
        $_arr_advertCreatTable          = $_mdl_advert->mdl_create_table();

        $this->tplData['db_rcode']['advert_create_table'] = array(
            'rcode'   => $_arr_advertCreatTable['rcode'],
            'status'  => substr($_arr_advertCreatTable['rcode'], 0, 1),
        );
    }


    private function table_attach() {
        $_mdl_attach       = new MODEL_ATTACH();
        $_arr_attachCreateTable  = $_mdl_attach->mdl_create_table();

        $this->tplData['db_rcode']['attach_create_table'] = array(
            'rcode'   => $_arr_attachCreateTable['rcode'],
            'status'  => substr($_arr_attachCreateTable['rcode'], 0, 1),
        );
    }


    private function table_posi() {
        $_mdl_posi                  = new MODEL_POSI();
        $_arr_posiCreatTable        = $_mdl_posi->mdl_create_table();

        $this->tplData['db_rcode']['posi_create_table'] = array(
            'rcode'   => $_arr_posiCreatTable['rcode'],
            'status'  => substr($_arr_posiCreatTable['rcode'], 0, 1),
        );
    }


    private function table_stat() {
        $_mdl_stat              = new MODEL_STAT();
        $_arr_statCreatTable    = $_mdl_stat->mdl_create_table();

        $this->tplData['db_rcode']['stat_create_table'] = array(
            'rcode'   => $_arr_statCreatTable['rcode'],
            'status'  => substr($_arr_statCreatTable['rcode'], 0, 1),
        );
    }


    private function table_session() {
        $_mdl_session               = new MODEL_SESSION();
        $_arr_sessionCreatTable    = $_mdl_session->mdl_create_table();

        $this->tplData['db_rcode']['session_create_table'] = array(
            'rcode'   => $_arr_sessionCreatTable['rcode'],
            'status'  => substr($_arr_sessionCreatTable['rcode'], 0, 1),
        );
    }


    private function table_link() {
        $_mdl_link              = new MODEL_LINK();
        $_arr_linkCreatTable    = $_mdl_link->mdl_create_table();

        $this->tplData['db_rcode']['link_create_table'] = array(
            'rcode'   => $_arr_linkCreatTable['rcode'],
            'status'  => substr($_arr_linkCreatTable['rcode'], 0, 1),
        );
    }

    private function table_plugin() {
        $_mdl_plugin               = new MODEL_PLUGIN();
        $_arr_pluginCreateTable    = $_mdl_plugin->mdl_create_table();

        $this->tplData['db_rcode']['plugin_create_table'] = array(
            'rcode'   => $_arr_pluginCreateTable['rcode'],
            'status'  => substr($_arr_pluginCreateTable['rcode'], 0, 1),
        );
    }
}
