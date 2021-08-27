<form action="" method="post" class="form" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{$product.id}">
    <label>
        <div class="div-label">Название : </div>
        <input type="text" name="name" required value="{$product.name}">
    </label>
    <label>
        <div class="div-label">Категории : </div>
        <select name="category_id" >
            <option value="0">Не выбрано</option>
            {foreach from=$categories item=category}
                <option {if $product.category_id == $category.id}selected{/if} value="{$category.id}">{$category.name}</option>
            {/foreach}
        </select>
    </label>
    <label>
        <div class="div-label">Загрузка файлов</div>
        <input type="file" name="images[]" multiple >
    </label>
    <label>
        <div class="div-label">Артикул : </div>
        <input type="text" name="article" value="{$product.article}">
    </label>
    <label>
        <div class="div-label">Цена : </div>
        <input type="text" name="price" value="{$product.price}">
    </label>
    <label>
        <div class="div-label">Количество : </div>
        <input type="text" name="amount" value="{$product.amount}">
    </label>
    <label>
        <div class="div-label">Описание : </div>
        <textarea name="description" cols="30" rows="10">{$product.description}</textarea>
    {*    <input type="text" name="description" value="{$product.description}"> *}
    </label>
    <input type="submit" value="{$submit_name|default:'Сохранить'}">
</form>