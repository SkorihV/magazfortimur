<?php

namespace App\Utils;

class ReflectionUtil
{
    public function setPrivateValue($object, string $propertyName, $propertyValue)
    {

        $reflectionModel = new \ReflectionObject($object);
        $reflectionId = $reflectionModel->getProperty($propertyName);
        $reflectionId->setAccessible(true);
        $reflectionId->setValue($object, $propertyValue);
        $reflectionId->setAccessible(false);
    }


    public function getClassDocBlock(object $object)
    {
        $reflectionObject = new \ReflectionObject($object);

        return $reflectionObject->getDocComment();
    }
}