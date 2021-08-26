<?php

$id = $_POST['id'] ?? 0;
$id = (int) $id;

if (!$id) {
    die ("error");
}


$deleted =  delete_product_by_id($connect,$id);

if ($deleted) {
    header('Location: /products/list');
} else {
    die('какая то ошибка сзаза');
}