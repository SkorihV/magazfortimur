<?php

    if (!empty($_POST)) {
        $product  = Product::getFromPost();
        $insert = Product::add($connect, $product);

        if ($insert) {
            header('Location: /products/list');
        } else {
            die('какая то ошибка сзаза');
        }
    }
$categories = Category::getList($connect);

$smarty->assign("categories", $categories);
$smarty->display('products/add.tpl');

