<?php

    if (!empty($_POST)) {
        $product  = Product::getFromPost();
        $insert = Product::add($product);

        if ($insert) {
            header('Location: /products/list');
        } else {
            die('какая то ошибка сзаза');
        }
    }
$categories = Category::getList();

$smarty->assign("categories", $categories);
$smarty->display('products/add.tpl');

