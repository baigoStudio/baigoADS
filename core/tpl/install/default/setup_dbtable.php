<?php $cfg = array(
    'title'         => $this->lang['mod']['page']['setup'] . ' &raquo; ' . $this->lang['mod']['page']['dbtable'],
    'sub_title'     => $this->lang['mod']['page']['dbtable'],
    'pathInclude'   => BG_PATH_TPLSYS . 'install' . DS . 'default' . DS . 'include' . DS,
    'mod_help'      => "install"
);

include($cfg['pathInclude'] . 'setup_head.php'); ?>

    <?php include($cfg['pathInclude'] . "dbtable.php"); ?>

    <div class="form-group clearfix">
        <div class="pull-left">
            <div class="btn-group">
                <a href="<?php echo BG_URL_INSTALL; ?>index.php?mod=setup&act=dbconfig" class="btn btn-default"><?php echo $this->lang['mod']['btn']['prev']; ?></a>
                <?php include($cfg['pathInclude'] . 'setup_drop.php'); ?>
                <a href="<?php echo BG_URL_INSTALL; ?>index.php?mod=setup&act=base" class="btn btn-default"><?php echo $this->lang['mod']['btn']['skip']; ?></a>
            </div>
        </div>

        <div class="pull-right">
            <a class="btn btn-primary" href="<?php echo BG_URL_INSTALL; ?>index.php?mod=setup&act=base"><?php echo $this->lang['mod']['btn']['next']; ?></a>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'install_foot.php'); ?>
<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>