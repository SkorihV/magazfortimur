<?php

function get_product_list ($connect){
    $query = "SELECT * FROM products";
    $result = query($connect, $query);
    $products = [];

    while  ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }

    return $products;
}

function get_product_by_id($connect, $id){

    $query = "SELECT * FROM products WHERE id = $id";
    $result = query($connect,$query);

    $product = mysqli_fetch_assoc($result);

    if (is_null($product)) {
        $product = [];
    }

    return $product;
}

function upload_product_by_id($connect, $id, $product){
    $name = $product['name'] ?? '';
    $article = $product['article'] ?? '';
    $price = $product['price'] ?? '';
    $amount = $product['amount'] ?? '';
    $description = $product['description'] ?? '';

    $query = "UPDATE products SET name = '$name', article = '$article', price = '$price', amount = '$amount', description = '$description' WHERE id = '$id'";
    query($connect,$query);

    return mysqli_affected_rows($connect);
}

function add_product($connect, $product){
    $name = $product['name'] ?? '';
    $article = $product['article'] ?? '';
    $price = $product['price'] ?? '';
    $amount = $product['amount'] ?? '';
    $description = $product['description'] ?? '';

    $query = "INSERT INTO products(name,article,price, amount, description) VALUES ('$name','$article','$price', '$amount', '$description')";
    query($connect, $query);

    return mysqli_affected_rows($connect);
}

function delete_product_by_id($connect, $id){
    $query = "DELETE FROM products WHERE id = $id";

    query($connect, $query);
    return mysqli_affected_rows($connect);
}

function get_product_from_post () {

    return [
        'name'           => $_POST['name'] ?? '',
        'article'        => $_POST['article'] ?? '',
        'price'          => $_POST['price'] ?? '',
        'amount'         => $_POST['amount'] ?? '',
        'description'    => $_POST['description'] ?? ''
    ];

}