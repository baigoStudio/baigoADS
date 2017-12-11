<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['advert']['main']['title'],
    'menu_active'    => 'advert',
    'sub_active'     => 'list',
    'baigoCheckall'  => 'true',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'tokenReload'    => 'true',
    "tooltip"        => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?mod=advert&" . $this->tplData['query'],
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group clearfix">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills bg-nav-pills">
                    <li>
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=advert&act=form">
                            <span class="glyphicon glyphicon-plus"></span>
                            <?php echo $this->lang['mod']['href']['add']; ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=advert" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            <?php echo $this->lang['mod']['href']['help']; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pull-right">
            <form name="advert_search" id="advert_search" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get" class="form-inline">
                <input type="hidden" name="mod" value="advert">
                <input type="hidden" name="act" value="list">

                <div class="form-group hidden-sm hidden-xs">
                    <select name="posi_id" class="form-control input-sm">
                        <option value=""><?php echo $this->lang['mod']['option']['allPosi']; ?></option>
                        <?php foreach ($this->tplData['posiRows'] as $key=>$value) { ?>
                            <option <?php if ($this->tplData['search']['posi_id'] == $value['posi_id']) { ?>selected<?php } ?> value="<?php echo $value['posi_id']; ?>"><?php echo $value['posi_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <select name="status" class="form-control input-sm">
                        <option value=""><?php echo $this->lang['mod']['option']['allStatus']; ?></option>
                        <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                            <option <?php if ($this->tplData['search']['status'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                                <?php if (isset($this->lang['mod']['status'][$value])) {
                                    echo $this->lang['mod']['status'][$value];
                                } else {
                                    echo $value;
                                } ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-sm">
                        <input type="text" name="key" class="form-control" value="<?php echo $this->tplData['search']['key']; ?>" placeholder="<?php echo $this->lang['mod']['label']['key']; ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <form name="advert_list" id="advert_list" class="form-inline">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">

        <div class="panel panel-default">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-nowrap bg-td-xs">
                                <label for="chk_all" class="checkbox-inline">
                                    <input type="checkbox" name="chk_all" id="chk_all" data-parent="first">
                                    <?php echo $this->lang['mod']['label']['all']; ?>
                                </label>
                            </th>
                            <th class="text-nowrap bg-td-xs"><?php echo $this->lang['mod']['label']['id']; ?></th>
                            <th><?php echo $this->lang['mod']['label']['advertName']; ?></th>
                            <th class="text-nowrap bg-td-lg"><?php echo $this->lang['mod']['label']['posi']; ?> / <?php echo $this->lang['mod']['label']['advertShow']; ?></th>
                            <th class="text-nowrap bg-td-lg"><?php echo $this->lang['mod']['label']['advertBegin']; ?> / <?php echo $this->lang['mod']['label']['advertPutType']; ?></th>
                            <th class="text-nowrap bg-td-md"><?php echo $this->lang['mod']['label']['status']; ?> / <?php echo $this->lang['mod']['label']['note']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->tplData['advertRows'] as $key=>$value) {
                            switch ($value['advert_put_type']) {
                                case "date":
                                    $str_putOpt = $this->lang['mod']['label']['advertPutDate'] . ' ' . date(BG_SITE_DATE . ' ' . BG_SITE_TIMESHORT, $value['advert_put_opt']);
                                break;

                                case "show":
                                    $str_putOpt = $this->lang['mod']['label']['advertPutShow'] . ' ' . $value['advert_put_opt'];
                                break;

                                case "hit":
                                    $str_putOpt = $this->lang['mod']['label']['advertPutHit'] . ' ' . $value['advert_put_opt'];
                                break;

                                default:
                                    $str_putOpt = $this->lang['mod']['putType'][$value['advert_put_type']];
                                break;
                            } ?>
                            <tr>
                                <td class="text-nowrap bg-td-xs"><input type="checkbox" name="advert_ids[]" value="<?php echo $value['advert_id']; ?>" id="advert_id_<?php echo $value['advert_id']; ?>" data-validate="advert_id" data-parent="chk_all"></td>
                                <td class="text-nowrap bg-td-xs"><?php echo $value['advert_id']; ?></td>
                                <td>
                                    <ul class="list-unstyled">
                                        <li><?php echo $value['advert_name']; ?></li>
                                        <li>
                                            <ul class="bg-nav-line">
                                                <li>
                                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=advert&act=show&advert_id=<?php echo $value['advert_id']; ?>"><?php echo $this->lang['mod']['href']['show']; ?></a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=advert&act=form&advert_id=<?php echo $value['advert_id']; ?>"><?php echo $this->lang['mod']['href']['edit']; ?></a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=stat&act=advert&advert_id=<?php echo $value['advert_id']; ?>"><?php echo $this->lang['mod']['href']['stat']; ?></a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </td>
                                <td class="text-nowrap bg-td-lg">
                                    <ul class="list-unstyled">
                                        <li>
                                            <?php if (isset($value['posiRow']['posi_name'])) { ?>
                                                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=advert&act=list&posi_id=<?php echo $value['posiRow']['posi_id']; ?>"><?php echo $value['posiRow']['posi_name']; ?></a>
                                            <?php } else {
                                                echo $this->lang['mod']['label']['unknow'];
                                            } ?>
                                        </li>
                                        <li>
                                            <abbr data-toggle="tooltip" data-placement="bottom" title="<?php echo $this->lang['mod']['label']['advertShow']; ?> <?php echo $value['advert_count_show']; ?><br><?php echo $this->lang['mod']['label']['advertHit']; ?> <?php echo $value['advert_count_hit']; ?>">
                                                <?php echo $value['advert_count_show']; ?>
                                            </abbr>
                                        </li>
                                    </ul>
                                </td>
                                <td class="text-nowrap bg-td-lg">
                                    <ul class="list-unstyled">
                                        <li>
                                            <abbr data-toggle="tooltip" data-placement="bottom" title="<?php echo date(BG_SITE_DATE . ' ' . BG_SITE_TIMESHORT, $value['advert_begin']); ?>"><?php echo date(BG_SITE_DATESHORT . ' ' . BG_SITE_TIMESHORT, $value['advert_begin']); ?></abbr>
                                        </li>
                                        <li>
                                            <abbr data-toggle="tooltip" data-placement="bottom" title="<?php echo $str_putOpt; ?>">
                                                <?php echo $this->lang['mod']['putType'][$value['advert_put_type']]; ?>
                                            </abbr>
                                        </li>
                                    </ul>
                                </td>
                                <td class="text-nowrap bg-td-md">
                                    <ul class="list-unstyled">
                                        <li>
                                            <?php advert_status_process($value, $this->lang['mod']['status'], $this->lang['mod']); ?>
                                        </li>
                                        <li><?php echo $value['advert_note']; ?></li>
                                    </ul>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><span id="msg_advert_id"></span></td>
                            <td colspan="5">
                                <div class="bg-submit-box"></div>

                                <div class="form-group">
                                    <div id="group_act">
                                        <select name="act" id="act" data-validate class="form-control input-sm">
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
                                            <option value="del"><?php echo $this->lang['mod']['option']['del']; ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-sm btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['submit']; ?></button>
                                </div>
                                <div class="form-group">
                                    <span id="msg_act"></span>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </form>

    <div class="text-right">
        <?php include($cfg['pathInclude'] . 'page.php'); ?>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_list = {
        advert_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='advert_id']", type: "checkbox" },
            msg: { selector: "#msg_advert_id", too_few: "<?php echo $this->lang['rcode']['x030202']; ?>" }
        },
        act: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_act" },
            msg: { selector: "#msg_act", too_few: "<?php echo $this->lang['rcode']['x030203']; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=advert",
        confirm: {
            selector: "#act",
            val: "del",
            msg: "<?php echo $this->lang['mod']['confirm']['del']; ?>"
        },
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    $(document).ready(function(){
        var obj_validator_list = $("#advert_list").baigoValidator(opts_validator_list);
        var obj_submit_list = $("#advert_list").baigoSubmit(opts_submit_list);
        $(".bg-submit").click(function(){
            if (obj_validator_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });

        $("#advert_list").baigoCheckall();
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>