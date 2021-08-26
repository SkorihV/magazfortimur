<form action="" method="post" class="form">
    <input type="hidden" name="id" value="{$category.id}">
    <label>
        <div class="div-label">Название категории: </div>
        <input type="text" name="name" required value="{$category.name}">
    </label>
    <input type="submit" value="{$submit_name|default:'Сохранить'}">
</form>