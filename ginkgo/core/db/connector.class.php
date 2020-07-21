<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace ginkgo\db;

use PDO;
use ginkgo\Config;
use ginkgo\Func;
use ginkgo\Log;
use ginkgo\Exception;

// 不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

// 数据库连接器抽象类
abstract class Connector {

    public $dbconfig = array(); // 数据库配置
    public $obj_builder; // 语句生成器实例

    protected static $instance; // 当前实例
    protected $obj_pdo; // PDO 实例
    protected $obj_result; // SQL 语句结果集实例
    protected $isConnect; // 是否连接标记
    protected $mid; // 模型 id

    protected $configDebug; // 调试配置

    protected $_table       = array(); // 数据表名
    protected $_tableTemp   = array(); // 临时数据表名, 切换操作的数据表, 对多表进行操作
    protected $_force       = ''; // 强制使用索引名
    protected $_distinct    = false; // 是否不重复
    protected $_join        = ''; // join 语句
    protected $_where       = ''; // where 条件语句
    protected $_whereOr     = array(); // whereOr 语句数组
    protected $_whereAnd    = array(); // whereAnd 语句数组
    protected $_group       = ''; // group 语句
    protected $_order       = ''; // order 语句
    protected $_limit       = ''; // limit 语句
    protected $_bind        = array(); // 绑定参数数组
    protected $_fetchSql    = false; // 是否获取 sql 语句

    // 默认参数类型
    protected $paramType = array(
        'bool'  => PDO::PARAM_BOOL,
        'int'   => PDO::PARAM_INT,
        'str'   => PDO::PARAM_STR,
    );

    private $this_config = array(
        'type'      => 'mysql',
        'host'      => '',
        'name'      => '',
        'user'      => '',
        'pass'      => '',
        'charset'   => 'utf8',
        'prefix'    => 'ginkgo_',
        'debug'     => false,
        'port'      => 3306,
    );


    /** 构造函数
     * __construct function.
     *
     * @access protected
     * @param array $dbconfig (default: array()) 数据库配置
     * @return void
     */
    protected function __construct($dbconfig = array()) {
        $this->config($dbconfig); // 配置处理
    }

    protected function __clone() {

    }

    /** 实例化
     * instance function.
     *
     * @access public
     * @static
     * @param array $dbconfig (default: array())
     * @return 当前类的实例
     */
    public static function instance($dbconfig = array()) {
        if (Func::isEmpty(static::$instance)) {
            static::$instance = new static($dbconfig);
        }
        return static::$instance;
    }

    /** 配置处理并实例化 sql 语句构造器
     * config function.
     *
     * @access public
     * @param array $dbconfig (default: array()) 配置
     * @return void
     */
    function config($dbconfig = array()) {
        $this->dbconfig = array_replace_recursive($this->this_config, $this->dbconfig, $dbconfig); // 合并配置

        if (Func::isEmpty($this->dbconfig['type'])) { // 未指定类型, 默认 mysql
            $this->dbconfig['type'] = 'mysql';
        }

        $_class = 'ginkgo\\db\\builder\\' . Func::ucwords($this->dbconfig['type'], '_'); // 补全构造器命名空间

        if (class_exists($_class)) {
            $this->obj_builder = $_class::instance($this->dbconfig); // 实例化 sql 语句构造器
        } else {
            $_obj_excpt = new Exception('SQL Builder not found', 500);

            $_obj_excpt->setData('err_detail', $_class);

            throw $_obj_excpt;
        }
    }


    /** 连接数据库
     * connect function.
     *
     * @access public
     * @return void
     */
    function connect() {
        try {
            if (Func::isEmpty($this->dbconfig['type'])) { // 未指定类型, 默认 mysql
                $this->dbconfig['type'] = 'mysql';
            }

            $_str_dsn = $this->dsnProcess(); // dsn 处理

            $this->obj_pdo = new PDO($_str_dsn, $this->dbconfig['user'], $this->dbconfig['pass']); // 实例化 pdo
        } catch (PDOException $excpt) { // 报错
            $_obj_excpt = new Exception('Can not connect to database', 500);
            if ($this->dbconfig['debug'] === true || $this->dbconfig['debug'] === 'true') {
                $_obj_excpt->setData('err_detail', $excpt->getMessage());
            }

            throw $_obj_excpt;
        }

        //$this->obj_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $this->obj_pdo->exec('SET NAMES ' . $this->dbconfig['charset']); // 设置字符编码

        $this->configDebug = Config::get('dump', 'debug'); // 取得调试配置

        $this->isConnect = true; // 标识为已连接
    }


