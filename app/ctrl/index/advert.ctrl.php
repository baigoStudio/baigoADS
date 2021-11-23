<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\index;

use app\classes\index\Ctrl;
use ginkgo\Loader;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Advert extends Ctrl {

  protected function c_init($param = array()) {
    parent::c_init();

    $this->mdl_statAdvert  = Loader::model('Stat_Advert');
    $this->mdl_statPosi    = Loader::model('Stat_Posi');

    $this->mdl_advert      = Loader::model('Advert');
  }

  public function index() {
    $_num_advertId = 0;

    if (isset($this->param['id'])) {
      $_num_advertId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    if ($_num_advertId < 1) {
      return $this->error('Missing ID', 'x080202');
    }

    $_arr_advertRow = $this->mdl_advert->read($_num_advertId);

    if ($_arr_advertRow['rcode'] != 'y080102') {
      return $this->error($_arr_advertRow['msg'], $_arr_advertRow['rcode']);
    }

    if (($_arr_advertRow['advert_type'] == 'date' && $_arr_advertRow['advert_opt'] < GK_NOW) || ($_arr_advertRow['advert_type'] == 'show' && $_arr_advertRow['advert_opt'] < $_arr_advertRow['advert_count_show']) || ($_arr_advertRow['advert_type'] == 'hit' && $_arr_advertRow['advert_opt'] < $_arr_advertRow['advert_count_hit'])) {
      return $this->error('Ad invalidation', 'x080402');
    }

    $this->mdl_advert->stat($_num_advertId, true);
    $this->mdl_statAdvert->submit($_num_advertId, true);
    $this->mdl_statPosi->submit($_arr_advertRow['advert_posi_id'], true);

    if (Func::isEmpty($_arr_advertRow['advert_url']) || $_arr_advertRow['advert_url'] == '#') {
      return $this->error('Invalid URL', 'x080402');
    }

    return $this->redirect($_arr_advertRow['advert_url']);
  }
}
