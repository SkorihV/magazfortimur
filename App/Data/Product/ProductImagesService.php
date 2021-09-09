<?php

namespace App\Data\Product;

use App\Db\Db;

class ProductImagesService
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

    public function getById(int $id): array
    {

        $query = "SELECT * FROM product_images WHERE id = $id";
        return Db::fetchRow($query);
    }

    public function findByFilenameInProduct(int $productId, string $filename): array
    {
        $query = "SELECT * FROM product_images WHERE product_id = $productId AND name = '$filename'";
        return Db::fetchRow($query);
    }

    public function uploadById(int $id, array $productImage): int
    {
        if (isset($productImage['id'])){
            unset($productImage['id']);
        }
        return Db::update('product_images', $productImage, "id = $id");
    }

    public function add ($productImage): int
    {
        if (isset($productImage['id'])){
            unset($productImage['id']);
        }
        return Db::insert("product_images", $productImage);
    }

    public function deleteById(int $Id): int
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

    public function deleteByProductId(int $productId)
    {
        return Db::delete('product_images', "product_id = $productId");
    }

    public function uploadImages(int $productId , array $files): int
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

    public function uploadImage(int $productId, array $file)
    {
        $imageName = basename(trim($file['name']));

        if (empty($imageName)) {
            return false;
        }

        $imageTmpName = $file['tmp_name'];
        $fileName = $this->getUniqueUploadImageName($productId, $imageName);

        $path = $this->getUploadDirForProduct($productId);
        $imagePath = $path . '/' . $fileName;

        move_uploaded_file($imageTmpName, $imagePath);

        $this->add([
            'product_id'    => $productId,
            'name'          => $fileName,
            'path'          => str_replace(APP_PUBLIC_DIR, '', $imagePath),
        ]);
        return true;
    }

    public function uploadImageByUrl(int $productId, string $imageUrl)
    {

        if (empty ($imageUrl)) {
            return false;
        }

        $imageMetaData = $this->getMetaDataByUrl($imageUrl);


        $mimeType = $imageMetaData['mimeType'];
        if (is_null($mimeType)) {
            return false;
        }

        $imageExt = $this->getExtensionByMimeType($mimeType);
        if (is_null($imageExt)) {
            return false;
        }

        $size = $imageMetaData['size'];
        if (is_null($size)) {
            return false;
        }

        $duplicateProductImage = $this->getByProductIdAndSize($productId, $size);
        if (!empty($duplicateProductImage)) {
            return false;
        }

        $productImageId = $this->add([
            'product_id'    => $productId,
            'name'          => '',
            'path'          => '',
            'size'         => $size,
        ]);
        $fileName = $productId . '_' . $productImageId . '_upload' . time() . $imageExt;

        $path = $this->getUploadDirForProduct($productId);
        $imagePath = $path . '/' . $fileName;

        file_put_contents($imagePath, fopen($imageUrl, 'r'));

        $this->uploadById($productImageId, [
            'name' => $fileName,
            'path' => str_replace(APP_PUBLIC_DIR, '', $imagePath)
        ]);

            //    echo "<pre>";    var_dump($fileName);
            //Загрузка картинки по URL конец
        return  true;
    }

    public function getListProductId(int $product_id)
    {
        $query = "SELECT * FROM product_images WHERE product_id = $product_id";
        return Db::fetchAll($query);
    }


    protected function getExtensionByMimeType(string $mimeType)
    {
        return static::IMAGES_MIME_DICT[$mimeType] ?? null;

    }

    protected function getMetaDataByUrl(string $url)
    {
        $headers = @get_headers($url);

        if ($headers === false) {
            return null;
        }

        $metaDataHeaders = [
            'Content-Length',
            'Content-Type',
        ];

        $metaData =  [
            'mimeType'  => null,
            'size'      => null,
        ];

        $mimeType = null;
        foreach ($headers as $headerStr) {

            $header = null;

            foreach ($metaDataHeaders as $metaDataHeader) {
                if (strpos(strtolower($headerStr), strtolower($metaDataHeader)) === false) {
                    continue;
                }
                $header = $metaDataHeader;
                break;
            }

            if (is_null($header)){
                continue;
            }

            $headerData = explode(':', $headerStr);
            $headerValue = trim(strtolower($headerData[1] ?? ''));

            switch ($header) {
                case "Content-Length":
                    $metaData['size'] = $headerValue;
                    break;
                case 'Content-Type':
                    $metaData['mimeType'] = $headerValue;
                    break;
            }
        }

        return $metaData;
    }

    protected function getUniqueUploadImageName(int $productId, string $imageName)
    {
        $fileName = $imageName;
        $counter = 0;

        while (true) {
            $duplicateImage  = $this->findByFilenameInProduct($productId, $fileName);
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
    protected function getUploadDirForProduct(int $productId)
    {
        $path =  APP_UPLOAD_PRODUCTS_DIR . '/' . $productId;

        if(!file_exists($path)) {
            mkdir($path);
        }
        return $path;
    }

    private function getByProductIdAndSize(int $productId, $size)
    {
        $query = "SELECT * FROM product_images WHERE product_id = $productId AND size = $size";
        return Db::fetchRow($query);
    }
}