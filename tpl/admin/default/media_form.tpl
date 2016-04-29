{*media_form.php 上传界面*}
{$cfg = [
    js_select => "true"
]}
<div class="modal-header">
    <div class="pull-left">
        <ul class="nav nav-pills nav_baigo">
            <li class="active">
                <a href="#pane_select" id="btn_select" data-toggle="tab">{$lang.href.select}</a>
            </li>
            <li>
                <a href="#pane_upload" id="btn_upload" data-toggle="tab">{$lang.href.upload}</a>
            </li>
        </ul>
    </div>
    <form name="media_search" id="media_search" class="form-inline pull-right">
        <input type="hidden" name="mod" value="media">
        <input type="hidden" name="act_get" value="list">
        <div class="form-group">
            <select name="year" id="search_year" class="form-control input-sm hidden-xs">
                <option value="">{$lang.option.allYear}</option>
                {foreach $tplData.yearRows as $key=>$value}
                    <option value="{$value.media_year}">{$value.media_year}</option>
                {/foreach}
            </select>
        </div>
        <div class="form-group">
            <select name="month" id="search_month" class="form-control input-sm hidden-xs">
                <option value="">{$lang.option.allMonth}</option>
                {for $_i = 1 to 12}
                    {if $_i < 10}
                        {$_str_month = "0{$_i}"}
                    {else}
                        {$_str_month = $_i}
                    {/if}
                    <option value="{$_str_month}">{$_str_month}</option>
                {/for}
            </select>
        </div>
        <div class="form-group">
            <select name="ext" id="search_ext" class="form-control input-sm hidden-xs">
                <option value="">{$lang.option.allExt}</option>
                {foreach $tplData.extRows as $key=>$value}
                    <option value="{$value.media_ext}">{$value.media_ext}</option>
                {/foreach}
            </select>
        </div>
        <div class="form-group">
            <div class="input-group input-group-sm">
                <input type="text" name="search_key" id="search_key" class="form-control" placeholder="{$lang.label.key}">
                <span class="input-group-btn">
                    <button class="btn btn-default btn-sm" type="button" id="search_btn">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </div>
    </form>
    <div class="clearfix"></div>
</div>

<div class="modal-body">

    <div class="tab-content">
        <div class="tab-pane active" id="pane_select">
            <div id="media_list" class="row"></div>
        </div>

        <div class="tab-pane" id="pane_upload">
            {include "{$smarty.const.BG_PATH_TPL}admin/default/include/upload.tpl" cfg=$cfg}
        </div>
    </div>

</div>

<div class="modal-footer">
    <div class="pull-left">
        <div id="media_page" class="page_baigo"></div>
    </div>
    <div class="pull-right">
        <div class="form-group">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{$lang.btn.close}</button>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<script type="text/javascript">
function get_page(result, _page, _year, _month, _ext, _key, func) {
    _str_appent_page = "<ul class=\"pagination pagination-sm\">";

        if (result.pageRow.page > 1) {
            _str_appent_page += "<li><a href=\"javascript:" + func + "(1,'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"{$lang.href.pageFirst}\">{$lang.href.pageFirst}</a></li>";
        }

        if (result.pageRow.p * 10 > 0) {
            _str_appent_page += "<li><a href=\"javascript:" + func + "(" + (result.pageRow.p * 10) + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"{$lang.href.pagePrevList}\">&laquo;</a></li>";
        }

        _str_appent_page += "<li";
        if (result.pageRow.page <= 1) {
            _str_appent_page += " class=\"disabled\"";
        }
        _str_appent_page += ">";
            if (result.pageRow.page <= 1) {
                _str_appent_page += "<span title=\"{$lang.href.pagePrev}\">&lsaquo;</span>";
            } else {
                _str_appent_page += "<a href=\"javascript:" + func + "(" + (result.pageRow.page - 1) + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"{$lang.href.pagePrev}\">&lsaquo;</a>";
            }
        _str_appent_page += "</li>";

        for (_iii = result.pageRow.begin; _iii <= result.pageRow.end; _iii++) {
            _str_appent_page += "<li";
                if (_iii == result.pageRow.page) {
                    _str_appent_page += " class=\"active\"";
                }
            _str_appent_page += ">";
            if (_iii == result.pageRow.page) {
                _str_appent_page += "<span>" + _iii + "</span>";
            } else {
                _str_appent_page += "<a href=\"javascript:" + func + "(" + _iii + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"" + _iii + "\">" + _iii + "</a>";
            }
            _str_appent_page += "</li>";
        }

        _str_appent_page += "<li";
        if (result.pageRow.page >= result.pageRow.total) {
            _str_appent_page += " class=\"disabled\"";
        }
        _str_appent_page += ">";
            if (result.pageRow.page >= result.pageRow.total) {
                _str_appent_page += "<span title=\"{$lang.href.pageNext}\">&rsaquo;</span>";
            } else {
                _str_appent_page += "<a href=\"javascript:" + func + "(" + (result.pageRow.page + 1) + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"{$lang.href.pageNext}\">&rsaquo;</a>";
            }
        _str_appent_page += "</li>";

        if (_iii < result.pageRow.total) {
            _str_appent_page += "<li><a href=\"javascript:" + func + "(" + _iii + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"{$lang.href.pageNextList}\">&raquo;</a></li>";
        }

        if (result.pageRow.page < result.pageRow.total) {
            _str_appent_page += "<li><a href=\"javascript:" + func + "(" + result.pageRow.total + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"{$lang.href.pageLast}\">{$lang.href.pageLast}</a></li>";
        }
    _str_appent_page += "</ul>";

    return _str_appent_page;
}


function get_list(_value) {
    _str_appent_media = "<div class=\"col-xs-6 col-md-3\">" +
        "<div class=\"thumbnail\">";
            _str_appent_media += "<a href=\"" + _value.media_url + "\" target=\"_blank\">" +
                "<div class=\"center-block thumb_baigo\">" +
                    "<img src=\"" + _value.media_url + "\" alt=\"" + _value.media_name + "\" class=\"img-responsive\" alt=\"" + _value.media_name + "\" title=\"" + _value.media_name + "\">" +
                "</div>" +
            "</a>" +

            "<div class=\"caption\">" +
                "<p class=\"media_overflow\" title=\"" + _value.media_name + "\">" + _value.media_name + "</p>" +
                "<a class=\"btn btn-success btn-block btn-sm\" href=\"javascript:selectMedia('" + _value.media_url + "'," + _value.media_id + ");\">"+
                    "{$lang.href.select}" +
                "</a>" +
            "</div>" +
        "</div>" +
    "</div>";

    return _str_appent_media;
}


function reload_media(_page, _year, _month, _ext, _key) {
    $("#media_list").empty();
    $("#media_page").empty();

    $.getJSON("{$smarty.const.BG_URL_ADMIN}ajax.php?mod=media&act_get=list&page=" + _page + "&year=" + _year + "&month=" + _month + "&ext=" + _ext + "&key=" + _key, function(result){
        //alert(result.pageRow.page);
        _str_appent_page = get_page(result, _page, _year, _month, _ext, _key, "reload_media");

        $("#media_page").append(_str_appent_page);

        $.each(result.mediaRows, function(_key, _value){
            //alert(_value.media_name);
            _str_appent_media = get_list(_value);

            $("#media_list").append(_str_appent_media);
        });
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