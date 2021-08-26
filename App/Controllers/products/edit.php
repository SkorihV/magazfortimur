<?php
$id = $_GET['id'];
$id = (int) $id;

$product = [];

if ($id) {
    $product = Product::getById($id);
}


if (!empty($_POST)) {

    $product = Product::getFromPost();

    $edited = Product::uploadById($id, $product);

    if ($edited) {
        header('Location: /products/list');
    } else {
        die('какая то ошибка сзаза');
    }
}


$categories = Category::getList();

$smarty->assign("categories", $categories);
$smarty->assign('product', $product);
$smarty->display('products/edit.tpl');

