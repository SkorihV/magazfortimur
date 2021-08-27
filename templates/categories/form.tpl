<form action="" method="post" class="form">
    <input type="hidden" name="id" value="{$category.id}">
    <div class="label-wrapper">
        <div class="div-for-label">Название категории: </div>
        <input type="text" name="name" required value="{$category.name}">
    </div>
    <input type="submit" value="{$submit_name|default:'Сохранить'}">
</form>