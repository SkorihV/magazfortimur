<?php

namespace App\Data\User;

class UserService
{
    protected static $salt = "Xg(F1/ou1)ak";

    public function passwordEncoder(string $password)
    {
        return $this->encodeByCrypt($password);
    }

    protected function encodeByMd5(string $encodeString) {
        return md5(md5($encodeString . static::$salt) . static::$salt);
    }

    protected function encodeByCrypt(string $encodeString) {
        return password_hash($encodeString, PASSWORD_DEFAULT);
    }
}