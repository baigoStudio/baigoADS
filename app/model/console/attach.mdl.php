<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Attach as Attach_Base;
use ginkgo\Func;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------附件模型-------------*/
class Attach extends Attach_Base {

    /**
     * mdl_submit function.
     *
     * @access public
     * @param mixed $str_attachName
     * @param mixed $str_attachExt
     * @param int $num_attachSize (default: 0)
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function submit() {
        $_tm_time = GK_NOW;
        $_num_attachId = 0;

        $_arr_attachData = array(
            'attach_time'   => $_tm_time,
            'attach_box'    => 'normal',
        );

        if (isset($this->inputSubmit['attach_id'])) {
            $_num_attachId  = $this->inputSubmit['attach_id'];
        }

        if (isset($this->inputSubmit['attach_name'])) {
            $_arr_attachData['attach_name']     = $this->inputSubmit['attach_name'];
        }

        if (isset($this->inputSubmit['attach_ext'])) {
            $_arr_attachData['attach_ext']      = $this->inputSubmit['attach_ext'];
        }

        if (isset($this->inputSubmit['attach_mime'])) {
            $_arr_attachData['attach_mime']     = $this->inputSubmit['attach_mime'];
        }

        if (isset($this->inputSubmit['attach_admin_id'])) {
            $_arr_attachData['attach_admin_id'] = $this->inputSubmit['attach_admin_id'];
        }

        if (isset($this->inputSubmit['attach_size'])) {
            $_arr_attachData['attach_size']     = $this->inputSubmit['attach_size'];
        }

        $_mix_vld = $this->validate($_arr_attachData, '', 'submit_db');

        if ($_mix_vld !== true) {
            return array(
                'advert_id' => $this->inputSubmit['attach_id'],
                'rcode'     => 'x070201',
                'msg'       => end($_mix_vld),
            );
        }

        if ($_num_attachId > 0) {
            $_num_count     = $this->where('attach_id', '=', $_num_attachId)->update($_arr_attachData); //更新数据
            if ($_num_count > 0) {
                $_str_rcode = 'y070103'; //更新成功
                $_str_msg   = 'Update attachment successfully';
            } else {
                $_str_rcode = 'x070103';
                $_str_msg   = 'Did not make any changes';
            }
        } else {
            $_arr_attachRow = $this->check('reserve', 'attach_box');

            if ($_arr_attachRow['rcode'] == 'x070102') {
                $_num_attachId = $this->insert($_arr_attachData);

                if ($_num_attachId > 0) { //数据库插入是否成功
                    $_str_rcode = 'y070101';
                    $_str_msg   = 'Upload attachment successfully';
                } else {
                    $_str_rcode = 'x070101';
                    $_str_msg   = 'Upload attachment failed';
                }
            } else {
                $_num_attachId  = $_arr_attachRow['attach_id'];
                $_num_count     = $this->where('attach_id', '=', $_num_attachId)->update($_arr_attachData); //更新数据
                if ($_num_count > 0) {
                    $_str_rcode = 'y070101';
                    $_str_msg   = 'Upload attachment successfully';
                } else {
                    $_str_rcode = 'x070101';
                    $_str_msg   = 'Upload attachment failed';
                }
            }
        }

        $_arr_return = array(
            'attach_id' => $_num_attachId,
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );

        $_arr_attachResult = array_replace_recursive($_arr_return, $_arr_attachData);

        return $this->rowProcess($_arr_attachResult);
    }


    /**
     * mdl_del function.
     *
     * @access public
     * @param mixed $this->attachIds['attach_ids']
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function delete() {
        $_arr_where[] = array('attach_id', 'IN', $this->inputDelete['attach_ids'], 'attach_ids');

        if (isset($this->inputDelete['admin_id']) && $this->inputDelete['admin_id'] > 0) {
            $_arr_where[] = array('attach_admin_id', '=', $this->inputDelete['admin_id']);
        }

        $_num_count     = $this->where($_arr_where)->delete();

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y070104';
            $_str_msg   = 'Successfully deleted {:count} attachments';
        } else {
            $_str_rcode = 'x070104';
            $_str_msg   = 'No attachment have been deleteds';
        }

        return array(
            'count' => $_num_count,
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        ); //成功
    }


    /**
     * mdl_ext function.
     *
     * @access public
     * @param mixed $num_no
     * @return void
     */
    function ext() {
        $_arr_attachSelect = array(
            'DISTINCT `attach_ext`',
        );

        $_arr_attachRows = $this->where('LENGTH(`attach_ext`)', '>', 0, 'attach_ext')->limit(100)->select($_arr_attachSelect);

        return $_arr_attachRows;
    }


    /**
     * mdl_year function.
     *
     * @access public
     * @param mixed $num_no
     * @return void
     */
    function year() {
        $_arr_attachSelect = array(
            'DISTINCT FROM_UNIXTIME(`attach_time`, \'%Y\') AS `attach_year`',
        );

        $_arr_yearRows = $this->where('attach_time', '>', 0, 'attach_time')->order('attach_time', 'ASC')->limit(100)->select($_arr_attachSelect);

        return $_arr_yearRows;
    }



