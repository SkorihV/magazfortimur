<?php

namespace App\Router;

use App\Category\CategoryController;
use App\Config\Config;
use App\Di\Container;
use App\FS\FS;
use App\Import\ImportController;
use App\Product\ProductController;
use App\Queue\QueueController;
use App\Renderer;
use App\Http\Request;
use App\Router\Exception\MethodDoesNotExistException;
use App\Router\Exception\NotFoundException;
use ReflectionClass;
use ReflectionException;

class Dispatcher
{
    /**
     * @var Container
     */
    private Container $di;

    /**
     * @var Config
     */
    private  $config;

    /**
     * @var FS
     */
    private $fs;

    public function __construct(Container $di)
    {
        $this->di = $di;
        $this->config = $di->get(Config::class);
        $this->fs = $di->get(FS::class);
    }






    /**
     * @return false|mixed|void|null
     * @throws ReflectionException
     */
    public function dispatch()
    {
        $request = $this->di->get(Request::class);

        $url = $request->getUrl();
        $route = new Route($url);

        foreach ($this->getRouts() as $path => $controller) {
            if ($this->isValidPath($path, $route)){
                break;
            }
        }
        try {
            $controllerClass = $route->getController();


            if (is_null($controllerClass)) {
                throw new NotFoundException();
            }

            $di = $this->getDi();

            $controller = $di->get($controllerClass);


            $renderer = $di->get(Renderer::class);
            $di->setProperty($controller, 'renderer', $renderer);
            $di->setProperty($controller, 'route', $route);

            $controllerMethod = $route->getMethod();

            if (method_exists($controller, $controllerMethod)) {
                return $di->call($controller, $controllerMethod);

            }
            throw new MethodDoesNotExistException();

        } catch (NotFoundException | MethodDoesNotExistException $e) {
            $this->error404();
        }
    }

    public function isValidPath(string $path, Route $route)
    {
        $routes = $this->getRouts();
        $controller = $routes[$path];

        $isValidPath = $route->isValidPath($path);
        if ($isValidPath){
            $route->setController($controller[0]);
            $route->setMethod($controller[1]);
        }

        return $isValidPath;
    }

    private function error404()
    {
        Renderer::getSmarty()->display('404.tpl');
        exit;
    }

    private function getRouts(): array
    {
        $routes = [];
        foreach ($this->config->routes as $routePath => $routeConfig) {
            $routes[$routePath] = $routeConfig;
        }

        $annotationRoutes = $this->parseControllerForAnnotationRoutes();

        return array_merge($routes, $annotationRoutes);
    }


    private function parseControllerForAnnotationRoutes()
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

    private function getRoutesFromControllerFile(string $filePath) {

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

    /**
     * @return Container
     */
    public function getDi(): Container
    {
        return $this->di;
    }
}