<?php

    if (!empty($_POST)) {
        $product  = get_product_from_post();
        $insert = add_product($connect, $product);

        if ($insert) {
            header('Location: /products/list');
        } else {
            die('какая то ошибка сзаза');
        }
    }

$smarty->display('products/add.tpl');

