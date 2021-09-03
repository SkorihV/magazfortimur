<?php

use App\Category\CategoryService;
use App\Di\Container;
use App\Renderer;
use App\Router\Dispatcher;

require_once 'config.php';

$di = new Container();
$di->singletone(Smarty::class, function (){
    $smarty = new Smarty();

    $smarty->template_dir = APP_DIR . '/templates';
    $smarty->compile_dir = APP_DIR . '/var/compile';
    $smarty->cache_dir = APP_DIR . '/var/cache';
    $smarty->config_dir = APP_DIR . '/var/configs';

    return $smarty;
});

$smarty = $di->get(Smarty::class);


$categoryService = new CategoryService();
$categories = $categoryService->getList();
$smarty->assign('categories_shared', $categories);

$dispatcher = new Dispatcher($di);
$dispatcher->dispatch();
