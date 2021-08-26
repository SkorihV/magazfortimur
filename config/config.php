<?php
require_once __DIR__ . '/../libs/Smarty/Smarty.class.php';
require_once __DIR__ . '/../App/Product.php';
require_once __DIR__ . '/../App/Category.php';


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

$connect = connect();

function query ($connect, $query) {
    $result = mysqli_query($connect, $query);

    if (mysqli_errno($connect)) {
        $error = mysqli_error($connect);
        var_dump($error);
        exit;
    }
    return $result;
}

$smarty = new Smarty();
$smarty->template_dir = __DIR__ . '/../templates';
$smarty->compile_dir = __DIR__ . '/../var/compile';
$smarty->cache_dir = __DIR__ . '/../var/cache';
$smarty->config_dir = __DIR__ . '/../var/configs';


