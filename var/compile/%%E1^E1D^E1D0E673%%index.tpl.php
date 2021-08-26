<?php /* Smarty version 2.6.31, created on 2021-08-26 11:27:40
         compiled from products/index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('h1' => "Список товаров")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<p>
    <a href='/products/add'>Добавить</a>
</p>
        <table class="table-products">
            <thead>
                <th>#</th>
                <th>Название товара</th>
                <th>Артикул</th>
                <th>Цена</th>
                <th>Количество на складе</th>
                <th>Описание</th>
                <th>#</th>
                <th>#</th>
            </thead>
            <tbody>
            <?php $_from = $this->_tpl_vars['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['product']):
?>
            <tr>
                <td><?php echo $this->_tpl_vars['product']['id']; ?>
</td>
                <td><?php echo $this->_tpl_vars['product']['name']; ?>
</td>
                <td><?php echo $this->_tpl_vars['product']['article']; ?>
</td>
                <td><?php echo $this->_tpl_vars['product']['price']; ?>
</td>
                <td><?php echo $this->_tpl_vars['product']['amount']; ?>
</td>
                <td><?php echo $this->_tpl_vars['product']['description']; ?>
</td>
                <td><a href='/products/edit?id=<?php echo $this->_tpl_vars['product']['id']; ?>
'>Редактировать</a></td>
                <td><form action="/products/delete" method="post" style="display:inline"><input type="hidden" name="id" value="<?php echo $this->_tpl_vars['product']['id']; ?>
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