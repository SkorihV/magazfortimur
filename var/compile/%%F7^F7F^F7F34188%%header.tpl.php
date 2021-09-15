<?php /* Smarty version 2.6.31, created on 2021-09-15 17:23:17
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
        <li><a href="/import/index">Импорт</a></li>
        <li><a href="/queue/list">Задачи</a></li>

        <?php if ($this->_tpl_vars['user']): ?>
           <li><span class="menu-item "><?php echo $this->_tpl_vars['user']->getName(); ?>
</span></li>
        <?php else: ?>
            <li><a href="/user/register">Регистрация</a></li>
        <?php endif; ?>
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
                    <a href="/categories/view?id=<?php echo $this->_tpl_vars['category']->getId(); ?>
" class="category-link <?php if ($this->_tpl_vars['current_category']['id'] == $this->_tpl_vars['category']->getId()): ?>active<?php endif; ?>">
                        <?php echo $this->_tpl_vars['category']->getName(); ?>

                    </a>
                </div>
                <?php endforeach; endif; unset($_from); ?>

                <form action="/user/auth" method="post">

                    <div class="form-group">
                        <label for="user-email">Email</label>
                        <input name="email"<?php if ($_POST['email']): ?>value="<?php echo $_POST['email']; ?>
"<?php endif; ?> type="email" class="form-control" id="user-email" placeholder="name@example.com">
                        <?php if ($this->_tpl_vars['error']['requiredFields']['email']): ?><div class="alert alert-danger">Заполните обязательное поле</div><?php endif; ?>

                    </div>
                    <br>

                    <div class="form-group">
                        <label for="user-password">Пароль</label>
                        <input name="password"  type="password" class="form-control" id="user-password" placeholder="Введите пароль">
                        <?php if ($this->_tpl_vars['error']['requiredFields']['password']): ?><div class="alert alert-danger">Заполните обязательное поле</div><?php endif; ?>

                    </div>
                    <br>

                    <button type="submit" class="btn btn-primary">Авторизироваться</button>

                </form>

            </div>
        </div>




        <div class="right-side">


