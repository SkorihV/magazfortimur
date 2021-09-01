<?php

namespace App\Router;

use App\Category\CategoryController;
use App\Import\ImportController;
use App\Product\ProductController;
use App\Queue\QueueController;
use App\Renderer;

class Dispatcher
{
    protected array $routes =  [
        '/products/list'            => [ProductController::class, 'list'],
        '/'                         => [ProductController::class, 'list'],
        '/products/edit'            => [ProductController::class, 'edit'],
        '/products/add'             => [ProductController::class, 'add'],
        '/products/delete'          => [ProductController::class, 'delete'],
        '/products/delete_image'    => [ProductController::class, 'deleteImage'],
        '/products/edit/{id}'       => [ProductController::class, 'edit'],
        '/products/{id}/edit'       => [ProductController::class, 'edit'],


        '/categories/list'          => [CategoryController::class, 'list'],
        '/categories/add'           => [CategoryController::class, 'add'],
        '/categories/edit'          => [CategoryController::class, 'edit'],
        '/categories/view'          => [CategoryController::class, 'view'],
        '/categories/delete'        => [CategoryController::class, 'delete'],
        '/categories/view/{id}'     => [CategoryController::class, 'view'],
        '/categories/{id}/view'     => [CategoryController::class, 'view'],

        '/queue/list'               => [QueueController::class, 'list'],
        '/queue/run'                => [QueueController::class, 'run'],

        '/import/index'             => [ImportController::class, 'index'],
        '/import/upload'            => [ImportController::class, 'upload'],



    ];
    public function dispatch()
    {
        $requestUri = $_SERVER["REQUEST_URI"];
        $requestUri = explode('?', $requestUri);
        $requestUri = $requestUri[0];

        $url = $requestUri ?? '/';

        $route = null;
        $controllerParams = [];
        foreach ($this->routes as $path => $controller) {
            $isSmartPath = strpos($path, '{');

            if ($url == $path) {
                $route = $controller;
                break;
            } else if($isSmartPath) {

                $isEqual = false;
                $urlLiChunks = explode('/', $url);
                $pathChunks = explode('/', $path);

                if (count($urlLiChunks) != count($pathChunks)) {
                    break;
                }

                $controllerParams = [];

                for ($i = 0; $i < count($pathChunks); $i++) {

                    $urlChunk = $urlLiChunks[$i];
                    $pathChunk = $pathChunks[$i];

                    $isSmartChunk = strpos($pathChunk, '{') !== false && strpos($pathChunk, '}') !== false;

                    if ($urlChunk == $pathChunk) {
                        $isEqual = true;
                    } else if ($isSmartChunk){
                        $paramName = str_replace(['{','}'], '', $pathChunk);
                        $controllerParams[$paramName] = $urlChunk;
                        $isEqual = true;
                    } else {
                        $controllerParams = [];
                        $isEqual = false;
                    }
                    if (!$isEqual) {
                        break;
                    }
                }

                if (!$isEqual) {
                    continue;
                }


                if ($isEqual) {
                    $route = $controller;
                    break;
                }
            }

        }

        if (is_null($route)) {
            Renderer::getSmarty()->display('404.tpl');
            exit;
        }

        $class = $route[0];
        $method = $route[1];

        $controller = new $class($controllerParams);
        if (method_exists($controller, $method)) {
            $controller->{$method}();
        } else {
            Renderer::getSmarty()->display('404.tpl');
            exit;
        }
    }

}