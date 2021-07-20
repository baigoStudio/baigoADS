<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Posi as Posi_Base;
use ginkgo\Func;
use ginkgo\Arrays;
use ginkgo\Plugin;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------广告位类-------------*/
class Posi extends Posi_Base {

    function duplicate() {
        $_arr_posiData = array(
            'posi_name',
            'posi_count',
            'posi_status',
            'posi_script',
            'posi_box_perfix',
            'posi_loading',
            'posi_close',
            'posi_is_percent',
            'posi_note',
        );

        $_num_posiId = $this->where('posi_id', '=', $this->inputDuplicate['posi_id'])->duplicate($_arr_posiData);

        if ($_num_posiId > 0) { //数据库更新是否成功
            $_str_rcode = 'y040112';
            $_str_msg   = 'Duplicate position successfully';
        } else {
            $_str_rcode = 'x040112';
            $_str_msg   = 'Duplicate position failed';
        }

        return array(
            'posi_id'   => $_num_posiId,
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }

    /**
     * mdl_submit function.
     *
     * @access public
     * @param mixed $num_posiId
     * @param mixed $str_posiName
     * @param mixed $str_posiType
     * @param string $str_posiNote (default: '')
     * @param string $str_posiAllow (default: '')
     * @return void
     */
    function submit() {
        $_arr_posiData = array(
            'posi_name'         => $this->inputSubmit['posi_name'],
            'posi_count'        => $this->inputSubmit['posi_count'],
            'posi_status'       => $this->inputSubmit['posi_status'],
            'posi_script'       => $this->inputSubmit['posi_script'],
            'posi_box_perfix'   => $this->inputSubmit['posi_box_perfix'],
            'posi_loading'      => $this->inputSubmit['posi_loading'],
            'posi_close'        => $this->inputSubmit['posi_close'],
            'posi_is_percent'   => $this->inputSubmit['posi_is_percent'],
            'posi_note'         => $this->inputSubmit['posi_note'],
        );

        if ($this->inputSubmit['posi_id'] > 0) {
            $_str_hook = 'edit'; //编辑文章时触发
        } else {
            $_str_hook = 'add';
        }

        $_arr_posiData    = Plugin::listen('filter_console_posi_' . $_str_hook, $_arr_posiData);

        $_mix_vld = $this->validate($_arr_posiData, '', 'submit_db');

        if ($_mix_vld !== true) {
            return array(
                'posi_id'  => $this->inputSubmit['posi_id'],
                'rcode'     => 'x040201',
                'msg'       => end($_mix_vld),
            );
        }

        if ($this->inputSubmit['posi_id'] > 0) { //插入
            $_num_posiId = $this->inputSubmit['posi_id'];
            $_num_count  = $this->where('posi_id', '=', $_num_posiId)->update($_arr_posiData);

            if ($_num_count > 0) { //数据库插入是否成功
                $_str_rcode = 'y040101';
                $_str_msg   = 'Update position successfully';
            } else {
                $_str_rcode = 'x040101';
                $_str_msg   = 'Did not make any changes';
            }
        } else {
            $_num_posiId = $this->insert($_arr_posiData);

            if ($_num_posiId > 0) { //数据库更新是否成功
                $_str_rcode = 'y040103';
                $_str_msg   = 'Add position successfully';
            } else {
                $_str_rcode = 'x040103';
                $_str_msg   = 'Add position failed';
            }
        }

        return array(
            'posi_id'   => $_num_posiId,
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }


    function opts() {
        $_arr_posiData = array(
            'posi_opts' => Arrays::toJson($this->inputOpts['posi_opts']),
        );

        $_num_count  = $this->where('posi_id', '=', $this->inputOpts['posi_id'])->update($_arr_posiData);

        if ($_num_count > 0) { //数据库插入是否成功
            $_str_rcode = 'y040101';
            $_str_msg   = 'Update position successfully';
        } else {
            $_str_rcode = 'x040101';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'posi_id'   => $this->inputOpts['posi_id'],
            'rcode'     => $_str_rcode,
            'msg'       => $_str_msg,
        );
    }


    function status() {
        $_arr_posiUpdate = array(
            'posi_status' => $this->inputStatus['act'],
        );

        $_num_count = $this->where('posi_id', 'IN', $this->inputStatus['posi_ids'], 'posi_ids')->update($_arr_posiUpdate); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y040103';
            $_str_msg   = 'Successfully updated {:count} positions';
        } else {
            $_str_rcode = 'x040103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'rcode' => $_str_rcode,
            'count' => $_num_count,
            'msg'   => $_str_msg,
        ); //成功

    }


    /**
     * mdl_del function.
     *
     * @access public
     * @param mixed $this->inputDelete['posi_ids']
     * @return void
     */
    function delete() {
        $_num_count = $this->where('posi_id', 'IN', $this->inputDelete['posi_ids'], 'posi_ids')->delete(); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y040104';
            $_str_msg   = 'Successfully deleted {:count} positions';

            $_arr_posiIds = explode(',', $this->inputDelete['posi_ids']);

            foreach ($_arr_posiIds as $_key=>$_value) {
                $this->obj_cache->delete('posi_' . $_value);
            }
        } else {
            $_str_rcode = 'x040104';
            $_str_msg   = 'No position have been deleted';
        }

        return array(
            'rcode' => $_str_rcode,
            'count' => $_num_count,
            'msg'   => $_str_msg,
        );
    }


