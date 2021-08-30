<?php

use App\Category;
use App\Request;
use App\Response;

$id = Request::getIntFromPost('id' );


if (!$id) {
    die ("error");
}

$deleted =  Category::deleteById($id);

if ($deleted) {
    Response::redirect('/categories/list');
} else {
    die('какая то ошибка сзаза');
}