    function box() {
        $_arr_attachData = array(
            'attach_box' => $this->inputBox['act'],
        );

        $_num_count = $this->where('attach_id', 'IN', $this->inputBox['attach_ids'], 'attach_ids')->update($_arr_attachData);

        if ($_num_count > 0) {
            $_str_rcode = 'y070103';
            $_str_msg   = 'Successfully updated {:count} attachments';
        } else {
            $_str_rcode = 'x070103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'count' => $_num_count,
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }


    function reserve() {
        $_arr_attachUpdate = array(
            'attach_box' => 'reserve',
        );

        $_num_count = $this->where('attach_id', '=', $this->inputReserve['attach_id'])->update($_arr_attachData);

        //如影响行数大于0则返回成功
        if ($_num_count > 0) {
            $_str_rcode = 'y070103'; //成功
        } else {
            $_str_rcode = 'x070103'; //失败
        }

        return array(
            'rcode' => $_str_rcode,
        );
    }


    function inputUpload() {
        $_arr_inputParam = array(
            '__token__'         => array('txt', ''),
        );

        $_arr_inputUpload = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputUpload, '', 'common');

        if ($_mix_vld !== true) {
            return array(
                'rcode'     => 'x070201',
                'msg'       => end($_mix_vld),
            );
        }

        $_arr_inputUpload['rcode'] = 'y070201';

        $this->inputUpload = $_arr_inputUpload;

        return $_arr_inputUpload;
    }


    function inputCommon() {
        $_arr_inputParam = array(
            '__token__' => array('txt', ''),
        );

        $_arr_inputCommon = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputCommon, '', 'common');

        if ($_mix_vld !== true) {
            return array(
                'rcode'     => 'x070201',
                'msg'       => end($_mix_vld),
            );
        }

        $_arr_inputCommon['rcode'] = 'y070201';

        $this->inputCommon = $_arr_inputCommon;

        return $_arr_inputCommon;
    }


    function inputSubmit() {
        $_arr_inputParam = array(
            'attach_id'         => array('int', 0),
            'attach_name'       => array('txt', ''),
            'attach_ext'        => array('txt', ''),
            'attach_mime'       => array('txt', ''),
            'attach_box'        => array('txt', ''),
            'attach_album_ids'  => array('arr', array()),
            '__token__'         => array('txt', ''),
        );

        $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputSubmit, '', 'submit');

        if ($_mix_vld !== true) {
            return array(
                'rcode'     => 'x070201',
                'msg'       => end($_mix_vld),
            );
        }

        $_arr_inputSubmit['rcode'] = 'y070201';

        $this->inputSubmit = $_arr_inputSubmit;

        return $_arr_inputSubmit;
    }


    function inputFix() {
        $_arr_inputParam = array(
            'attach_id'         => array('int', 0),
            '__token__'         => array('txt', ''),
        );

        $_arr_inputFix = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputFix, '', 'fix');

        if ($_mix_vld !== true) {
            return array(
                'rcode'     => 'x070201',
                'msg'       => end($_mix_vld),
            );
        }

        $_arr_inputFix['rcode'] = 'y070201';

        $this->inputFix = $_arr_inputFix;

        return $_arr_inputFix;
    }


    function inputClear() {
        $_arr_inputParam = array(
            'max_id'    => array('int', 0),
            '__token__' => array('txt', ''),
        );

        $_arr_inputClear = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputClear, '', 'clear');

        if ($_mix_vld !== true) {
            return array(
                'rcode'     => 'x070201',
                'msg'       => end($_mix_vld),
            );
        }

        $_arr_inputClear['rcode'] = 'y070201';

        $this->inputClear = $_arr_inputClear;

        return $_arr_inputClear;
    }


    /**
     * fn_thumbDo function.
     *
     * @access public
     * @return void
     */
    function inputBox() {
        $_arr_inputParam = array(
            'attach_ids' => array('arr', array()),
            'act'        => array('txt', ''),
            '__token__'  => array('txt', ''),
        );

        $_arr_inputBox = $this->obj_request->post($_arr_inputParam);

        //print_r($_arr_inputBox);

        $_arr_inputBox['attach_ids'] = Func::arrayFilter($_arr_inputBox['attach_ids']);

        $_mix_vld = $this->validate($_arr_inputBox, '', 'status');

        if ($_mix_vld !== true) {
            return array(
                'rcode'     => 'x070201',
                'msg'       => end($_mix_vld),
            );
        }

        $_arr_inputBox['rcode'] = 'y070201';

        $this->inputBox = $_arr_inputBox;

        return $_arr_inputBox;
    }

    function inputDelete() {
        $_arr_inputParam = array(
            'attach_ids' => array('arr', array()),
            '__token__'  => array('txt', ''),
        );

        $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

        //print_r($_arr_inputDelete);

        $_arr_inputDelete['attach_ids'] = Func::arrayFilter($_arr_inputDelete['attach_ids']);

        $_mix_vld = $this->validate($_arr_inputDelete, '', 'delete');

        if ($_mix_vld !== true) {
            return array(
                'rcode'     => 'x070201',
                'msg'       => end($_mix_vld),
            );
        }

        $_arr_inputDelete['rcode'] = 'y070201';

        $this->inputDelete = $_arr_inputDelete;

        return $_arr_inputDelete;
    }


    protected function rowProcess($arr_attachRow = array()) {
        $arr_attachRow = parent::rowProcess($arr_attachRow);
        $_str_attachNamePath                = $this->nameProcess($arr_attachRow, DS);
        $arr_attachRow['attach_path_name']  = $_str_attachNamePath;
        $arr_attachRow['attach_path']       = GK_PATH_ATTACH . $_str_attachNamePath;

        return $arr_attachRow;
    }
}
