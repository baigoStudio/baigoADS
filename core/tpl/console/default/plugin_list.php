<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['plugin']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['plugin']['sub']['list'],
    'menu_active'    => "plugin",
    'sub_active'     => "list",
    'baigoCheckall'  => 'true',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?m=plugin&a=list",
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a href="<?php echo BG_URL_HELP; ?>index.php?m=console&a=plugin" class="nav-link" target="_blank">
                <span class="badge badge-pill badge-primary">
                    <span class="oi oi-question-mark"></span>
                </span>
                <?php echo $this->lang['mod']['href']['help']; ?>
            </a>
        </li>
    </ul>

    <form name="plugin_list" id="plugin_list">
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
                        <th><?php echo $this->lang['mod']['label']['pluginName']; ?></th>
                        <th><?php echo $this->lang['mod']['label']['pluginDir']; ?></th>
                        <th class="text-nowrap bg-td-md"><?php echo $this->lang['mod']['label']['status']; ?> / <?php echo $this->lang['mod']['label']['note']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->tplData['pluginRows'] as $key=>$value) { ?>
                        <tr>
                            <td class="text-nowrap bg-td-xs">
                                <?php if (isset($value['pluginRow']['plugin_id'])) { ?>
                                    <input type="checkbox" name="plugin_ids[]" value="<?php echo $value['pluginRow']['plugin_id']; ?>" id="plugin_id_<?php echo $value['pluginRow']['plugin_id']; ?>" data-parent="chk_all" data-validate="plugin_id">
                                <?php } ?>
                            </td>
                            <td class="text-nowrap bg-td-xs">
                                <?php if (isset($value['pluginRow']['plugin_id'])) {
                                    echo $value['pluginRow']['plugin_id'];
                                } ?>
                            </td>
                            <td>
                                <ul class="list-unstyled">
                                    <li><?php echo $value['config']['name']; ?></li>
                                    <li>
                                        <ul class="bg-nav-line">
                                            <?php if ($value['pluginRow']['rcode'] == 'y190102') { ?>
                                                <li>
                                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=plugin&a=show&plugin_id=<?php echo $value['pluginRow']['plugin_id']; ?>"><?php echo $this->lang['mod']['href']['show']; ?></a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=plugin&a=form&plugin_id=<?php echo $value['pluginRow']['plugin_id']; ?>"><?php echo $this->lang['mod']['href']['edit']; ?></a>
                                                </li>
                                                <?php if (isset($value['config']['detail']) && !fn_isEmpty($value['config']['detail'])) { ?>
                                                    <li>
                                                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=plugin&a=opt&plugin_id=<?php echo $value['pluginRow']['plugin_id']; ?>"><?php echo $this->lang['mod']['href']['opt']; ?></a>
                                                    </li>
                                                <?php }
                                            } else if ($value['pluginRow']['plugin_status'] == 'not') { ?>
                                                <li>
                                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=plugin&a=form&plugin_dir=<?php echo $value['name']; ?>"><?php echo $this->lang['mod']['href']['add']; ?></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <?php echo $value['name']; ?>
                            </td>
                            <td class="text-nowrap bg-td-md">
                                <ul class="list-unstyled">
                                    <li>
                                        <?php plugin_status_process($value['pluginRow']['plugin_status'], $this->lang['mod']['status']); ?>
                                    </li>
                                    <li><?php echo $value['pluginRow']['plugin_note']; ?></li>
                                </ul>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <small class="form-text" id="msg_plugin_id"></small>
            <div class="bg-submit-box bg-submit-box-list"></div>
        </div>

        <div class="mt-3 clearfix">
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
                        <option value="del"><?php echo $this->lang['mod']['option']['del']; ?></option>
                    </select>
                    <span class="input-group-append">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['submit']; ?></button>
                    </span>
                </div>
                <small class="form-text" id="msg_a"></small>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_list = {
        plugin_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='plugin_id']", type: "checkbox" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x030202']; ?>" }
        },
        a: {
            len: { min: 1, max: 0 },
            validate: { type: "select" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x030203']; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=plugin&c=request",
        confirm: {
            selector: "#a",
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
        var obj_validate_list   = $("#plugin_list").baigoValidator(opts_validator_list);
        var obj_submit_list     = $("#plugin_list").baigoSubmit(opts_submit_list);
        $(".bg-submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        $("#plugin_list").baigoCheckall();
    });
    </script>

<?php include('include' . DS . 'html_foot.php');