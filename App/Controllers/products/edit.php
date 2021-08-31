<?php

use App\Category;
use App\Category\CategoryModel;
use App\Product;
use App\ProductImages;
use App\Request;
use App\Response;

$productId = Request::getIntFromGet('id');
$product = [];

$productRepository = new Product\ProductRepository();


if ($productId) {
    $product = $productRepository->getById($productId);
}

if (Request::isPost()) {

    $productData = Product::getDataFromPost();

    $product->setName(($productData['name']));
    $product->setAmount(($productData['amount']));
    $product->setArticle(($productData['article']));
    $product->setPrice(($productData['price']));
    $product->setDescription(($productData['description']));


    $categoryId = $productData['category_id'] ?? 0;
    if ($categoryId) {
        $categoryData = Category::getById($categoryId);
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
    ProductImages::uploadImageByUrl($productId, $imageUrl);

    /* Начало загрузки изображений*/

    $uploadImages = $_FILES['images'] ?? [];
    ProductImages::uploadImages($productId, $uploadImages);

    /* конец загрузки изображений*/

    Response::redirect('/products/list');


}

$categories = Category::getList();

$smarty->assign("categories", $categories);
$smarty->assign('product', $product);
$smarty->display('products/edit.tpl');
