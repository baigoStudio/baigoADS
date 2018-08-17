<?php
define('IN_BAIGO', true);
define('DS', DIRECTORY_SEPARATOR);

class CLASS_CONFIG {
    function __construct() {
        $this->arr_config = array(
            'BG_DEBUG_SYS'              => array(
                'default'   => 0,
                'kind'      => 'num',
            ),
            'BG_DEBUG_DB'               => array(
                'default'   => 0,
                'kind'      => 'num',
            ),
            'BG_SWITCH_LANG'            => array(
                'default'   => 0,
                'kind'      => 'num',
            ),
            'BG_SWITCH_UI'              => array(
                'default'   => 0,
                'kind'      => 'num',
            ),
            'BG_SWITCH_TOKEN'           => array(
                'default'   => 1,
                'kind'      => 'num',
            ),
            'BG_SWITCH_SMARTY_DEBUG'    => array(
                'default'   => 0,
                'kind'      => 'num',
            ),
            'BG_DEFAULT_SESSION'        => array(
                'default'   => 1200,
                'kind'      => 'num',
            ),
            'BG_DEFAULT_PERPAGE'        => array(
                'default'   => 30,
                'kind'      => 'num',
            ),
            'BG_DEFAULT_LANG'           => array(
                'default'   => 'zh_CN',
                'kind'      => 'str',
            ),
            'BG_DEFAULT_UI'             => array(
                'default'   => 'default',
                'kind'      => 'str',
            ),
            'BG_DEFAULT_TOKEN_RELOAD'   => array(
                'default'   => 1 * 60 * 1000,
                'kind'      => 'num',
            ),
            'BG_NAME_CONTENT'           => array(
                'default'   => 'content',
                'kind'      => 'str',
            ),
            'BG_NAME_PLUGIN'        => array(
                'default'   => 'plugin',
                'kind'      => 'str',
            ),
            'BG_NAME_CACHE'             => array(
                'default'   => 'cache',
                'kind'      => 'str',
            ),
            'BG_NAME_TPL'               => array(
                'default'   => 'tpl',
                'kind'      => 'str',
            ),
            'BG_NAME_ATTACH'             => array(
                'default'   => 'attach',
                'kind'      => 'str',
            ),
            'BG_NAME_SSO'               => array(
                'default'   => 'sso',
                'kind'      => 'str',
            ),
            'BG_NAME_HELP'              => array(
                'default'   => 'help',
                'kind'      => 'str',
            ),
            'BG_NAME_CORE'              => array(
                'default'   => 'core',
                'kind'      => 'str',
            ),
            'BG_NAME_MODULE'            => array(
                'default'   => 'module',
                'kind'      => 'str',
            ),
            'BG_NAME_MODEL'             => array(
                'default'   => 'model',
                'kind'      => 'str',
            ),
            'BG_NAME_CONTROL'           => array(
                'default'   => 'control',
                'kind'      => 'str',
            ),
            'BG_NAME_INC'               => array(
                'default'   => 'inc',
                'kind'      => 'str',
            ),
            'BG_NAME_LANG'              => array(
                'default'   => 'lang',
                'kind'      => 'str',
            ),
            'BG_NAME_CLASS'             => array(
                'default'   => 'class',
                'kind'      => 'str',
            ),
            'BG_NAME_FUNC'              => array(
                'default'   => 'func',
                'kind'      => 'str',
            ),
            'BG_NAME_FONT'              => array(
                'default'   => 'font',
                'kind'      => 'str',
            ),
            'BG_NAME_CONSOLE'           => array(
                'default'   => 'console',
                'kind'      => 'str',
            ),
            'BG_NAME_ADVERT'            => array(
                'default'   => 'advert',
                'kind'      => 'str',
            ),
            'BG_NAME_INSTALL'           => array(
                'default'   => 'install',
                'kind'      => 'str',
            ),
            'BG_NAME_API'               => array(
                'default'   => 'api',
                'kind'      => 'str',
            ),
            'BG_NAME_STATIC'            => array(
                'default'   => 'static',
                'kind'      => 'str',
            ),
            'BG_PATH_ROOT'              => array(
                'default'   => 'realpath(__DIR__ . \'/../\') . DS',
                'kind'      => 'const',
            ),
            'BG_PATH_CONTENT' => array(
                'default'   => 'BG_PATH_ROOT . BG_NAME_CONTENT . DS',
                'kind'      => 'const',
            ),
            'BG_PATH_PLUGIN'          => array(
                'default'   => 'BG_PATH_CONTENT . BG_NAME_PLUGIN . DS',
                'kind'      => 'const',
            ),
            'BG_PATH_CACHE'             => array(
                'default'   => 'BG_PATH_CONTENT . BG_NAME_CACHE . DS',
                'kind'      => 'const',
            ),
            'BG_PATH_TPL'               => array(
                'default'   => 'BG_PATH_CONTENT . BG_NAME_TPL . DS',
                'kind'      => 'const',
            ),
            'BG_PATH_HELP'              => array(
                'default'   => 'BG_PATH_ROOT . BG_NAME_HELP . DS',
                'kind'      => 'const',
            ),
            'BG_PATH_ATTACH'             => array(
                'default'   => 'BG_PATH_ROOT . BG_NAME_ATTACH . DS',
                'kind'      => 'const',
            ),
            'BG_PATH_SSO'               => array(
                'default'   => 'BG_PATH_ROOT . BG_NAME_SSO . DS',
                'kind'      => 'const',
            ),
            'BG_PATH_ADVERT'            => array(
                'default'   => 'BG_PATH_ROOT . BG_NAME_ADVERT . DS',
                'kind'      => 'const',
            ),
            'BG_PATH_CORE'              => array(
                'default'   => 'BG_PATH_ROOT . BG_NAME_CORE . DS',
                'kind'      => 'const',
            ),
            'BG_PATH_MODULE'            => array(
                'default'   => 'BG_PATH_CORE . BG_NAME_MODULE . DS',
                'kind'      => 'const',
            ),
            'BG_PATH_CONTROL'           => array(
                'default'   => 'BG_PATH_CORE . BG_NAME_CONTROL . DS',
                'kind'      => 'const',
            ),
            'BG_PATH_MODEL'             => array(
                'default'   => 'BG_PATH_CORE . BG_NAME_MODEL . DS',
                'kind'      => 'const',
            ),
            'BG_PATH_FONT'              => array(
                'default'   => 'BG_PATH_CORE . BG_NAME_FONT . DS',
                'kind'      => 'const',
            ),
            'BG_PATH_INC'               => array(
                'default'   => 'BG_PATH_CORE . BG_NAME_INC . DS',
                'kind'      => 'const',
            ),
            'BG_PATH_LANG'              => array(
                'default'   => 'BG_PATH_CORE . BG_NAME_LANG . DS',
                'kind'      => 'const',
            ),
            'BG_PATH_CLASS'             => array(
                'default'   => 'BG_PATH_CORE . BG_NAME_CLASS . DS',
                'kind'      => 'const',
            ),
            'BG_PATH_FUNC'              => array(
                'default'   => 'BG_PATH_CORE . BG_NAME_FUNC . DS',
                'kind'      => 'const',
            ),
            'BG_PATH_TPLSYS'            => array(
                'default'   => 'BG_PATH_CORE . BG_NAME_TPL . DS',
                'kind'      => 'const',
            ),
            'BG_URL_ROOT'               => array(
                'default'   => 'str_ireplace(DS, \'/\', str_ireplace($_SERVER[\'DOCUMENT_ROOT\'], \'\', BG_PATH_ROOT))',
                'kind'      => 'const',
            ),
            'BG_URL_HELP'               => array(
                'default'   => 'BG_URL_ROOT . BG_NAME_HELP . \'/\'',
                'kind'      => 'const',
            ),
            'BG_URL_CONSOLE'            => array(
                'default'   => 'BG_URL_ROOT . BG_NAME_CONSOLE . \'/\'',
                'kind'      => 'const',
            ),
            'BG_URL_ADVERT'             => array(
                'default'   => 'BG_URL_ROOT . BG_NAME_ADVERT . \'/\'',
                'kind'      => 'const',
            ),
            'BG_URL_ATTACH'              => array(
                'default'   => 'BG_URL_ROOT . BG_NAME_ATTACH . \'/\'',
                'kind'      => 'const',
            ),
            'BG_URL_SSO'                => array(
                'default'   => 'BG_URL_ROOT . BG_NAME_SSO . \'/\'',
                'kind'      => 'const',
            ),
            'BG_URL_INSTALL'            => array(
                'default'   => 'BG_URL_ROOT . BG_NAME_INSTALL . \'/\'',
                'kind'      => 'const',
            ),
            'BG_URL_API'                => array(
                'default'   => 'BG_URL_ROOT . BG_NAME_API . \'/\'',
                'kind'      => 'const',
            ),
            'BG_URL_STATIC'             => array(
                'default'   => 'BG_URL_ROOT . BG_NAME_STATIC . \'/\'',
                'kind'      => 'const',
            ),
        );

        $this->arr_dbconfig = array(
            'BG_DB_HOST'     => array(
                'default'   => 'localhost',
                'kind'      => 'str',
            ),
            'BG_DB_PORT'     => array(
                'default'   => 3306,
                'kind'      => 'num',
            ),
            'BG_DB_NAME'     => array(
                'default'   => 'baigo_ads',
                'kind'      => 'str',
            ),
            'BG_DB_USER'     => array(
                'default'   => 'baigo_ads',
                'kind'      => 'str',
            ),
            'BG_DB_PASS'     => array(
                'default'   => 'baigo_ads',
                'kind'      => 'str',
            ),
            'BG_DB_CHARSET'  => array(
                'default'   => 'utf8',
                'kind'      => 'str',
            ),
            'BG_DB_TABLE'    => array(
                'default'   => 'ads_',
                'kind'      => 'str',
            ),
        );

        $this->arr_opt = array(
            'base' => array(
                'title' => 'Base Settings',
                'list'    => array(
                    'BG_SITE_NAME' => array(
                        'type'       => 'str',
                        'format'     => 'text',
                        'min'        => 1,
                        'default'    => 'baigo ADS',
                        'kind'       => 'str',
                    ),
                    'BG_SITE_DOMAIN' => array(
                        'type'       => 'str',
                        'format'     => 'text',
                        'min'        => 1,
                        'default'    => '$_SERVER[\'SERVER_NAME\']',
                        'kind'       => 'const',
                    ),
                    'BG_SITE_URL' => array(
                        'type'       => 'str',
                        'format'     => 'url',
                        'min'        => 1,
                        'default'    => '\'http://\' . $_SERVER[\'SERVER_NAME\']',
                        'kind'       => 'const',
                    ),
                    'BG_SITE_PERPAGE' => array(
                        'type'       => 'str',
                        'format'     => 'int',
                        'min'        => 1,
                        'default'    => 30,
                        'kind'       => 'str',
                    ),
                    'BG_SITE_DATE' => array(
                        'type'   => 'select',
                        'min'    => 1,
                        'option' => array(
                            'Y-m-d'     => '2014-05-15',
                            'y-m-d'     => '14-05-15',
                            'M. d, Y'   => 'May. 05, 2014',
                        ),
                        'default' => 'Y-m-d',
                        'kind'    => 'str',
                    ),
                    'BG_SITE_DATESHORT' => array(
                        'type'   => 'select',
                        'min'    => 1,
                        'option' => array(
                            'm-d'   => '05-15',
                            'M. d'  => 'May. 05',
                        ),
                        'default' => 'Y-m-d',
                        'kind'      => 'str',
                    ),
                    'BG_SITE_TIME' => array(
                        'type'   => 'select',
                        'min'    => 1,
                        'option' => array(
                            'H:i:s'     => '14:08:25',
                            'h:i:s A'   => '02:08:25 PM',
                        ),
                        'default' => 'H:i:s',
                        'kind'      => 'str',
                    ),
                    'BG_SITE_TIMESHORT' => array(
                        'type'   => 'select',
                        'min'    => 1,
                        'option' => array(
                            'H:i'   => '14:08',
                            'h:i A' => '02:08 PM',
                        ),
                        'default' => 'H:i',
                        'kind'      => 'str',
                    ),
                ),
            ),
            'upload' => array(
                'title' => 'Upload Settings',
                'list'    => array(
                    'BG_UPLOAD_SIZE' => array(
                        'type'       => 'str',
                        'format'     => 'int',
                        'min'        => 1,
                        'default'    => 200,
                        'kind'      => 'str',
                    ),
                    'BG_UPLOAD_UNIT' => array(
                        'type'       => 'select',
                        'format'     => 'txt',
                        'min'        => 1,
                        'default'    => 'KB',
                        'option' => array(
                            'KB'    => 'KB',
                            'MB'    => 'MB',
                        ),
                        'kind'      => 'str',
                    ),
                    'BG_UPLOAD_COUNT' => array(
                        'type'       => 'str',
                        'format'     => 'int',
                        'min'        => 1,
                        'default'    => 10,
                        'kind'      => 'str',
                    ),
                ),
            ),
            'sso' => array(
                'title' => 'SSO Settings',
                'list'    => array(
                    'BG_SSO_URL' => array(
                        'type'       => 'str',
                        'format'     => 'url',
                        'min'        => 1,
                        'default'    => '',
                        'kind'      => 'str',
                    ),
                    'BG_SSO_APPID' => array(
                        'type'       => 'str',
                        'format'     => 'int',
                        'min'        => 1,
                        'default'    => 1,
                        'kind'      => 'num',
                    ),
                    'BG_SSO_APPKEY' => array(
                        'type'       => 'str',
                        'format'     => 'text',
                        'min'        => 1,
                        'default'    => '',
                        'kind'      => 'str',
                    ),
                    'BG_SSO_APPSECRET' => array(
                        'type'      => 'str',
                        'format'    => 'text',
                        'min'       => 16,
                        'default'   => '',
                        'kind'      => 'str',
                    ),
                    'BG_SSO_SYNC' => array(
                        'type'       => 'radio',
                        'min'        => 1,
                        'default'    => 'off',
                        'option' => array(
                            'on'    => array(
                                'value'    => 'ON'
                            ),
                            'off'   => array(
                                'value'    => 'OFF'
                            ),
                        ),
                        'kind'      => 'str',
                    ),
                ),
            ),
        );
    }