    function inputDuplicate() {
        $_arr_inputParam = array(
            'posi_id'    => array('int', 0),
            '__token__'  => array('str', ''),
        );

        $_arr_inputDuplicate = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputDuplicate, '', 'duplicate');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x040201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_posiRow = $this->check($_arr_inputDuplicate['posi_id']);

        if ($_arr_posiRow['rcode'] != 'y040102') {
            return $_arr_posiRow;
        }

        $_arr_inputDuplicate['rcode'] = 'y040201';

        $this->inputDuplicate = $_arr_inputDuplicate;

        return $_arr_inputDuplicate;
    }


    function inputSubmit() {
        $_arr_inputParam = array(
            'posi_id'           => array('int', 0),
            'posi_name'         => array('txt', ''),
            'posi_count'        => array('int', 0),
            'posi_note'         => array('txt', ''),
            'posi_status'       => array('txt', ''),
            'posi_script'       => array('txt', ''),
            'posi_box_perfix'   => array('txt', ''),
            'posi_loading'      => array('txt', ''),
            'posi_close'        => array('txt', ''),
            'posi_is_percent'   => array('txt', ''),
            '__token__'         => array('txt', ''),
        );

        $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputSubmit, '', 'submit');

        if ($_mix_vld !== true) {
            return array(
                'rcode'     => 'x040201',
                'msg'       => end($_mix_vld),
            );
        }

        $_arr_inputSubmit['rcode'] = 'y040201';

        if ($_arr_inputSubmit['posi_id'] > 0) {
            $_arr_posiRow = $this->check($_arr_inputSubmit['posi_id']);

            if ($_arr_posiRow['rcode'] != 'y040102') {
                return $_arr_posiRow;
            }
        }

        $this->inputSubmit = $_arr_inputSubmit;

        return $_arr_inputSubmit;
    }


    function inputOpts() {
        $_arr_inputParam = array(
            'posi_id'           => array('int', 0),
            'posi_opts'         => array('arr', array()),
            '__token__'         => array('txt', ''),
        );

        $_arr_inputOpts = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputOpts, '', 'opts');

        if ($_mix_vld !== true) {
            return array(
                'rcode'     => 'x040201',
                'msg'       => end($_mix_vld),
            );
        }

        $_arr_inputOpts['rcode'] = 'y040201';

        $_arr_posiRow = $this->check($_arr_inputOpts['posi_id']);

        if ($_arr_posiRow['rcode'] != 'y040102') {
            return $_arr_posiRow;
        }

        $this->inputOpts = $_arr_inputOpts;

        return $_arr_inputOpts;
    }


    function inputStatus() {
        $_arr_inputParam = array(
            'posi_ids' => array('arr', array()),
            'act'       => array('txt', ''),
            '__token__' => array('txt', ''),
        );

        $_arr_inputStatus = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputStatus, '', 'status');

        if ($_mix_vld !== true) {
            return array(
                'rcode'     => 'x040201',
                'msg'       => end($_mix_vld),
            );
        }

        $_arr_inputStatus['rcode'] = 'y040201';

        $this->inputStatus = $_arr_inputStatus;

        return $_arr_inputStatus;
    }


    function inputDelete() {
        $_arr_inputParam = array(
            'posi_ids' => array('arr', array()),
            '__token__' => array('txt', ''),
        );

        $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputDelete, '', 'delete');

        if ($_mix_vld !== true) {
            return array(
                'rcode'     => 'x040201',
                'msg'       => end($_mix_vld),
            );
        }

        $_arr_inputDelete['rcode'] = 'y040201';

        $this->inputDelete = $_arr_inputDelete;

        return $_arr_inputDelete;
    }

    function inputCommon() {
        $_arr_inputParam = array(
            '__token__' => array('txt', ''),
        );

        $_arr_inputCommon = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputCommon, '', 'common');

        if ($_mix_vld !== true) {
            return array(
                'rcode'     => 'x040201',
                'msg'       => end($_mix_vld),
            );
        }

        $_arr_inputCommon['rcode'] = 'y040201';

        $this->inputCommon = $_arr_inputCommon;

        return $_arr_inputCommon;
    }
}
