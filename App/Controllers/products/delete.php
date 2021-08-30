<?php

use App\Product;
use App\Request;
use App\Response;

$id = Request::getIntFromPost('id', false);


if (!$id) {
    die ("error");
}

$deleted =  Product::deleteById($id);

if ($deleted) {
    Response::redirect('/products/list');
} else {
    die('какая то ошибка сзаза1');
}