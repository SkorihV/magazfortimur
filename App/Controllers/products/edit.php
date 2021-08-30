<?php
$productId = Request::getIntFromGet('id');
$product = [];

if ($productId) {
    $product = Product::getById($productId);
}


if (Request::isPost()) {

    $productData = Product::getDataFromPost();
    $edited = Product::uploadById($productId, $productData);

    /* Начало загрузки изображений*/

    $path = APP_UPLOAD_PRODUCTS_DIR . '/' . $productId;

    if(!file_exists($path)) {
        mkdir($path);
    }

    $imageUrl = trim($_POST['image_url']);
    ProductImages::uploadImageByUrl($productId, $imageUrl);

    /* Начало загрузки изображений*/

    $uploadImages = $_FILES['images'] ?? [];
    ProductImages::uploadImages($productId, $uploadImages);

    /* конец загрузки изображений*/

    Response::redirect('/products/list');

//    if ($edited) {
//    } else {
//        die('какая то ошибка сзаза');
//    }
}

$categories = Category::getList();

$smarty->assign("categories", $categories);
$smarty->assign('product', $product);
$smarty->display('products/edit.tpl');
