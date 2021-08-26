<?php /* Smarty version 2.6.31, created on 2021-08-26 09:41:12
         compiled from products/add.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('h1' => "Добавление товара")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

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

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>