    /** 执行原生 sql (一般用于 插入、更新 或者 删除)
     * exec function.
     *
     * @access public
     * @param mixed $sql 语句
     * @return 影响行数
     */
    function exec($sql) {
        if (Func::isEmpty($this->isConnect)) {
            $this->connect();
        }

        if ($this->configDebug === 'trace') {
            Log::record($sql, 'sql'); // 记录日志
        }

        return $this->obj_pdo->exec($sql); // 执行
    }


    /** 执行原生 sql (一般用于 select)
     * query function.
     *
     * @access public
     * @param mixed $sql
     * @return 结果集实例
     */
    function query($sql) {
        if (Func::isEmpty($this->isConnect)) {
            $this->connect();
        }

        if ($this->configDebug === 'trace') {
            Log::record($sql, 'sql'); // 记录日志
        }

        $_obj_result = $this->obj_pdo->query($sql); // 执行

        //print_r($sql);

        $this->obj_result = $_obj_result;

        return $_obj_result;
    }


    /** 取得新插入的 id
     * lastInsertId function.
     *
     * @access public
     * @return void
     */
    function lastInsertId() {
        return $this->obj_pdo->lastInsertId();
    }


    /** 预处理 sql 语句
     * prepare function.
     *
     * @access public
     * @param mixed $sql 语句
     * @param array $bind (default: array()) 绑定参数
     * @param string $value (default: '') 绑定值
     * @param string $type (default: '') 参数类型
     * @return 结果集实例
     */
    function prepare($sql, $bind = array(), $value = '', $type = '') {
        if (Func::isEmpty($this->isConnect)) {
            $this->connect(); // 连接数据库
        }

        $_obj_result = $this->obj_pdo->prepare($sql); // 预处理

        $this->obj_result = $_obj_result;

        if (!Func::isEmpty($bind)) {
            $this->bind($bind, $value, $type); // 绑定处理
        }

        $this->resetSql(); // 重置 sql

        return $_obj_result;
    }


    /** 执行预处理 sql 语句
     * execute function.
     *
     * @access public
     * @param array $bind (default: array()) 绑定参数
     * @param string $value (default: '') 绑定值
     * @param string $type (default: '') 参数类型
     * @return void
     */
    function execute($bind = array(), $value = '', $type = '') {
        if (!Func::isEmpty($bind)) {
            $this->bind($bind, $value, $type); // 绑定处理
        }

        $this->resetSql(); // 重置 sql

        return $this->obj_result->execute(); // 执行
    }


    /** 是否查询不重复的记录
     * distinct function.
     *
     * @access public
     * @param bool $bool (default: false) 是否查询不重复
     * @return 当前实例
     */
    function distinct($bool = false) {
        $this->_distinct = $bool;

        return $this;
    }


    /** 是否获取 sql 语句
     * fetchSql function.
     *
     * @access public
     * @param bool $bool (default: true)
     * @return 当前实例
     */
    function fetchSql($bool = true) {
        $this->_fetchSql = $bool;

        return $this;
    }


    /** 取得影响行数
     * getRowCount function.
     *
     * @access public
     * @return 行数
     */
    function getRowCount() {
        return $this->obj_result->rowCount();
    }


    /** 取得当前行数据
     * getRow function.
     *
     * @access public
     * @return void
     */
    function getRow() {
        $_num_return = 0;

        $_arr_result = $this->obj_result->fetch(PDO::FETCH_NUM);

        if (isset($_arr_result[0])) {
            $_num_return = $_arr_result[0];
        }

        return $_num_return;
    }


    /** 取得结果
     * getResult function.
     *
     * @access public
     * @param bool $all (default: true) 是否为全部
     * @param mixed $type (default: PDO::FETCH_ASSOC) 取得类型
     * @return 数据结果
     */
    function getResult($all = true, $type = PDO::FETCH_ASSOC) {
        if ($all) {
            $_mix_return = $this->obj_result->fetchAll($type);
        } else {
            $_mix_return = $this->obj_result->fetch($type);
        }

        return $_mix_return;
    }


