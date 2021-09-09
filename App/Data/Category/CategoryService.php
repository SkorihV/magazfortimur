<?php

namespace App\Data\Category;

use App\Db\Db;
use App\Http\Request;

class CategoryService {
    public function getList ()
    {
        $query = "SELECT * FROM categories";

        return Db::fetchAll($query);
    }

    public function getById ($id)
    {
        $query = "SELECT * FROM categories WHERE id = $id";
        return Db::fetchRow($query);
    }

    public function uploadById (int $id, array $category)
    {
        return Db::update('categories', $category, "id = $id");
    }

    public function add($category)
    {

        if (isset($category['id'])){
            unset($category['id']);
        }
        return Db::insert("categories", $category);
    }

    public function deleteById ($id)
    {
//вернуться к вопросу позже. При удалении категории у товаров остаются и выпадают с ошибкой
        //Db::update("products", ['category_id' => NULL], "category_id = $id");

        return Db::delete('categories', "id = $id");

    }

    public function  getFromPost (Request $request) : array
    {
        return [
            'id'    => $request->getIntFromPost('id', false),
            'name'  => $request->getStrFromPost('name'),
        ];

    }

    public function getByName(string $categoryName)
    {
        $query = "SELECT * FROM categories WHERE name = '$categoryName'";
        return Db::fetchRow($query);
    }
}
