<?php

namespace App\Data\Shop\Order;

use App\Controller\AbstractController;
use App\Data\Product\ProductRepository;
use App\Model\ModelManager;


class OrderController extends AbstractController
{

    /**
     * @route("/order/list")
     */
    public function index()
    {
        return $this->render('shop/order/index.tpl', []);
    }

    /**
     * @route("/order/create")
     */
    public function create(ModelManager $manager, ProductRepository $productRepository)
    {
        $productsForOrder = [
            [115, 40],
            [117, 2],
            [119, 4],
        ];


        $order = new OrderModel();

        foreach ($productsForOrder as $info) {
            [$productId, $amount] = $info;

            $product = $productRepository->getById($productId);

            $orderItem = new OrderItemModel($amount, $product);

            $order->addItem($orderItem);
        }


//        $order->getById(); => 0

        $manager->save($order);
        //както сохранаяем


//        $order->getById(); => 5



        return $this->redirect("/order/list");
    }

    /**
     * @route("/order/view/{id}")
     */
    public function view(int $id)
    {
        return $this->render('shop/order/view.tpl', []);

    }

    /**
     * @route("/order/delite")
     */
    public function delete()
    {
        return $this->redirect("/order/list");
    }
}