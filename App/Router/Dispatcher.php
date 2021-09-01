<?php

namespace App\Router;

use App\Category\CategoryController;
use App\Import\ImportController;
use App\Product\ProductController;
use App\Queue\QueueController;
use App\Renderer;

class Dispatcher
{
    protected array $routes =  ['/products/' => [ProductController::class, 'list'],
        '/products/edit'            => [ProductController::class, 'edit'],
        '/products/add'             => [ProductController::class, 'add'],
        '/products/delete'          => [ProductController::class, 'delete'],
        '/products/delete_image'    => [ProductController::class, 'deleteImage'],


        '/category/list'        => [CategoryController::class, 'list'],
        '/category/add'     => [CategoryController::class, 'add'],
        '/category/edit'    => [CategoryController::class, 'edit'],
        '/category/view'    => [CategoryController::class, 'view'],
        '/category/delete'  => [CategoryController::class, 'delete'],

        '/queue/list'  => [QueueController::class, 'list'],
        '/queue/run'  => [QueueController::class, 'run'],

        '/import/index'  =>  [ImportController::class, 'index'],
        '/import/upload'  => [ImportController::class, 'upload'],

    ];

    public function dispatch()
    {
        $requestUri = $_SERVER["REQUEST_URI"];
        $requestUri = explode('?', $requestUri);
        $requestUri = $requestUri[0];

        $url = $requestUri ?? '/';

        $route = null;

        foreach ($this->routes as $path => $controller) {
            if ($url == $path) {
                $route = $controller;
                break;
            }
        }

        if (is_null($route)) {
            Renderer::getSmarty()->display('404.tpl');
            exit;
        }


        $class = $route[0];
        $method = $route[1];

        $controller = new $class();
        if (method_exists($controller, $method)) {
            $controller->{$method}();
        } else {
            Renderer::getSmarty()->display('404.tpl');
            exit;
        }
    }
}