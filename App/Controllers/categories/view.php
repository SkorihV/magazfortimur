<?php

$category_id = (int) $_GET['id'] ?? 0;

$category = Category::getById( $category_id);
$products = Product::getListByCategoryId($category_id);


$smarty->assign('current_category', $category);
$smarty->assign("products", $products);
$smarty->display('categories/view.tpl');