<?php $cfg = array(
    'pathInclude'   => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'js_select'     => 'true'
); ?>
<div class="modal-header clearfix">
    <div class="pull-left">
        <ul class="nav nav-pills bg-nav-pills">
            <li class="active">
                <a href="#pane_select" id="btn_select" data-toggle="tab"><?php echo $this->lang['mod']['href']['select']; ?></a>
            </li>
            <li>
                <a href="#pane_upload" id="btn_upload" data-toggle="tab"><?php echo $this->lang['mod']['href']['upload']; ?></a>
            </li>
        </ul>
    </div>
    <form name="media_search" id="media_search" class="form-inline pull-right">
        <input type="hidden" name="mod" value="media">
        <input type="hidden" name="act" value="list">
        <div class="form-group hidden-xs">
            <select name="year" id="search_year" class="form-control input-sm">
                <option value=""><?php echo $this->lang['mod']['option']['allYear']; ?></option>
                <?php foreach ($this->tplData['yearRows'] as $key=>$value) { ?>
                    <option value="<?php echo $value['media_year']; ?>"><?php echo $value['media_year']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group hidden-xs">
            <select name="month" id="search_month" class="form-control input-sm">
                <option value=""><?php echo $this->lang['mod']['option']['allMonth']; ?></option>
                <?php for ($_iii = 1; $_iii <=12; $_iii++) {
                    if ($_iii < 10) {
                        $_str_month = '0' . $_iii;
                    } else {
                        $_str_month = $_iii;
                    } ?>
                    <option value="<?php echo $_str_month; ?>"><?php echo $_str_month; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group hidden-xs">
            <select name="ext" id="search_ext" class="form-control input-sm">
                <option value=""><?php echo $this->lang['mod']['option']['allExt']; ?></option>
                <?php foreach ($this->tplData['extRows'] as $key=>$value) { ?>
                    <option value="<?php echo $value['media_ext']; ?>"><?php echo $value['media_ext']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <div class="input-group input-group-sm">
                <input type="text" name="search_key" id="search_key" class="form-control input-sm" placeholder="<?php echo $this->lang['mod']['label']['key']; ?>">
                <span class="input-group-btn">
                    <button class="btn btn-default btn-sm" type="button" id="search_btn">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>

<div class="modal-body">

    <div class="tab-content">
        <div class="tab-pane active" id="pane_select">
            <div id="media_list" class="row"></div>
        </div>

        <div class="tab-pane" id="pane_upload">
            <?php include($cfg['pathInclude'] . 'upload.php'); ?>
        </div>
    </div>

</div>

<div class="modal-footer clearfix">
    <div class="pull-left">
        <div id="media_page" class="bg-page"></div>
    </div>
    <div class="pull-right">
        <div class="form-group">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><?php echo $this->lang['common']['btn']['close']; ?></button>
        </div>
    </div>
</div>

<script type="text/javascript">
function get_page(result, _page, _year, _month, _ext, _key, func) {
    var _str_page = "";

    _str_page = "<ul class=\"pagination pagination-sm bg-pagination\">";

        if (result.pageRow.page > 1) {
            _str_page += "<li><a href=\"javascript:" + func + "(1,'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"<?php echo $this->lang['common']['href']['pageFirst']; ?>\"><?php echo $this->lang['common']['href']['pageFirst']; ?></a></li>";
        }

        if (result.pageRow.p * 10 > 0) {
            _str_page += "<li><a href=\"javascript:" + func + "(" + (result.pageRow.p * 10) + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"<?php echo $this->lang['common']['href']['pagePrevList']; ?>\">...</a></li>";
        }

        _str_page += "<li";
        if (result.pageRow.page <= 1) {
            _str_page += " class=\"disabled\"";
        }
        _str_page += ">";
            if (result.pageRow.page <= 1) {
                _str_page += "<span title=\"<?php echo $this->lang['common']['href']['pagePrev']; ?>\"><span class=\"glyphicon glyphicon-menu-left\"></span></span>";
            } else {
                _str_page += "<a href=\"javascript:" + func + "(" + (result.pageRow.page - 1) + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"<?php echo $this->lang['common']['href']['pagePrev']; ?>\"><span class=\"glyphicon glyphicon-menu-left\"></span></a>";
            }
        _str_page += "</li>";

        for (_iii = result.pageRow.begin; _iii <= result.pageRow.end; _iii++) {
            _str_page += "<li";
                if (_iii == result.pageRow.page) {
                    _str_page += " class=\"active\"";
                }
            _str_page += ">";
            if (_iii == result.pageRow.page) {
                _str_page += "<span>" + _iii + "</span>";
            } else {
                _str_page += "<a href=\"javascript:" + func + "(" + _iii + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"" + _iii + "\">" + _iii + "</a>";
            }
            _str_page += "</li>";
        }

        _str_page += "<li";
        if (result.pageRow.page >= result.pageRow.total) {
            _str_page += " class=\"disabled\"";
        }
        _str_page += ">";
            if (result.pageRow.page >= result.pageRow.total) {
                _str_page += "<span title=\"<?php echo $this->lang['common']['href']['pageNext']; ?>\"><span class=\"glyphicon glyphicon-menu-right\"></span></span>";
            } else {
                _str_page += "<a href=\"javascript:" + func + "(" + (result.pageRow.page + 1) + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"<?php echo $this->lang['common']['href']['pageNext']; ?>\"><span class=\"glyphicon glyphicon-menu-right\"></span></a>";
            }
        _str_page += "</li>";

        if (_iii < result.pageRow.total) {
            _str_page += "<li><a href=\"javascript:" + func + "(" + _iii + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"<?php echo $this->lang['common']['href']['pageNextList']; ?>\">...</a></li>";
        }

        if (result.pageRow.page < result.pageRow.total) {
            _str_page += "<li><a href=\"javascript:" + func + "(" + result.pageRow.total + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"<?php echo $this->lang['common']['href']['pageLast']; ?>\"><?php echo $this->lang['common']['href']['pageLast']; ?></a></li>";
        }
    _str_page += "</ul>";

    return _str_page;
}


function get_list(_value) {
    var _str_media = "<div class=\"col-xs-6 col-md-3\">" +
        "<div class=\"thumbnail\">";
            _str_media += "<a href=\"" + _value.media_url + "\" target=\"_blank\">" +
                "<div class=\"center-block thumb_baigo\">" +
                    "<img src=\"" + _value.media_url + "\" alt=\"" + _value.media_name + "\" class=\"img-responsive\" alt=\"" + _value.media_name + "\" title=\"" + _value.media_name + "\">" +
                "</div>" +
            "</a>" +

            "<div class=\"caption\">" +
                "<p class=\"bg-overflow\" title=\"" + _value.media_name + "\">" + _value.media_name + "</p>" +
                "<a class=\"btn btn-success btn-block btn-sm\" href=\"javascript:selectMedia('" + _value.media_url + "'," + _value.media_id + ");\">"+
                    "<?php echo $this->lang['mod']['href']['select']; ?>" +
                "</a>" +
            "</div>" +
        "</div>" +
    "</div>";

    return _str_media;
}


function reload_media(_page, _year, _month, _ext, _key) {
    var _str_appent_page    = "";
    var _str_appent_media   = "";

    $.getJSON("<?php echo BG_URL_CONSOLE; ?>request.php?mod=media&act=list&page=" + _page + "&year=" + _year + "&month=" + _month + "&ext=" + _ext + "&key=" + _key, function(result){
        //alert(result.pageRow.page);
        _str_appent_page = get_page(result, _page, _year, _month, _ext, _key, "reload_media");

        $("#media_page").html(_str_appent_page);

        $.each(result.mediaRows, function(_key, _value){
            //alert(_value.media_name);
            _str_appent_media += get_list(_value);
        });

        $("#media_list").html(_str_appent_media);
    });
}

function selectMedia(src, id) {
    $("#advert_media_id").val(id);
    $("#advert_media").attr("src", src);
}

$(document).ready(function(){
    reload_media(1, "", "", "", "");
    $("#btn_select").click(function(){
        reload_media(1, "", "", "", "");
        $("#media_search").show();
        $("#media_page").show();
    });
    $("#btn_upload").click(function(){
        $("#media_search").hide();
        $("#media_page").hide();
    });
    $("#search_btn").click(function(){
        var _year   = $("#search_year").val();
        var _month  = $("#search_month").val();
        var _ext    = $("#search_ext").val();
        var _key    = $("#search_key").val();
        reload_media(1, _year, _month, _ext, _key);
    });
});
</script>