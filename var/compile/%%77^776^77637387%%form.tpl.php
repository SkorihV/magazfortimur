<?php /* Smarty version 2.6.31, created on 2021-08-26 13:05:13
         compiled from categories/form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'categories/form.tpl', 7, false),)), $this); ?>
<form action="" method="post" class="form">
    <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['category']['id']; ?>
">
    <label>
        <div class="div-for-label">Название категории: </div>
        <input type="text" name="name" required value="<?php echo $this->_tpl_vars['category']['name']; ?>
">
    </label>
    <input type="submit" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['submit_name'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Сохранить') : smarty_modifier_default($_tmp, 'Сохранить')); ?>
">
</form>