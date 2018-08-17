            <div class="card bg-card-dashed mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <button type="button" class="btn btn-outline-secondary fileinput-button" id="upload_select">
                            <?php echo $this->lang['mod']['btn']['browse']; ?>
                        </button>

                        <button id="upload_begin" class="btn btn-primary">
                            <span class="oi oi-cloud-upload"></span>
                            <?php echo $this->lang['mod']['btn']['upload']; ?>
                        </button>
                    </div>

                    <!--用来存放文件信息-->
                    <div id="upload_list"></div>
                </div>
            </div>

            <script type="text/javascript">
            function upload_tpl(_key, _file, _msg) {
                var _str_tpl = "<div id=\"bg_" + _key + "\" class=\"alert alert-info mb-3\">" +
                    "<div class=\"media mb-3\">" +
                        "<img src=\"\" class=\"mr-3 bg-img\">" +
                        "<div class=\"media-body text-truncate\">" +
                            "<div class=\"text-truncate\">" + _file + "</div>" +
                            "<div>" +
                                "<span class=\"oi oi-cloud-upload\"></span>" +
                                "&nbsp;<span class=\"bg-msg\">" + _msg + "</span>" +
                            "</div>" +
                        "</div>" +
                    "</div>" +
                    "<div class=\"progress bg-progress\">" +
                        "<div class=\"progress-bar progress-bar-info progress-bar-striped active\" style=\"width: 10%\"></div>"+
                    "</div>" +
                "<div>";

                return _str_tpl;
            }

            function alert_process(_key, _class, _icon, _msg) {
                $("#bg_" + _key).removeClass("alert-info alert-danger alert-success");
                $("#bg_" + _key).addClass(_class);
                $("#bg_" + _key + " .oi").removeClass("oi-loop-circular oi-circle-x oi-circle-check oi-cloud-upload bg-spin");
                $("#bg_" + _key + " .oi").addClass(_icon);
                $("#bg_" + _key + " .bg-msg").html(_msg);
            }

            $(document).ready(function(){
                if (!WebUploader.Uploader.support()) {
                    alert("<?php echo $this->lang['mod']['label']['needH5']; ?>");
                }

                var obj_wu = new WebUploader.Uploader({
                    //附加表单数据
                    formData: {
                        <?php echo $this->common['tokenRow']['name_session']; ?>: "<?php echo $this->common['tokenRow']['token']; ?>",
                        a: "submit"
                    },
                    server: "<?php echo BG_URL_CONSOLE; ?>index.php?m=attach&c=request", //文件接收服务端
                    pick: {
                        id: "#upload_select", //选择按钮
                        multiple: false
                    },

                    fileVal: "attach_files", //设置 file 域的 name
                    //允许的 mime
                    accept: {
                        title: "file",
                        extensions: "<?php echo implode(',', $this->tplData['allowExtRows']); ?>",
                        mimeTypes: "<?php echo implode(',', $this->tplData['allowMimeRows']); ?>"
                    },
                    fileNumLimit: <?php echo BG_UPLOAD_COUNT; ?>, //队列限制
                    fileSingleSizeLimit: <?php echo $this->tplData['uploadSize']; ?>, //单个尺寸限制
                    resize: false //不压缩 image
                });

                $("#upload_begin").click(function(){
                    obj_wu.upload();
                });

                obj_wu.on("fileQueued", function(file){
                    _str_tpl = upload_tpl(file.id, file.name, "<?php echo $this->lang['mod']['label']['waiting']; ?>");

                    $("#upload_list").append(_str_tpl);
                    $("#bg_" + file.id + " .bg-progress").hide();

                    obj_wu.makeThumb(file, function(error, src) {
                        if (error) {
                            $("img.bg-img").hide();
                        }

                        $("#bg_" + file.id + " img.bg-img").attr("src", src);
                    }, 64, 64);

                    $(".close").click(function(){
                        obj_wu.removeFile(file, true);
                    });
                });

                obj_wu.on("error", function(error, size, file){
                    //console.log(file);
                    switch(error) {
                        case "F_EXCEED_SIZE":
                            alert(file.name + " <?php echo $this->lang['rcode']['x070203'], ' ', BG_UPLOAD_SIZE, ' ', BG_UPLOAD_UNIT; ?>");
                        break;

                        case "Q_EXCEED_NUM_LIMIT":
                            alert(file.name + " <?php echo $this->lang['rcode']['x070204'], ' ', BG_UPLOAD_COUNT; ?>");
                        break;

                        case "Q_TYPE_DENIED":
                            alert("<?php echo $this->lang['rcode']['x070202']; ?>");
                        break;
                    }
                });

                obj_wu.on("uploadProgress", function(file, percentage){
                    alert_process(file.id, "alert-info", "oi-loop-circular bg-spin", "<?php echo $this->lang['mod']['label']['uploading']; ?>");

                    $("#bg_" + file.id + " .bg-progress").show();
                    $("#bg_" + file.id + " .bg-progress .progress-bar").text(percentage * 100 + "%");
                    $("#bg_" + file.id + " .bg-progress .progress-bar").css("width", percentage * 100 + "%");
                });

                obj_wu.on("uploadSuccess", function(file, result){
                    var _str_msg;
                    if (result.rcode == 'y070401') {
                        alert_process(file.id, "alert-success", "oi-circle-check", "<?php echo $this->lang['mod']['label']['uploadSucc']; ?>");

                        <?php if (isset($cfg['js_insert'])) { ?>
                            insertAttach(result.attach_url, result.attach_id);
                        <?php } ?>
                    } else {
                        if (typeof result.msg == "undefined") {
                            _str_msg = "<?php echo $this->lang['mod']['label']['returnErr']; ?>";
                        } else {
                            _str_msg = result.msg;
                        }
                        alert_process(file.id, "alert-danger", "oi-circle-x", _str_msg);
                    }
                });

                obj_wu.on("uploadError", function(file, result){
                    alert_process(file.id, "alert-danger", "oi-circle-x", "Error&nbsp;status:&nbsp;" + result);
                });

                obj_wu.on("uploadComplete", function(file){
                    $("#bg_" + file.id + " .bg-progress").slideUp("slow");

                    setTimeout(function(){
                        $("#bg_" + file.id).slideUp("slow");
                    }, 5000);
                });
            });
            </script>
