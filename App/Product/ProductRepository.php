<?php

namespace App\Product;

use App\Category\Category;
use App\Db\Db;
use App\ProductImages;

class ProductRepository
{

    public function getProductFromArray(array $data): Product
    {
        $id             = $data['id'];

        $name           = $data['name'] ?? null;
        $price          = $data['price'] ?? null;
        $amount         = $data['amount'] ?? null;

        $article        = $data['article'] ?? '';
        $description    = $data['description'] ?? '';

        if (is_null($name)) {
            throw new \Exception('Имя для инициализации товара обязательно');
        }
        if (is_null($price)) {
            throw new \Exception('Цена для инициализации товара обязательно');
        }
        if (is_null($amount)) {
            throw new \Exception('Количество для инициализации товара обязательно');
        }

        $categoryId     = $data['category_id'] ?? 0;

        $product = new Product($name, $price, $amount);

        if ($categoryId > 0 ) {
            $categoryName   = $productArray['category_name'] ?? '';
            $category       = new Category($categoryName);
            $category->setId($categoryId);
            $product->setCategory($category);
        }

        $product
            ->setId($id)
            ->setArticle($article)
            ->setDescription($description);

        return $product;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Product[]
     */
    public function getList(int $limit = 50, int $offset = 0): array
    {
        $query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id  ORDER BY p.id  LIMIT $offset, $limit ";

        $result =  Db::query($query);

        $products = [];
        while   ($productArray = Db::fetchAssoc($result)) {
            $product = $this->getProductFromArray($productArray);
            $products[] = $product;
        }


//        foreach ($products as &$product) {
//            $images = ProductImages::getListProductId($product['id']);
//            $product['images'] = $images;
//        }

        return $products;
    }
}