<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------插件管理类-------------*/
class CLASS_PLUGIN {

    private $listeners  = array(); //监听已注册的插件
    public $opts        = array(); //插件设置

    /**
     * 构造函数
     *
     * @access public
     * @return void
     */
    function __construct() {
        $this->obj_file    = new CLASS_FILE(); //初始化文件对象

        $_mdl_plugin  = new MODEL_PLUGIN();

        $_arr_search = array(
            'status' => 'enable',
        );
        $_arr_pluginRows = $_mdl_plugin->mdl_list(1000, 0, $_arr_search);

        //print_r($_arr_pluginRows);

        if (!fn_isEmpty($_arr_pluginRows)) {
            foreach($_arr_pluginRows as $_key=>$_value) {//假定每个插件目录中包含一个action.php文件，它是插件的具体实现
                if (file_exists(BG_PATH_PLUGIN . $_value['plugin_dir'] . DS . 'action.php')) {
                    fn_include(BG_PATH_PLUGIN . $_value['plugin_dir'] . DS . 'action.php');

                    if (file_exists(BG_PATH_PLUGIN . $_value['plugin_dir'] . DS . 'config.php')) {
                        $_arr_config = fn_include(BG_PATH_PLUGIN . $_value['plugin_dir'] . DS . 'config.php');

                        if (isset($_arr_config['class'])) {
                            $_str_pluginClass = strtolower($_arr_config['class']);

                            $this->opts[$_str_pluginClass] = array();

                            if (file_exists(BG_PATH_PLUGIN . $_value['plugin_dir'] . DS . 'opts.json')) {
                                $_str_pluginOpts  = $this->obj_file->file_read(BG_PATH_PLUGIN . $_value['plugin_dir'] . DS . 'opts.json');
                                $this->opts[$_str_pluginClass] = json_decode($_str_pluginOpts, true);
                            }

                            $_class = 'PLUGIN_' . strtoupper($_str_pluginClass);
                            if (class_exists($_class)) {
                                //初始化所有插件
                                //$this 是本类的引用
                                new $_class($this);
                            }
                        }
                    }
                }
            }

            $this->trigger('action_sys_plugin_activated'); //插件激活后触发
        }
        //此处做些日志记录方面的东西
    }


    /**
    * 注册需要监听的插件方法（钩子）
    *
    * @param string $hook
    * @param object $reference
    * @param string $method
    */
    function register($hook, &$reference, $method) {
        //获取插件要实现的方法
        $_key = get_class($reference) . '->' . $method;
        //将插件类的引用连同方法 push 进监听数组中
        $this->listeners[$hook][$_key] = array(
            'class'     => &$reference,
            'method'    => $method
        );
        //此处做些日志记录方面的东西
    }

    /**
    * 触发一个钩子
    *
    * @param string $hook 钩子的名称
    * @param mixed $data 钩子的入参
    * @return mixed
    */
    function trigger($hook, $data = '') {
        $_result = array();
        //查看要实现的钩子，是否在监听数组之中
        if (isset($this->listeners[$hook]) && is_array($this->listeners[$hook]) && count($this->listeners[$hook]) > 0) {
            //循环调用开始
            foreach ($this->listeners[$hook] as $_key=>$_value) {
                //取出插件对象的引用和方法
                $_class  = &$_value['class'];
                $_method = $_value['method'];
                if (method_exists($_class, $_method)) {
                    //动态调用插件的方法
                    $_result[$hook] = array(
                        'plugin'    => $_key,
                        'return'    => $_class->$_method($data),
                    );
                }
            }
        }

        //此处做些日志记录方面的东西
        return $_result;
    }
}