<?php /* Smarty version 2.6.31, created on 2021-08-30 16:14:00
         compiled from queue/list.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('h1' => "Список задач")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<table class="table-products">
    <thead>
    <th>#</th>
    <th>Название задачи</th>
    <th>Статус задачи</th>
    <th>#</th>
    <th>#</th>
    </thead>
    <tbody>
    <?php $_from = $this->_tpl_vars['tasks_queue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['task']):
?>
        <tr>
            <td><?php echo $this->_tpl_vars['task']['id']; ?>
</td>
            <td><?php echo $this->_tpl_vars['task']['name']; ?>
</td>
            <td><?php echo $this->_tpl_vars['task']['status']; ?>
</td>
            <td><a href='/queue/run?id=<?php echo $this->_tpl_vars['task']['id']; ?>
'>Зап</a></td>
            <td><form action="/queue/delete" method="post" style="display:inline"><input type="hidden" name="id" value="<?php echo $this->_tpl_vars['task']['id']; ?>
"><input type="submit" value="Удалить"></form></td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
    </tbody>
</table>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>