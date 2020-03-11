## 广告数据

广告数据实际上是一个类似 API 接口的 URL，返回格式为 JSONP，其返回的数据可用于脚本的开发，实际上，在后台管理的 `广告位 -> 查看` 中已经将所需的广告数据 URL 准备好，直接就可以使用。

----------

##### 地址

http://server/index.php/posi/广告位 ID

##### 返回结果

系统采用 JSONP 返回数据，结构为带有 JSON 数据的回调函数，回调函数可在广告脚本中自定义。

| 键名 | 类型 | 描述 | 备注 |
| - | - | - | - |
| posiRow | array | 广告位信息 | 详情请查看 [$posiRow](#posiRow)。 |
| advertRows | array | 广告列表 | 详情请查看 [$advertRows](#advertRows) |
 
返回结果示例

``` javascript
jQuery111107948811247473591_1526367889575({
    "posiRow": { //广告位信息
        "posi_id": 2, //广告位 ID
        "posi_name": "Banner", //广告位名称
        "posi_count": 2, //显示广告数
        "posi_type": "attach", //广告位类型 attach 图片, text 文字
        "rcode": "y040102" //返回代码
    },
    "advertRows": [  //广告列表
        {
            "advert_id": 5, //广告 ID
            "advert_name": "Banner_5", //广告名称
            "advert_note": "", //备注
            "advert_href": "http://server/index.php/advert/5", //广告链接
            "rcode": "y080102", //返回代码
            "attachRow": { //图片信息
                "attach_id": 4, //图片 ID
                "attach_name": "20080228_fa178442e062486695ad9OcYaxbrb2Qv.jpg", //图片原始文件名
                "attach_ext": "jpg", //图片扩展名
                "attach_mime": "image/jpeg", //MIME
                "attach_size": 62308, //图片大小
                "attach_url": "http://www.domain.com/attach/2015/09/4.jpg", //图片 URL
                "rcode": "y070102" //返回代码
            }
        }
    ]
});
```

----------

<span id="posiRow"></span>

### $posiRow 结构

| 键名 | 类型 | 描述 | 备注 |
| - | - | - | - |
| posi_id | int | 广告位 ID |  |
| posi_name | string | 广告位名称 |  |
| posi_count | int | 显示广告数 |  |
| posi_type | string | 广告内容 | attach 或 text  |
| posi_status | string | 状态  |
| posi_script | string | 广告脚本 | | 
| posi_selector | string | 默认选择器 |  |
| posi_box_perfix | string | 广告容器前缀 |  |
| posi_loading | string | 正在载入文字 |  |
| posi_close | string | 关闭文字 |  |
| posi_is_percent | bool | 是否按几率投放 |  |
| posi_note | string | 备注 |  |
| rcode | string | 返回代码 |  |
 
----------

<span id="advertRows"></span>

### $advertRows 结构

| 键名 | 类型 | 描述 | 备注 |
| - | - | - | - |
| advert_id | int | 广告 ID | |
| advert_name | string | 广告名称 |  |
| advert_content | string | 广告文字内容 |  |
| advert_href | string | 广告链接地址 |  |
| attachRow | array | 图片信息 | 详情请查看 [$attachRow](#attachRow)。 |
| rcode | string | 返回代码 |  |
 
----------

<span id="attachRow"></span>

### $attachRow 结构

| 键名 | 类型 | 描述 |
| - | - | - |
| attach_id | int | 图片 ID |  
| attach_url | string | 图片 URL 地址 |  
| attach_name | string | 图片名称 |  
| attach_ext | string | 扩展名 |  
| attach_mime | string | MIME |  
| attach_size | int | 图片大小 |  
| rcode | string | 返回代码 |
 
