<?php

namespace App\Middleware;

use App\Data\Cart\Cart;
use App\Di\Container;

class CartMiddleware implements IMiddleware
{

    /**
     * @var Container
     */
    private Container $di;

    /**
     * @var Cart|mixed|null
     */
    private $cart;

    public function __construct(Container $di)
    {

        $this->di = $di;

        $cartSerializedData = $_SESSION['cart'] ?? null;
        $cart = null;


        if(!is_null($cartSerializedData)) {
            $cart = unserialize($cartSerializedData);
        }

        if (!($cart instanceof Cart)) {
            $cart = new Cart();
        }

        $this->cart = $cart;
        $di->addOneMapping(Cart::class, $cart);

    }

    public function beforeDispatch()
    {
        // TODO: Implement run() method.
    }

    public function afterDispatch()
    {
       $_SESSION['cart'] = serialize($this->cart);
    }
}