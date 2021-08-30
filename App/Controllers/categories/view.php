<?php

use App\Category;
use App\Product;
use App\Request;

$category_id = Request::getIntFromGet('id');

$category = Category::getById( $category_id);
$products = Product::getListByCategoryId($category_id);

$smarty->assign('current_category', $category);
$smarty->assign("products", $products);
$smarty->display('categories/view.tpl');