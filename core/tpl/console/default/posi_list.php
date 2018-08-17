<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['posi']['main']['title'],
    'menu_active'    => 'posi',
    'sub_active'     => 'list',
    'baigoCheckall'  => 'true',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'tokenReload'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?m=posi&" . $this->tplData['query'],
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="clearfix mb-3">
        <div class="float-left">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=posi&a=form" class="nav-link">
                        <span class="oi oi-plus"></span>
                        <?php echo $this->lang['mod']['href']['add']; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BG_URL_HELP; ?>index.php?m=console&a=posi" class="nav-link" target="_blank">
                        <span class="badge badge-pill badge-primary">
                            <span class="oi oi-question-mark"></span>
                        </span>
                        <?php echo $this->lang['mod']['href']['help']; ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="float-right">
            <form name="posi_search" id="posi_search" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get">
                <input type="hidden" name="m" value="posi">
                <input type="hidden" name="a" value="list">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="key" class="form-control" value="<?php echo $this->tplData['search']['key']; ?>" placeholder="<?php echo $this->lang['mod']['label']['key']; ?>">
                        <span class="input-group-append">
                            <button class="btn btn-secondary" type="submit">
                                <span class="oi oi-magnifying-glass"></span>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <form name="posi_list" id="posi_list">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">

        <div class="table-responsive">
            <table class="table table-striped table-hover border">
                <thead>
                    <tr>
                        <th class="text-nowrap bg-td-xs">
                            <div class="form-check">
                                <label for="chk_all" class="form-check-label">
                                    <input type="checkbox" name="chk_all" id="chk_all" data-parent="first" class="form-check-input">
                                    <?php echo $this->lang['mod']['label']['all']; ?>
                                </label>
                            </div>
                        </th>
                        <th class="text-nowrap bg-td-xs"><?php echo $this->lang['mod']['label']['id']; ?></th>
                        <th><?php echo $this->lang['mod']['label']['posi']; ?></th>
                        <th class="text-nowrap bg-td-lg"><?php echo $this->lang['mod']['label']['contentType']; ?></th>
                        <th class="text-nowrap bg-td-md"><?php echo $this->lang['mod']['label']['status']; ?> / <?php echo $this->lang['mod']['label']['note']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->tplData['posiRows'] as $key=>$value) { ?>
                        <tr>
                            <td class="text-nowrap bg-td-xs"><input type="checkbox" name="posi_ids[]" value="<?php echo $value['posi_id']; ?>" id="posi_id_<?php echo $value['posi_id']; ?>" data-parent="chk_all" data-validate="posi_id"></td>
                            <td class="text-nowrap bg-td-xs"><?php echo $value['posi_id']; ?></td>
                            <td>
                                <ul class="list-unstyled">
                                    <li><?php echo $value['posi_name']; ?></li>
                                    <li>
                                        <ul class="bg-nav-line">
                                            <li>
                                                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=posi&a=show&posi_id=<?php echo $value['posi_id']; ?>"><?php echo $this->lang['mod']['href']['posiPreview']; ?></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=posi&a=form&posi_id=<?php echo $value['posi_id']; ?>"><?php echo $this->lang['mod']['href']['edit']; ?></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=stat&a=posi&posi_id=<?php echo $value['posi_id']; ?>"><?php echo $this->lang['mod']['href']['stat']; ?></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=advert&a=list&posi_id=<?php echo $value['posi_id']; ?>"><?php echo $this->lang['mod']['href']['advertMan']; ?></a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                            <td class="text-nowrap bg-td-lg">
                                <ul class="list-unstyled">
                                    <li><?php echo $this->lang['mod']['type'][$value['posi_type']]; ?></li>
                                </ul>
                            </td>
                            <td class="text-nowrap bg-td-md">
                                <ul class="list-unstyled">
                                    <li>
                                        <?php posi_status_process($value['posi_status'], $this->lang['mod']['status']); ?>
                                    </li>
                                    <li><?php echo $value['posi_note']; ?></li>
                                </ul>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <small class="form-text" id="msg_posi_id"></small>
            <div class="bg-submit-box bg-submit-box-list"></div>
        </div>

        <div class="clearfix mt-3">
            <div class="float-left">
                <div class="input-group">
                    <select name="a" id="a" data-validate class="custom-select">
                        <option value=""><?php echo $this->lang['mod']['option']['batch']; ?></option>
                        <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                            <option value="<?php echo $value; ?>">
                                <?php if (isset($this->lang['mod']['status'][$value])) {
                                    echo $this->lang['mod']['status'][$value];
                                } else {
                                    echo $value;
                                } ?>
                            </option>
                        <?php } ?>
                        <option value="cache"><?php echo $this->lang['mod']['option']['cache']; ?></option>
                        <option value="del"><?php echo $this->lang['mod']['option']['del']; ?></option>
                    </select>
                    <span class="input-group-append">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['submit']; ?></button>
                    </span>
                </div>
                <small class="form-text" id="msg_a"></small>
            </div>
            <div class="float-right">
                <?php include($cfg['pathInclude'] . 'page.php'); ?>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_list = {
        posi_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='posi_id']", type: "checkbox" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x030202']; ?>" }
        },
        a: {
            len: { min: 1, max: 0 },
            validate: { type: "select" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x030203']; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=posi&c=request",
        confirm: {
            selector: "#a",
            val: "del",
            msg: "<?php echo $this->lang['mod']['confirm']['del']; ?>"
        },
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    $(document).ready(function(){
        var obj_validate_list = $("#posi_list").baigoValidator(opts_validator_list);
        var obj_submit_list   = $("#posi_list").baigoSubmit(opts_submit_list);
        $(".bg-submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        $("#posi_list").baigoCheckall();
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php');
