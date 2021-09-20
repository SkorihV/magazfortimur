<?php

namespace App\Data\Product;

use App\Data\Category\CategoryModel;


/**
 * @Model\Table("products")
 */
class ProductModel
{
    /**
     * @var int
     * @Model\Id()
     */
    protected int $id = 0;

    /**
     * @var string
     * @Model\TableField
     */
    protected string $name;

    /**
     * @var string
     * @Model\TableField
     */
    protected string $article = '';

    /**
     * @var float
     * @Model\TableField
     */
    protected float $price;

    /**
     * @var int
     * @Model\TableField
     */
    protected int $amount;

    /**
     * @var string
     * @Model\TableField
     */
    protected string $description = '';

    /**
     * @var CategoryModel
     * @Model\TableField("category_id")
     */
    protected CategoryModel $category;

    /**
     * @var ProductImageModel[]
     */
    protected array $images = [];

    /**
     * @param string $name
     * @param float $price
     * @param int $amount
     */
    public function __construct(string $name, float $price, int $amount)
    {
        $this->setName($name);
        $this->setPrice($price);
        $this->setAmount($amount);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getArticle(): string
    {
        return $this->article;
    }

    /**
     * @param string $article
     * @return $this
     */
    public function setArticle(string $article): self
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return $this
     */
    public function setAmount(int $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return CategoryModel|null
     */
    public function getCategory(): CategoryModel
    {
        return $this->category;
    }

    /**
     * @param CategoryModel $category
     * @return $this
     */
    public function setCategory(CategoryModel $category): self
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return ProductImageModel[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param ProductImageModel[] $images
     * @return $this
     */
    public function setImages(array $images): self
    {
        $this->images = $images;
        return $this;
    }

    public function addImage(ProductImageModel $productImage): self
    {
        $this->images[] = $productImage;
        return $this;
    }
}