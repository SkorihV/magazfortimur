<?php

namespace App\Utils;

use ReflectionObject;

class ReflectionUtil
{
    public function getClassAnnotatie(object $object, string $annotation)
    {

        $docComment = $this->getClassDocBlock($object);


        return $this->getAnnotationValue($annotation, $docComment, false);
    }

    public function toArray(string $docComment)
    {
        $docComment = str_replace(['/**', '*/'], '', $docComment);
        $docComment = trim($docComment);
        $docCommentArray = explode("\n", $docComment);

        $docCommentArray = array_map(function ($item) {
            $item = trim($item);

            $position = strpos($item, '*');
            if ($position === 0) {
                $item = substr($item, 1);
            }

            return trim($item);
        }, $docCommentArray);

        return $docCommentArray;
    }

    public function getAnnotationValue(string $annotation, string $docComment, bool $replaceQuotes = true)
    {
        $docCommentArray = $this->toArray($docComment);
        $annotateValue = null;

        foreach ($docCommentArray as $docCommentItem) {

            $annotationPrefix = $annotation . '(';
            $isHasAnnotate = strpos($docCommentItem, $annotationPrefix) === 0;


            if (!$isHasAnnotate) {
                continue;
            }

            $annotateValue = str_replace($annotationPrefix, '', $docCommentItem);
            $annotateValue = substr($annotateValue, 0, -1);

            if ($replaceQuotes && !empty($annotateValue)) {
                $annotateValue = substr($annotateValue, 1, -1);
            }

            break;
        }

        return $annotateValue;
    }

    /**
     * @param string $annotation
     * @param string $docComment
     * @return bool
     */
    public function isHasAnnotate(string $annotation,  string $docComment): bool
    {
        return strpos($docComment, $annotation) !== false;
    }


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

    public function getProperyType($object, string $propertyName)
    {
        $reflectionObject = new ReflectionObject($object);
        $reflectionProperty = $reflectionObject->getProperty($propertyName);

        $docComment = $reflectionProperty->getDocComment();
        $type = $this->getVarDocValue( $docComment);

        if (strpos($type, '\\') === 0) {
            return $type;
        }

        $firstChar = $type[0];

        $firstCharLower = strtolower($firstChar);

        if ($firstChar === $firstCharLower) {
            return $type;
        }

       $line =  $reflectionObject->getStartLine();

        return $type;
    }

    public function getVarDocValue(string $docComment)
    {
        $docArray = $this->toArray($docComment);
        $varDoc = null;

        foreach ($docArray as $docString) {
            if (strpos($docString, "@var ") === 0) {
                $varDoc = $docString;
                break;
            }
        }

        if (is_null($varDoc)) {
            return null;
        }

        $value = substr($varDoc, 5);
        $value = trim($value);

        $validateType = [
            'int',
            'integer',
            'float',
            'string',
            'bool',
            'boolean',
//            'array',
        ];


        return $value;


    }
}

