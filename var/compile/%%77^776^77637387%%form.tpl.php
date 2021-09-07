<?php /* Smarty version 2.6.31, created on 2021-09-07 12:52:47
         compiled from categories/form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'categories/form.tpl', 7, false),)), $this); ?>
<form action="" method="post" class="form">
    <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['category']->getId(); ?>
">
    <div class="label-wrapper">
        <div class="div-for-label">Название категории: </div>
        <input type="text" name="name" required value="<?php echo $this->_tpl_vars['category']->getName(); ?>
">
    </div>
    <input type="submit" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['submit_name'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Сохранить') : smarty_modifier_default($_tmp, 'Сохранить')); ?>
">
</form>