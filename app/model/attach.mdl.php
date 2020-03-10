<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Func;
use ginkgo\Config;
use ginkgo\Loader;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------附件模型-------------*/
class Attach extends Model {

    protected $urlPrefix;
    private $configUpload;
    public $imageExts;
    public $arr_box         = array('normal', 'recycle', 'reserve');

    function m_init() { //构造函数
        $_arr_configImage   = Config::get('image');

        $this->imageExts    = array_keys($_arr_configImage);
        $this->configUpload = Config::get('upload', 'var_extra');
        $this->configBase   = Config::get('base', 'var_extra');

        $_str_dirAttach     = str_ireplace(GK_PATH_PUBLIC, '', GK_PATH_ATTACH);
        $_str_dirAttach     = str_ireplace(DS, '/', $_str_dirAttach);
        $_str_dirAttach     = Func::fixDs($_str_dirAttach, '/');

        $this->urlPrefix    = Func::fixDs($this->obj_request->root(), '/') . $_str_dirAttach;

        if (!Func::isEmpty($this->configUpload['ftp_host']) && !Func::isEmpty($this->configUpload['url_prefix'])) {
            $this->urlPrefix = $this->configUpload['url_prefix'] . '/';
        }
    }


    function check($mix_attach, $str_by = 'attach_id', $str_box = '') {
        $arr_select = array(
            'attach_id',
        );

        $_arr_attachRow = $this->readProcess($mix_attach, $str_by, $arr_select);

        return $_arr_attachRow;
    }


    function read($mix_attach, $str_by = 'attach_id', $arr_select = array()) {
        $_arr_attachRow = $this->readProcess($mix_attach, $str_by, $arr_select);

        if ($_arr_attachRow['rcode'] == 'y070102') {
            $_arr_attachRow = $this->rowProcess($_arr_attachRow);
        }

        return $_arr_attachRow;
    }


    /**
     * read function.
     *
     * @access public
     * @param mixed $num_attachId
     * @return void
     */
    function readProcess($mix_attach, $str_by = 'attach_id', $arr_select = array()) {
        if (Func::isEmpty($arr_select)) {
            $arr_select = array(
                'attach_id',
                'attach_name',
                'attach_time',
                'attach_ext',
                'attach_mime',
                'attach_size',
                'attach_box',
                'attach_admin_id',
            );
        }

        $_arr_where = $this->readQueryProcess($mix_attach, $str_by);

        $_arr_attachRow  = $this->where($_arr_where)->find($arr_select);

        if (!$_arr_attachRow) {
            return array(
                'msg'   => 'Image not found',
                'rcode' => 'x070102', //不存在记录
            );
        }

        $_arr_attachRow['rcode'] = 'y070102';

        return $_arr_attachRow;
    }


