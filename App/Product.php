<?php

class Product {

    public static function getListCount() {
        $query = "SELECT COUNT(1) as c FROM products p LEFT JOIN categories c ON p.category_id = c.id";
        $result = Db::query($query);

        $row = mysqli_fetch_assoc($result);

        return (int) ($row['c'] ?? 0);
    }

    public static function getList (int $limit = 100, int $offset = 0 ){
        $query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id  ORDER BY p.id  LIMIT $offset, $limit ";
        $result = Db::query($query);
        $products = [];

        while  ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }

        return $products;
    }

     public static function getListByCategoryId ($category_id) {
        $query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.category_id = $category_id";
        $result = Db::query($query);
        $products = [];

        while  ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }

        return $products;
    }

     public static function getById($id){

        $query = "SELECT p.*, c.id as category_id FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = $id";
        $result = Db::query($query);

        $product = mysqli_fetch_assoc($result);

        if (is_null($product)) {
            $product = [];
        }

        return $product;
    }

    public static function uploadById($id, $product){
        $name = $product['name'] ?? '';
        $article = $product['article'] ?? '';
        $price = $product['price'] ?? '';
        $amount = $product['amount'] ?? '';
        $description = $product['description'] ?? '';
        $category_id = $product['category_id'] ?? '';

        $query = "UPDATE products SET name = '$name', article = '$article', price = '$price', amount = '$amount', description = '$description', category_id = '$category_id' WHERE id = '$id'";
        Db::query($query);

        return Db::affectedRows();
    }

    public static function add ($product){
        $name = $product['name'] ?? '';
        $article = $product['article'] ?? '';
        $price = $product['price'] ?? '';
        $amount = $product['amount'] ?? '';
        $description = $product['description'] ?? '';
        $category_id = $product['category_id'] ?? '';

        $query = "INSERT INTO products(name,article,price, amount, description, category_id) VALUES ('$name','$article','$price', '$amount', '$description', '$category_id')";
        Db::query($query);

        return Db::affectedRows();
    }

    public static function deleteById($id){
        $query = "DELETE FROM products WHERE id = $id";

        Db::query($query);
        return Db::affectedRows();
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