    /** 设置模型名 (防止冲突)
     * setModel function.
     *
     * @access public
     * @param string $model (default: '')
     * @return void
     */
    function setModel($model = '') {
        if (Func::isEmpty($model)) {
            $model = get_class($this); // 如果未定义参数, 直接以当前实例命名
        }

        $this->mid = md5($model); // md5 编码

        /*print_r($model);
        print_r('<br>');
        print_r($this->mid);
        print_r('<br>');*/
    }


    /** 设置数据表名
     * setTable function.
     *
     * @access public
     * @param mixed $table
     * @return void
     */
    function setTable($table) {
        $this->_table[$this->mid] = $this->obj_builder->table(strtolower($table));
    }


    /** 取得当前数据表明
     * getTable function.
     *
     * @access public
     * @return void
     */
    function getTable() {
        $_str_table = '';

        if (isset($this->_tableTemp[$this->mid]) && !Func::isEmpty($this->_tableTemp[$this->mid])) {
            $_str_table = $this->_tableTemp[$this->mid];
        } else if (isset($this->_table[$this->mid]) && !Func::isEmpty($this->_table[$this->mid])) {
            $_str_table = $this->_table[$this->mid];
        }

        return $_str_table;
    }


    /** 绑定参数
     * bind function.
     *
     * @access public
     * @param mixed $bind 参数
     * @param string $value (default: '') 值
     * @param string $type (default: '') 参数类型
     * @return 当前实例
     */
    function bind($bind, $value = '', $type = '') {
        if (is_array($bind)) {
            if (isset($bind[0])) {
                if (is_array($bind[0])) {
                    foreach ($bind as $_key => $_value) {
                        if (is_array($_value)) {
                            if (isset($_value[0]) && is_scalar($_value[0])) {
                                if (!isset($_value[1])) {
                                    $_value[1] = '';
                                }

                                if (!isset($_value[2])) {
                                    $_value[2] = '';
                                }

                                $_result = $this->bindProcess($_value[0], $_value[1], $_value[2]);
                            }
                        }
                    }
                } else if (is_scalar($bind[0])) {
                    if (!isset($bind[1])) {
                        $bind[1] = '';
                    }

                    if (!isset($bind[2])) {
                        $bind[2] = '';
                    }

                    $_result = $this->bindProcess($bind[0], $bind[1], $bind[2]);
                }
            }
        } else if (is_scalar($bind)) {
            $_result = $this->bindProcess($bind, $value, $type);
        }

        $this->resetSql();

        return $this;
    }


    /** 重置 sql
     * resetSql function.
     *
     * @access public
     * @return void
     */
    function resetSql() {
        $this->_tableTemp   = array();
        $this->_force       = '';
        $this->_join        = '';
        $this->_distinct    = false;
        $this->_where       = '';
        $this->_group       = '';
        $this->_order       = '';
        $this->_limit       = '';
        $this->_bind        = '';
        $this->_whereOr     = array();
        $this->_whereAnd    = array();
        $this->_fetchSql    = false;
    }


    /** 绑定处理
     * bindProcess function.
     *
     * @access private
     * @param mixed $bind 参数
     * @param string $value (default: '') 值
     * @param string $type (default: '') 参数类型
     * @return void
     */
    private function bindProcess($param, $value, $type = '') {
        //print_r($param);

        $_result = false;
        $type    = strtolower($type); // 转小写

        if (!Func::isEmpty($param) && is_scalar($param)) { // 如果参数是标量才有效
            $_num_type = $this->getType($value, $type); // 取得参数类型

            if ($_num_type !== PDO::PARAM_STR && Func::isEmpty($value)) { // 如果不是字符串类型且为空
                $value = 0; // 值设为 0
            }

            if (is_numeric($param)) { // 如果参数是数字, 直接使用
                $_mix_param = $param;
            } else {
                $_mix_param = ':' . $param; // 否则添加前缀
            }

            /*print_r($_mix_param);
            print_r(' => ');
            print_r($value);
            print_r(', type: ');
            print_r($_num_type);
            print_r('<br>');
            print_r(PHP_EOL);*/

            $_result = $this->obj_result->bindValue($_mix_param, $value, $_num_type); // 绑定

            if (!$_result) { // 报错
                $_obj_excpt = new Exception('Error occurred when binding parameters', 500);

                $_obj_excpt->setData('err_detail', $param);

                throw $_obj_excpt;
            }
        }

        return $_result;
    }


