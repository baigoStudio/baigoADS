            <div class="panel panel-default bg-panel-dashed">
                <div class="panel-body">
                    <div class="form-group">
                        <a id="upload_select" class="btn btn-success fileinput-button">
                            <span class="glyphicon glyphicon-cloud-upload"></span>
                            <?php echo $this->lang['mod']['btn']['upload']; ?>
                        </a>
                    </div>

                    <div id="media_upload"></div>
                </div>
            </div>

            <script type="text/javascript">
            function alert_process(_class, _icon, _msg) {
                $("#media_upload .bg-alert").removeClass("alert-info alert-danger alert-success");
                $("#media_upload .bg-alert").addClass(_class);
                $("#media_upload .bg-alert i").removeClass("glyphicon-refresh glyphicon-remove-sign glyphicon-ok-sign glyphicon-cloud-upload bg-spin");
                $("#media_upload .bg-alert i").addClass(_icon);
                $("#media_upload .bg-alert span").html(_msg);
            }

            $(document).ready(function(){
                if (!WebUploader.Uploader.support()) {
                    alert("<?php echo $this->lang['mod']['label']['needH5']; ?>");
                }

                var obj_wu = new WebUploader.Uploader({
                    //附加表单数据
                    formData: {
                        <?php echo $this->common['tokenRow']['name_session']; ?>: "<?php echo $this->common['tokenRow']['token']; ?>",
                        act: "submit"
                    },
                    server: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=media", //文件接收服务端
                    pick: {
                        id: "#upload_select", //选择按钮
                        multiple: false
                    },
                    auto: true, //自动上传
                    fileVal: "media_files", //设置 file 域的 name
                    //允许的扩展名
                    accept: {
                        title: "file",
                        mimeTypes: "<?php echo implode(",", $this->tplData['mimeRows']); ?>"
                    },
                    fileSingleSizeLimit: <?php echo $this->tplData['uploadSize']; ?>, //单个尺寸限制
                    resize: false //不压缩 image
                });

                obj_wu.on("fileQueued", function(file){
                    $("#media_upload").html("<div class=\"alert alert-info alert-dismissible bg-alert\">" +
                        "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" +
                        "<h4>" + file.name + "</h4>" +
                        "<p class=\"bg-alert-text\">" +
                            "<i class=\"glyphicon glyphicon-refresh bg-spin\"></i>" +
                            " <span></span>" +
                        "</p>" +
                    "</div>");
                    "<div class=\"progress bg-progress\">" +
                        "<div class=\"progress-bar progress-bar-info progress-bar-striped active\" style=\"width: 10%\"></div>"+
                    "</div>" +
                    $("#media_upload .bg-progress").hide();
                });

                obj_wu.on('error', function(error, size, file){
                    switch(error) {
                        case "F_EXCEED_SIZE":
                            alert(file.name + " <?php echo $this->lang['rcode']['x070203']; ?> <?php echo BG_UPLOAD_SIZE; ?> <?php echo BG_UPLOAD_UNIT; ?>");
                        break;

                        case "Q_TYPE_DENIED":
                            alert(file.name + " <?php echo $this->lang['rcode']['x070202']; ?>");
                        break;
                    }
                });

                obj_wu.on("uploadProgress", function(file, percentage){
                    alert_process("alert-info", "glyphicon-refresh bg-spin", "<?php echo $this->lang['mod']['label']['uploading']; ?>");

                    $("#media_upload .bg-progress").show();
                    $("#media_upload .bg-progress .progress-bar").text(percentage * 100 + "%");
                    $("#media_upload .bg-progress .progress-bar").css("width", percentage * 100 + "%");
                });

                obj_wu.on("uploadSuccess", function(file, result){
                    var _str_msg;
                    if (result.rcode == "y070401") {
                        alert_process("alert-success", "glyphicon-ok-sign", "<?php echo $this->lang['mod']['label']['uploadSucc']; ?>");

                        <?php if (isset($cfg['js_select'])) { ?>
                            selectMedia(result.media_url, result.media_id);
                        <?php } ?>
                    } else {
                        if (typeof result.msg == "undefined") {
                            _str_msg = "<?php echo $this->lang['mod']['label']['returnErr']; ?>";
                        } else {
                            _str_msg = result.msg;
                        }
                        alert_process("alert-danger", "glyphicon-remove-sign", _str_msg);
                    }
                });

                obj_wu.on("uploadError", function(file, result){
                    alert_process("alert-danger", "glyphicon-remove-sign", "Error&nbsp;status:&nbsp;" + result);
                });

                obj_wu.on("uploadComplete", function(file){
                    $("#media_upload .bg-progress").slideUp("slow");

                    setTimeout(function(){
                        $("#media_upload .bg-alert").slideUp("slow");
                    }, 5000);
                });
            });
            </script>
