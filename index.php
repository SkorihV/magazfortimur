<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
require_once "db.php";
require_once('libs/Smarty/Smarty.class.php');

$smarty = new Smarty();
$smarty->template_dir = __DIR__ . '/templates';
$smarty->compile_dir = __DIR__ . '/var/compile';
$smarty->cache_dir = __DIR__ . '/var/cache';
$smarty->config_dir = __DIR__ . '/var/configs';

$connect = connect();

$query = "SELECT * FROM products";
$result = query($connect, $query);

$smarty->display('products/index.tpl');

//echo "<a href='/add.php'>Добавить</a>";
//echo "<table border='1' cellpadding='3'>";
//while ($row = mysqli_fetch_assoc($result)) {
//
//        echo "<tr>";
//    foreach ($row as $field => $value) {
//        echo "<td>";
//        echo "$field : $value";
//        echo "</td>";
//    }
//    $id = $row['id'];
//    echo "<td>";
//    echo "<a href='/edit.php?id=$id'>Редактировать</a>";
//    echo "</td>";
//        echo "<td>";
//        echo '<form action="/delete.php" method="post" style="display:inline"><input type="hidden" name="id" value="' . $id . '"><input type="submit" value="Удалить"></form>';
//        echo "</td>";
//        echo "</tr>";
//
//}
//echo "</table>";
//
//?>


