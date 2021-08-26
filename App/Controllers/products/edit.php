<?php
$id = $_GET['id'];
$id = (int) $id;

$product = [];

if ($id) {
    $product = get_product_by_id($connect, $id);
}


if (!empty($_POST)) {

    $product = get_product_from_post();

    $edited = upload_product_by_id($connect, $id, $product);

    if ($edited) {
        header('Location: /products/list');
    } else {
        die('какая то ошибка сзаза');
    }
}


$categories = get_category_list($connect);

$smarty->assign("categories", $categories);
$smarty->assign('product', $product);
$smarty->display('products/edit.tpl');