    function config_gen() {
        $this->file_gen($this->arr_dbconfig, 'opt_dbconfig'); //数据库配置
        $this->file_gen($this->arr_config, 'config'); //全局配置
        $this->file_gen($this->arr_opt['base']['list'], 'opt_base'); //基本配置
        $this->file_gen($this->arr_opt['sso']['list'], 'opt_sso'); //SSO 配置
        $this->file_gen($this->arr_opt['upload']['list'], 'opt_upload'); //上传配置
    }


    private function file_gen($arr_configSrc, $str_file) {
        $_str_constConfig   = '';
        $_str_config        = '';
        if (file_exists(BG_PATH_CONFIG . $str_file . '.inc.php')) { //如果文件存在
            if (defined('IS_INSTALL')) { //如果是安装状态，一一对比
                $_str_configChk = file_get_contents(BG_PATH_CONFIG . $str_file . '.inc.php'); //将配置文件转换为变量
                $_arr_config    = file(BG_PATH_CONFIG . $str_file . '.inc.php'); //将配置文件转换为数组
                $_arr_config    = array_filter(array_unique($_arr_config));

                foreach ($arr_configSrc as $_key_src=>$_value_src) {
                    if (!stristr($_str_configChk, $_key_src)) { //如不存在则加上
                        if ($_value_src['kind'] == 'str') {
                            $_str_constConfig = 'define(\'' . $_key_src . '\', \'' . $_value_src['default'] . '\');' . PHP_EOL;
                        } else {
                            $_str_constConfig = 'define(\'' . $_key_src . '\', ' . $_value_src['default'] . ');' . PHP_EOL;
                        }

                        array_push($_arr_config, $_str_constConfig);
                    }
                }

                foreach ($_arr_config as $_key_m=>$_value_m) { //拼接
                    $_str_config .= $_value_m;
                }

                $_str_config = preg_replace('/(require_once|include_once|require|include)\(.*\);/i', '', $_str_config);

                $_str_config = str_ireplace('?>', '', $_str_config); //去除旧版本配置文件的 php 结尾

                file_put_contents(BG_PATH_CONFIG . $str_file . '.inc.php', $_str_config);
            }
        } else { //如果文件不存在则生成默认
            $_str_config = '<?php' . PHP_EOL;
            foreach ($arr_configSrc as $_key_src=>$_value_src) {
                if ($_value_src['kind'] == 'str') {
                    $_str_config .= 'define(\'' . $_key_src . '\', \'' . $_value_src['default'] . '\');' . PHP_EOL;
                } else {
                    $_str_config .= 'define(\'' . $_key_src . '\', ' . $_value_src['default'] . ');' . PHP_EOL;
                }
            }

            file_put_contents(BG_PATH_CONFIG . $str_file . '.inc.php', $_str_config);
        }
    }


    /** 随机数
     * rand function.
     *
     * @access private
     * @param int $num_rand (default: 32)
     * @return void
     */
    private function rand($num_rand = 32) {
        $_str_char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $_str_rnd = '';
        while (strlen($_str_rnd) < $num_rand) {
            $_str_rnd .= substr($_str_char, (rand(0, strlen($_str_char))), 1);
        }
        return $_str_rnd;
    }
}

$GLOBALS['obj_config'] = new CLASS_CONFIG();

$GLOBALS['obj_config']->config_gen();
