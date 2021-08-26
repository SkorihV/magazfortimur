<?php

$id = $_POST['id'] ?? 0;
$id = (int) $id;

if (!$id) {
    die ("error");
}


$deleted =  delete_category_by_id($connect,$id);

if ($deleted) {
    header('Location: /categories/list');
} else {
    die('какая то ошибка сзаза');
}