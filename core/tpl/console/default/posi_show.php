<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['posi']['main']['title'] . ' &raquo; ' . $this->lang['mod']['page']['show'],
    'menu_active'    => 'posi',
    "prism"          => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'sub_active'     => 'list'
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=posi&a=list" class="nav-link">
                <span class="oi oi-chevron-left"></span>
                <?php echo $this->lang['common']['href']['back']; ?>
            </a>
        </li>
    </ul>

    <div class="row">
        <div class="col-md-9">
            <div class="card mb-3 mb-lg-0">
                <div class="card-body">
                    <?php if ($this->tplData['posiRow']['posi_type'] == 'attach') {
                        foreach ($this->tplData['advertRows'] as $key=>$value) { ?>
                            <div class="form-group">
                                <a href="<?php echo $value['advert_url']; ?>" target="_blank">
                                    <?php if (isset($value['attachRow']['attach_url'])) { ?>
                                        <img src="<?php echo $value['attachRow']['attach_url']; ?>" width="100%">
                                    <?php } else {
                                        echo $this->lang['mod']['label']['unknown'];
                                    } ?>
                                </a>
                            </div>
                        <?php }
                    } else {
                        foreach ($this->tplData['advertRows'] as $key=>$value) { ?>
                            <div class="form-group">
                                <a href="<?php echo $value['advert_url']; ?>" target="_blank"><?php echo $value['advert_content']; ?></a>
                            </div>
                        <?php }
                    } ?>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['dataUrl']; ?></label>
                        <div class="form-text">
                            <?php echo BG_SITE_URL . BG_URL_ADVERT; ?>index.php?m=advert&amp;c=request&amp;a=list&amp;posi_id=<?php echo $this->tplData['posiRow']['posi_id']; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=posi&a=form&posi_id=<?php echo $this->tplData['posiRow']['posi_id']; ?>">
                            <span class="oi oi-pencil"></span>
                            <?php echo $this->lang['mod']['href']['edit']; ?>
                        </a>
                    </div>
                </div>
            </div>

            <div>&nbsp;</div>

            <h4><?php echo $this->lang['mod']['label']['posiCode']; ?></h4>
            <p>
<pre class="border rounded"><code class="language-markup">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;<?php echo substr($this->config['lang'], 0, 2); ?>&quot;&gt;
    &lt;head&gt;
        &lt;title&gt;advert&lt;/title&gt;

        &lt;!-- <?php echo $this->lang['mod']['label']['jQuery']; ?> begin --&gt;
        &lt;script src=&quot;<?php echo BG_SITE_URL . BG_URL_STATIC; ?>lib/jquery.min.js&quot; type="text/javascript"&gt;&lt;/script&gt;
        &lt;!-- <?php echo $this->lang['mod']['label']['jQuery']; ?> end --&gt;

        &lt;!-- <?php echo $this->lang['mod']['label']['posiCodeNote1']; ?> begin --&gt;
        &lt;link href=&quot;<?php echo BG_SITE_URL . BG_URL_ADVERT . $this->tplData['posiRow']['posi_script']; ?>/style.css&quot; type=&quot;text/css&quot; rel=&quot;stylesheet&quot;&gt;
        &lt;!-- <?php echo $this->lang['mod']['label']['posiCodeNote1']; ?> end --&gt;

    &lt;/head&gt;
    &lt;body&gt;

        &lt;!-- <?php echo $this->lang['mod']['label']['posiCodeNote2']; ?> begin --&gt;
        &lt;div id=&quot;<?php echo str_replace("#", "", $this->tplData['posiRow']['posi_selector']); ?>_<?php echo $this->tplData['posiRow']['posi_id']; ?>&quot;&gt;&lt;/div&gt;
        &lt;!-- <?php echo $this->lang['mod']['label']['posiCodeNote2']; ?> end --&gt;

        &lt;!-- <?php echo $this->lang['mod']['label']['posiCodeNote3']; ?> begin --&gt;
        &lt;script type=&quot;text/javascript&quot;&gt;
        _opts_ad_<?php echo $this->tplData['posiRow']['posi_id']; ?> = {
            <?php if (!fn_isEmpty($this->tplData['posiRow']['posi_opts'])) {
                foreach ($this->tplData['posiRow']['posi_opts'] as $key=>$value) {
                    echo $value['field']; ?>: &quot;<?php echo $value['value']; ?>&quot;, //<?php echo $value['label'] . PHP_EOL;
                }
            } ?>
            data_url: &quot;<?php echo BG_SITE_URL . BG_URL_ADVERT; ?>index.php?m=advert&amp;c=request&amp;a=list&amp;posi_id=<?php echo $this->tplData['posiRow']['posi_id']; ?>&quot
        };

        $(document).ready(function(){
            $(&quot;<?php echo $this->tplData['posiRow']['posi_selector']; ?>_<?php echo $this->tplData['posiRow']['posi_id']; ?>&quot;).<?php echo $this->tplData['posiRow']['posi_plugin']; ?>(_opts_ad_<?php echo $this->tplData['posiRow']['posi_id']; ?>);
        });
        &lt;/script&gt;
        &lt;!-- <?php echo $this->lang['mod']['label']['posiCodeNote3']; ?> end --&gt;

        &lt;!-- <?php echo $this->lang['mod']['label']['posiCodeNote4']; ?> begin --&gt;
        &lt;script src=&quot;<?php echo BG_SITE_URL . BG_URL_ADVERT . $this->tplData['posiRow']['posi_script']; ?>/script.js&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;
        &lt;!-- <?php echo $this->lang['mod']['label']['posiCodeNote4']; ?> end --&gt;

    &lt;/body&gt;
&lt;/html&gt;
</code></pre>
            </p>

            <div><?php echo $this->lang['mod']['text']['posiCodeNote']; ?></div>
        </div>

        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                    <div class="form-text"><?php echo $this->tplData['posiRow']['posi_id']; ?></div>
                </div>

                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['posiName']; ?></label>
                    <div class="form-text"><?php echo $this->tplData['posiRow']['posi_name']; ?></div>
                </div>

                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['posiCount']; ?></label>
                    <div class="form-text"><?php echo $this->tplData['posiRow']['posi_count']; ?></div>
                </div>

                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['contentType']; ?></label>
                    <div class="form-text"><?php echo $this->lang['mod']['type'][$this->tplData['posiRow']['posi_type']]; ?></div>
                </div>

                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['note']; ?></label>
                    <div class="form-text"><?php echo $this->tplData['posiRow']['posi_note']; ?></div>
                </div>

                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['status']; ?></label>
                    <div class="form-text">
                        <?php posi_status_process($this->tplData['posiRow']['posi_status'], $this->lang['mod']['status']); ?>
                    </div>
                </div>

                <div class="form-group">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=posi&a=form&posi_id=<?php echo $this->tplData['posiRow']['posi_id']; ?>">
                        <span class="oi oi-pencil"></span>
                        <?php echo $this->lang['mod']['href']['edit']; ?>
                    </a>
                </div>
            </div>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php');
include($cfg['pathInclude'] . 'html_foot.php');
