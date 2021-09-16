<?php

namespace App\AuthMiddleware;

use App\Data\Cart\Cart;
use App\Di\Container;

class CartMiddleware implements IMiddleware
{

    public function __construct(Container $di)
    {


        $cartSerializedData = $_SESSION['cart'] ?? null;
        $cart = null;

        echo "<pre>";
        var_dump(1);
        echo "</pre>";

        if(!is_null($cartSerializedData)) {
            $cart = unserialize($cartSerializedData);

        }

        if (!$cart instanceof Cart) {
            $cart = new Cart();
        }

        $cart = new Cart();


        $di->addOneMapping(Cart::class, $cart);


        //
    }

    public function beforeDispatch()
    {
        // TODO: Implement run() method.
    }

    public function afterDispatch()
    {
        // TODO: Implement afterDispatch() method.
    }
}