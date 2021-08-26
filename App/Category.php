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

    public static function uploadById ($id, $category)
    {
        $name = $category['name'] ?? '';

        $query = "UPDATE categories SET name = '$name' WHERE id = '$id'";
        Db::query($query);

        return Db::affectedRows();
    }

    public static function add($category)
    {
        $name = $category['name'] ?? '';


        $query = "INSERT INTO categories(name) VALUES ('$name')";
        Db::query($query);

        return Db::affectedRows();
    }

    public static function deleteById ($id)
    {
        return Db::delete('categories', "id = $id");

    }

    public static function  getFromPost () : array
    {
        return [
            'name' => $_POST['name'] ?? '',
        ];

    }
}
