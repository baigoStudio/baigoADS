<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}


/*-------------用户类-------------*/
class CONTROL_CONSOLE_REQUEST_MEDIA {

    private $is_super = false;

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->dspType = 'result';
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        $this->obj_upload     = new CLASS_UPLOAD();
        $this->mdl_media      = new MODEL_MEDIA();
        $this->mdl_admin      = new MODEL_ADMIN();
        $this->setUpload();

        if ($this->adminLogged['admin_type'] == 'super') {
            $this->is_super = true;
        }
    }


    function ctrl_empty() {
        if (!isset($this->adminLogged['admin_allow']['media']['del']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode'    => 'x070304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        if (!fn_token('chk')) { //令牌
            $_arr_tplData = array(
                'rcode'    => 'x030206',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_status = $this->obj_upload->upload_init();
        if ($_arr_status['rcode'] != 'y070403') {
            $this->obj_tpl->tplDisplay('result', $_arr_status);
        }


        $_arr_search = array(
            'box'        => 'recycle',
        ); //搜索设置

        $_arr_mediaIds    = array();
        $_num_perPage     = 10;
        $_num_mediaCount  = $this->mdl_media->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_mediaCount, $_num_perPage, 'post');
        $_arr_mediaRows   = $this->mdl_media->mdl_list($_num_perPage, 0, $_arr_search);

        if ($_num_mediaCount > 0) {
            foreach ($_arr_mediaRows as $_key=>$_value) {
                $_arr_mediaIds[] = $_value['media_id'];
            }

            $_arr_search = array(
                'box'       => 'recycle',
                'media_ids' => $_arr_mediaIds,
            ); //搜索设置
            $_arr_mediaRows  = $this->mdl_media->mdl_list(1000, 0, $_arr_search);
            //print_r($_arr_mediaRows);
            $this->obj_upload->upload_del($_arr_mediaRows);
            //exit;

            $_arr_mediaDel   = $this->mdl_media->mdl_del(0, $_arr_mediaIds);
            $_str_status     = 'loading';
            $_str_msg        = $this->obj_tpl->lang['rcode']['x070408'];
        } else {
            $_str_status = 'complete';
            $_str_msg    = $this->obj_tpl->lang['rcode']['y070408'];
        }

        $_arr_re = array(
            'msg'    => $_str_msg,
            'count'  => $_arr_page['total'],
            'status' => $_str_status,
        );

        $this->obj_tpl->tplDisplay('result', $_arr_re);
    }


    function ctrl_clear() {
        if (!isset($this->adminLogged['admin_allow']['media']['del']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode'    => 'x070304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_num_maxId        = fn_getSafe(fn_post('max_id'), 'int', 0);

        $_arr_search = array(
            'box'        => 'normal',
        ); //搜索设置

        $_num_perPage     = 10;
        $_num_mediaCount  = $this->mdl_media->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_mediaCount, $_num_perPage, 'post');
        $_arr_search = array(
            'box'       => 'normal',
            'max_id'    => $_num_maxId,
        ); //搜索设置
        $_arr_mediaRows   = $this->mdl_media->mdl_list($_num_perPage, 0, $_arr_search);

        if (fn_isEmpty($_arr_mediaRows)) {
            $_str_status    = 'complete';
            $_str_msg       = $this->obj_tpl->lang['rcode']['y070407'];
        } else {
            foreach ($_arr_mediaRows as $_key=>$_value) {
                $_arr_mediaRow = $this->mdl_media->mdl_chkMedia($_value['media_id'], $_value['media_ext'], $_value['media_time']);
                if ($_arr_mediaRow['rcode'] == 'x070406') {
                    $this->mdl_media->mdl_box('recycle', array($_value['media_id']));
                }
            }
            $_str_status    = 'loading';
            $_str_msg       = $this->obj_tpl->lang['rcode']['x070407'];
            $_num_maxId     = $_value['media_id'];
        }

        $_arr_re = array(
            'msg'       => $_str_msg,
            'count'     => $_arr_page['total'],
            'max_id'    => $_num_maxId,
            'status'    => $_str_status,
        );

        $this->obj_tpl->tplDisplay('result', $_arr_re);
    }


    function ctrl_box() {
        if (!isset($this->adminLogged['admin_allow']['media']['del']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode'    => 'x170303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_mediaIds = $this->mdl_media->input_ids();
        if ($_arr_mediaIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_mediaIds);
        }

        $_str_mediaStatus = fn_getSafe($GLOBALS['route']['bg_act'], 'txt', '');

        $_arr_mediaRow = $this->mdl_media->mdl_box($_str_mediaStatus);

        $this->obj_tpl->tplDisplay('result', $_arr_mediaRow);
    }

    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        $_arr_status = $this->obj_upload->upload_init();
        if ($_arr_status['rcode'] != 'y070403') {
            $this->obj_tpl->tplDisplay('result', $_arr_status);
        }

        if (!isset($this->adminLogged['admin_allow']['media']['upload']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode'    => 'x070302',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        if (!fn_token('chk')) { //令牌
            $_arr_tplData = array(
                'rcode'    => 'x030206',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        if (!is_array($this->mediaMime)) {
            $_arr_tplData = array(
                'rcode'    => 'x070405',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_uploadRow = $this->obj_upload->upload_pre();

        if ($_arr_uploadRow['rcode'] != 'y100201') {
            if ($str_rcode == 'x070203') {
                $_arr_uploadRow['msg'] = $this->obj_tpl->lang['rcode'][$str_rcode] . ' ' . BG_UPLOAD_SIZE . ' ' . BG_UPLOAD_UNIT;
            }

            $this->obj_tpl->tplDisplay('result', $_arr_uploadRow);
        }

        $_arr_mediaRow = $this->mdl_media->mdl_submit(0, $_arr_uploadRow['media_name'], $_arr_uploadRow['media_ext'], $_arr_uploadRow['media_mime'], $_arr_uploadRow['media_size'], $this->adminLogged['admin_id']);

        if ($_arr_mediaRow['rcode'] != 'y070101') {
            $this->obj_tpl->tplDisplay('result', $_arr_mediaRow);
        }

        $_arr_uploadRowSubmit = $this->obj_upload->upload_submit($_arr_mediaRow['media_time'], $_arr_mediaRow['media_id']);
        if ($_arr_uploadRowSubmit['rcode'] != 'y070401') {
            $this->obj_tpl->tplDisplay('result', $_arr_uploadRowSubmit);
        }
        $_arr_uploadRowSubmit['media_id']    = $_arr_mediaRow['media_id'];
        $_arr_uploadRowSubmit['media_ext']   = $_arr_uploadRow['media_ext'];
        $_arr_uploadRowSubmit['media_name']  = $_arr_uploadRow['media_name'];

        $this->obj_tpl->tplDisplay('result', $_arr_uploadRowSubmit);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        $_arr_status = $this->obj_upload->upload_init();
        if ($_arr_status['rcode'] != 'y070403') {
            $this->obj_tpl->tplDisplay('result', $_arr_status);
        }

        if (isset($this->adminLogged['admin_allow']['media']['del']) || $this->is_super) {
            $_num_adminId = 0;
        } else {
            $_num_adminId = $this->adminLogged['admin_id'];
        }

        $_arr_mediaIds = $this->mdl_media->input_ids();
        if ($_arr_mediaIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_mediaIds);
        }

        $_arr_search = array(
            'admin_id'  => $_num_adminId,
            'media_ids' => $_arr_mediaIds['media_ids'],
        ); //搜索设置
        $_arr_mediaRows = $this->mdl_media->mdl_list(1000, 0, $_arr_search);
        $this->obj_upload->upload_del($_arr_mediaRows);

        $_arr_mediaDel = $this->mdl_media->mdl_del($_num_adminId);

        $this->obj_tpl->tplDisplay('result', $_arr_mediaDel);
    }


    /**
     * ajax_list function.
     *
     * @access public
     * @return void
     */
    function ctrl_list() {
        if (!isset($this->adminLogged['admin_allow']['media']['browse']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x070301'
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_search = array(
            'key'       => fn_getSafe(fn_get('key'), 'txt', ''),
            'year'      => fn_getSafe(fn_get('year'), 'txt', ''),
            'month'     => fn_getSafe(fn_get('month'), 'txt', ''),
            'ext'       => fn_getSafe(fn_get('ext'), 'txt', ''),
            'admin_id'  => fn_getSafe(fn_get('admin_id'), 'int', 0),
            'status'    => 'normal',
        );
        $_num_perPage     = 8;
        $_num_mediaCount  = $this->mdl_media->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_mediaCount, $_num_perPage);
        $_arr_mediaRows   = $this->mdl_media->mdl_list($_num_perPage, $_arr_page['except'], $_arr_search);

        foreach ($_arr_mediaRows as $_key=>$_value) {
            $_arr_mediaRows[$_key]['adminRow']  = $this->mdl_admin->mdl_read($_value['media_admin_id']);
        }

        //print_r($_arr_page);

        $_arr_tpl = array(
            'pageRow'    => $_arr_page,
            'mediaRows'  => $_arr_mediaRows, //上传信息
        );

        $this->obj_tpl->tplDisplay('result', $_arr_tpl);
    }


    /**
     * setUpload function.
     *
     * @access private
     * @return void
     */
    private function setUpload() {
        foreach ($this->mdl_media->mime as $_key=>$_value) {
            $this->mediaMime[$_key] = $_value;
        }

        $this->obj_upload->mimeRows   = $this->mediaMime;
    }
}
