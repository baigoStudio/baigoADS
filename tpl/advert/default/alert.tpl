{$cfg = [
    title  => $lang.page.alert
]}

{include "{$smarty.const.BG_PATH_TPL}advert/default/include/advert_head.tpl" cfg=$cfg}

    <h3>{$lang.page.alert}</h3>

    <p>&nbsp;</p>

    <div class="alert alert-{if $tplData.status == "y"}success{else}danger{/if}">
        <h3>
            <span class="glyphicon glyphicon-{if $tplData.status == "y"}ok-circle{else}remove-circle{/if}"></span>
            {$alert[$tplData.alert]}
        </h3>
        <p>
            {if isset($lang.text[$tplData.alert])}
                {$lang.text[$tplData.alert]}
            {/if}
        </p>
        <p>
            {$lang.label.alert}
            :
            {$tplData.alert}
        </p>
    </div>

{include "{$smarty.const.BG_PATH_TPL}advert/default/include/advert_foot.tpl" cfg=$cfg}
{include "{$smarty.const.BG_PATH_TPL}advert/default/include/html_foot.tpl" cfg=$cfg}
