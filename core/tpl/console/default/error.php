<?php $cfg = array(
    "title"         => $this->lang['common']['page']['rcode'],
    'pathInclude'   => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
);

$_str_status = substr($this->tplData['rcode'], 0, 1);

if ($GLOBALS['view'] == 'iframe') { ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <?php echo $this->lang['common']['page']['rcode']; ?>
    </div>

    <div class="modal-body">
<?php } else {
    include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group">
        <a href="javascript:history.go(-1);">
            <span class="oi oi-chevron-left"></span>
            <?php echo $this->lang['common']['href']['back']; ?>
        </a>
    </div>
<?php } ?>

        <div class="alert alert-<?php if ($_str_status == "y") { ?>success<?php } else { ?>danger<?php } ?>">
            <h3>
                <span class="oi oi-<?php if ($_str_status == "y") { ?>circle-check<?php } else { ?>circle-x<?php } ?>"></span>
                <?php if (isset($this->tplData['rcode']) && !fn_isEmpty($this->tplData['rcode']) && isset($this->lang['rcode'][$this->tplData['rcode']])) {
                    echo $this->lang['rcode'][$this->tplData['rcode']];
                } ?>
            </h3>
            <p>
                <?php if (isset($this->tplData['rcode']) && !fn_isEmpty($this->tplData['rcode']) && isset($this->lang['common']['text'][$this->tplData['rcode']])) {
                    echo $this->lang['common']['text'][$this->tplData['rcode']];
                } ?>
            </p>
            <p>
                <?php if (isset($this->tplData['rcode']) && !fn_isEmpty($this->tplData['rcode'])) {
                    echo $this->lang['common']['page']['rcode']; ?>
                    :
                    <?php echo $this->tplData['rcode'];
                } ?>
            </p>
        </div>

<?php if ($GLOBALS['view'] == 'iframe') { ?>
    </div>
    <div class="modal-footer clearfix">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><?php echo $this->lang['common']['btn']['close']; ?></button>
    </div>
<?php } else {
    include($cfg['pathInclude'] . 'console_foot.php');
    include($cfg['pathInclude'] . 'html_foot.php');
}

