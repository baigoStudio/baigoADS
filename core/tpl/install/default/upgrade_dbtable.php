<?php $cfg = array(
    'title'         => $this->lang['mod']['page']['upgrade'] . ' &raquo; ' . $this->lang['mod']['page']['dbtable'],
    'sub_title'     => $this->lang['mod']['page']['dbtable'],
    'pathInclude'   => BG_PATH_TPLSYS . 'install' . DS . 'default' . DS . 'include' . DS,
    'mod_help'      => 'upgrade'
); ?>
<?php include($cfg['pathInclude'] . 'upgrade_head.php'); ?>

    <?php include($cfg['pathInclude'] . "dbtable.php"); ?>

    <div class="bg-submit-box"></div>

    <div class="form-group clearfix">
        <div class="pull-left">
            <div class="btn-group">
                <a href="<?php echo BG_URL_INSTALL; ?>index.php?mod=upgrade&act=dbconfig" class="btn btn-default"><?php echo $this->lang['mod']['btn']['prev']; ?></a>
                <?php include($cfg['pathInclude'] . 'upgrade_drop.php'); ?>
                <a href="<?php echo BG_URL_INSTALL; ?>index.php?mod=upgrade&act=base" class="btn btn-default"><?php echo $this->lang['mod']['btn']['skip']; ?></a>
            </div>
        </div>

        <div class="pull-right">
            <a class="btn btn-primary" href="<?php echo BG_URL_INSTALL; ?>index.php?mod=upgrade&act=base"><?php echo $this->lang['mod']['btn']['next']; ?></a>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'install_foot.php'); ?>
<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>