## 后台钩子

| 名称 | 类型 | 描述 | 位置 |
| - | - | - | - |
| action_console_init | action | 后台初始化时触发 | 控制器 |
| [filter_console_posi_add](#filter_console_posi_add) | filter | 添加广告位时触发 | 模型 |
| [filter_console_posi_edit](#filter_console_posi_add) | filter | 编辑广告位时触发 | 模型 |
| [action_console_posi_status](#action_console_posi_status) | action | 变更广告位状态时触发 | 控制器 |
| [action_console_posi_delete](#action_console_posi_delete) | action | 删除广告位时触发 | 控制器 |
| [filter_console_advert_add](#filter_console_advert_add) | filter | 添加广告时触发 | 模型 |
| [filter_console_advert_edit](#filter_console_advert_add) | filter | 编辑广告时触发 | 模型 |
| [action_console_advert_status](#action_console_advert_status) | action | 变更广告状态时触发 | 控制器 |
| [action_console_advert_delete](#action_console_advert_delete) | action | 删除广告时触发 | 控制器 |
| [filter_console_link_add](#filter_console_link_add) | filter | 添加链接时触发 | 模型 |
| [filter_console_link_edit](#filter_console_link_add) | filter | 编辑链接时触发 | 模型 |
| [action_console_link_status](#action_console_link_status) | action | 更改链接状态时触发 | 控制器 |
| [action_console_link_delete](#action_console_link_delete) | action | 删除链接时触发 | 控制器 |
| action_console_head_before | action | 后台界面头部之前 | 模板 |
| action_console_head_after | action | 后台界面头部之后  | 模板 |
| action_console_navbar_before | action | 后台界面导航条之前 | 模板 |
| action_console_navbar_after | action | 后台界面导航条之后 | 模板 |
| action_console_menu_before | action | 后台界面菜单之前 | 模板 |
| action_console_menu_plugin | action | 后台界面插件菜单中 | 模板 |
| action_console_menu_end | action | 后台界面菜单末尾 | 模板 |
| action_console_menu_after | action | 后台界面菜单之后 | 模板 |
| action_console_foot_before | action | 后台界面底部之前 | 模板 |
| action_console_foot_after | action | 后台界面底部之后 | 模板 |

----------

<span id="filter_console_posi_add"></span>

##### filter_console_posi_add

* 返回、回传参数

    详情请参考 [广告脚本 -> 广告数据](../advert/data.md#posiRow)

----------

<span id="filter_console_posi_edit"></span>

##### filter_console_posi_edit

* 返回、回传参数

    详情请参考 [广告脚本 -> 广告数据](../advert/data.md#posiRow)

----------

<span id="action_console_posi_status"></span>

##### action_console_posi_status

* 返回

    | 参数 | 类型 | 描述 |
    | - | - | - |
    | posi_ids | array | 被变更的广告位 ID |
    | posi_status | array | 状态 |
    
----------

<span id="action_console_posi_delete"></span>

##### action_console_posi_delete

* 返回

    | 参数 | 类型 | 描述 |
    | - | - | - |
    | posi_ids | array | 被删除的广告位 ID |

----------

<span id="filter_console_advert_add"></span>

##### filter_console_advert_add

* 返回、回传参数

    | 参数 | 类型 | 描述 |
    | - | - | - |
    | advert_name | string | 广告名称 |
    | advert_posi_id | int | 广告位 ID |
    | advert_attach_id | int | 附件 ID |
    | advert_content | string | 文字广告内容 |
    | advert_url | string | 链接地址 |
    | advert_percent | int | 投放几率（1-10） |
    | advert_note | string | 备注 |
    | advert_status | string | 状态 |
    | advert_begin | int | 开始时间（UNIX 时间戳） |
    | advert_type | string | 广告类型 |
    | advert_opt | mix | 广告参数（根据 advert_type 不同变化） |
    
* advert_opt 类型

    | advert_type 值 | 类型 | 描述 |
    | - | - | - |
    | date | int | 结束时间（UNIX 时间戳） |
    | show | int | 显示数 |
    | hit | int | 点击数 |


----------

<span id="filter_console_advert_edit"></span>

##### filter_console_advert_edit

* 返回、回传参数

    | 参数 | 类型 | 描述 |
    | - | - | - |
    | advert_id | int | 广告 ID |
    | advert_name | string | 广告名称 |
    | advert_posi_id | int | 广告位 ID |
    | advert_attach_id | int | 附件 ID |
    | advert_content | string | 文字广告内容 |
    | advert_url | string | 链接地址 |
    | advert_percent | int | 投放几率（1-10） |
    | advert_note | string | 备注 |
    | advert_status | string | 状态 |
    | advert_begin | int | 开始时间（UNIX 时间戳） |
    | advert_type | string | 广告类型 |
    | advert_opt | mix | 广告参数（根据 advert_type 不同变化） |
    
* advert_opt 类型

    | advert_type 值 | 类型 | 描述 |
    | - | - | - |
    | date | int | 结束时间（UNIX 时间戳） |
    | show | int | 显示数 |
    | hit | int | 点击数 |

----------

<span id="action_console_advert_status"></span>

##### action_console_advert_status

* 返回

    | 参数 | 类型 | 描述 |
    | - | - | - |
    | advert_ids | array | 被变更的广告 ID |
    | advert_status | array | 状态 |
    
----------

<span id="action_console_advert_delete"></span>

##### action_console_advert_delete

* 返回

    | 参数 | 类型 | 描述 |
    | - | - | - |
    | advert_ids | array | 被删除的广告 ID |

----------

<span id="filter_console_link_add"></span>

##### filter_console_link_add

* 返回、回传参数

    | 参数 | 类型 | 描述 |
    | - | - | - |
    | link_name | string | 链接名称 |
    | link_url | string | 链接地址 |
    | link_status | string | 状态 |
    | link_blank | bool | 是否新窗口打开 |
    
----------

<span id="action_console_link_edit"></span>

##### action_console_link_edit

* 返回、回传参数

    | 参数 | 类型 | 描述 |
    | - | - | - |
    | link_id | int | 链接 ID |
    | link_name | string | 链接名称 |
    | link_url | string | 链接地址 |
    | link_status | string | 状态 |
    | link_blank | bool | 是否新窗口打开 |

----------

<span id="action_console_link_status"></span>

##### action_console_link_status

* 返回

    | 参数 | 类型 | 描述 |
    | - | - | - |
    | link_ids | array | 被更改的链接 ID |
    | link_status | array | 状态 |
    
----------

<span id="action_console_link_delete"></span>

##### action_console_link_delete

* 返回

    | 参数 | 类型 | 描述 |
    | - | - | - |
    | link_ids | array | 被删除的链接 ID |
