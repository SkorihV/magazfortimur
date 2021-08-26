<?php

class Product {

    public static function getListCount($connect) {
        $query = "SELECT COUNT(1) as c FROM products p LEFT JOIN categories c ON p.category_id = c.id";
        $result = query($connect, $query);

        $row = mysqli_fetch_assoc($result);

        return (int) ($row['c'] ?? 0);
    }

    public static function getList ($connect, int $limit = 100, int $offset = 0 ){
        $query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id LIMIT $offset, $limit";
        $result = query($connect, $query);
        $products = [];

        while  ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }

        return $products;
    }

     public static function getListByCategoryId ($connect, $category_id) {
        $query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.category_id = $category_id";
        $result = query($connect, $query);
        $products = [];

        while  ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }

        return $products;
    }

     public static function getById($connect, $id){

        $query = "SELECT p.*, c.id as category_id FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = $id";
        $result = query($connect,$query);

        $product = mysqli_fetch_assoc($result);

        if (is_null($product)) {
            $product = [];
        }

        return $product;
    }

    public static function uploadById($connect, $id, $product){
        $name = $product['name'] ?? '';
        $article = $product['article'] ?? '';
        $price = $product['price'] ?? '';
        $amount = $product['amount'] ?? '';
        $description = $product['description'] ?? '';
        $category_id = $product['category_id'] ?? '';

        $query = "UPDATE products SET name = '$name', article = '$article', price = '$price', amount = '$amount', description = '$description', category_id = '$category_id' WHERE id = '$id'";
        query($connect,$query);

        return mysqli_affected_rows($connect);
    }

    public static function add ($connect, $product){
        $name = $product['name'] ?? '';
        $article = $product['article'] ?? '';
        $price = $product['price'] ?? '';
        $amount = $product['amount'] ?? '';
        $description = $product['description'] ?? '';
        $category_id = $product['category_id'] ?? '';

        $query = "INSERT INTO products(name,article,price, amount, description, category_id) VALUES ('$name','$article','$price', '$amount', '$description', '$category_id')";
        query($connect, $query);

        return mysqli_affected_rows($connect);
    }

    public static function deleteById($connect, $id){
        $query = "DELETE FROM products WHERE id = $id";

        query($connect, $query);
        return mysqli_affected_rows($connect);
    }

    public static function getFromPost () : array
    {

        return [
            'name'           => $_POST['name'] ?? '',
            'article'        => $_POST['article'] ?? '',
            'price'          => $_POST['price'] ?? '',
            'amount'         => $_POST['amount'] ?? '',
            'description'    => $_POST['description'] ?? '',
            'category_id'    => $_POST['category_id'] ?? ''

        ];

    }
}