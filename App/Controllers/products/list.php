<?php


$current_page = (int) $_GET['p'] ?? 0;
$limit = 5;

$offset = ($current_page - 1) * $limit;

if ($offset < 1) {
    $offset = 0;
}



$products = Product::getList($limit, $offset);


$products_count = Product::getListCount();
$pages_count = ceil($products_count / $limit);


$smarty->assign('pages_count', $pages_count);
$smarty->assign('products', $products);
$smarty->display('products/index.tpl');




