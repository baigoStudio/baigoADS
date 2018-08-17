<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------上传类-------------*/
class CLASS_UPLOAD {

    public $mimeRows   = array();

    function __construct() { //构造函数
        $this->obj_file          = new CLASS_FILE();
        $this->obj_file->perms   = 0755;
    }


    /** 上传初始化
     * upload_init function.
     *
     * @access public
     * @return void
     */
    function upload_init() {
        switch (BG_UPLOAD_UNIT) { //初始化单位
            case 'B':
                $_num_sizeUnit = 1;
            break;

            case 'KB':
                $_num_sizeUnit = 1024;
            break;

            case 'MB':
                $_num_sizeUnit = 1024 * 1024;
            break;

            case 'GB':
                $_num_sizeUnit = 1024 * 1024 * 1024;
            break;
        }
        $this->uploadSize = BG_UPLOAD_SIZE * $_num_sizeUnit;

        return array(
            'rcode' => 'y070403',
        );
    }


    /** 上传预处理
     * upload_pre function.
     *
     * @access public
     * @return void
     */
    function upload_pre() {
        $this->attachFiles = $_FILES['attach_files'];

        //是否上传文件校验
        if (!is_uploaded_file($this->attachFiles['tmp_name'])) {
            return array(
                'rcode' => 'x070206',
            );
        }

        switch ($this->attachFiles['error']) { //返回错误
            case 1:
                return array(
                    'rcode' => 'x100201',
                );
            break;
            case 2:
                return array(
                    'rcode' => 'x100202',
                );
            break;
            case 3:
                return array(
                    'rcode' => 'x100203',
                );
            break;
            case 4:
                return array(
                    'rcode' => 'x100204',
                );
            break;
            case 6:
                return array(
                    'rcode' => 'x100206',
                );
            break;
            case 7:
                return array(
                    'rcode' => 'x100207',
                );
            break;
        }


        $_obj_finfo               = new finfo();
        $this->attachFiles['mime'] = $_obj_finfo->file($this->attachFiles['tmp_name'], FILEINFO_MIME_TYPE);

        if ($this->attachFiles['mime'] == 'CDF V2 Document, corrupt: Can\'t expand summary_info') { //如果无法识别则以浏览器报告的 mime 为准
            $this->attachFiles['mime'] = $this->attachFiles['type'];
        }

        $_str_ext = strtolower(pathinfo($this->attachFiles['name'], PATHINFO_EXTENSION)); //取得扩展名

        //扩展名与 MIME 不符的情况下, 反向查找, 如果允许, 则更改扩展名
        if (!isset($this->mimeRows[$_str_ext]) || !in_array($this->attachFiles['mime'], $this->mimeRows[$_str_ext])) {
            foreach ($this->mimeRows as $_key_allow=>$_value_allow) {
                if (in_array($this->attachFiles['mime'], $_value_allow)) {
                    $_str_ext = $_key_allow;
                    break;
                }
            }
        }

        if (!isset($this->mimeRows[$_str_ext])) { //该扩展名的 mime 数组是否存在
            return array(
                'rcode' => 'x070207',
            );
        }

        if (!in_array($this->attachFiles['mime'], $this->mimeRows[$_str_ext])) { //是否允许
            return array(
                'rcode' => 'x070202',
            );
        }

        if ($this->attachFiles['size'] > $this->uploadSize) { //是否超过尺寸
            return array(
                'rcode' => 'x070203',
            );
        }

        $this->attachFiles['ext'] = $_str_ext;

        return array(
            'attach_tmp'     => $this->attachFiles['tmp_name'],
            'attach_ext'     => $this->attachFiles['ext'],
            'attach_mime'    => $this->attachFiles['mime'],
            'attach_name'    => $this->attachFiles['name'],
            'attach_size'    => $this->attachFiles['size'],
            'rcode'          => 'y100201',
        );
    }


    /** 提交上传
     * upload_submit function.
     *
     * @access public
     * @param mixed $tm_time 上传时间
     * @param mixed $num_attachId 文件ID
     * @return void
     */
    function upload_submit($tm_time, $num_attachId) {

        $this->attachPath  = BG_PATH_ATTACH . date('Y', $tm_time) . DS . date('m', $tm_time) . DS;
        $_str_attachPre    = BG_URL_ATTACH;
        $_str_attachUrl    = $_str_attachPre . date('Y', $tm_time) . '/' . date('m', $tm_time) . '/';

        if (!$this->obj_file->dir_mk($this->attachPath)) { //建目录失败
            return array(
                'rcode' => 'x100101',
            );
        }

        $this->attachName = $num_attachId; //原始文件名

        move_uploaded_file($this->attachFiles['tmp_name'], $this->attachPath . $this->attachName . '.' . $this->attachFiles['ext']); //将上传的文件移到指定路径

        return array(
            'attach_path' => $this->attachPath . $this->attachName . '.' . $this->attachFiles['ext'],
            'attach_url'  => $_str_attachUrl . $this->attachName . '.' . $this->attachFiles['ext'],
            'rcode'      => 'y070401',
        );
    }


    /** 删除
     * upload_del function.
     *
     * @access public
     * @param mixed $arr_attach 预删除的文件数组
     * @return void
     */
    function upload_del($arr_attach) {
        foreach ($arr_attach as $_key=>$_value) {
            $_str_filePath = date('Y', $_value['attach_time']) . DS . date('m', $_value['attach_time']) . DS . $_value['attach_id'] . '.' . $_value['attach_ext'];

            //print_r($_str_filePath);
            //exit;

            $this->obj_file->file_del(BG_PATH_ATTACH . $_str_filePath);
        }
    }

    /**
     * __destruct function.
     *
     * @access public
     * @return void
     */
    function __destruct() { //析构函数

    }
}
