<?php
/** 规则
* 1. 本插件类的文件名必须是 action.php
* 2. 插件类的名称必须是 PLUGIN_类名 英文大写
* 3. 用户设置键名为 obj_plugin->opts[类名] 英文小写
*/

/**
* 这是一个 Hello 简单插件的实现
*/
if (!class_exists('PLUGIN_HELLO')) { //防止类重复
    class PLUGIN_HELLO {

        public $opts = array();

        //构造函数的参数是 obj_plugin 的引用
        function __construct(&$obj_plugin) {
            //注册这个插件
            //第一个参数是 钩子 的名称
            //第二个参数是 对象名 一般为本类
            //第三个是插件所执行的 方法（函数）
            $obj_plugin->register('filter_console_link_add', $this, 'say_hello');

            if (isset($obj_plugin->opts['hello'])) { //用户对本插件的设置, 键名务必与 config.php 中的 class 一致
                $this->opts = $obj_plugin->opts['hello'];
            }
        }


        function say_hello($param) {

            $param = str_ireplace('b', '1', $param);

            return $param;
        }
    }
}