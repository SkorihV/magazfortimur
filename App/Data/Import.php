<?php

namespace App\Data;

use App\Data\Category\CategoryService;
use App\Db\Db;
use App\Data\Product\ProductImagesService;
use App\Data\Product\ProductService;

class Import
{
    public static function productsFromFileTask(array $params, array $fields)
    {

        $categoryService = new CategoryService;
        $productService = new ProductService;
        $productImagesService = new ProductImagesService;

        $filename = $params['filename'] ?? null;

        if(is_null($filename)) {
            return false;
        }
        $filePath = APP_UPLOAD_DIR . '/import/' . $filename;

        $file = fopen($filePath, 'r');
        $withHeader = true;
//        $settings = [
//            0 =>'name',
//            1 => 'category_name',
//            2 => 'article',
//            3 => 'price',
//            4 => 'amount',
//            5 => 'description',
//            6 => 'image_urls',
//        ];

        $mainField = 'article';

        if ($withHeader) {
            $headers = fgetcsv($file);
        }


        while ($row = fgetcsv($file)) {

            $product = array_combine($fields, $row);

            $image_urls = $product['image_url'] ?? null;
            unset($product['image_url']);



            foreach ($product as $key => $value) {

                $product[$key] = Db::escape($value);
            }

            $productData = [];

//            foreach ($fields as $index => $key) {
//
//                $productData[$key] = $row[$index] ?? null;
//            }
//            $product = [
//                'name'           => Db::escape($productData['name']),
//                'article'        => Db::escape($productData['article']),
//                'price'          => Db::escape($productData['price']),
//                'amount'         => Db::escape($productData['amount']),
//                'description'    => Db::escape($productData['description']),
//            ];


            $categoryName = $product['category_id'];

            $category = $categoryService->getByName($categoryName);

            if (empty($category)) {
                $categoryId =  $categoryService->add([
                    'name' => $categoryName,
                ]);
            } else {
                $categoryId = $category['id'];
            }
            $product['category_id'] = $categoryId;



            $targetProduct = $productService->getByField($mainField, $product[$mainField]);


            if (empty($targetProduct)) {
                $productId = $productService->add($product);
                echo "<pre>";
                var_dump($product);
                echo "</pre>";

            } else {
                $productId = $targetProduct['id'];
                $targetProduct = array_merge($targetProduct, $product);
                echo "<pre>";
                var_dump($productId, $targetProduct);
                echo "</pre>";

                $productService->uploadById($productId, $targetProduct);



            }

exit;
            $productData['image_urls'] = explode("\n", $image_urls);
            $productData['image_urls'] = array_map(function ($item) {
                return trim($item);
            }, $productData['image_urls']);
            $productData['image_urls'] = array_filter($productData['image_urls'],function ($item) {
                return !empty($item);
            });

            foreach ($productData['image_urls'] as $imageUrl) {
                $productImagesService->uploadImageByUrl($productId, $imageUrl);
            }
        }

        return  true;
    }
}