{include file="header.tpl" h1="Добавление товара"}

<form action="" method="post" class="form">
    <label>
        <div class="div-label">Название : </div>
        <input type="text" name="name" required >
    </label>
    <label>
        <div class="div-label">Артикул : </div>
        <input type="text" name="article" >
    </label>
    <label>
        <div class="div-label">Цена : </div>
        <input type="text" name="price" >
    </label>
    <label>
        <div class="div-label">Количество : </div>
        <input type="text" name="amount">
    </label>
    <label>
        <div class="div-label">Описание : </div>
        <input type="text" name="description">
    </label>
    <input type="submit" value="Добавить">
</form>

{include file="bottom.tpl"}