<?php

use App\ProductImages;
use App\Request;

$productImageId = Request::getIntFromPost('product_image_id');

if (!$productImageId) {
    die ("error");
}

$deleted =  ProductImages::deleteById($productImageId);
die('ок');
//if ($deleted) {
//
//    Response::redirect('/products/list');
//} else {
//    die('какая то ошибка сзаза');
//}