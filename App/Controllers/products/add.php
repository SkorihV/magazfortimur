<?php

use App\Category;
use App\Product;
use App\ProductImages;
use App\Request;
use App\Response;
//
//if (Request::isPost()) {
//
//    $productData  = Product::getDataFromPost();
//
//    $productRepository = new Product\ProductRepository();
//    $product = $productRepository->getProductFromArray($productData);
//
//
//    $product = $productRepository->save($product);
//
//    $productId = $product->getId();
//
//    /* Начало загрузки изображений*/
//
//    $imageUrl = trim($_POST['image_url']);
//    ProductImages::uploadImageByUrl($productId, $imageUrl);
//
//    $uploadImages = $_FILES['images'] ?? [];
//    ProductImages::uploadImages($productId, $uploadImages);
//
//    /* конец загрузки изображений*/
//
//    if ($productId) {
//       Response::redirect('/products/list');
//    } else {
//        die('какая то ошибка сзаза');
//    }
//}
//$categories = Category::getList();
//
//
//
//$smarty->assign("categories", $categories);
//$smarty->display('products/add.tpl');
