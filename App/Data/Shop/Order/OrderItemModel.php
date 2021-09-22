<?php

namespace App\Data\Shop\Order;

use App\Data\Product\ProductModel;
use App\Model\AbstractModel;

/**
 * @Model\Table("order_items")
 */
class OrderItemModel extends AbstractModel
{

    /**
     * @var int
     * @Model\Id
     */
     protected $id;

    /**
     * @var int
     * @Model\TableField
     */
    protected int $amount;

    /**
     * @var float
     * @Model\TableField
     */
    protected $totalSum;

    /**
     * @var ProductModel
     * @Model\TableField("product_id")
     */
    protected $product;

    /**
     * @var array
     * @Model\TableField
     */
    protected array $productData;

    //     * @Model\TableField("order_id")
    /**
     * @var OrderModel
     *
     */
    protected  $order;

    /**
     * @param int $amount
     * @param ProductModel $productModel
     * @param OrderModel $order
     */
    public function __construct(int $amount, ProductModel $productModel, OrderModel $order)
    {
        $this->amount = $amount;
        $this->totalSum = $amount * $productModel->getPrice();
        $this->order = $order;
        $this->product = $productModel;
        $this->productData = [
             'name' => $productModel->getName(),
             'price' => $productModel->getPrice(),
             'article' => $productModel->getArticle(),
        ];
    }

    public function getId(): int
    {
       return $this->id;
    }


    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getTotalSum(): float
    {
        return $this->totalSum;
    }
}