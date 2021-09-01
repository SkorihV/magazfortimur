<?php

namespace App\Router;

use App\Category\CategoryController;
use App\Import\ImportController;
use App\Product\ProductController;
use App\Queue\QueueController;
use App\Renderer;
use App\Router\Exception\MethodDoesNotExistException;
use App\Router\Exception\NotFoundException;

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
        '/categories/edit/{id}'     => [CategoryController::class, 'edit'],
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

        $route = new Route($url);

        $controllerParams = [];
        foreach ($this->routes as $path => $controller) {
            $isSmartPath = strpos($path, '{');

            if ($route->getUrl() == $path) {
                $route->setController(($controller[0]));
                $route->setMethod(($controller[1]));

                break;
            } else if($isSmartPath) {

                $isEqual = $this->checkSmartPath($path, $route);
                if ($isEqual) {
                    $route->setController(($controller[0]));
                    $route->setMethod(($controller[1]));

                    break;
                }
            }
        }


        try {
            $route->execute();
        } catch (NotFoundException | MethodDoesNotExistException $e) {
            $this->error404();
        }


//        if (is_null($route)) {
//            $this->error404();
//        }
//
//        $class = $route[0];
//        $method = $route[1];
//
//        $controller = new $class($controllerParams);
//        if (method_exists($controller, $method)) {
//           return $controller->{$method}();
//        }
//
//        $this->error404();
    }

    private function error404()
    {
        Renderer::getSmarty()->display('404.tpl');
        exit;
    }

    private function checkSmartPath(string $path, Route $route): bool
    {

        $isEqual = false;

        $url = $route->getUrl();

        $urlLiChunks = explode('/', $url);
        $pathChunks = explode('/', $path);

        if (count($urlLiChunks) != count($pathChunks)) {
            return false;
        }

        for ($i = 0; $i < count($pathChunks); $i++) {

            $urlChunk = $urlLiChunks[$i];
            $pathChunk = $pathChunks[$i];

            $isSmartChunk = strpos($pathChunk, '{') !== false && strpos($pathChunk, '}') !== false;

            if ($urlChunk == $pathChunk) {
                $isEqual = true;

                continue;
            } else if ($isSmartChunk){
                $paramName = str_replace(['{','}'], '', $pathChunk);


                $route->setParam($paramName, $urlChunk);
                $isEqual = true;

                continue;
            }
            $isEqual = false;
            break;

        }

        return $isEqual;
    }
}