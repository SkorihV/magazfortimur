<?php

$category = get_category_list($connect);
$smarty->assign('categories', $category);
$smarty->display('categories/index.tpl');




