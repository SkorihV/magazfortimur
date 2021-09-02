<?php
namespace App\Di;


use App\Router\Exception\MethodDoesNotExistException;
use App\Router\Exception\NotFoundException;

class Container
{
    public function execute(string $className, string $methodName)
    {
        $controllerClass = $this->getController();

        if (is_null($className)) {

            throw new NotFoundException();
        }

        $controller = new $className($this);
        $controllerMethod = $this->getMethod();

        if (method_exists($controller, $controllerMethod)) {
            return $controller->{$controllerMethod}();
        }

        throw new MethodDoesNotExistException();
    }
}