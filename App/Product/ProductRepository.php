<?php

namespace App\Product;

use App\Category;
use App\Category\CategoryModel;
use App\Db\Db;
use App\ProductImages;
use App\ProductImages as ProductImageService;

class ProductRepository
{
    public function getById(int $id)
    {
        $query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = $id";

        $productArray =  Db::fetchRow($query);
        $product = $this->getProductFromArray($productArray);

        $imagesData = ProductImageService::getListProductId($product->getId());
        foreach ($imagesData as &$imageItem) {
            $productImage = $this->getProductImageFromArray($imageItem);

            $product->addImage($productImage);
        }

        return $product;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return ProductModel[]
     */
    public function getList(int $limit = 50, int $offset = 0): array
    {
        $query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id  ORDER BY p.id  LIMIT $offset, $limit ";


        $result =  Db::query($query);

        $products = [];
        while   ($productArray = Db::fetchAssoc($result)) {
            $product = $this->getProductFromArray($productArray);


            $imagesData = ProductImageService::getListProductId($product->getId());
            foreach ($imagesData as &$imageItem) {
                $productImage = $this->getProductImageFromArray($imageItem);

                $product->addImage($productImage);
            }

            $products[] = $product;
        }

        return $products;
    }

    public function save(ProductModel $product): ProductModel
    {
        $id = $product->getId();
        $productArray = $this->productToArray($product);


        if ($id) {
            Db::update('products', $productArray, "id = $id");
            return $product;

        }
        $id = Db::insert("products", $productArray);

        $product->setId($id);

        return $product;

    }

    public function productToArray(ProductModel $product)
    {
        $data =  [
            'name'          => $product->getName(),
            'article'       => $product->getArticle(),
            'amount'        => $product->getAmount(),
            'price'         => $product->getPrice(),
            'description'   => $product->getDescription(),
            'category_id'   => $product->getCategory()->getId(),
        ];
        $category = $product->getCategory();

        if (!is_null($category)) {
            $data['category_id'] = $category->getId();
        }

        return $data;
    }

    /**
     * @param array $data
     * @return ProductModel
     * @throws \Exception
     */
    public function getProductFromArray(array $data): ProductModel
    {
        $id             = $data['id'];

        $name           = $data['name'] ?? null;
        $price          = $data['price'] ?? null;
        $amount         = $data['amount'] ?? null;

        if (is_null($name)) {
            throw new \Exception('Имя для инициализации товара обязательно');
        }
        if (is_null($price)) {
            throw new \Exception('Цена для инициализации товара обязательно');
        }
        if (is_null($amount)) {
            throw new \Exception('Количество для инициализации товара обязательно');
        }

        $article        = $data['article']      ?? '';
        $description    = $data['description']  ?? '';
        $categoryId     = $data['category_id']  ?? 0;


        $product = new ProductModel($name, $price, $amount);

        if ($categoryId > 0 ) {
            $categoryName   = $productArray['category_name'] ?? null;

            if (is_null($categoryName)) {

                $categoryData = Category::getById($categoryId);
                $categoryName = $categoryData['name'];

            }

            $category = new CategoryModel($categoryName);

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
     * @param array $data
     * @return ProductImageModel
     */
    public function getProductImageFromArray(array $data): ProductImageModel
    {
        $productImage = new ProductImageModel();

        $productImage
            ->setId($data['id'])
            ->setName($data['name'])
            ->setPath($data['path'])
            ->setSize($data['size']);

        return $productImage;
    }
}