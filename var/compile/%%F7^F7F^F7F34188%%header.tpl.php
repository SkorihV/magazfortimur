<?php /* Smarty version 2.6.31, created on 2021-08-27 15:46:43
         compiled from header.tpl */ ?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Список товаров</title>
    <link rel="stylesheet" href="/assets/styles.scss">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</head>
<body>
<div class="site-wrapper">
    <h1><?php echo $this->_tpl_vars['h1']; ?>
</h1>
    <ul class="top-menu">
        <li><a href="/products/list">Товарв</a></li>
        <li><a href="/categories/list">Категории</a></li>
    </ul>
    <p>
        <a href="/products/list">На главную</a>
    </p>
    <div class="main-wrapper">
        <div class="left-side">
            <div class="category-list">
                <?php $_from = $this->_tpl_vars['categories_shared']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['category']):
?>
                <div class="category-item">
                    <a href="/categories/view?id=<?php echo $this->_tpl_vars['category']['id']; ?>
" class="category-link <?php if ($this->_tpl_vars['current_category']['id'] == $this->_tpl_vars['category']['id']): ?>active<?php endif; ?>">
                        <?php echo $this->_tpl_vars['category']['name']; ?>

                    </a>
                </div>
                <?php endforeach; endif; unset($_from); ?>

            </div>
        </div>
        <div class="right-side">


