<?php
require_once "db.php";

$id = $_POST['id'] ?? 0;
$id = (int) $id;

if (!$id) {
    die ("error");
}

$connect = connect();

$query = "DELETE FROM products WHERE id = $id";

$result = query($connect, $query);

if (mysqli_affected_rows($connect)) {
    header('Location: /');
} else {
    die('какая то ошибка сзаза');
}