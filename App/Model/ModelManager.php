<?php
namespace App\Model;

use App\Data\Shop\Order\OrderModel as Model;
use App\Di\Container;
use App\Units\DocParser;
use ReflectionObject;

class ModelManager
{
    /**
     * @var DocParser
     */
    private DocParser $docParser;

    public function __construct(DocParser $docParser)
    {
        $this->docParser = $docParser;
    }

    public function save(Model $model)
    {

        $reflectionObject = new ReflectionObject($model);
        $docComment = $reflectionObject->getDocComment();
        $docCommentArray = $this->docParser->getAnnotationValue('@Model\Table', $docComment);

        echo "<pre>";
        var_dump($docCommentArray);
        echo "</pre>";

exit;
        $table = 'order';

    }
}