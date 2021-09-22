<?php

namespace App\Model;

use App\Di\Container;
use App\FS\FS;
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
     * @onInit(App\Utils\DocParser)
     */
    private  $docParser;

    /**
     * @var StringUtil
     * @onInit(App\Utils\StringUtil)
     */
    private $stringUtil;

    /**
     * @var ReflectionUtil
     * @onInit(App\Utils\ReflectionUtil)
     */
    private $reflectionUtil;

    /**
     * @var Container
     * @onInit(App\Di\Container)
     */
    private $di;

    /**
     * @var FS
     * @onInit(App\FS\FS)
     */
    private $fs;

    /**
     * @var array
     */
    private $repositoryDictionary;

    public function __construct()
    {
//        $this->docParser = $docParser;
//        $this->stringUtil = $stringUtil;
//        $this->reflectionUtil = $reflectionUtil;
//        $this->di = $di;
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

    public function getRelations(Model $model)
    {
        return $this->getModelFieldsByAnnotate("@Model\Relation", $model);
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

    public function setRelation(AbstractModel $model, string $property, $outsideTableFieldName)
    {
        $propertyType = $this->reflectionUtil->getProperyType($model, $property);
//echo "<pre>";
//var_dump("App/Model/ModelAnalyzer.php : 157", $propertyType);
//echo "</pre>";


        $value = $this->generateRelationType($model, $propertyType, $outsideTableFieldName);

echo "<pre>";
var_dump("App/Model/ModelAnalyzer.php : 164", $value);
echo "</pre>";

//        $value = $this->caseTypeFromOutside($propertyType, $value);
//        $this->reflectionUtil->setPrivateValue($model, $property, $value);
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

    private function generateRelationType(AbstractModel $model, string $propertyType, $outsideTableFieldName)
    {
        $value = null;

        $isArrayType = strpos($propertyType, '[]') !== false;

        if ($isArrayType) {
            $propertyType = str_replace('[]', '', $propertyType);
        }

        $repository = $this->getRepositoryForModelClass($propertyType);
        $id = $model->getId();

        $where = [
            $outsideTableFieldName => $id,
        ];

        if($isArrayType) {
           $value =  $repository->findAllBy($where);
        } else {
            $value =  $repository->findBy($where);

        }

        return $value;
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


                /**
                 * @todo
                 *
                 * Задача на следующий урок:
                 *  - реализовать новый репозиторий для юзера
                 *  - перевести юзера на новый механизм моделей
                 *
                 *
                 * Если тип - это модель, то нужно подтянуть в качестве значения - саму модель
                 * Если мы подтягиваем модель, то делать это надо через специальный репозиторий
                 * если делаем через репозиторий, тио надо искать подходящий репозиторий на основе аннатаций
                 *
                 * либо делать ленивую загрузку объекта, инициализировать только во время запроса но все равно через репозиторий
                 */

            if ($this->di->isInstanceOf($propertyType, AbstractModel::class)) {
                $repository = $this->getRepositoryForModelClass($propertyType);
                $value = $repository->find($value);
            }
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

    protected function getRepositoryForModelClass(string $modelClass) {
        $repositoryClass = $this->getRepositoryClassByModelClass($modelClass);
        

        

        /**
         * @var $repository AbstractRepository
         */
        $repository = $this->di->get($repositoryClass);

        return $repository;
    }


    protected function getRepositoryClassByModelClass(string $modelClass) {
        $repositories = $this->getAllRepositories();

        return $repositories[$modelClass] ?? null;
    }

    protected function getAllRepositories()
    {
        if (is_array($this->repositoryDictionary)) {
            return $this->repositoryDictionary;
        }

        $files =  $this->fs->scanDir(APP_DIR . '/App');

        $repositories = [];

        foreach ($files as $filePath) {
            if (strpos($filePath, 'Repository.php') === false) {
                continue;
            }
            $repoClass = $this->getRepositoryClassName($filePath);
            $modelClass = $this->getRepositoryModel($repoClass);

            if(!is_null($modelClass)) {
                $repositories[$modelClass] = $repoClass;
            }
        }

        $this->repositoryDictionary = $repositories;

        return $this->repositoryDictionary;
    }

    protected function getRepositoryClassName($filePath)
    {
        $className = str_replace([APP_DIR . '/', '.php'], '', $filePath);
        return str_replace([ '/', ], '\\', $className);
    }

    protected function getRepositoryModel(string $className)
    {
        $repo = $this->di->get($className);
        return $this->docParser->getClassAnnotate($repo, '@Model');
    }
}