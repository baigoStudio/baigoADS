<?php $cfg = array(
    'title'          => $this->lang['mod']['page']['pm'],
    'menu_active'    => "pm",
    'sub_active'     => 'list',
    'baigoCheckall'  => 'true',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    "tooltip"        => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?mod=pm&act=list&" . $this->tplData['query'],
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group clearfix">
        <div class="pull-left">
            <?php include($cfg['pathInclude'] . 'pm_menu.php'); ?>
        </div>
        <div class="pull-right">
            <form name="pm_search" id="pm_search" class="form-inline" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get">
                <input type="hidden" name="mod" value="pm">
                <input type="hidden" name="act" value="list">
                <div class="form-group hidden-sm hidden-xs">
                    <select name="status" class="form-control input-sm">
                        <option value=""><?php echo $this->lang['mod']['option']['allStatus']; ?></option>
                        <?php foreach ($this->pm['status'] as $key=>$value) { ?>
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

    <form name="pm_list" id="pm_list" class="form-inline">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">

        <div class="panel panel-default">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-nowrap bg-td-xs">
                                <label for="chk_all" class="checkbox-inline">
                                    <input type="checkbox" name="chk_all" id="chk_all" data-parent="first">
                                    <?php echo $this->lang['mod']['label']['all']; ?>
                                </label>
                            </th>
                            <th class="text-nowrap bg-td-xs"><?php echo $this->lang['mod']['label']['id']; ?></th>
                            <th><?php echo $this->lang['mod']['label']['pm']; ?></th>
                            <th>
                                <?php if ($this->tplData['search']['type'] == "in") {
                                    echo $this->lang['mod']['label']['pmFrom'];
                                } else {
                                    echo $this->lang['mod']['label']['pmTo'];
                                } ?>
                            </th>
                            <th class="text-nowrap bg-td-md"><?php echo $this->lang['mod']['label']['time']; ?></th>
                            <th class="text-nowrap bg-td-sm"><?php echo $this->lang['mod']['label']['status']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->tplData['pmRows'] as $key=>$value) {
                            $_arr_status = pm_status_process($value, $this->lang['common']['pm'], $this->lang['mod'], $this->tplData['search']['type']); ?>
                            <tr class="<?php echo $_arr_status['css_text']; ?>">
                                <td class="text-nowrap bg-td-xs"><input type="checkbox" name="pm_ids[]" value="<?php echo $value['pm_id']; ?>" id="pm_id_<?php echo $value['pm_id']; ?>" data-parent="chk_all"  data-validate="pm_id"></td>
                                <td class="text-nowrap bg-td-xs"><?php echo $value['pm_id']; ?></td>
                                <td>
                                    <a href="#pm_modal" data-toggle="modal" data-id="<?php echo $value['pm_id']; ?>">
                                        <?php echo $_arr_status['bold_begin'] . $value['pm_title'] . $_arr_status['bold_end']; ?>
                                    </a>
                                </td>
                                <td>
                                    <?php if ($this->tplData['search']['type'] == "in") {
                                        if ($value['pm_from'] > 0) {
                                            if (isset($value['fromUser']['user_name'])) { ?>
                                                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=admin&act=show&admin_id=<?php echo $value['pm_from']; ?>"><?php echo $value['fromUser']['user_name']; ?></a>
                                            <?php } else {
                                                echo $this->lang['mod']['label']['unknown'];
                                            }
                                        } else {
                                            echo $this->lang['mod']['label']['pmSys'];
                                        }
                                    } else {
                                        if (isset($value['toUser']['user_name'])) { ?>
                                            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=admin&act=show&admin_id=<?php echo $value['pm_to']; ?>"><?php echo $value['toUser']['user_name']; ?></a>
                                        <?php } else {
                                            echo $this->lang['mod']['label']['unknown'];
                                        }
                                    } ?>
                                </td>
                                <td class="text-nowrap bg-td-md">
                                    <abbr title="<?php echo date(BG_SITE_DATE . ' ' . BG_SITE_TIMESHORT, $value['pm_time']); ?>" data-toggle="tooltip" data-placement="bottom">
                                        <?php echo date(BG_SITE_DATESHORT . ' ' . BG_SITE_TIMESHORT, $value['pm_time']); ?>
                                    </abbr>
                                </td>
                                <td class="text-nowrap bg-td-sm">
                                    <span class="label label-<?php echo $_arr_status['css_label']; ?> bg-label"><?php echo $_arr_status['str_text']; ?></span>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><span id="msg_pm_id"></span></td>
                            <td colspan="4">
                                <div class="bg-submit-box bg-submit-box-list"></div>
                                <div class="form-group">
                                    <div id="group_act">
                                        <select name="act" id="act" data-validate class="form-control input-sm">
                                            <option value=""><?php echo $this->lang['mod']['option']['batch']; ?></option>
                                            <?php if ($this->tplData['search']['type'] == "in") {
                                                foreach ($this->pm['status'] as $key=>$value) { ?>
                                                    <option value="<?php echo $value; ?>">
                                                        <?php if (isset($this->lang['common']['pm'][$value])) {
                                                            echo $this->lang['common']['pm'][$value];
                                                        } else {
                                                            echo $value;
                                                        } ?>
                                                    </option>
                                                <?php }
                                            } ?>
                                            <option value="del"><?php echo $this->lang['mod']['option']['del']; ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-sm bg-submit"><?php echo $this->lang['mod']['btn']['submit']; ?></button>
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

    <div class="modal fade" id="pm_modal">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_list = {
        pm_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='pm_id']", type: "checkbox" },
            msg: { selector: "#msg_pm_id", too_few: "<?php echo $this->lang['rcode']['x030202']; ?>" }
        },
        act: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_act" },
            msg: { selector: "#msg_act", too_few: "<?php echo $this->lang['rcode']['x030203']; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=pm",
        confirm: {
            selector: "#act",
            val: "del",
            msg: "<?php echo $this->lang['mod']['confirm']['del']; ?>"
        },
        box: {
            selector: ".bg-submit-box-list"
        },
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    $(document).ready(function(){
        $("#pm_modal").on("shown.bs.modal", function(event) {
    		var _obj_button   = $(event.relatedTarget);
    		var _id           = _obj_button.data("id");
            $("#pm_modal .modal-content").load("<?php echo BG_URL_CONSOLE; ?>index.php?mod=pm&act=show&pm_id=" + _id + "&view=iframe");
    	}).on("hidden.bs.modal", function(){
        	$("#pm_modal .modal-content").empty();
    	});

        var obj_validate_list = $("#pm_list").baigoValidator(opts_validator_list);
        var obj_submit_list   = $("#pm_list").baigoSubmit(opts_submit_list);
        $(".bg-submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        $("#pm_list").baigoCheckall();
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>

