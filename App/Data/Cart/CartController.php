<?php

namespace App\Data\Cart;

use App\Controller\AbstractController;
use App\Data\Category\CategoryModel;
use App\Data\Product\ProductRepository;

class CartController extends AbstractController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @route("/shop/cart")
     */
    public function index(ProductRepository $productRepository)
    {
       $cart = new Cart();
       $product = $productRepository->getById(113);


       $amount = 2;

       $cart->addProduct($amount, $product);
       $cart->addProduct($amount, $product);
$cart->changeAmount(-2, $product);

$cart->removeProduct($product);


       return $this->render('cart/index.tpl', [
           'cart' => $cart
       ]);
    }

    /**
     * @route("/shop/cart/add")
     */
    public function addProduct()
    {

        return  $this->redirect("/shop/cart");
    }
}