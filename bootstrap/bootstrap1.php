<?php


use App\Category\CategoryRepository;
use App\Category\CategoryService;
use App\Di\Container;
use App\Kernel;
use App\Renderer;
use App\Router\Dispatcher;

//require_once 'config.php';

//use App\Renderer;

require_once __DIR__ . '/../vendor/autoload.php';

define('APP_DIR', realpath(__DIR__ . '/../'));
define('APP_PUBLIC_DIR', APP_DIR . '/public');
define('APP_UPLOAD_DIR', APP_PUBLIC_DIR . '/upload');
define('APP_UPLOAD_PRODUCTS_DIR', APP_UPLOAD_DIR . '/products');


(new Kernel())->run();


//
//
//if (!file_exists(APP_UPLOAD_DIR)) {
//    mkdir(APP_UPLOAD_DIR);
//}
//if (!file_exists(APP_UPLOAD_PRODUCTS_DIR)) {
//    mkdir(APP_UPLOAD_PRODUCTS_DIR);
//}
//
//$smarty = Renderer::getSmarty();
//
//function delDir($dir) {
//    $files = array_diff(scandir($dir), array('.','..'));
//    foreach ($files as $file) {
//        (is_dir("$dir/$file")) ? delDir("$dir/$file") : unlink("$dir/$file");
//    }
//    return rmdir($dir);
//}
//
//
//
//$di = new Container();
//$di->singletone(Smarty::class, function (){
//    $smarty = new Smarty();
//
//    $smarty->template_dir = APP_DIR . '/templates';
//    $smarty->compile_dir = APP_DIR . '/var/compile';
//    $smarty->cache_dir = APP_DIR . '/var/cache';
//    $smarty->config_dir = APP_DIR . '/var/configs';
//
//    return $smarty;
//});
//
//$smarty = $di->get(Smarty::class);
//
//
//$category = new CategoryRepository();
//$categories = $category->getList();
//
//$smarty->assign('categories_shared', $categories);
//
//
//$dispatcher = new Dispatcher($di);
//$dispatcher->dispatch();


