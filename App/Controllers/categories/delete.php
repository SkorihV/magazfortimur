<?php

$id = $_POST['id'] ?? 0;
$id = (int) $id;

if (!$id) {
    die ("error");
}


$deleted =  Category::deleteById($id);

if ($deleted) {
    header('Location: /categories/list');
} else {
    die('какая то ошибка сзаза');
}