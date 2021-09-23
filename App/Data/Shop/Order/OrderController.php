<?php

namespace App\Data\Shop\Order;

use App\Controller\AbstractController;
use App\Data\Product\ProductRepositoryOld;
use App\Data\User\UserModel;
use App\Http\Response;
use App\Model\Exceptions\ManyModelIdFieldException;
use App\Model\ModelAnalyzer;
use App\Model\ModelManager;
use App\Utils\ReflectionUtil;


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
    public function create(ModelManager $manager, ProductRepositoryOld $productRepository, UserModel $user = null)
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

            $orderItem = new OrderItemModel($amount, $product, $order);

            $order->addItem($orderItem);
        }

        if (!is_null($user)) {
            $order->setUserId($user);
        }

//        $order->getById(); => 0

        $manager->save($order);
        //както сохранаяем

        foreach ($order->getItems() as $item ) {
            $manager->save($item);
        }
        return $this->redirect("/order/list");
    }

    /**
     * @route("/order/update")
     */
    public function update(OrderRepository $orderRepository,
                           OrderItemRepository $orderItemRepository,
                           ReflectionUtil $reflectionUtil,
                           ModelAnalyzer $modelAnalyzer)
    {

        $orderItem = $orderItemRepository->find(2);

        /**
         * @var $orderItemProxy OrderItemModelProxy
         */
        $orderItemProxy = $this->di->get(OrderItemModelProxy::class);

        
        
//        $orderItemProxy = new OrderItemModelProxy();

        $reflectionUtil->setPrivateValue($orderItemProxy, $modelAnalyzer->getIdPropertyName($orderItemProxy), 2);
       // $orderItemProxy->getAmount();

        echo "<pre>";
var_dump("App/Data/Shop/Order/OrderController.php : 71", $orderItemProxy);
echo "</pre>";
        exit;
        
//        $order = $orderRepository->find(13);


//        echo "<pre>";
//        var_dump($order);
//        echo "</pre>";
//        exit;
//        $productsForOrder = [
//            [115, 40],
//            [117, 2],
//            [119, 4],
//        ];
//
//
//        $order = new OrderModel();
//
//        foreach ($productsForOrder as $info) {
//            [$productId, $amount] = $info;
//
//            $product = $productRepository->getById($productId);
//
//            $orderItem = new OrderItemModel($amount, $product, $order);
//
//            $order->addItem($orderItem);
//        }
//
//        if (!is_null($user)) {
//            $order->setUserId($user);
//        }
//
//
//        $manager->save($order);
//        //както сохранаяем
//
//        foreach ($order->getItems() as $item ) {
//            $manager->save($item);
//        }

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