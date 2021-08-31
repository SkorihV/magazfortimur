<?php

namespace App\Product;

use App\Category\Category;

/**
 *
 */
class Product
{
    /**
     * @var int
     */
    protected int $id = 0;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $article = '';

    /**
     * @var float
     */
    protected float $price;

    /**
     * @var int
     */
    protected int $amount;

    /**
     * @var string
     */
    protected string $description = '';

    /**
     * @var Category
     */
    protected Category $category;

    /**
     * @var array
     */
    protected array $images = [];

    /**
     * @param string $name
     * @param string $article
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
     * @return Category|null
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function setCategory(Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param array $images
     * @return $this
     */
    public function setImages(array $images): self
    {
        $this->images = $images;
        return $this;
    }
}