    /**
     * mdl_list function.
     *
     * @access public
     * @param mixed $num_no
     * @param int $num_except (default: 0)
     * @param string $str_year (default: '')
     * @param string $str_month (default: '')
     * @param string $str_ext (default: '')
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function lists($num_no, $num_except = 0, $arr_search = array(), $arr_order = array(array('attach_id', 'DESC'))) {
        $_arr_attachSelect = array(
            'attach_id',
            'attach_name',
            'attach_time',
            'attach_ext',
            'attach_mime',
            'attach_size',
            'attach_admin_id',
            'attach_box',
        );

        $_arr_where   = $this->queryProcess($arr_search);

        $_arr_attachRows = $this->where($_arr_where)->order($arr_order)->limit($num_except, $num_no)->select($_arr_attachSelect);

        foreach ($_arr_attachRows as $_key=>$_value) {
            $_arr_attachRows[$_key] = $this->rowProcess($_value);
        }

        //$_arr_mimeImage = array_flip($this->imageExts);

        return $_arr_attachRows;
    }


    /**
     * mdl_count function.
     *
     * @access public
     * @param string $str_year (default: '')
     * @param string $str_month (default: '')
     * @param string $str_ext (default: '')
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function count($arr_search = array()) {
        $_arr_where    = $this->queryProcess($arr_search);
        $_num_attachCount = $this->where($_arr_where)->count();

        return $_num_attachCount;
    }


    function nameProcess($arr_attachRow, $ds = '/') {
        $_str_return = date('Y', $arr_attachRow['attach_time']) . $ds . date('m', $arr_attachRow['attach_time']) . $ds . $arr_attachRow['attach_id'];

        return $_str_return . '.' . $arr_attachRow['attach_ext'];
    }


    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['key']) && !Func::isEmpty($arr_search['key'])) {
            $_arr_where[] = array('attach_name|attach_id', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
        }

        if (isset($arr_search['year']) && !Func::isEmpty($arr_search['year'])) {
            $_arr_where[] = array('FROM_UNIXTIME(`attach_time`, \'%Y\')', '=', $arr_search['year'], 'year');
        }

        if (isset($arr_search['month']) && !Func::isEmpty($arr_search['month'])) {
            $_arr_where[] = array('FROM_UNIXTIME(`attach_time`, \'%m\')', '=', $arr_search['month'], 'month');
        }

        if (isset($arr_search['ext']) && !Func::isEmpty($arr_search['ext'])) {
            $_arr_where[] = array('attach_ext', '=', $arr_search['ext']);
        }

        if (isset($arr_search['box']) && !Func::isEmpty($arr_search['box'])) {
            $_arr_where[] = array('attach_box', '=', $arr_search['box']);
        }

        if (isset($arr_search['attach_ids']) && !Func::isEmpty($arr_search['attach_ids'])) {
            $arr_search['attach_ids'] = Func::arrayFilter($arr_search['attach_ids']);

            $_arr_where[] = array('attach_id', 'IN', $arr_search['attach_ids'], 'attach_ids');
        }

        if (isset($arr_search['admin_id']) && $arr_search['admin_id'] > 0) {
            $_arr_where[] = array('attach_admin_id', '=', $arr_search['admin_id']);
        }

        if (isset($arr_search['min_id']) && $arr_search['min_id'] > 0) {
            $_arr_where[] = array('attach_id', '>' . $arr_search['min_id'], 'min_id');
        }

        if (isset($arr_search['max_id']) && $arr_search['max_id'] > 0) {
            $_arr_where[] = array('attach_id', '<', $arr_search['max_id'], 'max_id');
        }

        return $_arr_where;
    }

    function readQueryProcess($mix_attach, $str_by = 'attach_id', $str_box = '') {
        $_arr_where[] = array($str_by, '=', $mix_attach);

        if (!Func::isEmpty($str_box)) {
            $_arr_where[] = array('attach_box', '=', $str_box);
        }

        return $_arr_where;
    }

    protected function rowProcess($arr_attachRow = array()) {
        if (isset($arr_attachRow['attach_ext'])) {
            if (in_array($arr_attachRow['attach_ext'], $this->imageExts)) {
                $arr_attachRow['attach_type'] = 'image';
            } else {
                $arr_attachRow['attach_type'] = 'file';
            }
        } else {
            $arr_attachRow['attach_type'] = 'file';
        }

        $_str_attachNameUrl                 = $this->nameProcess($arr_attachRow);
        $arr_attachRow['attach_url_name']   = $_str_attachNameUrl;
        $arr_attachRow['attach_url']        = $this->urlPrefix . $_str_attachNameUrl;

        if (!isset($arr_attachRow['attach_time'])) {
            $arr_attachRow['attach_time'] = GK_NOW;
        }

        if (!isset($arr_attachRow['attach_size'])) {
            $arr_attachRow['attach_size'] = 0;
        }

        $arr_attachRow['attach_time_format'] = $this->dateFormat($arr_attachRow['attach_time']);
        $arr_attachRow['attach_size_format'] = Func::sizeFormat($arr_attachRow['attach_size']);

        return $arr_attachRow;
    }
}
