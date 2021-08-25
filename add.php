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

    if (!empty($_POST)) {
        $name = $_POST['name'] ?? '';
        $article = $_POST['article'] ?? '';
        $price = $_POST['price'] ?? '';
        $amount = $_POST['amount'] ?? '';
        $description = $_POST['description'] ?? '';


        $connect = connect();

        $query = "INSERT INTO products(name,article,price, amount, description) VALUES ('$name','$article','$price', '$amount', '$description')";
        $result = query($connect, $query);

        if (mysqli_affected_rows($connect)) {
            header('Location: /');
        } else {
            die('какая то ошибка сзаза');
        }
    }
?>

<form action="" method="post">
    <label>
        Название : <input type="text" name="name" required >
    </label>
    <label>
        Артикул : <input type="text" name="article" >
    </label>
    <label>
        Цена : <input type="text" name="price" >
    </label>
    <label>
        Количество : <input type="text" name="amount">
    </label>
    <label>
        Описание : <input type="text" name="description">
    </label>
    <input type="submit" value="Добавить">
</form>
