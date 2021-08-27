<?php
$productId = Request::getIntFromGet('id');
$product = [];

if ($productId) {
    $product = Product::getById($productId);
}


if (Request::isPost()) {

    $productData = Product::getDataFromPost();


    $edited = Product::uploadById($productId, $productData);

    $uploadImages = $_FILES['images'] ?? [];

    $imageNames = $uploadImages['name'];
    $imageTmpNames = $uploadImages['tmp_name'];

//    $currentImageNames = [];
//    foreach ($product['images'] as $image) {
//        $currentImageNames[] = $image['name'];
//    }
//
//    $diffImageName = array_diff($imageNames, $currentImageNames);

    $path = APP_UPLOAD_PRODUCTS_DIR . '/' . $productId;

    if(!file_exists($path)) {
        mkdir($path);
    }

    for ($i = 0; $i < count($imageNames); $i++) {
        $imageName = basename($imageNames[$i]);
        $imageTmpName = $imageTmpNames[$i];

        $fileName = $imageName;
        $counter = 0;

        while (true) {
            $duplicateImage  = ProductImages::findByFilenameProduct($productId, $fileName);
            if (empty($duplicateImage)) {
                break;
            }

            $info = pathinfo($imageName);
            $fileName = $info['filename'];
            $fileName .= '_' . $counter . '.' . $info['extension'];

            $counter++;

        }


        $imagePath = $path . '/' . $fileName;

        move_uploaded_file($imageTmpName, $imagePath);

            ProductImages::add([
                'product_id'    => $productId,
                'name'          => $fileName,
                'path'          => str_replace(APP_PUBLIC_DIR, '', $imagePath),
            ]);

    }

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
