<?php

namespace App\Category;

use App\Db\Db;
use App\Request;

class CategoryRepository
{
    public function getList()
    {
       $query = "SELECT * FROM categories";
       $result = Db::fetchAll($query);

       $categories = [];

    foreach ($result as $item) {
        $category = new CategoryModel($item['name']);
        $category->setId($item['id']);

        $categories[] = $category;
    }

    return $categories;
    }

    /**
     * @param $id
     * @return CategoryModel
     */
    public function getById($id)
    {
        $query = "SELECT * FROM categories WHERE id = $id";
        $result = Db::fetchRow($query);

        $category = new CategoryModel($result['name']);
        $category->setId($result['id']);

        return $category;
    }

    /**
     * @param Request $request
     * @return CategoryModel
     */
    public function getFromPostObj(Request $request)
    {
        $result =  [
            'id'    => $request->getIntFromPost('id', false),
            'name'  => $request->getStrFromPost('name'),
        ];

        $category = new CategoryModel($result['name']);
        $category->setId($result['id']);

        return $category;
    }

    /**
     * @param CategoryModel $category
     * @return int|string
     */
    public function uploadById (CategoryModel $category)
    {
        $id     = $category->getId();
        $name   = $category->getName();
        $arr = [
            'name' =>  $name,
        ];
        return Db::update('categories',  $arr, "id = $id");
    }

    public function deleteById($id)
    {
        //вернуться к вопросу позже. При удалении категории у товаров остаются и выпадают с ошибкой
        //Db::update("products", ['category_id' => NULL], "category_id = $id");
        return Db::delete('categories', "id = $id");
    }

}