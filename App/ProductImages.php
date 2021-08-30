<?php

class ProductImages
{
    private CONST IMAGES_MIME_DICT = [
            'image/apng'        => '.apng',
            'image/bmp'         => '.bmp',
            'image/gif'         => '.gif',
            'image/x-ico'       => '.ico',
            'image/jpeg'        => '.jpg',
            'image/png'         => '.png',
            'image/svg+xml'     => '.svg',
            'image/tiff'        => '.tiff',
            'image/webp'        => '.webp',
        ];

    public static function getById(int $id)
    {

        $query = "SELECT * FROM product_images WHERE id = $id";
        return Db::fetchRow($query);
    }

    public static function findByFilenameInProduct(int $productId, string $filename)
    {
        $query = "SELECT * FROM product_images WHERE product_id = $productId AND name = '$filename'";
        return Db::fetchRow($query);
    }

    public static function uploadById(int $id, array $productImage): int
    {
        if (isset($productImage['id'])){
            unset($productImage['id']);
        }
        return Db::update('product_images', $productImage, "id = $id");
    }

    public static function add ($productImage): int
    {
        if (isset($productImage['id'])){
            unset($productImage['id']);
        }
        return Db::insert("product_images", $productImage);
    }

    public static function deleteById(int $Id): int
    {
        $productImage = static::getById($Id);
        $filePath = APP_PUBLIC_DIR . $productImage['path'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        return Db::delete('product_images', "id = $Id");
    }

//    public static function getFromPost () : array
//    {
//        return [
//            'id'             => Request::getIntFromPost('id', false),
//            'name'           => Request::getStrFromPost('name'),
//            'article'        => Request::getStrFromPost('article'),
//            'price'          => Request::getIntFromPost('price'),
//            'amount'         => Request::getStrFromPost('amount'),
//            'description'    => Request::getStrFromPost('description'),
//            'category_id'    => Request::getIntFromPost('category_id')
//        ];
//    }

    public static function deleteByProductId(int $productId)
    {
        return Db::delete('product_images', "product_id = $productId");
    }

    public static function uploadImages(int $productId , array $files): int
    {

        $imageNames = $files['name'] ?? [];

        $imageTmpNames = $files['tmp_name'] ?? [];

        $imagesCount = 0;

        for ($i = 0; $i < count($imageNames); $i++) {

           $result = static::uploadImage($productId, [
                'name'      => $imageNames[$i],
                'tmp_name'  => $imageTmpNames[$i]
            ]);

           if ($result) {
               $imagesCount++;
           }
        }
        return $imagesCount;
    }

    public static function uploadImage(int $productId, array $file)
    {
        $imageName = basename(trim($file['name']));

        if (empty($imageName)) {
            return false;
        }

        $imageTmpName = $file['tmp_name'];
        $fileName = static::getUniqueUploadImageName($productId, $imageName);

        $path = static::getUploadDirForProduct($productId);
        $imagePath = $path . '/' . $fileName;

        move_uploaded_file($imageTmpName, $imagePath);

        ProductImages::add([
            'product_id'    => $productId,
            'name'          => $fileName,
            'path'          => str_replace(APP_PUBLIC_DIR, '', $imagePath),
        ]);
        return true;
    }

    public static function uploadImagesByUrl(int $productId, string  $imageUrl)
    {
        if (empty ($imageUrl)) {
            return false;
        }

        $imageExt = static::getExtensionByUrl($imageUrl);

        if (is_null($imageExt)) {
            return false;
        }

        $productImageId = ProductImages::add([
            'product_id'    => $productId,
            'name'          => '',
            'path'          => '',
        ]);
        $fileName = $productId . '_' . $productImageId . '_upload' . time() . $imageExt;

        $path = static::getUploadDirForProduct($productId);
        $imagePath = $path . '/' . $fileName;

        file_put_contents($imagePath, fopen($imageUrl, 'r'));

        ProductImages::uploadById($productImageId, [
            'name' => $fileName,
            'path' => str_replace(APP_PUBLIC_DIR, '', $imagePath)
        ]);

            //    echo "<pre>";    var_dump($fileName);
            //Загрузка картинки по URL конец
        return  true;
    }

    public static function getListProductId(int $product_id)
    {
        $query = "SELECT * FROM product_images WHERE product_id = $product_id";
        return Db::fetchAll($query);
    }

    protected static function getExtensionByUrl(string  $url)
    {
        $mimeType = static::getMimeTypeByUrl($url);

        return static::IMAGES_MIME_DICT[$mimeType] ?? null;
    }

    protected static function getMimeTypeByUrl( string $url)
    {
        $headers = @get_headers($url);

        if ($headers === false) {
            return null;
        }
        $mimeType = null;

        foreach ($headers as $headerStr) {
            if (strpos(strtolower($headerStr), 'content-type') === false) {
                continue;
            }
            $header = explode(':', $headerStr);
            $mimeType = trim(strtolower($header[1] ?? ''));
        }

        return $mimeType;
    }

    protected static function getUniqueUploadImageName(int $productId, string $imageName)
    {
        $fileName = $imageName;
        $counter = 0;

        while (true) {
            $duplicateImage  = ProductImages::findByFilenameInProduct($productId, $fileName);
            if (empty($duplicateImage)) {
                break;
            }

            $info = pathinfo($imageName);
            $fileName = $info['filename'];
            $fileName .= '_' . $counter . '.' . $info['extension'];

            $counter++;
        }
        return $fileName;
    }
    protected static function getUploadDirForProduct(int $productId)
    {
        $path =  APP_UPLOAD_PRODUCTS_DIR . '/' . $productId;

        if(!file_exists($path)) {
            mkdir($path);
        }
        return $path;
    }
}