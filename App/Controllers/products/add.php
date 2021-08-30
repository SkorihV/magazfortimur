<?php

if (Request::isPost()) {

    $product  = Product::getDataFromPost();
    $productId = Product::add($product);

    /* Начало загрузки изображений*/

    $imageUrl = trim($_POST['image_url']);
    ProductImages::uploadImagesByUrl($productId, $imageUrl);

    $uploadImages = $_FILES['images'] ?? [];
    ProductImages::uploadImages($productId, $uploadImages);

    /* конец загрузки изображений*/

    if ($productId) {
       Response::redirect('/products/list');
    } else {
        die('какая то ошибка сзаза');
    }
}
$categories = Category::getList();


$smarty->assign("categories", $categories);
$smarty->display('products/add.tpl');
