<?php
$id = $_GET['id'];
$id = (int) $id;

$category = [];

if ($id) {
    $category = get_category_by_id($connect, $id);
}


if (!empty($_POST)) {

    $category = get_category_from_post();

    $edited = upload_category_by_id($connect, $id, $category);

    if ($edited) {
        header('Location: /categories/list');
    } else {
        die('какая то ошибка сзаза');
    }
}



$smarty->assign('category', $category);
$smarty->display('categories/edit.tpl');

