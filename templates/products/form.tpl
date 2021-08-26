<form action="" method="post" class="form">
    <input type="hidden" name="id" value="{$product.id}">
    <label>
        <div class="div-label">Название : </div>
        <input type="text" name="name" required value="{$product.name}">
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
        <input type="text" name="description" value="{$product.description}">
    </label>
    <input type="submit" value="{$submit_name|default:'Сохранить'}">
</form>