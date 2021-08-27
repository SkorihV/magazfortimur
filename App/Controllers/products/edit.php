<?php
$productId = Request::getIntFromGet('id');
$product = [];

if ($productId) {
    $product = Product::getById($productId);
}


if (Request::isPost()) {

    $productData = Product::getDataFromPost();
    $edited = Product::uploadById($productId, $productData);

    $path = APP_UPLOAD_PRODUCTS_DIR . '/' . $productId;

    if(!file_exists($path)) {
        mkdir($path);
    }

    $imageUrl = $_POST['image_url'] ?? '';

    $imageContentType = [
        'image/apng' => '.apng',
        'image/bmp' => '.bmp',
        'image/gif' => '.gif',
        'image/x-ico' => '.ico',
        'image/jpeg' => '.jpg',
        'image/png' => '.png',
        'image/svg+xml' => '.svg',
        'image/tiff' => '.tif, .tiff',
        'image/webp' => '.webp',
    ];

    $imagePath = $path . '/';

    $headers = get_headers($imageUrl);
    $contentType = null;

    foreach ($headers as $headerStr) {
        if (strpos(strtolower($headerStr), 'content-type') === false) {
            continue;
        }
        $header = explode(':', $headerStr);
        $contentType = trim(strtolower($header[1] ?? ''));
    }

    $imageExt = $imageContentType[$contentType] ?? null;

    if (!is_null($imageExt)) {
        $productImageId = 0;
        $fileName = $productId . '_' . $productImageId . '_upload' . time() . $imageExt;
        echo "<pre>";    var_dump($fileName);
    }


    echo "</pre>";

exit;


    /* Начало загрузки изображений*/

    $uploadImages = $_FILES['images'] ?? '';

    $imageNames = $uploadImages['name'];

    if ($imageNames[0]) {

        $imageTmpNames = $uploadImages['tmp_name'];


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
    }
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
