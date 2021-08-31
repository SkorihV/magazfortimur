<?php /* Smarty version 2.6.31, created on 2021-08-31 15:00:19
         compiled from products/form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'products/form.tpl', 93, false),)), $this); ?>
<form action="" method="post" class="form" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['product']->getId(); ?>
">
    <div class="label-wrapper">
        <div class="div-for-label">Название : </div>
        <input type="text" name="name" required value="<?php echo $this->_tpl_vars['product']->getName(); ?>
">
    </div>
    <div class="label-wrapper">
        <div class="div-for-label">Категории : </div>
        <select name="category_id" >
            <option value="0">Не выбрано</option>

            <?php $this->assign('productCategory', $this->_tpl_vars['product']->getCategory()); ?>
            <?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['category']):
?>
                <option <?php if ($this->_tpl_vars['productCategory']->getId() == $this->_tpl_vars['category']['id']): ?>selected<?php endif; ?> value="<?php echo $this->_tpl_vars['category']['id']; ?>
"><?php echo $this->_tpl_vars['category']['name']; ?>
</option>
            <?php endforeach; endif; unset($_from); ?>
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
    <?php if ($this->_tpl_vars['product']->getImages()): ?>
        <div class="label-wrapper">
            <div class="div-for-label">Картинки : </div>
            <?php $_from = $this->_tpl_vars['product']->getImages(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['image']):
?>
                <div class="card" style="width: 90px;">
                    <div class="card-body">
                        <button class="btn btn-danger btn-sm" data-image-id="<?php echo $this->_tpl_vars['image']->getId(); ?>
" onclick="return deleteImage(this)">Удалить</button>
                    </div>
                    <img src="<?php echo $this->_tpl_vars['image']->getPath(); ?>
" class="card-img-top" alt="<?php echo $this->_tpl_vars['image']->getName(); ?>
">
                </div>
            <?php endforeach; endif; unset($_from); ?>
        </div>
        <?php echo '
            <script>
                function deleteImage(button) {
                    let imageId = $(button).attr(\'data-image-id\');
                    console.log(imageId);
                    imageId = parseInt(imageId);

                    if (!imageId) {
                        alert("Проблема с image_id");
                        return false;
                    }

                    let url = \'/products/delete_image\';

                    const formData = new FormData();
                    formData.append(\'product_image_id\', imageId);

                    fetch(url, {
                        method: \'POST\',
                        body: formData
                    })
                    .then((response) => {
                        response.text()
                        .then((text) => {
                            console.log(imageId);
                            if (text.indexOf(\'error\') > -1) {
                                alert("Ошибка удаления");
                            } else {
                                document.location.reload();
                            }
                        })
                    });

                    return false;
                }
            </script>
        '; ?>

    <?php endif; ?>
    <div class="label-wrapper">
        <div class="div-for-label">Артикул : </div>
        <input type="text" name="article" value="<?php echo $this->_tpl_vars['product']->getArticle(); ?>
">
    </div>
    <div class="label-wrapper">
        <div class="div-for-label">Цена : </div>
        <input type="text" required name="price" value="<?php echo $this->_tpl_vars['product']->getPrice(); ?>
">
    </div class="label">
    <div class="label-wrapper">
        <div class="div-for-label">Количество : </div>
        <input type="text" required name="amount" value="<?php echo $this->_tpl_vars['product']->getAmount(); ?>
">
    </div class="label">
    <div class="label-wrapper">
        <div class="div-for-label">Описание : </div>
        <textarea name="description" cols="30" rows="10"><?php echo $this->_tpl_vars['product']->getDescription(); ?>
</textarea>
        </div class="label">
    <input type="submit" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['submit_name'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Сохранить') : smarty_modifier_default($_tmp, 'Сохранить')); ?>
">
</form>

