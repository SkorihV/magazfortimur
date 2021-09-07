<?php
namespace App\Di;


use App\Router\Exception\MethodDoesNotExistException;
use App\Router\Exception\NotFoundException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionObject;

class  Container
{
    /**
     * @var callable[]
     */
    private $factories = [];

    /**
     * @var object[]
     */
    private $singletones = [];


    /**
     * @param string $className
     * @return object
     * @throws ReflectionException
     */
    public function get(string $className)
    {
        if ($this->isSingletone($className)) {
            return $this->getSingletone($className);
        }
        return $this->createInstance($className);
    }

    public function factory(string $className, callable $factory)
    {
        $this->factories[$className] = $factory;
    }

    /**
     * @param string $className
     * @param callable|null $factory
     */
    public function singletone(string $className, callable $factory = null)
    {
        if (!$this->isSingletone($className)) {
            $this->singletones[$className] = null;
        }

        if (is_callable($factory)) {
            $this->factory($className, $factory);
        }
    }

    /**
     * @param string $className
     * @return bool
     */
    public function isSingletone(string $className)
    {
        return array_key_exists($className, $this->singletones);
    }

    /**
     * @param string $className
     * @return object|null
     */
    protected function getSingletone(string $className)
    {
        if (!$this->isSingletone($className)) {
            return null;
        };

        if (is_null($this->singletones[$className])) {
            $this->singletones[$className] = $this->createInstance($className);
        }

        return $this->singletones[$className];
    }

    /**
     * @param string $className
     * @return object
     * @throws ReflectionException
     */
    protected function createInstance(string $className)
    {


        if (isset($this->factories[$className])) {
            return $this->factories[$className]();
        }

        $reflectionClass = new ReflectionClass($className);
        $reflectionConstructor = $reflectionClass->getConstructor();

        if ($reflectionConstructor instanceof ReflectionMethod) {
            $arguments = $this->getDependencies($reflectionConstructor);
            return $reflectionClass->newInstanceArgs($arguments);
        }

        return $reflectionClass->newInstance();
    }

    /**
     * @param $object
     * @param string $propertyName
     * @param $value
     * @return bool|null
     * @throws ReflectionException
     */
    public function setProperty($object, string $propertyName, $value)
    {
        if (!is_object($object)){
            return null;
        }

        $reflectionController = new ReflectionObject($object);

        $reflectionRenderer = $reflectionController->getProperty($propertyName);
        $reflectionRenderer->setAccessible(true);
        $reflectionRenderer->setValue($object, $value);
        $reflectionRenderer->setAccessible(false);


        return true;
    }

    /**
     * @param \ReflectionMethod $reflectionMethod
     * @return array|void
     * @throws ReflectionException
     */
    protected function getDependencies(\ReflectionMethod $reflectionMethod) {
        $reflectionParameters = $reflectionMethod->getParameters();

        $arguments = [];

        foreach ($reflectionParameters as $parameter) {


            $parameterName = $parameter->getName();
            $parameterType = $parameter->getType();


            assert($parameterType instanceof \ReflectionNamedType);
            $className = $parameterType->getName();

            if (class_exists($className)) {
                $arguments[$parameterName] = $this->get($className);
            }
        }

        return $arguments;
    }

    /**
     * @param $object
     * @param string $methodName
     * @return false|mixed|null
     * @throws ReflectionException
     */
    public function call($object, string $methodName)
    {
        if (!is_object($object)){
            return null;
        }
        $reflectionClass = new ReflectionClass($object);
        $reflectionMethod = $reflectionClass->getMethod($methodName);

        $arguments = $this->getDependencies($reflectionMethod);



        return call_user_func_array([$object, $methodName], $arguments);
    }

}