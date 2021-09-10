<?php

namespace App\Data\User;

use App\Db\Db;

class UserRepository
{
    /**
     * @param UserModel $user
     * @return UserModel
     */
    public function save(UserModel $user): UserModel
    {
        $id = $user->getId();
        $arrayData = $this->toArray($user);


        if ($id) {
            Db::update('users', $arrayData, "id = $id");
            return $user;

        }
        $id = Db::insert("users", $arrayData);

        $user->setId($id);

        return $user;

    }

    public function fromArray(array $data): UserModel
    {
        $id             = $data['id'];

        $name           = $data['name'] ?? null;
        $email          = $data['email'] ?? null;
        $password       = $data['password'] ?? null;

        if (is_null($name)) {
            throw new \Exception('Имя для инициализации пользователя обязательно');
        }
        if (is_null($email)) {
            throw new \Exception('Почта для инициализации пользователя обязательно');
        }
        if (is_null($password)) {
            throw new \Exception('Пароль для инициализации пользователя обязательно');
        }


        $user= new UserModel($name, $email, $password);


        $user
            ->setId($id);


        return $user;

    }

    /**
     * @param UserModel $user
     * @return array
     */
    public function toArray(UserModel $user): array
    {
        $data =  [
            'name'              => $user->getName(),
            'email'             => $user->getEmail(),
            'password'          => $user->getPassword(),
        ];

        return $data;
    }

    public function getById(int $id)
    {
        $query = "SELECT u.*  FROM users u  WHERE u.id = $id";

        $userArray =  Db::fetchRow($query);
        return $this->fromArray($userArray);


    }

    /**
     * @param $email
     * @param $password
     * @return UserModel|null
     * @throws \Exception
     */
    public function findByEmailAndPassword($email, $password): ?UserModel
    {
        $query = "SELECT u.*  FROM users u  WHERE u.email = '$email' AND u.password = '$password'";

        $userArray =  Db::fetchRow($query);

        if(empty($userArray)) {
            return null;
        }

        return $this->fromArray($userArray);

    }
}