<?php
$id = Request::getIntFromGet('id', false);

$category = [];

if ($id) {
    $category = Category::getById($id);
}

if (Request::isPost()) {

    $category = Category::getFromPost();

    $edited = Category::uploadById($id, $category);

    if ($edited) {
        Response::redirect('/categories/list');
    } else {
        die('какая то ошибка сзаза');
    }
}

$smarty->assign('category', $category);
$smarty->display('categories/edit.tpl');
