<?php
namespace App\Model;

use App\Model\AbstractModel as Model;
use App\Db\Db;
use App\Model\Exceptions\ManyModelIdFieldException;
use App\Utils\DocParser;
use App\Utils\ReflectionUtil;
use App\Utils\StringUtil;
use ReflectionObject;

class ModelManager
{

    /**
     * @var ReflectionUtil
     */
    private $reflectionUtil;

    /**
     * @var ModelAnalyzer
     */
    private $modelAnalyzer;

    public function __construct(ModelAnalyzer $modelAnalyzer, ReflectionUtil $reflectionUtil)
    {
        $this->reflectionUtil = $reflectionUtil;
        $this->modelAnalyzer = $modelAnalyzer;
    }

    /**
     * @param AbstractModel $model
     * @return bool
     * @throws ManyModelIdFieldException
     */
    public function save(Model $model)
    {
        $tableName = $this->modelAnalyzer->getTableName($model);
        $tableFields = $this->modelAnalyzer->getTableFields($model);
        $tableData = [];

        foreach ($tableFields as $objectKey => $tableKey) {
            $objectValue = $model[$objectKey];

            $value = null;

           if (is_object($objectValue)) {
                if (method_exists($objectValue, 'getId')) {
                    $value = $objectValue->getId();
                } else if ($objectValue instanceof \DateTime) {
                    $value = $objectValue->format('Y-m-d H:i');
                }
           } else if (is_array($objectValue)) {
               $value = json_encode($objectValue);
           } else {
               $value = $objectValue;
           }

           if (!is_null($value)) {
               $tableData[$tableKey] =  $value;
           }
        }

        $id = $model->getId();
        $modelIdInfo = $this->modelAnalyzer->getIdField($model);

        if (is_null($modelIdInfo)) {
            return false;
        }

        if ($id) {
            $id = Db::insert($tableName, $tableData);
            $this->reflectionUtil->setPrivateValue($model, $modelIdInfo['objectProperty'], $id);
        } else {
            Db::update($tableName, $tableData, $modelIdInfo['tableProperty'] . " = '$id'");
        }


//        echo "<pre>";
//        var_dump($tableFields);
//        var_dump($tableData);
//        var_dump($model);
//        echo "</pre>";
//
//exit;

        return true;

    }

//    private function getTableName(Model $model)
//    {
//        $reflectionObject = new ReflectionObject($model);
//        $docComment = $reflectionObject->getDocComment();
//        return $this->docParser->getAnnotationValue('@Model\Table', $docComment);
//    }
//
//    private function getTableFields(Model $model)
//    {
//        return $this->getModelFieldsByAnnotate("@Model\TableField", $model);
//    }
//
//    /**
//     * @param Model $model
//     * @return array|null
//     * @throws ManyModelIdFieldException
//     */
//    private function getIdField(Model $model)
//    {
//        $fields = $this->getModelFieldsByAnnotate("@Model\Id", $model);
//
//        if (count($fields) > 1) {
//            $message = 'class ' . get_class($model) . ' can have only one Model\Id annotate';
//            throw new ManyModelIdFieldException($message);
//        }
//
//        if (empty($fields)) {
//            return null;
//        }
//
//        $key = array_key_first($fields);
//        $value = $fields[$key];
//
//        return [
//            'objectProperty'    => $key,
//            'tableProperty'     => $value,
//        ];
//
//    }
//
//    private function getModelFieldsByAnnotate(string $annotate, Model $model )
//    {
//        $fields = [];
//        $reflectionObject = new ReflectionObject($model);
//
//        foreach ($reflectionObject->getProperties() as $property) {
//            $docComment = $property->getDocComment();
//
//            $fieldAnnotate = $annotate;
//
//            if(!$this->docParser->isHasAnnotate($fieldAnnotate, $docComment)) {
//                continue;
//            }
//
//            $propertyName = $property->getName();
//            $field = $this->docParser->getAnnotationValue($fieldAnnotate, $docComment);
//            if (empty($field)) {
//                $field = $property->getName();
//            }
//            $fields[$propertyName] = $this->stringUtil->camelToSnake($field);
//
//        }
//
//        return $fields;
//    }
}