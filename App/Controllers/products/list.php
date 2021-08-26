<?php
$current_page = (int) $_GET['p'] ?? 0;
$limit = 4;

$offset = ($current_page - 1) * $limit;

if ($offset < 1) {
    $offset = 0;
}


$products = Product::getList($connect, $limit, $offset);


$products_count = Product::getListCount($connect);
$pages_count = ceil($products_count / $limit);


$smarty->assign('pages_count', $pages_count);
$smarty->assign('products', $products);
$smarty->display('products/index.tpl');




