<?php

$category_id = (int) $_GET['id'] ?? 0;

$category = get_category_by_id($connect, $category_id);
$products = get_product_list_by_category_id($connect, $category_id);


$smarty->assign('current_category', $category);
$smarty->assign("products", $products);
$smarty->display('categories/view.tpl');