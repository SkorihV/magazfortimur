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

$products = get_product_list($connect);
$smarty->assign('products', $products);
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


