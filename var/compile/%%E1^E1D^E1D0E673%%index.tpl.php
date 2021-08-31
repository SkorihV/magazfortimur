<?php /* Smarty version 2.6.31, created on 2021-08-31 10:59:37
         compiled from products/index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('h1' => "Список товаров")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<p>
    <a href='/products/add'>Добавить</a>
</p>

        <nav>
            <ul class="pagination">
                <?php unset($this->_sections['pagination']);
$this->_sections['pagination']['loop'] = is_array($_loop=$this->_tpl_vars['pages_count']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['pagination']['name'] = 'pagination';
$this->_sections['pagination']['show'] = true;
$this->_sections['pagination']['max'] = $this->_sections['pagination']['loop'];
$this->_sections['pagination']['step'] = 1;
$this->_sections['pagination']['start'] = $this->_sections['pagination']['step'] > 0 ? 0 : $this->_sections['pagination']['loop']-1;
if ($this->_sections['pagination']['show']) {
    $this->_sections['pagination']['total'] = $this->_sections['pagination']['loop'];
    if ($this->_sections['pagination']['total'] == 0)
        $this->_sections['pagination']['show'] = false;
} else
    $this->_sections['pagination']['total'] = 0;
if ($this->_sections['pagination']['show']):

            for ($this->_sections['pagination']['index'] = $this->_sections['pagination']['start'], $this->_sections['pagination']['iteration'] = 1;
                 $this->_sections['pagination']['iteration'] <= $this->_sections['pagination']['total'];
                 $this->_sections['pagination']['index'] += $this->_sections['pagination']['step'], $this->_sections['pagination']['iteration']++):
$this->_sections['pagination']['rownum'] = $this->_sections['pagination']['iteration'];
$this->_sections['pagination']['index_prev'] = $this->_sections['pagination']['index'] - $this->_sections['pagination']['step'];
$this->_sections['pagination']['index_next'] = $this->_sections['pagination']['index'] + $this->_sections['pagination']['step'];
$this->_sections['pagination']['first']      = ($this->_sections['pagination']['iteration'] == 1);
$this->_sections['pagination']['last']       = ($this->_sections['pagination']['iteration'] == $this->_sections['pagination']['total']);
?>
                    <li class="page-item <?php if ($_GET['p'] == $this->_sections['pagination']['iteration']): ?>active <?php endif; ?>">
                        <a class="page-link" href="<?php echo $_SERVER['PATH_INFO']; ?>
?p=<?php echo $this->_sections['pagination']['iteration']; ?>
">
                            <?php echo $this->_sections['pagination']['iteration']; ?>

                        </a>
                    </li>
                <?php endfor; endif; ?>
            </ul>
        </nav>

        <table class="table-products">
            <thead>
                <th>#</th>
                <th>Название товара</th>
                <th>Категория</th>
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
                <td><?php echo $this->_tpl_vars['product']->getId(); ?>
</td>
                <td><?php echo $this->_tpl_vars['product']->getName(); ?>

                                    </td>
                <?php $this->assign('productCategory', $this->_tpl_vars['product']->getCategory()); ?>
                <td><?php echo $this->_tpl_vars['productCategory']->getName(); ?>
</td>
                <td><?php echo $this->_tpl_vars['product']->getArticle(); ?>
</td>
                <td><?php echo $this->_tpl_vars['product']->getPrice(); ?>
</td>
                <td><?php echo $this->_tpl_vars['product']->getAmount(); ?>
</td>
                <td><?php echo $this->_tpl_vars['product']->getDescription(); ?>
</td>
                <td><a href='/products/edit?id=<?php echo $this->_tpl_vars['product']->getId(); ?>
'>Редактировать</a></td>
                <td><form action="/products/delete" method="post" style="display:inline"><input type="hidden" name="id" value="<?php echo $this->_tpl_vars['product']->getId(); ?>
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