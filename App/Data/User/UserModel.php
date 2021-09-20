<?php

namespace App\Data\User;

use App\Model\AbstractModel;

/**
 * @Model\Table("users")
 */
class UserModel extends AbstractModel
{
    /**
     * @var int
     * @Model\Id()
     */
    private int $id = 0;

    /**
     * @var string
     * @Model\TableField
     */
    private string $name;

    /**
     * @var string
     * @Model\TableField
     */
    private string $email;

    /**
     * @var string
     * @Model\TableField
     */
    private string $password;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $name
     * @return UserModel
     */
    public function setName(string $name): UserModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $password
     * @return UserModel
     */
    public function setPassword(string $password): UserModel
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }


}