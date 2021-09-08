{include file="header.tpl" h1="Импорт товаров"}
<form action="/import/upload" method="POST" class="form" enctype="multipart/form-data" >
    <div class="label-wrapper">
        <input type="hidden" name="filePath" value="{$filePath}" >
    </div>
    {if $fieldsFile}
    {foreach from=$fieldsFile item=field}
        <div class="label-wrapper">
            <div class="div-for-label">{$field}</div>
            <select name="{$field}">
                <option value="none" selected>Не выбрано</option>
                {foreach from=$columnTable item=column}
                    {if $column != "id"}
                        <option value="{$column}">{$column}</option>
                    {/if}
                {/foreach}
                <option value="image_url" >Ссылки на изображения</option>
            </select>
        </div>
    {/foreach}
    {/if}
    <input type="submit" value="{$submit_name|default:'Импортировать'}">
</form>

{include file="bottom.tpl"}