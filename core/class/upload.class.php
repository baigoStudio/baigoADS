<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

/*-------------上传类-------------*/
class CLASS_UPLOAD {

    private $obj_dir;
    private $uploadSize; //允许上传大小
    private $mediaExt; //扩展名
    private $mediaPath; //路径
    private $mediaName; //文件名
    private $fileTmp;
    public $config;
    public $mimeRows   = array();

    function __construct() { //构造函数
        $this->obj_base   = $GLOBALS["obj_base"]; //获取界面类型
        $this->config     = $this->obj_base->config;
        $this->obj_dir    = new CLASS_DIR();
    }


    /** 上传初始化
     * upload_init function.
     *
     * @access public
     * @return void
     */
    function upload_init() {
        switch (BG_UPLOAD_UNIT) { //初始化单位
            case "B":
                $_num_sizeUnit = 1;
            break;

            case "KB":
                $_num_sizeUnit = 1024;
            break;

            case "MB":
                $_num_sizeUnit = 1024 * 1024;
            break;

            case "GB":
                $_num_sizeUnit = 1024 * 1024 * 1024;
            break;
        }
        $this->uploadSize = BG_UPLOAD_SIZE * $_num_sizeUnit;

        return array(
            "alert" => "y070403",
        );
    }


    /** 上传预处理
     * upload_pre function.
     *
     * @access public
     * @return void
     */
    function upload_pre() {
        $this->mediaFiles = $_FILES["media_files"];

        switch ($this->mediaFiles["error"]) { //返回错误
            case 1:
                return array(
                    "alert" => "x100201",
                );
            break;
            case 2:
                return array(
                    "alert" => "x100202",
                );
            break;
            case 3:
                return array(
                    "alert" => "x100203",
                );
            break;
            case 4:
                return array(
                    "alert" => "x100204",
                );
            break;
            case 6:
                return array(
                    "alert" => "x100206",
                );
            break;
            case 7:
                return array(
                    "alert" => "x100207",
                );
            break;
        }


        $_obj_finfo               = new finfo();
        $this->mediaFiles["mime"] = $_obj_finfo->file($this->mediaFiles["tmp_name"], FILEINFO_MIME_TYPE);
        $_str_ext                 = $this->mimeRows[$this->mediaFiles["mime"]];
        $this->mediaFiles["ext"]  = strtolower($_str_ext); //扩展名

        if (!array_key_exists($this->mediaFiles["mime"], $this->mimeRows)) { //是否允许
            return array(
                "alert" => "x070202",
            );
        }

        if ($this->mediaFiles["size"] > $this->uploadSize) { //是否超过尺寸
            return array(
                "alert" => "x070203",
            );
        }

        return array(
            "media_tmp"     => $this->mediaFiles["tmp_name"],
            "media_ext"     => $this->mediaFiles["ext"],
            "media_mime"    => $this->mediaFiles["mime"],
            "media_name"    => $this->mediaFiles["name"],
            "media_size"    => $this->mediaFiles["size"],
            "alert"      => "y100201",
        );
    }


    /** 提交上传
     * upload_submit function.
     *
     * @access public
     * @param mixed $tm_time 上传时间
     * @param mixed $num_mediaId 文件ID
     * @return void
     */
    function upload_submit($tm_time, $num_mediaId) {

        $this->mediaPath  = BG_PATH_MEDIA . date("Y", $tm_time) . "/" . date("m", $tm_time) . "/";
        $_str_mediaPre    = BG_URL_MEDIA;
        $_str_mediaUrl    = $_str_mediaPre . date("Y", $tm_time) . "/" . date("m", $tm_time) . "/";

        if (!$this->obj_dir->mk_dir($this->mediaPath)) { //建目录失败
            return array(
                "alert" => "x100101",
            );
        }

        $this->mediaName = $num_mediaId; //原始文件名

        move_uploaded_file($this->mediaFiles["tmp_name"], $this->mediaPath . $this->mediaName . "." . $this->mediaFiles["ext"]); //将上传的文件移到指定路径

        return array(
            "media_path" => $this->mediaPath . $this->mediaName . "." . $this->mediaFiles["ext"],
            "media_url"  => $_str_mediaUrl . $this->mediaName . "." . $this->mediaFiles["ext"],
            "alert"      => "y070401",
        );
    }


    /** 删除
     * upload_del function.
     *
     * @access public
     * @param mixed $arr_media 预删除的文件数组
     * @return void
     */
    function upload_del($arr_media) {
        foreach ($arr_media as $_key=>$_value) {
            $_str_filePath = date("Y", $_value["media_time"]) . "/" . date("m", $_value["media_time"]) . "/" . $_value["media_id"] . "." . $_value["media_ext"];

            //print_r($_str_filePath);
            //exit;

            if (file_exists(BG_PATH_MEDIA . $_str_filePath)) { //文件是否存在
                unlink(BG_PATH_MEDIA . $_str_filePath);
            }
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
