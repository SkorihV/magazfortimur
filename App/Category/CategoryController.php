<?php

namespace App\Category;


use App\Controller\AbstractController;
use App\Product\ProductService;
use App\Renderer;
use App\Request;
use App\Response;
use App\Router\Route;

class CategoryController extends AbstractController
{
//    /**
//     * @var Route
//     */
//    private Route $params;

    public function __construct()
    {
//        $this->params = $params;
    }

    public function add(Request $request, CategoryService $categoryService, Response $response)
    {
        if ($request->isPost()) {
            $category  = $categoryService->getFromPost();
            $insert = $categoryService->add($category);


            if ($insert) {
                $response->redirect('/categories/list');
            } else {
                die('какая то ошибка сзаза');
            }
        }
        //$smarty = Renderer::getSmarty();
       // $smarty->display('categories/add.tpl');


        return $this->render('categories/add.tpl');


    }

    public function delete(Request $request, CategoryService $categoryService, Response $response)
    {
        $id = $request->getIntFromPost('id' );

        if (!$id) {
            die ("error");
        }


        $deleted =  $categoryService->deleteById($id);

        if ($deleted) {
            $response->redirect('/categories/list');
        } else {
            die('какая то ошибка сзаза');
        }
    }

    public function edit(Request $request, CategoryService $categoryService, Response $response)
    {
        $id = $request->getIntFromGet('id', null);

        if (is_null($id)) {
            $id = $this->params['id'] ?? null;
        }

        $category = [];

        if ($id) {
            $category = $categoryService->getById($id);
        }

        if ($request->isPost()) {

            $category = $categoryService->getFromPost( );

            $edited = $categoryService->uploadById($id, $category);

            if ($edited) {
                $response->redirect('/categories/list');
            } else {
                die('какая то ошибка сзаза');
            }
        }

        $smarty = Renderer::getSmarty();
        $smarty->assign('category', $category);
        $smarty->display('categories/edit.tpl');


        return $this->render('categories/edit.tpl', [
            'categories' => $category
        ]);

    }

    /**
     * @param CategoryService $categoryService
     *
     * @return mixed
     * @route("/categories/list")
     */
    public function list(CategoryService $categoryService)
    {

        $category = $categoryService->getList();

        return $this->render('categories/index.tpl', [
            'categories' => $category
        ]);
    }

    public function view(Request $request, CategoryService $categoryService, ProductService $productService)
    {
        $category_id = $request->getIntFromGet('id', null);


        if (is_null($category_id)) {
            $category_id = $this->params['id'] ?? null;
        }

        $category = $categoryService->getById( $category_id);
        $products = $productService->getListByCategoryId($category_id);


        return $this->render('categories/view.tpl', [
            'categories' => $category,
            "products" => $products
        ]);

    }
}