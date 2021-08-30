<?php

class Product {

    public static function getListCount() {
        $query = "SELECT COUNT(1) as c FROM products p LEFT JOIN categories c ON p.category_id = c.id";
        return Db::fetchOne($query);
    }

    public static function getList (int $limit = 100, int $offset = 0 ){
        $query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id  ORDER BY p.id  LIMIT $offset, $limit ";

        $products =  Db::fetchAll($query);
        foreach ($products as &$product) {
            $images = ProductImages::getListProductId($product['id']);
            $product['images'] = $images;
        }

        return $products;
    }

     public static function getListByCategoryId ($category_id) {
        $query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.category_id = $category_id";

         $products =  Db::fetchAll($query);
         foreach ($products as &$product) {
             $images = ProductImages::getListProductId($product['id']);
             $product['images'] = $images;
         }
         return $products;
    }

     public static function getById($id){

        $query = "SELECT p.*, c.id as category_id FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = $id";

        $product =  Db::fetchRow($query);
        $product['images'] = ProductImages::getListProductId($id);

        return $product;
    }

    public static function uploadById(int $id, array $product): int
    {
        return Db::update('products', $product, "id = $id");
    }

    public static function add ($product){

        if (isset($product['id'])){
            unset($product['id']);
        }
        return Db::insert("products", $product);
    }

    public static function deleteById(int $id){

        $path = APP_UPLOAD_PRODUCTS_DIR . '/' . $id;
        delDir($path);

        ProductImages::deleteByProductId($id);

        return Db::delete('products', "id = $id");
    }

    public static function getDataFromPost () : array
    {
        return [
            'id'             => Request::getIntFromPost('id', false),
            'name'           => Request::getStrFromPost('name'),
            'article'        => Request::getStrFromPost('article'),
            'price'          => Request::getIntFromPost('price'),
            'amount'         => Request::getStrFromPost('amount'),
            'description'    => Request::getStrFromPost('description'),
            'category_id'    => Request::getIntFromPost('category_id')
        ];
    }
}