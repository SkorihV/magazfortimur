<?php

namespace App\Category;

use App\Category;
use App\Product;
use App\Renderer;
use App\Request;
use App\Response;

class CategoryController
{
    public function add()
    {
        if (Request::isPost()) {
            $category  = Category::getFromPost();
            $insert = Category::add($category);


            if ($insert) {
                Response::redirect('/category/list');
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

        $deleted =  Category::deleteById($id);

        if ($deleted) {
            Response::redirect('/category/list');
        } else {
            die('какая то ошибка сзаза');
        }
    }

    public function edit()
    {
        $id = Request::getIntFromGet('id', false);

        $category = [];

        if ($id) {
            $category = Category::getById($id);
        }

        if (Request::isPost()) {

            $category = Category::getFromPost();

            $edited = Category::uploadById($id, $category);

            if ($edited) {
                Response::redirect('/category/list');
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
        $category = Category::getList();

        $smarty = Renderer::getSmarty();
        $smarty->assign('categories', $category);
        $smarty->display('categories/index.tpl');

    }

    public function view()
    {
        $category_id = Request::getIntFromGet('id');

        $category = Category::getById( $category_id);
        $products = Product::getListByCategoryId($category_id);

        $smarty = Renderer::getSmarty();
        $smarty->assign('current_category', $category);
        $smarty->assign("products", $products);
        $smarty->display('categories/view.tpl');
    }
}