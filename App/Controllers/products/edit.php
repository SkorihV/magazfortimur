<?php
$id = Request::getIntFromGet('id');
$product = [];

if ($id) {
    $product = Product::getById($id);
}

if (Request::isPost()) {

    $product = Product::getFromPost();

    $edited = Product::uploadById($id, $product);


    if ($edited) {
        Response::redirect('/products/list');
    } else {
        die('какая то ошибка сзаза');
    }
}

$categories = Category::getList();

$smarty->assign("categories", $categories);
$smarty->assign('product', $product);
$smarty->display('products/edit.tpl');
