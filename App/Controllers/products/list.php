<?php
$current_page = (int) $_GET['p'] ?? 0;
$limit = 4;

$offset = ($current_page - 1) * $limit;


$products = get_product_list($connect, $limit, $offset);

$products_count = get_product_list_count($connect);
$pages_count = ceil($products_count / $limit);



$smarty->assign('pages_count', $pages_count);
$smarty->assign('products', $products);
$smarty->display('products/index.tpl');




