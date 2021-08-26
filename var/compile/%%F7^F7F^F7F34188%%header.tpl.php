<?php /* Smarty version 2.6.31, created on 2021-08-26 11:28:18
         compiled from header.tpl */ ?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Список товаров</title>
</head>
<?php echo '
<style>
    html, body {
        margin: 0;
        padding: 0;
        font: normal 13px Arial, Helvetica;
    }
    .site-wrapper {
        background-color: #eae7e5;
        width:980px;
        margin: 0 auto;
        padding: 30px;
    }
    .table-products {
        border-collapse: collapse;
    }
    .table-products td,
    .table-products tr {
        padding: 5px;
        border: 1px solid blue;
    }
    .table-products th {
        padding: 10px;
    }

    .form {
        display: flex;
        flex-direction: column;
        width: 100%;
    }
    .form label {
        width: 100%;
        display: flex;
        flex-direction: row;
        margin: 5px;
    }

    .form .div-label {
        flex: 1 1 auto;
        max-width: 30%;
    }
    .form input {
        flex: 1 1 auto;
        padding: 5px;
    }
</style>
'; ?>


<body>
<div class="site-wrapper">
    <h1><?php echo $this->_tpl_vars['h1']; ?>
</h1>
    <p>
        <a href="/products/list">На главную</a>
    </p>