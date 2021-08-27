<?php

$current_page = Request::getIntFromGet('p', 1);
$limit = 5;

$offset = ($current_page - 1) * $limit;

$products = Product::getList($limit, $offset);

$products_count = Product::getListCount();
$pages_count = ceil($products_count / $limit);

$smarty->assign('pages_count', $pages_count);
$smarty->assign('products', $products);
$smarty->display('products/index.tpl');




