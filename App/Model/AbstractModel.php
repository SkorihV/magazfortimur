<?php

namespace App\Model;

use ReflectionObject;

class AbstractModel implements \ArrayAccess
{
    public function offsetExists($offset)
    {
        return property_exists($this, $offset);
    }

    public function offsetGet($offset)
    {

        /*Если мы хотим использовать свойства в наследуемом классе( модели ) private то этот код*/

//        $reflectionObject = new ReflectionObject($this);
//        $reflectionProperty = $reflectionObject->getProperty($offset);
//        $reflectionProperty->setAccessible(true);
//        return $reflectionProperty->getValue($this);

        /*Если достаточно protected ир этот'*/


         return $this->{$offset};
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

//    abstract public function getId(): int;
}