## 选项

选项文件必须命名为 `opts.json`，系统将读取此文件。

选项文件将为后台管理的 `广告位 -> 编辑` 中添加选项表单，并在生成广告代码时，成为广告插件的 JSON 对象。

选项文件示例

``` javascript
{
    "remain": {
        "title": "定位",
        "var_default": "top",
        "type": "select",
        "option": {
            "top": "上部",
            "bottom": "底部"
        }
    },
    "speed": {
        "title": "收起速度",
        "var_default": "slow",
        "type": "select_input",
        "note": "选择或输入毫秒",
        "option": {
            "slow": "慢",
            "normal": "普通",
            "fast": "快"
        }
    },
    "speed": {
        "title": "移动",
        "var_default": "slow",
        "type": "radio",
        "option": {
            "slow": array
                "value": "慢",
                "note": "slow"
            },
            "fast": {
                "value": "快",
                "note": "fast"
            }
        }
    },
    "top": {
        "title": "上边距",
        "note": "定位为 top 时有效",
        "var_default": "50px",
        "type": "text"
    },
    "bottom": {
        "title": "下边距（定位为 bottom 时有效）",
        "var_default": "50px",
        "type": "text"
    },
    "left": {
        "title": "左边距（左侧对联）",
        "var_default": "10px",
        "type": "text"
    },
    "right": {
        "title": "右边距（右侧对联）",
        "var_default": "10px",
        "type": "text"
    }
}
```

键名为选项名，每个键的结构说明：

| 键名 | 类型 | 描述 | 备注
| - | - | - | - |
| title | string | 显示的名称 | |
| var_default | string | 默认值 | |
| type | string | 表单类型 | 可选 text 文本框、select 下拉菜单、select_input 可输入的下拉菜单、radio 单选、switch 开关、textarea 文本区域。 |
| option | array | 选项数组 | 仅在表单类型为 select、select_input、radio 时有效。 |
| note | string | 备注 | |

