## 描述

描述文件必须命名为 `config.json`，系统将读取此文件。

| 键名 | 类型 | 描述 | 备注
| - | - | - | - |
| name | string | 脚本名 | 如未定义或为空，系统将使用目录名。 |
| require | array | 依赖 | 脚本依赖的 JS 库，如 jQuery、Bootstrap 等。 |
| script_name | string | 脚本文件名 | 如未定义或为空，系统将自动生成为 `目录名.min.js`，如没有后缀，系统将自动添加 `.min.js` 后缀。 |
| css_name | string | CSS 文件 | 如未定义或为空，系统将自动生成为 `目录名.css`，如没有后缀，系统将自动添加 `.css` 后缀。 |
| func_init | string | 初始化函数名 | 如未定义或为空，系统将自动生成为 `ads` + 目录名的驼峰形式，如 `adsBanner`。 |
| box_perfix | string | 广告容器前缀 | 如未定义或为空，系统将自动生成为 `#ads-` + 目录名的式，如 `#ads-banner`，支持 ID 或 class 选择器，如果只填入字符，系统会转换为 ID 选择器。 |
| is_percent | string | 是否允许按几率展现 | enable 或 disable，创建（编辑）广告位时，选择脚本，会自动选择允许按几率展现。|
| count | int | 显示广告数 | 每个广告位上允许同时显示的广告数，如：Banner、飘动、卷帘等一般为 1 个，轮播可以为数个，可根据实际情况决定。`2.0` 新增 |
| loading | string | 加载信息 | 加载广告时显示的消息 |
| close | string | 关闭文字 | 关闭按钮的文字 |
| note | string | 备注 | 创建（编辑）广告位时，选择脚本，会自动显示本参数。 |


描述文件示例

``` javascript
{
    "name": "对联",
    "require": [
        {
            "url": "/static/lib/1.11.1/jquery.min.js",
            "type": "js"
        }
    ],
    "script_name": "couplet",
    "css_name": "couplet",
    "func_init": "adsCouplet",
    "box_perfix": "#ads-couplet",
    "is_percent": "enable",
    "count": 1,
    "loading": "正在加载广告 ...",
    "close": "关闭",
    "note": "本脚本需要 jQuery 支持"
}
```