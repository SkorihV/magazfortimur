<?php
$id = $_GET['id'];
$id = (int) $id;

$product = [];

if ($id) {
    $product = Product::getById($connect, $id);
}


if (!empty($_POST)) {

    $product = Product::getFromPost();

    $edited = Product::uploadById($connect, $id, $product);

    if ($edited) {
        header('Location: /products/list');
    } else {
        die('какая то ошибка сзаза');
    }
}


$categories = Category::getList($connect);

$smarty->assign("categories", $categories);
$smarty->assign('product', $product);
$smarty->display('products/edit.tpl');

