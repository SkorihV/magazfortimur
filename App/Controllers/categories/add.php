<?php

    if (!empty($_POST)) {
        $category  = get_category_from_post();
        $insert = add_category($connect, $category);

        if ($insert) {
            header('Location: /categories/list');
        } else {
            die('какая то ошибка сзаза');
        }
    }

$smarty->display('categories/add.tpl');

