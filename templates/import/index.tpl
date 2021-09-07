{include file="header.tpl" h1="Импорт товаров"}
<form action="/import/parsing" method="post" class="form" enctype="multipart/form-data" >
    <div class="label-wrapper">
        <div class="div-for-label">Файл импорта</div>
        <input type="file" name="import_file" >
    </div>
    <input type="submit" value="{$submit_name|default:'Разобрать файл'}">

</form>

{include file="bottom.tpl"}