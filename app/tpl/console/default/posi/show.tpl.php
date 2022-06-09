<?php $cfg = array(
  'title'             => $lang->get('Ad position', 'console.common') . ' &raquo; ' . $lang->get('Show'),
  'menu_active'       => 'posi',
  'sub_active'        => 'index',
  'prism'             => 'true',
  'baigoSubmit'       => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <nav class="nav mb-3">
    <a href="<?php echo $hrefRow['index']; ?>" class="nav-link">
      <span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('Back'); ?>
    </a>
  </nav>

  <form name="posi_form" id="posi_form" action="<?php echo $hrefRow['duplicate']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
    <input type="hidden" name="posi_id" id="posi_id" value="<?php echo $posiRow['posi_id']; ?>">

    <div class="row">
      <div class="col-xl-9">
        <div class="card mb-3">
          <?php include($tpl_ctrl . 'menu' . GK_EXT_TPL); ?>
          <div class="card-body">
            <?php foreach ($advertRows as $key=>$value) { ?>
              <div class="form-group">
                <a href="<?php echo $value['advert_url']; ?>" target="_blank">
                  <img src="<?php echo $value['attachRow']['attach_url']; ?>" class="img-fluid">
                </a>
              </div>

              <div class="form-group">
                <a href="<?php echo $value['advert_url']; ?>" target="_blank"><?php echo $value['advert_content']; ?></a>
              </div>
            <?php } ?>

            <div class="form-group">
              <label class="text-muted font-weight-light"><?php echo $lang->get('Data URL'); ?></label>
              <div class="form-text font-weight-bolder">
                <?php echo $posiRow['posi_data_url']; ?>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="d-flex justify-content-between">
              <button type="submit" class="btn btn-primary">
                <?php echo $lang->get('Duplicate'); ?>
              </button>

              <a href="<?php echo $hrefRow['edit'], $posiRow['posi_id']; ?>">
                <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
                <?php echo $lang->get('Edit'); ?>
              </a>
            </div>
          </div>
        </div>

        <div>&nbsp;</div>

        <h4><?php echo $lang->get('Ad code'); ?></h4>
        <div>
          <pre class="border bg-white rounded"><code class="language-markup"><?php echo $adCode; ?></code></pre>
        </div>

        <small><?php echo $lang->get('This code is used to display Ad, please use it according to the actual situation. It is recommended to place <mark>JavaScript</mark> and <mark>CSS</mark> between <code>&lt;head&gt;</code>, the <mark>Ad container</mark> where it needs to be displayed. Note: If the script is Depend on JS librarys such as jQuery, Bootstrap etc., you also need to import these librarys.'); ?></small>
      </div>

      <?php include($tpl_ctrl . 'side' . GK_EXT_TPL); ?>
    </div>
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);  ?>

  <script type="text/javascript">
  $(document).ready(function(){
    var obj_submit_form   = $('#posi_form').baigoSubmit(opts_submit);
    $('#posi_form').submit(function(){
      obj_submit_form.formSubmit();
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
