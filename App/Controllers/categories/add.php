<?php

    if (!empty($_POST)) {
        $category  = Category::getFromPost();
        $insert = Category::add($connect, $category);

        if ($insert) {
            header('Location: /categories/list');
        } else {
            die('какая то ошибка сзаза');
        }
    }

$smarty->display('categories/add.tpl');

