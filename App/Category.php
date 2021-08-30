<?php

class Category {
    public static function getList ()
    {
        $query = "SELECT * FROM categories";

        return Db::fetchAll($query);
    }

    public static function getById ($id)
    {
        $query = "SELECT * FROM categories WHERE id = $id";
        return Db::fetchRow($query);
    }

    public static function uploadById (int $id, array $category)
    {
        return Db::update('categories', $category, "id = $id");
    }

    public static function add($category)
    {
        if (isset($category['id'])){
            unset($category['id']);
        }
        return Db::insert("categories", $category);
    }

    public static function deleteById ($id)
    {
        return Db::delete('categories', "id = $id");

    }

    public static function  getFromPost () : array
    {
        return [
            'id'    => Request::getIntFromPost('id', false),
            'name'  => Request::getStrFromPost('name'),
        ];

    }

    public static function getByName(string $categoryName)
    {
        $query = "SELECT * FROM categories WHERE name = '$categoryName'";
        return Db::fetchRow($query);
    }
}
