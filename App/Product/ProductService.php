<?php

namespace App\Product;

use App\Db\Db;
use App\Request;

class ProductService {

    public function getListCount() {
        $query = "SELECT COUNT(1) as c FROM products p LEFT JOIN categories c ON p.category_id = c.id";
        return Db::fetchOne($query);
    }

    public function getList (int $limit = 100, int $offset = 0 ){
        $query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id  ORDER BY p.id  LIMIT $offset, $limit ";

        $products =  Db::fetchAll($query);
        foreach ($products as &$product) {
            $images = ProductImages::getListProductId($product['id']);
            $product['images'] = $images;
        }

        return $products;
    }

     public function getListByCategoryId ($category_id) {
        $query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.category_id = $category_id";

         $products =  Db::fetchAll($query);
         foreach ($products as &$product) {
             $images = ProductImages::getListProductId($product['id']);
             $product['images'] = $images;
         }
         return $products;
    }

     public function getById($id){

        $query = "SELECT p.*, c.id as category_id FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = $id";

        $product =  Db::fetchRow($query);
        $product['images'] = ProductImages::getListProductId($id);

        return $product;
    }

    public function uploadById(int $id, array $product): int
    {
        return Db::update('products', $product, "id = $id");
    }

    public function add ($product){

        if (isset($product['id'])){
            unset($product['id']);
        }
        return Db::insert("products", $product);
    }

    public function deleteById(int $id){

        $path = APP_UPLOAD_PRODUCTS_DIR . '/' . $id;
        delDir($path);

        ProductImages::deleteByProductId($id);

        return Db::delete('products', "id = $id");
    }

    public function getDataFromPost (Request $request) : array
    {
        return [
            'id'             => $request->getIntFromPost('id', false),
            'name'           => $request->getStrFromPost('name'),
            'article'        => $request->getStrFromPost('article'),
            'price'          => $request->getIntFromPost('price'),
            'amount'         => $request->getStrFromPost('amount'),
            'description'    => $request->getStrFromPost('description'),
            'category_id'    => $request->getIntFromPost('category_id', 0)
        ];

    }

    public function getByField(string $mainField,string $value)
    {
        $mainField = Db::escape($mainField);
        $value = Db::escape($value);
        $query = "SELECT * FROM products WHERE `$mainField` = '$value'";

        return Db::fetchRow($query);
    }
}