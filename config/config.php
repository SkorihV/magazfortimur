<?php
require_once __DIR__ . '/../libs/Smarty/Smarty.class.php';
require_once __DIR__ . '/../App/Product.php';
require_once __DIR__ . '/../App/Category.php';
require_once __DIR__ . '/../App/Db.php';
require_once __DIR__ . '/../App/Request.php';
require_once __DIR__ . '/../App/Response.php';
require_once __DIR__ . '/../App/ProductImages.php';

define('APP_DIR', realpath(__DIR__ . '/../'));
define('APP_PUBLIC_DIR', APP_DIR . '/public');
define('APP_UPLOAD_DIR', APP_PUBLIC_DIR . '/upload');
define('APP_UPLOAD_PRODUCTS_DIR', APP_UPLOAD_DIR . '/products');


if (!file_exists(APP_UPLOAD_DIR)) {
    mkdir(APP_UPLOAD_DIR);
}
if (!file_exists(APP_UPLOAD_PRODUCTS_DIR)) {
    mkdir(APP_UPLOAD_PRODUCTS_DIR);
}



$smarty = new Smarty();
$smarty->template_dir = __DIR__ . '/../templates';
$smarty->compile_dir = __DIR__ . '/../var/compile';
$smarty->cache_dir = __DIR__ . '/../var/cache';
$smarty->config_dir = __DIR__ . '/../var/configs';

function delDir($dir) {
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delDir("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}
