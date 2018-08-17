    <?php $cfg = array(
        'pathInclude'   => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
        "js_insert"     => 'true',
    ); ?>
    <div class="modal-header">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a href="#pane_insert" id="btn_insert" data-toggle="tab" class="nav-link py-1 active"><?php echo $this->lang['mod']['href']['select']; ?></a>
            </li>
            <li class="nav-item">
                <a href="#pane_upload" id="btn_upload" data-toggle="tab" class="nav-link py-1"><?php echo $this->lang['mod']['href']['upload']; ?></a>
            </li>
        </ul>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <form name="attach_search" id="attach_search" class="mb-3">
            <div class="input-group input-group-sm">
                <select name="ext" id="search_ext" class="custom-select custom-select-sm">
                    <option value=""><?php echo $this->lang['mod']['option']['allExt']; ?></option>
                    <?php foreach ($this->tplData['extRows'] as $key=>$value) { ?>
                        <option value="<?php echo $value['attach_ext']; ?>"><?php echo $value['attach_ext']; ?></option>
                    <?php } ?>
                </select>
                <select name="year" id="search_year" class="custom-select custom-select-sm d-none d-sm-block">
                    <option value=""><?php echo $this->lang['mod']['option']['allYear']; ?></option>
                    <?php foreach ($this->tplData['yearRows'] as $key=>$value) { ?>
                        <option value="<?php echo $value['attach_year']; ?>"><?php echo $value['attach_year']; ?></option>
                    <?php } ?>
                </select>
                <select name="month" id="search_month" class="custom-select custom-select-sm d-none d-sm-block">
                    <option value=""><?php echo $this->lang['mod']['option']['allMonth']; ?></option>
                    <?php for ($iii = 1 ; $iii <= 12; $iii++) {
                        if ($iii < 10) {
                            $str_month = "0" . $iii;
                        } else {
                            $str_month = $iii;
                        } ?>
                        <option value="<?php echo $str_month; ?>"><?php echo $str_month; ?></option>
                    <?php } ?>
                </select>
                <input type="text" name="search_key" id="search_key" class="form-control" placeholder="<?php echo $this->lang['mod']['label']['key']; ?>">
                <span class="input-group-append">
                    <button class="btn btn-secondary" type="button" id="search_btn">
                        <span class="oi oi-magnifying-glass"></span>
                    </button>
                </span>
            </div>
        </form>

        <div class="tab-content">
            <div class="tab-pane active" id="pane_insert">
                <div id="attach_list" class="row"></div>
            </div>

            <div class="tab-pane" id="pane_upload">
                <?php include($cfg['pathInclude'] . 'upload.php'); ?>
            </div>
        </div>

        <div class="clearfix mt-3">
            <div id="attach_page" class="float-right"></div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><?php echo $this->lang['common']['btn']['close']; ?></button>
    </div>

    <script type="text/javascript">
    function get_page(result, _page, _year, _month, _ext, _key, func) {
        var _str_page = "<ul class=\"pagination pagination-sm\">";

            if (result.pageRow.page > 1) {
                _str_page += "<li class=\"page-item\"><a href=\"javascript:" + func + "(1,'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"<?php echo $this->lang['common']['href']['pageFirst']; ?>\" class=\"page-link\"><?php echo $this->lang['common']['href']['pageFirst']; ?></a></li>";
            }

            if (result.pageRow.p * 10 > 0) {
                _str_page += "<li class=\"page-item\"><a href=\"javascript:" + func + "(" + (result.pageRow.p * 10) + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"<?php echo $this->lang['common']['href']['pagePrevList']; ?>\" class=\"page-link\">...</a></li>";
            }

            _str_page += "<li class=\"page-item";
            if (result.pageRow.page <= 1) {
                _str_page += " disabled";
            }
            _str_page += "\">";
                if (result.pageRow.page <= 1) {
                    _str_page += "<span title=\"<?php echo $this->lang['common']['href']['pagePrev']; ?>\" class=\"page-link\"><span class=\"oi oi-chevron-left\"></span></span>";
                } else {
                    _str_page += "<a href=\"javascript:" + func + "(" + (result.pageRow.page - 1) + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"<?php echo $this->lang['common']['href']['pagePrev']; ?>\" class=\"page-link\"><span class=\"oi oi-chevron-left\"></span></a>";
                }
            _str_page += "</li>";

            for (_iii = result.pageRow.begin; _iii <= result.pageRow.end; _iii++) {
                _str_page += "<li class=\"page-item";
                    if (_iii == result.pageRow.page) {
                        _str_page += " active";
                    }
                _str_page += "\">";
                if (_iii == result.pageRow.page) {
                    _str_page += "<span class=\"page-link\">" + _iii + "</span>";
                } else {
                    _str_page += "<a href=\"javascript:" + func + "(" + _iii + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"" + _iii + "\" class=\"page-link\">" + _iii + "</a>";
                }
                _str_page += "</li>";
            }

            _str_page += "<li class=\"page-item";
            if (result.pageRow.page >= result.pageRow.total) {
                _str_page += " disabled";
            }
            _str_page += "\">";
                if (result.pageRow.page >= result.pageRow.total) {
                    _str_page += "<span title=\"<?php echo $this->lang['common']['href']['pageNext']; ?>\" class=\"page-link\"><span class=\"oi oi-chevron-right\"></span></span>";
                } else {
                    _str_page += "<a href=\"javascript:" + func + "(" + (result.pageRow.page + 1) + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"<?php echo $this->lang['common']['href']['pageNext']; ?>\" class=\"page-link\"><span class=\"oi oi-chevron-right\"></span></a>";
                }
            _str_page += "</li>";

            if (_iii < result.pageRow.total) {
                _str_page += "<li class=\"page-item\"><a href=\"javascript:" + func + "(" + _iii + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"<?php echo $this->lang['common']['href']['pageNextList']; ?>\" class=\"page-link\">...</a></li>";
            }

            if (result.pageRow.page < result.pageRow.total) {
                _str_page += "<li class=\"page-item\"><a href=\"javascript:" + func + "(" + result.pageRow.total + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"<?php echo $this->lang['common']['href']['pageLast']; ?>\" class=\"page-link\"><?php echo $this->lang['common']['href']['pageLast']; ?></a></li>";
            }
        _str_page += "</ul>";

        return _str_page;
    }

    function get_list(_value) {
        var _str_appent = "<div class=\"col-6 col-md-3\">" +
            "<div class=\"card mb-3\">";
                _str_appent += "<a href=\"" + _value.attach_url + "\" target=\"_blank\">" +
                    "<div class=\"embed-responsive embed-responsive-4by3\">" +
                        "<img src=\"" + _value.attach_url + "\" alt=\"" + _value.attach_name + "\" class=\"card-img-top embed-responsive-item\" alt=\"" + _value.attach_name + "\" title=\"" + _value.attach_name + "\">" +
                    "</div>" +
                "</a>" +

                "<div class=\"card-body\">" +
                    "<div class=\"text-truncate mb-3\" title=\"" + _value.attach_name + "\">" + _value.attach_name + "</div>" +

                    "<a href=\"javascript:insertAttach('" + _value.attach_url + "','" + _value.attach_id + "');\" class=\"btn btn-success\">"+
                        "<?php echo $this->lang['mod']['href']['select']; ?>" +
                    "</a>" +
                "</div>" +
            "</div>" +
        "</div>";

        return _str_appent;
    }


    function reload_attach(_page, _year, _month, _ext, _key) {
        var _str_appent_page    = "";
        var _str_appent_attach  = "";

        $.getJSON("<?php echo BG_URL_CONSOLE; ?>index.php?m=attach&c=request&a=list&page=" + _page + "&year=" + _year + "&month=" + _month + "&ext=" + _ext + "&key=" + _key, function(result){
            _str_appent_page = get_page(result, _page, _year, _month, _ext, _key, "reload_attach");

            $("#attach_page").html(_str_appent_page);

            $.each(result.attachRows, function(_key, _value){
                _str_appent_attach += get_list(_value);
            });

            $("#attach_list").html(_str_appent_attach);
        });
    }

    function insertAttach(src, id) {
        $("#advert_attach_id").val(id);
        $("#advert_attach").attr("src", src);
    }

    $(document).ready(function(){
        reload_attach(1, "", "", "", "");
        $("#btn_insert").click(function(){
            reload_attach(1, "", "", "", "");
            $("#attach_search").show();
            $("#attach_page").show();
        });
        $("#btn_upload").click(function(){
            $("#attach_search").hide();
            $("#attach_page").hide();
        });
        $("#search_btn").click(function(){
            var _year   = $("#search_year").val();
            var _month  = $("#search_month").val();
            var _ext    = $("#search_ext").val();
            var _key    = $("#search_key").val();
            reload_attach(1, _year, _month, _ext, _key);
        });
    });
    </script>