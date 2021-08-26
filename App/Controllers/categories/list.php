<?php


$category = Category::getList($connect);
$smarty->assign('categories', $category);
$smarty->display('categories/index.tpl');




