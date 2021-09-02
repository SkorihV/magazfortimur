<?php

namespace App\Category;


use App\Product\ProductService;
use App\Renderer;
use App\Request;
use App\Response;
use App\Router\Route;

class CategoryController
{
    /**
     * @var Route
     */
    private Route $params;

    public function __construct(Route $params)
    {
        $this->params = $params;
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
        $smarty = Renderer::getSmarty();
        $smarty->display('categories/add.tpl');
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
    }

    public function list(CategoryService $categoryService)
    {

        $category = $categoryService->getList();

        $smarty = Renderer::getSmarty();
        $smarty->assign('categories', $category);
        $smarty->display('categories/index.tpl');

    }

    public function view(Request $request, CategoryService $categoryService, ProductService $productService)
    {
        $category_id = $request->getIntFromGet('id', null);


        if (is_null($category_id)) {
            $category_id = $this->params['id'] ?? null;
        }

        $category = $categoryService->getById( $category_id);
        $products = $productService->getListByCategoryId($category_id);

        $smarty = Renderer::getSmarty();
        $smarty->assign('current_category', $category);
        $smarty->assign("products", $products);
        $smarty->display('categories/view.tpl');
    }
}