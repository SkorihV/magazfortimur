<?php

namespace App\Model;

use App\Model\AbstractModel as Model;
use App\Model\Exceptions\ManyModelIdFieldException;
use App\Utils\DocParser;
use App\Utils\ReflectionUtil;
use App\Utils\StringUtil;
use DateTime;


class ModelAnalyzer
{
    /**
     * @var DocParser
     */
    private  $docParser;

    /**
     * @var StringUtil
     */
    private $stringUtil;

    /**
     * @var ReflectionUtil
     */
    private $reflectionUtil;


    public function __construct(DocParser $docParser, StringUtil $stringUtil, ReflectionUtil $reflectionUtil)
    {
        $this->docParser = $docParser;
        $this->stringUtil = $stringUtil;
        $this->reflectionUtil = $reflectionUtil;
    }

    public function getTableName(Model $model)
    {
        $reflectionObject = new \ReflectionObject($model);
        $docComment = $reflectionObject->getDocComment();


        return $this->docParser->getAnnotationValue('@Model\Table', $docComment);
    }


    public function getTableFields(Model $model)
    {
        return $this->getModelFieldsByAnnotate("@Model\TableField", $model);
    }

    /**
     * @param Model $model
     * @return array|null
     * @throws ManyModelIdFieldException
     */
    public function getIdField(Model $model)
    {
        $fields = $this->getModelFieldsByAnnotate("@Model\Id", $model);

        if (count($fields) > 1) {
            $message = 'class ' . get_class($model) . ' can have only one Model\Id annotate';
            throw new ManyModelIdFieldException($message);
        }

        if (empty($fields)) {
            return null;
        }

        $key = array_key_first($fields);
        $value = $fields[$key];

        return [
            'objectProperty'    => $key,
            'tableProperty'     => $value,
        ];
    }

    public function getIdColumnName(Model $model)
    {
        $idFieldData = $this->getIdField($model);

        if (is_null($idFieldData)) {
            return null;
        }

        return $idFieldData['tableProperty'];
    }

    public function getIdPropertyName(Model $model)
    {
        $idFieldData = $this->getIdField($model);

        if (is_null($idFieldData)) {
            return null;
        }

        return $idFieldData['objectProperty'];
    }

    public function setId(AbstractModel $model, int $id)
    {
        $objectProperty = $this->getIdPropertyName($model);
        $this->setProperty($model, $objectProperty, $id);
    }


    /**
     * Назначение свойств модели
     *
     *
     * @param AbstractModel $model
     * @param string $property
     * @param $value
     */
    public function setProperty(AbstractModel $model, string $property, $value)
    {

        $propertyType = $this->reflectionUtil->getProperyType($model, $property);

        $value = $this->caseTypeFromOutside($propertyType, $value);

        $this->reflectionUtil->setPrivateValue($model, $property, $value);

    }

    private function getModelFieldsByAnnotate(string $annotate, Model $model )
    {
        $fields = [];
        $reflectionObject = new \ReflectionObject($model);

        foreach ($reflectionObject->getProperties() as $property) {
            $docComment = $property->getDocComment();

            $fieldAnnotate = $annotate;

            if(!$this->docParser->isHasAnnotate($fieldAnnotate, $docComment)) {
                continue;
            }

            $propertyName = $property->getName();
            $field = $this->docParser->getAnnotationValue($fieldAnnotate, $docComment);
            if (empty($field)) {
                $field = $property->getName();
            }
            $fields[$propertyName] = $this->stringUtil->camelToSnake($field);

        }
        return $fields;
    }

    private function caseTypeFromOutside(string $propertyType, $value)
    {
        switch($propertyType) {
            case "int":
            case "integer":
                $value = (int) $value;
                break;
            case "float":
                $value = (float) $value;
                break;
            case "string":
                $value = (string) $value;
                break;
            case "bool":
            case "boolean":
                $value = (bool) $value;
                break;
            case "DateTime":
                $value = new DateTime($value);
                break;
            default:
                echo "<pre>";
                var_dump('case');
                var_dump($propertyType);
                var_dump($value);
                echo "</pre>";

                exit;
                break;


        }
        return $value;
    }

    private function caseTypeFromInside(string $propertyType, $value)
    {
        switch($propertyType) {
            case "int":
            case "integer":
                $value = (int) $value;
                break;
            case "float":
                $value = (float) $value;
                break;
            case "string":
                $value = (string) $value;
                break;
            case "bool":
            case "boolean":
                $value = (bool) $value;
                break;
        }
        return $value;
    }
}