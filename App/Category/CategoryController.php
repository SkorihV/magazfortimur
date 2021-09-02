<?php

namespace App\Category;

use App\CategoryService;
use App\ProductService;
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

    public function add()
    {
        if (Request::isPost()) {
            $category  = CategoryService::getFromPost();
            $insert = CategoryService::add($category);


            if ($insert) {
                Response::redirect('/categories/list');
            } else {
                die('какая то ошибка сзаза');
            }
        }
        $smarty = Renderer::getSmarty();
        $smarty->display('categories/add.tpl');
    }

    public function delete()
    {
        $id = Request::getIntFromPost('id' );

        if (!$id) {
            die ("error");
        }


        $deleted =  CategoryService::deleteById($id);

        if ($deleted) {
            Response::redirect('/categories/list');
        } else {
            die('какая то ошибка сзаза');
        }
    }

    public function edit()
    {
        $id = Request::getIntFromGet('id', null);

        if (is_null($id)) {
            $id = $this->params['id'] ?? null;
        }

        $category = [];

        if ($id) {
            $category = CategoryService::getById($id);
        }

        if (Request::isPost()) {

            $category = CategoryService::getFromPost();

            $edited = CategoryService::uploadById($id, $category);

            if ($edited) {
                Response::redirect('/categories/list');
            } else {
                die('какая то ошибка сзаза');
            }
        }

        $smarty = Renderer::getSmarty();
        $smarty->assign('category', $category);
        $smarty->display('categories/edit.tpl');
    }

    public function list()
    {

        $category = CategoryService::getList();

        $smarty = Renderer::getSmarty();
        $smarty->assign('categories', $category);
        $smarty->display('categories/index.tpl');

    }

    public function view()
    {
        $category_id = Request::getIntFromGet('id', null);


        if (is_null($category_id)) {
            $category_id = $this->params['id'] ?? null;
        }

        $category = CategoryService::getById( $category_id);
        $products = ProductService::getListByCategoryId($category_id);

        $smarty = Renderer::getSmarty();
        $smarty->assign('current_category', $category);
        $smarty->assign("products", $products);
        $smarty->display('categories/view.tpl');
    }
}