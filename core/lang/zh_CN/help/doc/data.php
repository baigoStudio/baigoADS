<?php
return "<h3>广告数据</h3>
    <p>
        广告数据实际上是一个类似 API 接口的 URL，返回格式为 JSONP，其返回的数据可用于脚本的开发。
    </p>

    <p>
        地址：<span class=\"text-primary\">http://www.domain.com/api/api.php?mod=adver&act_get=list&posi_id=广告位 ID</span>
    </p>

    <p>&nbsp;</p>

    <h4>返回结果</h4>
    <p>
        系统采用 JSONP 返回数据，结构为带有 JSON 数据的回调函数，回调函数可在广告脚本中自定义。
    </p>

    <div class=\"panel panel-default\">
        <div class=\"table-responsive\">
            <table class=\"table\">
                <thead>
                    <tr>
                        <th class=\"text-nowrap\">键名</th>
                        <th class=\"text-nowrap\">类型</th>
                        <th class=\"text-nowrap\">说明</th>
                        <th>备注</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class=\"text-nowrap\">posiRow</td>
                        <td class=\"text-nowrap\">array</td>
                        <td class=\"text-nowrap\">广告位信息</td>
                        <td>详情请查看 <a href=\"#posiRow\">posiRow</a>。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">advertRows</td>
                        <td class=\"text-nowrap\">array</td>
                        <td class=\"text-nowrap\">广告列表</td>
                        <td>多维数组，详情请查看 <a href=\"#advertRows\">advertRows</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <p>&nbsp;</p>

    <a name=\"posiRow\"></a>
    <h4><code>posiRow</code> 对象</h4>

    <div class=\"panel panel-default\">
        <div class=\"table-responsive\">
            <table class=\"table\">
                <thead>
                    <tr>
                        <th class=\"text-nowrap\">键名</th>
                        <th class=\"text-nowrap\">类型</th>
                        <th class=\"text-nowrap\">说明</th>
                        <th>备注</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class=\"text-nowrap\">posi_id</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">广告位 ID</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">posi_name</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">广告位名称</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">posi_count</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">显示广告数</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">posi_type</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">广告内容</td>
                        <td>media 或 text</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">posi_script</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">广告脚本</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">posi_plugin</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">插件名</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">posi_selector</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">默认选择器</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">alert</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">返回代码</td>
                        <td>详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=alert\">返回代码</a>。</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <p>&nbsp;</p>

    <a name=\"advertRows\"></a>
    <h4><code>advertRows</code> 对象</h4>

    <div class=\"panel panel-default\">
        <div class=\"table-responsive\">
            <table class=\"table\">
                <thead>
                    <tr>
                        <th class=\"text-nowrap\">键名</th>
                        <th class=\"text-nowrap\">类型</th>
                        <th class=\"text-nowrap\">说明</th>
                        <th>备注</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class=\"text-nowrap\">advert_id</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">广告 ID</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">advert_name</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">广告名称</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">advert_content</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">广告文字内容</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">advert_href</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">广告链接地址</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">mediaRow</td>
                        <td class=\"text-nowrap\">array</td>
                        <td class=\"text-nowrap\">图片信息</td>
                        <td>详情请查看 <a href=\"#mediaRow\">mediaRow</a>。</td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">alert</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">返回代码</td>
                        <td>详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=alert\">返回代码</a>。</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <p>&nbsp;</p>

    <a name=\"mediaRow\"></a>
    <h4><code>mediaRow</code> 对象</h4>

    <div class=\"panel panel-default\">
        <div class=\"table-responsive\">
            <table class=\"table\">
                <thead>
                    <tr>
                        <th class=\"text-nowrap\">键名</th>
                        <th class=\"text-nowrap\">类型</th>
                        <th class=\"text-nowrap\">说明</th>
                        <th>备注</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class=\"text-nowrap\">media_id</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">图片 ID</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">media_url</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">图片 URL 地址</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">media_name</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">图片名称</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">media_ext</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">扩展名</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">media_mime</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">MIME</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">media_size</td>
                        <td class=\"text-nowrap\">int</td>
                        <td class=\"text-nowrap\">图片大小</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td class=\"text-nowrap\">alert</td>
                        <td class=\"text-nowrap\">string</td>
                        <td class=\"text-nowrap\">返回代码</td>
                        <td>详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=alert\">返回代码</a>。</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <p>&nbsp;</p>

    <h4>返回结果示例</h4>
    <p>
<pre><code class=\"language-javascript\">callback({
    &quot;posiRow&quot;: { //广告位信息
        &quot;posi_id&quot;: 2, //广告位 ID
        &quot;posi_name&quot;: &quot;Banner&quot;, //广告位名称
        &quot;posi_count&quot;: 2, //显示广告数
        &quot;posi_type&quot;: &quot;media&quot;, //广告位类型 media 图片, text 文字
        &quot;alert&quot;: &quot;y040102&quot; //返回代码
    },
    &quot;advertRows&quot;: [  //广告列表
        {
            &quot;advert_id&quot;: 5, //广告 ID
            &quot;advert_name&quot;: &quot;Banner_5&quot;, //广告名称
            &quot;advert_note&quot;: &quot;&quot;, //备注
            &quot;advert_href&quot;: &quot;http://www.domain.com/advert/ctl.php?mod=advert&amp;act_get=url&amp;advert_id=5&quot;, //广告链接
            &quot;alert&quot;: &quot;y080102&quot;, //返回代码
            &quot;mediaRow&quot;: { //图片信息
                &quot;media_id&quot;: 4, //图片 ID
                &quot;media_name&quot;: &quot;20080228_fa178442e062486695ad9OcYaxbrb2Qv.jpg&quot;, //图片原始文件名
                &quot;media_ext&quot;: &quot;jpg&quot;, //图片扩展名
                &quot;media_mime&quot;: &quot;image/jpeg&quot;, //MIME
                &quot;media_size&quot;: 62308, //图片大小
                &quot;media_url&quot;: &quot;http://www.domain.com/media/2015/09/4.jpg&quot;, //图片 URL
                &quot;alert&quot;: &quot;y070102&quot; //返回代码
            }
        }
    ]
});</code></pre>
    </p>";