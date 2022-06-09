  <?php $cfg = array(
    'script_choose' => 'true',
  );

  $_lang_pageFirst    = $lang->get('First page', 'console.common');
  $_lang_pagePrevList = $lang->get('Previous ten pages', 'console.common');
  $_lang_pagePrev     = $lang->get('Previous page', 'console.common');
  $_lang_pageNext     = $lang->get('Next page', 'console.common');
  $_lang_pageNextList = $lang->get('Next ten pages', 'console.common');
  $_lang_pageLast     = $lang->get('End page', 'console.common'); ?>

  <div class="modal-header bg-light">
    <ul class="nav nav-tabs bg-modal-header-tabs">
      <li class="nav-item">
        <a href="#pane_choose" id="btn_choose" data-toggle="tab" class="nav-link py-1 active"><?php echo $lang->get('Choose'); ?></a>
      </li>
      <li class="nav-item">
        <a href="#pane_upload" id="btn_upload" data-toggle="tab" class="nav-link py-1"><?php echo $lang->get('Upload'); ?></a>
      </li>
    </ul>
    <button type="button" class="close pb-2" data-dismiss="modal">
      &times;
    </button>
  </div>

  <div class="modal-body">
    <div class="clearfix" id="attach_search">
      <div class="float-right">
        <div class="input-group input-group-sm mb-3">
          <input type="text" name="search_key" id="search_key" placeholder="<?php echo $lang->get('Keyword'); ?>" class="form-control">
          <span class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" id="search_btn">
              <span class="bg-icon"><?php include($tpl_icon . 'search' . BG_EXT_SVG); ?></span>
            </button>
            <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-toggle="collapse" data-target="#bg-search-more">
              <span class="sr-only">Dropdown</span>
            </button>
          </span>
        </div>
        <div class="collapse" id="bg-search-more">
          <div class="input-group input-group-sm mb-3">
            <select name="ext" id="search_ext" class="custom-select">
              <option value=""><?php echo $lang->get('All extensions'); ?></option>
              <?php foreach ($extRows as $key=>$value) { ?>
                <option value="<?php echo $value['attach_ext']; ?>"><?php echo $value['attach_ext']; ?></option>
              <?php } ?>
            </select>
            <select name="year" id="search_year" class="custom-select">
              <option value=""><?php echo $lang->get('All years'); ?></option>
              <?php foreach ($yearRows as $key=>$value) { ?>
                <option value="<?php echo $value['attach_year']; ?>"><?php echo $value['attach_year']; ?></option>
              <?php } ?>
            </select>
            <select name="month" id="search_month" class="custom-select">
              <option value=""><?php echo $lang->get('All months'); ?></option>
              <?php for ($iii = 1 ; $iii <= 12; ++$iii) {
                if ($iii < 10) {
                  $str_month = '0' . $iii;
                } else {
                  $str_month = $iii;
                } ?>
                <option value="<?php echo $str_month; ?>"><?php echo $str_month; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
    </div>

    <div class="tab-content">
      <div class="tab-pane active" id="pane_choose">
        <div id="attach_list" class="row"></div>
      </div>

      <div class="tab-pane" id="pane_upload">
        <?php include($tpl_ctrl . 'upload_form' . GK_EXT_TPL); ?>
      </div>
    </div>

    <div class="clearfix">
      <div id="attach_page" class="float-right"></div>
    </div>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal"><?php echo $lang->get('Close', 'console.common'); ?></button>
  </div>

  <?php include($tpl_ctrl . 'upload_script' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  function pageTpl(result, page, year, month, ext, key) {
    if (typeof page == 'undefined') {
      page = 1;
    }

    if (typeof year == 'undefined') {
      year = 0;
    }

    if (typeof month == 'undefined') {
      month = 0;
    }

    if (typeof ext == 'undefined') {
      ext = 0;
    }

    if (typeof key == 'undefined') {
      key = 0;
    }

    result.pageRow.page     = parseInt(result.pageRow.page);
    result.pageRow.begin    = parseInt(result.pageRow.begin);
    result.pageRow.end      = parseInt(result.pageRow.end);
    result.pageRow.total    = parseInt(result.pageRow.total);
    result.pageRow.p        = parseInt(result.pageRow.p);

    var _str_page = '<ul class="pagination pagination-sm mt-1 mb-2">';

      if (result.pageRow.page > 1) {
        _str_page += '<li class="page-item"><a href="javascript:void(0);" data-page="1" data-year="' + year + '" data-month="' + month + '" data-ext="' + ext + '" data-key="' + key + '" title="<?php echo $_lang_pageFirst; ?>" class="page-link"><?php echo $_lang_pageFirst; ?></a></li>';
      }

      if (result.pageRow.p * 10 > 0) {
        _str_page += '<li class="page-item d-none d-lg-block"><a href="javascript:void(0);" data-page="' + (result.pageRow.p * 10) + '" data-year="' + year + '" data-month="' + month + '" data-ext="' + ext + '" data-key="' + key + '" title="<?php echo $_lang_pagePrevList; ?>" class="page-link">...</a></li>';
      }

      _str_page += '<li class="page-item';
      if (result.pageRow.page <= 1) {
        _str_page += ' disabled';
      }
      _str_page += '">';
        if (result.pageRow.page <= 1) {
          _str_page += '<span title="<?php echo $_lang_pagePrev; ?>" class="page-link"><span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span></span>';
        } else {
          _str_page += '<a href="javascript:void(0);" data-page="' + (result.pageRow.page - 1) + '" data-year="' + year + '" data-month="' + month + '" data-ext="' + ext + '" data-key="' + key + '" title="<?php echo $_lang_pagePrev; ?>" class="page-link"><span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span></a>';
        }
      _str_page += '</li>';

      for (_iii = result.pageRow.begin; _iii <= result.pageRow.end; ++_iii) {
        _str_page += '<li class="page-item d-none d-lg-block';
          if (_iii == result.pageRow.page) {
            _str_page += ' active';
          }
        _str_page += '">';
        if (_iii == result.pageRow.page) {
          _str_page += '<span class="page-link">' + _iii + '</span>';
        } else {
          _str_page += '<a href="javascript:void(0);" data-page="' + _iii + '" data-year="' + year + '" data-month="' + month + '" data-ext="' + ext + '" data-key="' + key + '" title="' + _iii + '" class="page-link">' + _iii + '</a>';
        }
        _str_page += '</li>';
      }

      _str_page += '<li class="page-item';
      if (result.pageRow.page >= result.pageRow.total) {
        _str_page += ' disabled';
      }
      _str_page += '">';
        if (result.pageRow.page >= result.pageRow.total) {
          _str_page += '<span title="<?php echo $_lang_pageNext; ?>" class="page-link"><span class="bg-icon"><?php include($tpl_icon . 'chevron-right' . BG_EXT_SVG); ?></span></span>';
        } else {
          _str_page += '<a href="javascript:void(0);" data-page="' + (result.pageRow.page + 1) + '" data-year="' + year + '" data-month="' + month + '" data-ext="' + ext + '" data-key="' + key + '" title="<?php echo $_lang_pageNext; ?>" class="page-link"><span class="bg-icon"><?php include($tpl_icon . 'chevron-right' . BG_EXT_SVG); ?></span></a>';
        }
      _str_page += '</li>';

      if (_iii < result.pageRow.total) {
        _str_page += '<li class="page-item d-none d-lg-block"><a href="javascript:void(0);" data-page="' + _iii + '" data-year="' + year + '" data-month="' + month + '" data-ext="' + ext + '" data-key="' + key + '" title="<?php echo $_lang_pageNextList; ?>" class="page-link">...</a></li>';
      }

      if (result.pageRow.page < result.pageRow.total) {
        _str_page += '<li class="page-item"><a href="javascript:void(0);" data-page="' + result.pageRow.total + '" data-year="' + year + '" data-month="' + month + '" data-ext="' + ext + '" data-key="' + key + '" title="<?php echo $_lang_pageLast; ?>" class="page-link"><?php echo $_lang_pageLast; ?></a></li>';
      }
    _str_page += '</ul>';

    return _str_page;
  }

  function attachTpl(value) {
    var _str_appent = '<div class="col-4 col-lg-2 mb-3">' +
      '<div class="card h-100">' +
        '<div class="embed-responsive embed-responsive-4by3">' +
          '<img src="' + value.attach_url + '" alt="' + value.attach_name + '" class="card-img-top embed-responsive-item" alt="' + value.attach_name + '" title="' + value.attach_name + '">' +
        '</div>' +

        '<div class="card-body p-2">' +
          '<div class="text-truncate" title="' + value.attach_name + '"><small>' + value.attach_name + '</small></div>' +
        '</div>' +

        '<div>' +
          '<button type="button" class="btn btn-outline-success btn-block bg-btn-bottom attach_choose" data-src="' + value.attach_url + '" data-id="' + value.attach_id + '">'+
            '<?php echo $lang->get('Choose'); ?>' +
          '</button>' +
        '</div>' +
      '</div>' +
    '</div>';

    return _str_appent;
  }


  function reloadAttach(page, year, month, ext, key) {
    var _str_appent_page    = '';
    var _str_appent_attach  = '';
    var _url                = '<?php echo $hrefRow['lists']; ?>';

    if (typeof page == 'undefined' || page < 1) {
      page = 1;
    }

    if (typeof year == 'undefined' || year.length < 1) {
      year = 0;
    }

    if (typeof month == 'undefined' || month.length < 1) {
      month = 0;
    }

    if (typeof ext == 'undefined' || ext.length < 1) {
      ext = 0;
    }

    if (typeof key == 'undefined' || key.length < 1) {
      key = 0;
    }

    _url = _url.replace('{:page}', page);
    _url = _url.replace('{:year}', year);
    _url = _url.replace('{:month}', month);
    _url = _url.replace('{:ext}', ext);
    _url = _url.replace('{:key}', key);

    $.getJSON(_url, function(result){
      _str_appent_page = pageTpl(result, page, year, month, ext, key);

      $('#attach_page').html(_str_appent_page);

      $.each(result.attachRows, function(key, value){
        _str_appent_attach += attachTpl(value);
      });

      $('#attach_list').html(_str_appent_attach);
    });
  }

  function chooseAttach(src, id) {
    $('#advert_attach_id').val(id);
    $('#advert_attach_src').val(src);

    $('#advert_attach_img').html('<img src="' + src + '" class="img-fluid">');
  }

  $(document).ready(function(){
    reloadAttach(1);
    $('#btn_choose').click(function(){
      reloadAttach(1);
      $('#attach_search').show();
      $('#attach_page').show();
    });
    $('#btn_upload').click(function(){
      $('#attach_search').hide();
      $('#attach_page').hide();
    });
    $('#search_btn').click(function(){
      var _year   = $('#search_year').val();
      var _month  = $('#search_month').val();
      var _ext    = $('#search_ext').val();
      var _key    = $('#search_key').val();
      reloadAttach(1, _year, _month, _ext, _key);
    });
    $('#attach_page').on('click', '.page-link', function(){
      var _page       = $(this).data('page');
      var _year       = $(this).data('year');
      var _month      = $(this).data('month');
      var _ext        = $(this).data('ext');
      var _key        = $(this).data('key');
      reloadAttach(_page, _year, _month, _ext, _key);
    });
    $('#attach_list').on('click', '.attach_choose', function(){
      var _src    = $(this).data('src');
      var _id     = $(this).data('id');
      chooseAttach(_src, _id);
    });
  });
  </script>
