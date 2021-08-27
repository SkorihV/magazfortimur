<?php

if (Request::isPost()) {
    $product  = Product::getFromPost();
    $insert = Product::add($product);

    if ($insert) {
       Response::redirect('/products/list');
    } else {
        die('какая то ошибка сзаза');
    }
}
$categories = Category::getList();


$smarty->assign("categories", $categories);
$smarty->display('products/add.tpl');
