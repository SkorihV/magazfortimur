<?php
namespace App\Data\Shop\Order;

use App\Data\User\UserModel;
use App\Model\AbstractModel;
use DateTime;


/**
 * @Model\Table("orders")
 */
class OrderModel extends AbstractModel
{

    /**
     * @var int
     * @Model\Id()
     */
    protected  $id = 0;

    /**
     * @var DateTime
     * @Model\TableField
     */
    protected $createdAt;

    /**
     * @var float
     * @Model\TableField("totalSum")
     */
    protected $totalSum = 0;

    /**
     * @var UserModel
     * @Model\TableField
     */
    protected  $userId;

    /**
     * @var OrderItemModel[]
     */
    protected $items;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    
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
    public function getUserId(): UserModel
    {
        return $this->userId;
    }

    /**
     * @param UserModel $userId
     * @return OrderModel
     */
    public function setUserId(UserModel $userId): OrderModel
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return OrderItemModel[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function addItem(OrderItemModel $item)
    {
        $this->items[] = $item;
        $this->totalSum += $item->getTotalSum();


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
}