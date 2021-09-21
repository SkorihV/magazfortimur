<?php

namespace App\Data\Shop\Order;


use App\Db\Db;
use App\Di\Container;
use App\Exception\ClassNotExistException;
use App\Model\AbstractModel;
use App\Model\Exceptions\ClassNotAllowedException;
use App\Model\ModelAnalyzer;
use App\Utils\DocParser;


/**
 * @Model(App\Data\Shop\Order\OrderModel)
 */
class OrderRepository
{

    const FIND_BY_AND = 'and';
    const FIND_BY_OR = 'or';

    /**
     * @var ModelAnalyzer
     * @onInit(App\Model\ModelAnalyzer)
     */
    protected $modelAnalyzer;

    /**
     * @var DocParser
     * @onInit(App\Utils\DocParser)
     */
    protected DocParser $docParser;

    /**
     * @var Container
     * @onInit(App\Di\Container)
     */
    protected $di;

    public function find(int $id)
    {
        $modelClass = $this->docParser->getClassAnnotatie($this, '@Model');

        if (!class_exists($modelClass)) {
            $message = 'Class ' . $modelClass . ' does not exist';
            throw new ClassNotExistException($message);
        }

        /**
         * @var $exampleModel AbstractModel
         */
        $exampleModel = $this->di->get($modelClass);

        if (!($exampleModel instanceof AbstractModel)) {
            $message = 'Class ' . $modelClass . ' does not allowed there. It must be a AbstractModel';
            throw new ClassNotAllowedException($message);
        }

        $tableName = $this->modelAnalyzer->getTableName($exampleModel);
        $idColumnName = $this->modelAnalyzer->getIdColumnName($exampleModel);
        $idPropertyName = $this->modelAnalyzer->getIdColumnName($exampleModel);




        $query = "SELECT * FROM $tableName WHERE $idColumnName = $id";
        $modelArray = Db::fetchRow($query);

        /**
         * @var $model AbstractModel
         */
        $model = $this->di->get($modelClass);
        $this->modelAnalyzer->setId($model, $id);

        $tableFields = $this->modelAnalyzer->getTableFields($exampleModel);


        foreach ($tableFields as $propertyName => $propertyField) {
            $propertyValue = $modelArray[$propertyField] ?? null;

            if (!is_null($propertyValue)) {
                $this->modelAnalyzer->setProperty($model, $propertyName, $propertyValue);
            }
        }

        echo "<pre>";
        var_dump($tableFields);
        var_dump($modelArray);
        var_dump($model);
        echo "</pre>";
exit;

        return $modelArray;
    }

    public function findBy(array $condition)
    {
//        $condition = [
//            'find1' => 'value1'
//        ];

    }

    public function findAll()
    {

    }

    public function findAllBy(array $condition, int $offset = 0, $limit = 100, string $findBy = self::FIND_BY_AND)
    {
//        $condition = [
//            'find1' => 'value1'
//        ];

    }

}