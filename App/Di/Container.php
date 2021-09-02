<?php
namespace App\Di;


use App\Router\Exception\MethodDoesNotExistException;
use App\Router\Exception\NotFoundException;
use ReflectionClass;

class Container
{
    public function execute(string $className, string $methodName)
    {

    }

    public function get(string $className)
    {
        return new $className();
    }

    /**
     * @throws \ReflectionException
     */
    public function getController(string $className)
    {
        $reflectionClass = new ReflectionClass($className);
        $reflectionConstructor = $reflectionClass->getConstructor();

        $reflectionParameters = $reflectionConstructor->getParameters();

        $arguments = [];

        foreach ($reflectionParameters as $parameter) {

            $parameterName = $parameter->getName();
            $parameterType = $parameter->getType();

            assert($parameterType instanceof \ReflectionNamedType);
            $className = $parameterType->getName();

            if (class_exists($className)) {
                $arguments[$parameterName] = new $className();
            }
        }

        return $reflectionClass->newInstanceArgs($arguments);

//        return call_user_func_array([$controller, $controllerMethod], $arguments);
    }

}