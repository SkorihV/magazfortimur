<?php

namespace App\Data\Cart;

use App\Controller\AbstractController;
use App\Data\Category\CategoryModel;
use App\Data\Product\ProductRepositoryOld;

class CartController extends AbstractController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @route("/shop/cart")
     */
    public function index(Cart $cart, ProductRepositoryOld $productRepository)
    {
//       $cart = new Cart();
//       $product = $productRepository->getById(113);
//
//
//       $amount = 2;
//
//       $cart->addProduct($amount, $product);
//       $cart->addProduct($amount, $product);
//$cart->changeAmount(-2, $product);
//
//$cart->removeProduct($product);





       return $this->render('cart/index.tpl', [
           'cart' => $cart
       ]);
    }

    /**
     * @param Cart $cart
     * @param ProductRepositoryOld $productRepository
     * @return \App\Http\Response
     *
     * @route("/shop/cart/add")
     */
    public function addProduct(Cart $cart, ProductRepositoryOld $productRepository)
    {

        $id = $this->request->getIntFromGet('id');
        $amount = $this->request->getIntFromGet('amount', 1);


        if($id) {
            $product = $productRepository->getById($id);
            $cart->addProduct($amount, $product);

            $_SESSION['cart'] = serialize($cart);
        }


        return  $this->redirect("/shop/cart");
    }

    /**
     * @param Cart $cart
     * @param ProductRepositoryOld $productRepository
     * @return \App\Http\Response
     *
     * @route("/shop/cart/remove")
     */
    public function removeProuct(Cart $cart, ProductRepositoryOld $productRepository)
    {

        $id = $this->request->getIntFromGet('id');


        if($id) {
            $product = $productRepository->getById($id);
            $cart->removeProduct($product);

            $_SESSION['cart'] = serialize($cart);
        }


        return $this->redirect('/shop/cart');
    }
}