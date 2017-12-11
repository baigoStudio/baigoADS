<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------栏目模型-------------*/
class MODEL_PM {

    public $arr_status = array('wait', 'read');
    public $arr_type   = array('in', 'out');

    function input_ids() {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $_arr_pmIds = fn_post('pm_ids');

        if (fn_isEmpty($_arr_pmIds)) {
            $_str_rcode = 'x030202';
        } else {
            foreach ($_arr_pmIds as $_key=>$_value) {
                $_arr_pmIds[$_key] = fn_getSafe($_value, 'int', 0);
            }
            $_str_rcode = 'ok';
        }

        $_arr_pmIds = array(
            'rcode'     => $_str_rcode,
            'pm_ids'    => array_filter(array_unique($_arr_pmIds)),
        );

        return $_arr_pmIds;
    }


    function input_send() {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $_arr_pmTitle = fn_validate(fn_post('pm_title'), 0, 90);
        switch ($_arr_pmTitle['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x110202',
                );
            break;

            case 'ok':
                $_arr_pmSend['pm_title'] = $_arr_pmTitle['str'];
            break;
        }

        $_arr_pmContent = fn_validate(fn_post('pm_content'), 0, 900);
        switch ($_arr_pmContent['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x110203',
                );
            break;

            case 'ok':
                $_arr_pmSend['pm_content'] = $_arr_pmContent['str'];
            break;
        }

        /*if (!$_arr_pmSend['pm_title']) {
            $_arr_pmSend['pm_title'] = fn_substr_utf8($_arr_pmSend['pm_content'], 0, 30);
        }*/

        $_arr_pmTo = fn_validate(fn_post('pm_to'), 1, 0);
        switch ($_arr_pmTo['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x110205',
                );
            break;

            case 'ok':
                $_arr_pmSend['pm_to'] = $_arr_pmTo['str'];
            break;
        }

        $_arr_pmSend['rcode'] = 'ok';

        return $_arr_pmSend;
    }
}
