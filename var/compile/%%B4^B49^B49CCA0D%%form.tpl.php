<?php /* Smarty version 2.6.31, created on 2021-08-26 09:57:27
         compiled from products/form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'products/form.tpl', 23, false),)), $this); ?>
<form action="" method="post" class="form">
    <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['product']['id']; ?>
">
    <label>
        <div class="div-label">Название : </div>
        <input type="text" name="name" required value="<?php echo $this->_tpl_vars['product']['name']; ?>
">
    </label>
    <label>
        <div class="div-label">Артикул : </div>
        <input type="text" name="article" value="<?php echo $this->_tpl_vars['product']['article']; ?>
">
    </label>
    <label>
        <div class="div-label">Цена : </div>
        <input type="text" name="price" value="<?php echo $this->_tpl_vars['product']['price']; ?>
">
    </label>
    <label>
        <div class="div-label">Количество : </div>
        <input type="text" name="amount" value="<?php echo $this->_tpl_vars['product']['amount']; ?>
">
    </label>
    <label>
        <div class="div-label">Описание : </div>
        <input type="text" name="description" value="<?php echo $this->_tpl_vars['product']['description']; ?>
">
    </label>
    <input type="submit" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['submit_name'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Сохранить') : smarty_modifier_default($_tmp, 'Сохранить')); ?>
">
</form>