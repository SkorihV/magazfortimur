<?php


use App\Category;

$category = Category::getList();
$smarty->assign('categories', $category);
$smarty->display('categories/index.tpl');
