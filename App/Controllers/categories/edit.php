<?php
$id = $_GET['id'];
$id = (int) $id;

$category = [];

if ($id) {
    $category = Category::getById($id);
}

if (!empty($_POST)) {

    $category = Category::getFromPost();

    $edited = Category::uploadById($id, $category);

    if ($edited) {
        header('Location: /categories/list');
    } else {
        die('какая то ошибка сзаза');
    }
}



$smarty->assign('category', $category);
$smarty->display('categories/edit.tpl');

