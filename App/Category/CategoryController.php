<?php

namespace App\Category;


use App\Controller\AbstractController;
use App\Product\ProductRepository;
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
        $category = new CategoryModel('');
        $category->setId(0);
        if ($request->isPost()) {

            $category  = $categoryService->getFromPost($request);
            $insert = $categoryService->add($category);


            if ($insert) {
                $response->redirect('/categories/list');
            } else {
                die('какая то ошибка сзаза');
            }
        }

        return $this->render('categories/add.tpl',[
            'category' => $category
        ]);
    }

    public function delete(Request $request, CategoryService $categoryService, Response $response, CategoryRepository $categoryRepository)
    {
        $id = $request->getIntFromPost('id' );

        if (!$id) {
            die ("error");
        }


        $deleted =  $categoryRepository->deleteById($id);

        if ($deleted) {
            $response->redirect('/categories/list');
        } else {
            die('какая то ошибка сзаза');
        }
    }

    public function edit(Request $request, CategoryService $categoryService, Response $response, CategoryRepository $categoryRepository)
    {


        $id = $request->getIntFromGet('id', null);

        if (is_null($id)) {
            $id = $this->params['id'] ?? null;
        }

        $category = [];

        if ($id) {
            $category = $categoryRepository->getById($id);
        }

        if ($request->isPost()) {

            $category = $categoryRepository->getFromPostObj($request);

            $edited = $categoryRepository->uploadById($category);


            if ($edited) {
                $response->redirect('/categories/list');
            } else {
                die('какая то ошибка сзаза');
            }
        }

//        $smarty = Renderer::getSmarty();
//        $smarty->assign('category', $category);
//        $smarty->display('categories/edit.tpl');


        return $this->render('categories/edit.tpl', [
            'category' => $category
        ]);

    }

    /**
     * @param CategoryService $categoryService
     *
     * @return mixed
     * @route("/categories/list")
     */
    public function list(CategoryRepository $categoryRepository)
    {

        $categories = $categoryRepository->getList();

        return $this->render('categories/index.tpl', [
            'categories' => $categories
        ]);
    }

    public function view(Request $request,
                         CategoryService $categoryService,
                         ProductService $productService,
                         CategoryRepository $categoryRepository,
                         ProductRepository $productRepository)
    {
        $category_id = $request->getIntFromGet('id', null);


        if (is_null($category_id)) {
            $category_id = $this->params['id'] ?? null;
        }

        $category = $categoryRepository->getById( $category_id);
        $products = $productService->getListByCategoryId($category_id);

        return $this->render('categories/view.tpl', [
            'categories' => $category,
            "products" => $products
        ]);

    }
}