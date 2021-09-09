<?php

namespace App\Router;

use App\Config\Config;
use App\Di\Container;
use App\FS\FS;
use ReflectionClass;

trait RouteCollectionTrait
{
    /**
     * @var Container
     */
    protected $di;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var FS
     */
    protected $FS;

    /**
     * @return array
     * @throws \ReflectionException
     */
    protected function getRoutes(): array
    {
        $routes = [];
        foreach ($this->config->routes as $routePath => $routeConfig) {
            $routes[$routePath] = $routeConfig;
        }

        $annotationRoutes = $this->parseControllerForAnnotationRoutes();

        return array_merge($routes, $annotationRoutes);
    }


    /**
     * @return array
     * @throws \ReflectionException
     */
    protected function parseControllerForAnnotationRoutes()
    {
        $files =  $this->fs->scanDir(APP_DIR . '/App');

        $routes = [];

        foreach ($files as $filepath) {

            if (strpos($filepath, 'Controller.php') === false) {
                continue;
            }
            $controllerRoutes = $this->getRoutesFromControllerFile($filepath);
            $routes = array_merge($routes, $controllerRoutes);
        }

        return $routes;
    }

    /**
     * @param string $filePath
     * @return array
     * @throws \ReflectionException
     */
    protected function getRoutesFromControllerFile(string $filePath) {

        $routes = [];

        $controllerClassName = str_replace([APP_DIR . '/', '.php'], '', $filePath);
        $controllerClassName = str_replace([ '/', ], '\\', $controllerClassName);

        $reflectionClass = new ReflectionClass($controllerClassName);
        $reflectionMethods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);


        foreach ($reflectionMethods as $reflectionMethod) {
            if ($reflectionMethod->isConstructor()) {
                continue;
            }


            $docComment = (string) $reflectionMethod->getDocComment();

            $docComment = str_replace(['/**', '*/'], '', $docComment);
            $docComment = trim($docComment);
            $docCommentArray = explode("\n", $docComment);

            $docCommentArray = array_map(function($item) {
                $item = trim($item);

                $position = strpos($item, '*');
                if ($position === 0) {
                    $item = substr($item, 1);
                }

                return trim($item);
            }, $docCommentArray);

            foreach ($docCommentArray as $docString) {
                $isRoute = strpos($docString, '@route(') === 0;

                if (empty($docString) || !$isRoute) {
                    continue;
                }

                $url = str_replace(['@route("','")'], '', $docString);

                $routes[$url] = [$controllerClassName, $reflectionMethod->getName()];
            }
        }

        return $routes;
    }
}