<form action="" method="post" class="form">
    <input type="hidden" name="id" value="{$category->getId()}">
    <div class="label-wrapper">
        <div class="div-for-label">Название категории: </div>
        <input type="text" name="name" required value="{$category->getName()}">
    </div>
    <input type="submit" value="{$submit_name|default:'Сохранить'}">
</form>