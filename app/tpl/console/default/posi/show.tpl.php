<?php $cfg = array(
    'title'             => $lang->get('Ad position', 'console.common') . ' &raquo; ' . $lang->get('Show'),
    'menu_active'       => 'posi',
    'sub_active'        => 'index',
    'prism'             => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>posi/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <div class="row">
        <div class="col-xl-9">
            <div class="card mb-3">
                <?php include($cfg['pathInclude'] . 'posi_menu' . GK_EXT_TPL); ?>
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
                        <label><?php echo $lang->get('Data URL'); ?></label>
                        <div class="form-text">
                            <?php echo $posiRow['posi_data_url']; ?>
                        </div>
                    </div>

                </div>
                <div class="card-footer text-right">
                    <a href="<?php echo $route_console; ?>posi/form/id/<?php echo $posiRow['posi_id']; ?>/">
                        <span class="fas fa-edit"></span>
                        <?php echo $lang->get('Edit'); ?>
                    </a>
                </div>
            </div>

            <div>&nbsp;</div>

            <h4><?php echo $lang->get('Ad code'); ?></h4>
            <div>
<pre class="border bg-white rounded"><code class="language-markup">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;<?php echo $lang->getCurrent(); ?>&quot;&gt;
    &lt;head&gt;
        &lt;title&gt;advert&lt;/title&gt;

        <?php foreach ($scriptConfig['require'] as $_key=>$_value) { ?>
&lt;!-- <?php echo $lang->get('Dependent'), ' - ', $_key; ?> begin --&gt;
        <?php switch ($_value['type']) {
            case 'js': ?>
&lt;script src=&quot;<?php echo $_value['url']; ?>&quot; type="text/javascript"&gt;&lt;/script&gt;
        <?php break;

            default: ?>
&lt;link href=&quot;<?php echo $_value['url']; ?>&quot; type=&quot;text/css&quot; rel=&quot;stylesheet&quot;&gt;
        <?php break;
        } ?>
&lt;!-- <?php echo $lang->get('Dependent'), ' - ', $_key; ?> end --&gt;

        <?php } ?>

        &lt;!-- <?php echo $lang->get('Ad CSS'); ?> begin --&gt;
        &lt;link href=&quot;<?php echo $scriptConfig['css_url']; ?>&quot; type=&quot;text/css&quot; rel=&quot;stylesheet&quot;&gt;
        &lt;!-- <?php echo $lang->get('Ad CSS'); ?> end --&gt;

        &lt;!-- <?php echo $lang->get('Ad script'); ?> begin --&gt;
        &lt;script src=&quot;<?php echo $scriptConfig['script_url']; ?>&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;
        &lt;!-- <?php echo $lang->get('Ad script'); ?> end --&gt;

    &lt;/head&gt;
    &lt;body&gt;

        &lt;!-- <?php echo $lang->get('Ad container'); ?> begin --&gt;
        &lt;div <?php echo $posiRow['posi_box_attr']; ?>&gt;&lt;/div&gt;
        &lt;!-- <?php echo $lang->get('Ad container'); ?> end --&gt;

        &lt;!-- <?php echo $lang->get('Initialization'); ?> begin --&gt;
        &lt;script type=&quot;text/javascript&quot;&gt;
        opts_ad_<?php echo $posiRow['posi_id']; ?> = <?php echo $optsJson; ?>;

        $(document).ready(function(){
            $('<?php echo $posiRow['posi_selector']; ?>').<?php echo $scriptConfig['func_init']; ?>(opts_ad_<?php echo $posiRow['posi_id']; ?>);
        });
        &lt;/script&gt;
        &lt;!-- <?php echo $lang->get('Initialization'); ?> end --&gt;

    &lt;/body&gt;
&lt;/html&gt;
</code></pre>
            </div>

            <small><?php echo $lang->get('This code is used to display ad, please use it according to the actual situation. It is recommended to place <mark>JavaScript</mark> and <mark>CSS</mark> between <code>&lt;head&gt;</code>, the <mark>Ad container</mark> where it needs to be displayed. Note: If the script is Depend on JS librarys such as jQuery, Bootstrap etc., you also need to import these librarys.'); ?></small>

        </div>

        <?php include($cfg['pathInclude'] . 'posi_side' . GK_EXT_TPL); ?>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);