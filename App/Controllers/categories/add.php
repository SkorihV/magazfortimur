<?php

    if (Request::isPost()) {
        $category  = Category::getFromPost();
        $insert = Category::add($category);


        if ($insert) {
            Response::redirect('/categories/list');
        } else {
            die('какая то ошибка сзаза');
        }
    }

$smarty->display('categories/add.tpl');
