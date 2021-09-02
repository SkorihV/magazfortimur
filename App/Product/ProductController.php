<?php

namespace App\Product;

use App\CategoryService;
use App\Category\CategoryModel;
use App\Renderer;
use App\Request;
use App\Response;
use App\Router\Route;

class ProductController
{
    /**
     * @var Route
     */
    private Route $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    public function list(Request $request, ProductRepository $productRepository)
    {
        $current_page = $request->getIntFromGet('p', 1);
        $limit = 10;

        $offset = ($current_page - 1) * $limit;

        $products_count = $productRepository->getListCount();
        $pages_count = ceil($products_count / $limit);

        $products = $productRepository->getList($limit, $offset);

//$products = Product::getList($limit, $offset);


        Renderer::getSmarty()->assign('pages_count', $pages_count);
        Renderer::getSmarty()->assign('products', $products);
        Renderer::getSmarty()->display('products/index.tpl');
    }

    public function edit(Request $request,
                         ProductRepository $productRepository,
                         ProductService $productService,
                         ProductImagesService $productImagesService,
                         Response $response,
                         CategoryService $categoryService)
    {

        $productId = $request->getIntFromGet('id', null);
        if (is_null($productId)) {
            $productId = $this->route->getParam('id');
        }

        $product = [];

        if ($productId) {
            $product = $productRepository->getById($productId);
        }

        if ($request->isPost()) {

            $productData = $productService->getDataFromPost($request);

            $product->setName(($productData['name']));
            $product->setAmount(($productData['amount']));
            $product->setArticle(($productData['article']));
            $product->setPrice(($productData['price']));
            $product->setDescription(($productData['description']));

            $categoryId = $productData['category_id'] ?? 0;
            if ($categoryId) {
                $categoryData = $categoryService->getById($categoryId);
                $categoryName = $categoryData['name'];

                $category = new CategoryModel($categoryName);
                $category->setId($categoryId);

                $product->setCategory($category);
            }

            $product = $productRepository->save($product);

            /* Начало загрузки изображений*/

//    $path = APP_UPLOAD_PRODUCTS_DIR . '/' . $productId;
//
//    if(!file_exists($path)) {
//        mkdir($path);
//    }

            $imageUrl = trim($_POST['image_url']);
            $productImagesService->uploadImageByUrl($productId, $imageUrl);

            /* Начало загрузки изображений*/

            $uploadImages = $_FILES['images'] ?? [];
            $productImagesService->uploadImages($productId, $uploadImages);

            /* конец загрузки изображений*/

            $response->redirect('/products/list');
        }

        $categories = $categoryService->getList();

        Renderer::getSmarty()->assign("categories", $categories);
        Renderer::getSmarty()->assign('product', $product);
        Renderer::getSmarty()->display('products/edit.tpl');
    }

    public function add()    {

        if (Request::isPost()) {
            $productData  = ProductService::getDataFromPost();
            $productRepository = new Product\ProductRepository();
            $product = $productRepository->getProductFromArray($productData);

            $product = $productRepository->save($product);
            $productId = $product->getId();

            /* Начало загрузки изображений*/

            $imageUrl = trim($_POST['image_url']);
            ProductImagesService::uploadImageByUrl($productId, $imageUrl);

            $uploadImages = $_FILES['images'] ?? [];
            ProductImagesService::uploadImages($productId, $uploadImages);

            /* конец загрузки изображений*/

            if ($productId) {
                Response::redirect('/products/list');
            } else {
                die('какая то ошибка сзаза');
            }
        }
        $categories = CategoryService::getList();
        $product = new ProductModel('', 0, 0);
        $product->setId(0);
        $category = new CategoryModel('');
        $category->setId(0);
        $product->setCategory($category);

        Renderer::getSmarty()->assign("categories", $categories);
        Renderer::getSmarty()->assign("product", $product);
        Renderer::getSmarty()->display('products/add.tpl');
    }

    public function delete()
    {
        $id = Request::getIntFromPost('id', false);


        if (!$id) {
            die ("error");
        }

        $deleted =  ProductService::deleteById($id);

        if ($deleted) {
            Response::redirect('/products/list');
        } else {
            die('какая то ошибка сзаза1');
        }
    }

    public function deleteImage ()
    {
        $productImageId = Request::getIntFromPost('product_image_id');

        if (!$productImageId) {
            die ("error");
        }

        $deleted =  ProductImagesService::deleteById($productImageId);
        die('ок');

//        if ($deleted) {
//
//            Response::redirect('/products/list');
//        } else {
//            die('какая то ошибка сзаза');
//        }
    }
}