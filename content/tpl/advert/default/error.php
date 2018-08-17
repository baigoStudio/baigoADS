<?php $cfg = array(
    "title"         => $this->lang['common']['page']['rcode'],
    'pathInclude'   => BG_PATH_TPL . 'advert' . DS . 'default' . DS . 'include' . DS,
);

$_str_status = substr($this->tplData['rcode'], 0, 1);

include($cfg['pathInclude'] . 'advert_head.php'); ?>

    <h3><?php echo $this->lang['common']['page']['rcode']; ?></h3>

    <div>&nbsp;</div>

    <div class="alert alert-<?php if ($_str_status == "y") { ?>success<?php } else { ?>danger<?php } ?>">
        <h3>
            <span class="oi oi-<?php if ($_str_status == "y") { ?>circle-check<?php } else { ?>circle-x<?php } ?>"></span>
            <?php if (isset($this->tplData['rcode']) && !fn_isEmpty($this->tplData['rcode']) && isset($this->lang['rcode'][$this->tplData['rcode']])) {
                echo $this->lang['rcode'][$this->tplData['rcode']];
            } ?>
        </h3>
        <p>
            <?php if (isset($this->tplData['rcode']) && !fn_isEmpty($this->tplData['rcode']) && isset($this->lang['mod']['text'][$this->tplData['rcode']])) {
                echo $this->lang['mod']['text'][$this->tplData['rcode']];
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

<?php include($cfg['pathInclude'] . 'advert_foot.php');

