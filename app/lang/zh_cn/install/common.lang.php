<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------------------通用-------------------------*/
return array(
  'Installer'                             => '安装程序',
  'Error'                                 => '错误',
  'System already installed'              => '系统已安装',
  'Need to upgrade'                       => '需要执行升级程序',
  'PDO (The PHP Data Objects) for MySQL'  => 'PDO (PHP 数据对象) MySQL 驱动',
  'GD Library (Image Processing and GD)'  => 'GD 库 (图像处理和 GD)',
  'MBString (Multibyte String)'           => 'MBString (多字节字符串)',
  'cURL (Client URL Library)'             => 'cURL (Client URL)',
  'Database not set'                      => '未设置数据库',
  'No data created'                       => '未创建数据',
  'No administrators created'             => '未创建管理员',

  'Cancel'                        => '取消',
  'Confirm'                       => '确定',
  'OK'                            => '确定',
  'Close'                         => '关闭',
  'Submitting'                    => '正在提交 ...',
  'Complete'                      => '完成',

  'x030411' => '<h5>请执行如下步骤：</h5>
    <ol>
      <li>重新选择安装方式 <a href="{:route_install}index/type/">{:route_install}index/type/</a>
    </ol>',

  'x030412' => '<h5>如需重新安装，请执行如下步骤：</h5>
    <ol>
      <li>删除 {:path_installed} 文件</li>
      <li>重新运行 <a href="{:route_install}">{:route_install}</a></li>
    </ol>',

  'x030203' => '<h5>安全码错误：</h5>
    <p>
      点击选择安装方式 <a href="{:route_install}index/type/">{:route_install}index/type/</a> 重新生成安全码
    </p>',

  'x030204' => '<h5>请选择安装方式：</h5>
    <p>
      点击选择安装方式 <a href="{:route_install}index/type/">{:route_install}index/type/</a>
    </p>',

  'x030405' => '<h5>缺少必要的 PHP 扩展：</h5>
    <p>
      点击查看详情 <a href="{:route_install}">{:route_install}</a>
    </p>',
);
