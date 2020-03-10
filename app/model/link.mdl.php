<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Func;
use ginkgo\Cache;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------链接模型-------------*/
class Link extends Model {

    protected $obj_cache;
    public $arr_status = array('enable', 'disabled');

    function m_init() { //构造函数
        $this->obj_cache  = Cache::instance();
    }


    function check($num_linkId) {
        $_arr_linkSelect = array(
            'link_id',
        );

        $_arr_linkRow = $this->read($num_linkId, $_arr_linkSelect);

        return $_arr_linkRow;
    }


    /**
     * read function.
     *
     * @access public
     * @param mixed $str_link
     * @return void
     */
    function read($num_linkId, $arr_select = array()) {
        if (Func::isEmpty($arr_select)) {
            $arr_select = array(
                'link_id',
                'link_name',
                'link_url',
                'link_status',
                'link_blank',
                'link_order',
            );
        }

        $_arr_linkRow = $this->where('link_id', '=', $num_linkId)->find($arr_select);

        if (!$_arr_linkRow) {
            return array(
                'msg'   => 'Link not found',
                'rcode' => 'x240102', //不存在记录
            );
        }

        $_arr_linkRow['rcode'] = 'y240102';
        $_arr_linkRow['msg']   = '';

        return $_arr_linkRow;
    }


    /**
     * mdl_list function.
     *
     * @access public
     * @param string $str_status (default: '')
     * @param string $str_type (default: '')
     * @return void
     */
    function lists($num_no, $num_except = 0, $arr_search = array()) {
        $_arr_linkSelect = array(
            'link_id',
            'link_name',
            'link_status',
            'link_url',
            'link_blank',
            'link_order',
        );

        $_arr_where = $this->queryProcess($arr_search);

        $_arr_linkRows = $this->where($_arr_where)->order('link_order', 'ASC')->limit($num_except, $num_no)->select($_arr_linkSelect);

        return $_arr_linkRows;
    }


    function count($arr_search = array()) {

        $_arr_where  = $this->queryProcess($arr_search);

        $_num_linkCount = $this->where($_arr_where)->count();

        return $_num_linkCount;
    }


    function cache() {
        $_arr_return = array();

        $_str_cacheName = 'link_lists';
        if (!$this->obj_cache->check($_str_cacheName)) {
            $this->cacheProcess();
        }

        $_arr_return = $this->obj_cache->read($_str_cacheName);

        return $_arr_return;
    }


    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['key']) && !Func::isEmpty($arr_search['key'])) {
            $_arr_where[] = array('link_name', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
        }

        if (isset($arr_search['status']) && !Func::isEmpty($arr_search['status'])) {
            $_arr_where[] = array('link_status', '=', $arr_search['status']);
        }

        return $_arr_where;
    }


    protected function cacheProcess() {
        $_arr_search = array(
            'status'    => 'enable',
        );
        $_arr_linkRows = $this->lists(1000, 0, $_arr_search);


        return $this->obj_cache->write('link_lists', $_arr_linkRows);
    }
}
