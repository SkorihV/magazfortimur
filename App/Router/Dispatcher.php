<?php

namespace App\Router;


use App\Config\Config;
use App\Di\Container;
use App\FS\FS;
use App\Http\Response;
use App\Renderer\Renderer;
use App\Router\Exception\ControllerDoesNotException;
use App\Router\Exception\ExpectToRecieveResponseObjectException;
use App\Router\Exception\MethodDoesNotExistException;
use App\Router\Exception\NotFoundException;
use ReflectionException;

class Dispatcher
{
    use RouteCollectionTrait;


    public function __construct(Container $di)
    {
        $this->di = $di;
        $this->config = $di->get(Config::class);
        $this->fs = $di->get(FS::class);
    }


    /**
     * @return Response
     * @throws ControllerDoesNotException
     * @throws ExpectToRecieveResponseObjectException
     * @throws MethodDoesNotExistException
     * @throws NotFoundException
     * @throws ReflectionException
     */
    public function dispatch()
    {

        /**
         * @var $route Route
         */
        $route = $this->di->get(Route::class);

        foreach ($this->getRoutes() as $path => $controller) {
            if ($this->isValidPath($path, $route)){
                break;
            }
        }


        $controllerClass = $route->getController();

        if (is_null($controllerClass)) {
            throw new NotFoundException();
        }
        if (!class_exists($controllerClass)) {
            throw new ControllerDoesNotException();
        }



        $controller = $this->di->get($controllerClass);

        $renderer = $this->di->get(Renderer::class);
        $this->di->setProperty($controller, 'renderer', $renderer);
        $this->di->setProperty($controller, 'route', $route);

        $controllerMethod = $route->getMethod();

        if (!method_exists($controller, $controllerMethod)) {
            throw new MethodDoesNotExistException();
        }
        $response = $this->di->call($controller, $controllerMethod);

        if(!($response instanceof Response)) {
            throw new ExpectToRecieveResponseObjectException();
        }

        return $response;

    }

    private function isValidPath(string $path, Route $route)
    {
        $routes = $this->getRoutes();
        $controller = $routes[$path];




        $isValidPath = $route->getUrl() == $path || $this->checkSmartPath($path, $route);
        if ($isValidPath){
            $route->setController($controller[0]);
            $route->setMethod($controller[1]);
        }

        return $isValidPath;
    }


    private function checkSmartPath(string $path, Route $route): bool
    {
        $isSmartPath = strpos($path, '{');

        if (!$isSmartPath) {
            return false;
        }

        $route->clearParams();
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