    /** 取得绑定后参数 (主要用于取得 sql 语句)
     * fetchBind function.
     *
     * @access protected
     * @param mixed $sql 语句
     * @param mixed $bind 参数
     * @param string $value (default: '') 值
     * @param string $type (default: '') 参数类型
     * @return 处理后的语句
     */
    protected function fetchBind($sql, $bind, $value = '', $type = '') {
        if (is_array($bind)) {
            if (isset($bind[0])) {
                if (is_array($bind[0])) {
                    foreach ($bind as $_key => $_value) {
                        if (is_array($_value)) {
                            if (isset($_value[0]) && is_scalar($_value[0])) {
                                if (!isset($_value[1])) {
                                    $_value[1] = '';
                                }

                                if (!isset($_value[2])) {
                                    $_value[2] = '';
                                }

                                $sql = $this->fetchBindProcess($sql, $_value[0], $_value[1], $_value[2]);
                            }
                        }
                    }
                } else if (is_scalar($bind[0])) {
                    if (!isset($bind[1])) {
                        $bind[1] = '';
                    }

                    if (!isset($bind[2])) {
                        $bind[2] = '';
                    }

                    $sql = $this->fetchBindProcess($sql, $bind[0], $bind[1], $bind[2]);
                }
            }
        } else if (is_scalar($bind)) {
            $sql = $this->fetchBindProcess($sql, $bind, $value, $type);
        }

        return $sql;
    }


    /** 取得绑定处理
     * fetchBindProcess function.
     *
     * @access private
     * @param mixed $sql 语句
     * @param mixed $bind 参数
     * @param string $value (default: '') 值
     * @param string $type (default: '') 参数类型
     * @return void
     */
    private function fetchBindProcess($sql, $param, $value, $type = '') {
        $type   = strtolower($type); // 转小写

        if (!Func::isEmpty($param)) { // 参数不为空才有效
            $_num_type = $this->getType($value, $type); // 取得类型

            if ($_num_type !== PDO::PARAM_STR && Func::isEmpty($value)) { // 如果不是字符串类型且为空
                $value = 0; // 值设为 0
            }

            if ($_num_type === PDO::PARAM_STR) { // 如果是字符串类型, 则转义处理
                $_str_value = '\'' . $value . '\'';
            } else {
                $_str_value = $value;
            }

            if (!is_numeric($param)) { // 如果参数不是数字
                $param = ':' . $param; // 添加前缀
            }

            $sql = str_ireplace($param, $_str_value, $sql);
        }

        return $sql;
    }


    /** 取得类型
     * getType function.
     *
     * @access private
     * @param mixed $value 值
     * @param string $type (default: '') 类型
     * @return void
     */
    private function getType($value, $type = '') {
        $_num_type = $this->paramType['str'];

        if (Func::isEmpty($type)) {
            if (is_bool($value)) {
                $_str_type = 'bool';
            } else if (is_numeric($value)) {
                $_str_type = 'int';
            } else if (is_string($value)) {
                $_str_type = 'str';
            }

            if (isset($this->paramType[$_str_type])) {
                $_num_type = $this->paramType[$_str_type];
            }
        } else {
            if (isset($this->paramType[$type])) {
                $_num_type = $this->paramType[$type];
            }
        }

        return $_num_type;
    }


    /** dsn 处理
     * dsnProcess function.
     *
     * @access private
     * @return dsn 字符串
     */
    private function dsnProcess() {
        $_str_dsn = $this->dbconfig['type'] . ':host=' . $this->dbconfig['host'];

        if (isset($this->dbconfig['port']) && !Func::isEmpty($this->dbconfig['port'])) {
            $_str_dsn .= ';port=' . $this->dbconfig['port'];
        }

        $_str_dsn .= ';dbname=' . $this->dbconfig['name'];

        return $_str_dsn;
    }

    function __destruct() {
        if ($this->obj_pdo) {
            //$this->closeDb();
            //unset($this->obj_pdo);
        }
    }
}
