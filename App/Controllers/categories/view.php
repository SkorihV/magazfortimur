<?php

$category_id = (int) $_GET['id'] ?? 0;

$category = Category::getById($connect, $category_id);
$products = Product::getListByCategoryId($connect, $category_id);


$smarty->assign('current_category', $category);
$smarty->assign("products", $products);
$smarty->display('categories/view.tpl');