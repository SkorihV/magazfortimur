<?php

class ProductImages
{
    public static function getById(int $id)
    {

        $query = "SELECT * FROM product_images WHERE id = $id";
        return Db::fetchRow($query);
    }

    public static function findByFilenameProduct(int $productId, string $filename)
    {
        $query = "SELECT * FROM product_images WHERE product_id = $productId AND name = '$filename'";
        return Db::fetchRow($query);
    }

    public static function uploadById(int $id, array $productImage): int
    {
        if (isset($productImage['id'])){
            unset($productImage['id']);
        }
        return Db::update('product_images', $productImage, "id = $id");
    }

    public static function add ($productImage): int
    {
        if (isset($productImage['id'])){
            unset($productImage['id']);
        }
        return Db::insert("product_images", $productImage);
    }

    public static function deleteById(int $productImageId): int
    {
        return Db::delete('product_images', "id = $productImageId");
    }

//    public static function getFromPost () : array
//    {
//        return [
//            'id'             => Request::getIntFromPost('id', false),
//            'name'           => Request::getStrFromPost('name'),
//            'article'        => Request::getStrFromPost('article'),
//            'price'          => Request::getIntFromPost('price'),
//            'amount'         => Request::getStrFromPost('amount'),
//            'description'    => Request::getStrFromPost('description'),
//            'category_id'    => Request::getIntFromPost('category_id')
//        ];
//    }
    public static function getListProductId(int $product_id)
    {
        $query = "SELECT * FROM product_images WHERE product_id = $product_id";
        return Db::fetchAll($query);
    }
}