<form action="" method="post" class="form" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{$product.id}">
    <div class="label-wrapper">
        <div class="div-for-label">Название : </div>
        <input type="text" name="name" required value="{$product.name}">
    </div>
    <div class="label-wrapper">
        <div class="div-for-label">Категории : </div>
        <select name="category_id" >
            <option value="0">Не выбрано</option>
            {foreach from=$categories item=category}
                <option {if $product.category_id == $category.id}selected{/if} value="{$category.id}">{$category.name}</option>
            {/foreach}
        </select>
    </div>
    <div class="label-wrapper">
        <div class="div-for-label">Ссылка на изображение :</div>
        <input type="text" name="image_url"  >
    </div>
     <div class="label-wrapper">
        <div class="div-for-label">Загрузка файлов</div>
        <input type="file" name="images[]" multiple >
    </div>
    {if $product.images}
        <div class="label-wrapper">
            <div class="div-for-label">Картинки : </div>
            {foreach from=$product.images item=image}
                <div class="card" style="width: 90px;">
                    <div class="card-body">
                        <button class="btn btn-danger btn-sm" data-image-id="{$image.id}" onclick="return deleteImage(this)">Удалить</button>
                    </div>
                    <img src="{$image.path}" class="card-img-top" alt="{$image.name}">
                </div>
            {/foreach}
        </div>
        {literal}
            <script>
                function deleteImage(button) {
                    let imageId = $(button).attr('data-image-id');
                    console.log(imageId);
                    imageId = parseInt(imageId);

                    if (!imageId) {
                        alert("Проблема с image_id");
                        return false;
                    }

                    let url = '/products/delete_image';

                    const formData = new FormData();
                    formData.append('product_image_id', imageId);

                    fetch(url, {
                        method: 'POST',
                        body: formData
                    })
                    .then((response) => {
                        response.text()
                        .then((text) => {
                            console.log(imageId);
                            if (text.indexOf('error') > -1) {
                                alert("Ошибка удаления");
                            } else {
                                document.location.reload();
                            }
                        })
                    });

                    return false;
                }
            </script>
        {/literal}
    {/if}
    <div class="label-wrapper">
        <div class="div-for-label">Артикул : </div>
        <input type="text" name="article" value="{$product.article}">
    </div>
    <div class="label-wrapper">
        <div class="div-for-label">Цена : </div>
        <input type="text" name="price" value="{$product.price}">
    </div class="label">
    <div class="label-wrapper">
        <div class="div-for-label">Количество : </div>
        <input type="text" name="amount" value="{$product.amount}">
    </div class="label">
    <div class="label-wrapper">
        <div class="div-for-label">Описание : </div>
        <textarea name="description" cols="30" rows="10">{$product.description}</textarea>
    {*    <input type="text" name="description" value="{$product.description}"> *}
    </div class="label">
    <input type="submit" value="{$submit_name|default:'Сохранить'}">
</form>


