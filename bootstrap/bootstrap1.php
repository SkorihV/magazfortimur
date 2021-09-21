<?php


use App\Data\Category\CategoryRepository;
use App\Data\Category\CategoryService;
use App\Di\Container;
use App\Kernel;
use App\Renderer\Renderer;
use App\Router\Dispatcher;

//require_once 'config.php';

//use App\Renderer;

require_once __DIR__ . '/../vendor/autoload.php';

define('APP_DIR', realpath(__DIR__ . '/../'));
define('APP_PUBLIC_DIR', APP_DIR . '/public');
define('APP_UPLOAD_DIR', APP_PUBLIC_DIR . '/upload');
define('APP_UPLOAD_PRODUCTS_DIR', APP_UPLOAD_DIR . '/products');


(new Kernel())->run();