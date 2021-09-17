<?php
namespace App\Data\Shop\Order;

use App\Data\User\UserModel;
use DateTime;


/**
 * @Model\Table("orders")
 */
class OrderModel implements \ArrayAccess
{

    /**
     * @var int
     */
    private int $id = 0;

    /**
     * @var DateTime
     */
    private DateTime $createAt;

    /**
     * @var float
     */
    private float $totalSum;

    /**
     * @var UserModel
     */
    private UserModel $user;

    /**
     * @var OrderItemModel[]
     */
    private $items;



    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getTotalSum(): float
    {
        return $this->totalSum;
    }


    /**
     * @return UserModel
     */
    public function getUser(): UserModel
    {
        return $this->user;
    }

    /**
     * @param UserModel $user
     * @return OrderModel
     */
    public function setUser(UserModel $user): OrderModel
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return OrderItemModel[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(OrderItemModel $item)
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @param OrderItemModel[] $items
     * @return OrderModel
     */
    public function setItems(array $items): OrderModel
    {
        $this->items = $items;
        return $this;
    }


    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }
}