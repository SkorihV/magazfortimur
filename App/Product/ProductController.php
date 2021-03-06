<?php

namespace App\Product;


use App\Category\CategoryModel;
use App\Category\CategoryService;
use App\Controller\AbstractController;
use App\Renderer;
use App\Request;
use App\Response;
use App\Router\Route;
use Exception;

class ProductController extends AbstractController
{
//    /**
//     * @var Route
//     */
//    private Route $route;

    public function __construct()
    {
  //      $this->route = $route;
    }

    /**
     * @param Request $request
     * @param ProductRepository $productRepository
     *
     * @return mixed
     * @route("/product_list")
     */
    public function list(Request $request, ProductRepository $productRepository)
    {
        $current_page = $request->getIntFromGet('p', 1);
        $limit = 10;

        $offset = ($current_page - 1) * $limit;

        $productsCount = $productRepository->getListCount();
        $pages_count = ceil($productsCount / $limit);

        $products = $productRepository->getList($limit, $offset);

//$products = Product::getList($limit, $offset);

        return $this->render('products/index.tpl', [
            'pages_count'   => $pages_count,
            'products'      => $products
        ]);
    }

    /**
     * @param Request $request
     * @param ProductRepository $productRepository
     * @param ProductService $productService
     * @param ProductImagesService $productImagesService
     * @param Response $response
     * @param CategoryService $categoryService
     * @return mixed
     *
     * @route("/product_edit/{id}")
     * @route("/product_edit")
     */
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

            /* ???????????? ???????????????? ??????????????????????*/


            $imageUrl = trim($_POST['image_url']);
            $productImagesService->uploadImageByUrl($productId, $imageUrl);

            /* ???????????? ???????????????? ??????????????????????*/

            $uploadImages = $_FILES['images'] ?? [];
            $productImagesService->uploadImages($productId, $uploadImages);

            /* ?????????? ???????????????? ??????????????????????*/

            $response->redirect('/products/list');
        }

        $categories = $categoryService->getList();

        return $this->render('products/edit.tpl', [
            "categories" => $categories,
            'product' => $product
        ]);

    }

    /**
     * @param Request $request
     * @param ProductService $productService
     * @param ProductImagesService $productImagesService
     * @param Response $response
     * @param CategoryService $categoryService
     * @param ProductRepository $productRepository
     * @return mixed
     *
     * @throws Exception
     */
    public function add(
        Request $request,
        ProductService $productService,
        ProductImagesService $productImagesService,
        Response $response,
        CategoryService $categoryService,
        ProductRepository $productRepository)
    {

        if ($request->isPost()) {
            $productData  = $productService->getDataFromPost($request);
            $product = $productRepository->getProductFromArray($productData);

            $product = $productRepository->save($product);
            $productId = $product->getId();

            /* ???????????? ???????????????? ??????????????????????*/

            $imageUrl = trim($request->getStrFromPost("image_url"));
            $productImagesService->uploadImageByUrl($productId, $imageUrl);

            $uploadImages = $_FILES['images'] ?? [];
            $productImagesService->uploadImages($productId, $uploadImages);

            /* ?????????? ???????????????? ??????????????????????*/

            if ($productId) {
                $response->redirect('/products/list');
            } else {
                die('?????????? ???? ???????????? ??????????');
            }
        }
        $categories = $categoryService->getList();
        $product = new ProductModel('', 0, 0);
        $product->setId(0);
        $category = new CategoryModel('');
        $category->setId(0);
        $product->setCategory($category);

        return $this->render('products/add.tpl', [
            "categories" => $categories,
            'product' => $product
        ]);
    }

    public function delete(
        Request $request,
        ProductService $productService,
        Response $response)
    {
        $id = $request->getIntFromPost('id', false);


        if (!$id) {
            die ("error");
        }

        $deleted =  $productService->deleteById($id);

        if ($deleted) {
            $response->redirect('/products/list');
        } else {
            die('?????????? ???? ???????????? ??????????1');
        }
    }

    public function deleteImage (
        Request $request,
        ProductImagesService $productImagesService)
    {
        $productImageId = $request->getIntFromPost('product_image_id');

        if (!$productImageId) {
            die ("error");
        }

        $deleted =  $productImagesService->deleteById($productImageId);
        die('????');

//        if ($deleted) {
//
//            Response::redirect('/products/list');
//        } else {
//            die('?????????? ???? ???????????? ??????????');
//        }
    }
}