<?php

namespace App\Data\Shop\Order;


use App\Db\Db;
use App\Di\Container;
use App\Exception\ClassNotExistException;
use App\Model\AbstractModel;
use App\Model\Exceptions\ClassNotAllowedException;
use App\Model\ModelAnalyzer;
use App\Model\ModelManager;
use App\Utils\DocParser;

/**
 * @Model(App\Data\Shop\OrderModel)
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
    protected $docParser;

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

        $model = $this->di->get($modelClass);

        if (!($model instanceof AbstractModel)) {
            $message = 'Class ' . $modelClass . ' does not allowed there. It must be a AbstractModel';
            throw new ClassNotAllowedException($message);
        }


        $tableName = $this->modelAnalyzer->getTableName($model);
        $isColumnName = $this->modelAnalyzer->getIdColumnName($model);


        $query = "SELECT * FROM $tableName WHERE $isColumnName = $id";
        $order = Db::fetchRow($query);

        return $order;
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