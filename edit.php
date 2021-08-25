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

</body>
</html>

<?php

require_once "db.php";
$connect = connect();


$id = $_GET['id'];
$id = (int) $id;

$products = [];

if ($id) {
    $query = "SELECT * FROM products WHERE id = $id";
    $result = query($connect,$query);

    $products = mysqli_fetch_assoc($result);

    if (is_null($products)) {
        $products = [];
    }
}


if (!empty($_POST)) {
    $id = $_POST['id'] ?? 0;
    $name = $_POST['name'] ?? '';
    $article = $_POST['article'] ?? '';
    $price = $_POST['price'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $description = $_POST['description'] ?? '';


    $query = "UPDATE products SET name = '$name', article = '$article', price = '$price', amount = '$amount', description = '$description' WHERE id = '$id'";
    $result = query($connect,$query);

    if (mysqli_affected_rows($connect)) {
        header('Location: /');
    } else {
        die('какая то ошибка сзаза');
    }
}


?>

<form action="" method="post">
    <input type="hidden" name="id" value="<?php echo $products['id'] ?? 0; ?>">
    <label>
        Название : <input type="text" name="name" required value="<?php echo $products['name'] ?? ''; ?>" >
    </label>
    <label>
        Артикул : <input type="text" name="article" value="<?php echo $products['article'] ?? 0 ?>" >
    </label>
    <label>
        Цена : <input type="text" name="price" value="<?php echo $products['price'] ?? 0 ?>" >
    </label>
    <label>
        Количество : <input type="text" name="amount" value="<?php echo $products['amount'] ?? 0 ?>" >
    </label>
    <label>
        Описание : <input type="text" name="description" value="<?php echo $products['description'] ?? 0 ?>" >
    </label>
    <input type="submit" value="Сохранить">
</form>
