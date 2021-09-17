<?php

namespace App\Data\Shop\Order;

use App\Data\Product\ProductModel;

class OrderItemModel
{
    /**
     * @var int
     */
    private int $amount;

    /**
     * @var float
     */
    private float $total;

    /**
     * @var array
     */
    private array $productData;

    /**
     * @var OrderModel
     */
    private  $order;

    public function __construct(int $amount, ProductModel $productModel)
    {
        $this->amount = $amount;
//        $this->productData = $productModel;

    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getTotal(): float
    {
        return $this->total;
    }
}