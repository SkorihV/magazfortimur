<?php

class Db
{
    private static $connect;
    private static $host = '127.0.0.1';
    private static $user = 'skorihv';
    private static $password = '';
    private static $bd = 'phpwebinars';

    public static function getConnect()
    {
        if (is_null(static::$connect)) {
            static::$connect = static::connect();
        }

        return static::$connect;
    }
    
    private static function connect () {

        $connect = mysqli_connect(static::$host, static::$user, static::$password, static::$bd);
        if(mysqli_connect_errno()) {
            $error = mysqli_connect_error();
            var_dump($error);
            exit;
        }

        mysqli_query($connect, "SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
        mysqli_query($connect, "SET CHARACTER SET 'utf8'");

        return $connect;
    }

    public static function query ($query) {
        $conn = static::getConnect();
        $result = mysqli_query($conn, $query);

        if (mysqli_errno($conn)) {
            $error = mysqli_error($conn);
            var_dump($error);
            exit;
        }
        return $result;
    }

}

