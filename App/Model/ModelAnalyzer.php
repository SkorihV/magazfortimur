<?php

namespace App\Model;

use App\Model\AbstractModel as Model;
use App\Model\Exceptions\ManyModelIdFieldException;
use App\Utils\DocParser;
use App\Utils\ReflectionUtil;
use App\Utils\StringUtil;


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


    public function __construct(DocParser $docParser, StringUtil $stringUtil)
    {
        $this->docParser = $docParser;
        $this->stringUtil = $stringUtil;

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
        $isFieldData = $this->getIdField($model);

        if (is_null($isFieldData)) {
            return null;
        }
        return $isFieldData['tableProperty'];

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


}