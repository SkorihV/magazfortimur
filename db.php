<?php

function connect () {

    $host = '127.0.0.1';
    $user = 'skorihv';
    $password = '';
    $bd = 'phpwebinars';

    $connect = mysqli_connect($host, $user, $password, $bd);
    if(mysqli_connect_errno()) {
        $error = mysqli_connect_error();
        var_dump($error);
        exit;
    }

    mysqli_query($connect, "SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
    mysqli_query($connect, "SET CHARACTER SET 'utf8'");

    return $connect;
}

function query ($connect, $query) {
    $result = mysqli_query($connect, $query);

    if (mysqli_errno($connect)) {
        $error = mysqli_error($connect);
        var_dump($error);
        exit;
    }

    return $result;
}