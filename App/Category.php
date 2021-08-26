<?php

class Category {
    public static function getList ($connect)
    {
        $query = "SELECT * FROM categories";
        $result = query($connect, $query);
        $categories = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }

        return $categories;
    }

    public static function getById ($connect, $id)
    {

        $query = "SELECT * FROM categories WHERE id = $id";
        $result = query($connect, $query);

        $category = mysqli_fetch_assoc($result);

        if (is_null($category)) {
            $category = [];
        }

        return $category;
    }

    public static function uploadById ($connect, $id, $category)
    {
        $name = $category['name'] ?? '';

        $query = "UPDATE categories SET name = '$name' WHERE id = '$id'";
        query($connect, $query);

        return mysqli_affected_rows($connect);
    }

    public static function add($connect, $category)
    {
        $name = $category['name'] ?? '';


        $query = "INSERT INTO categories(name) VALUES ('$name')";
        query($connect, $query);

        return mysqli_affected_rows($connect);
    }

    public static function deleteById ($connect, $id)
    {
        $query = "DELETE FROM categories WHERE id = $id";

        query($connect, $query);
        return mysqli_affected_rows($connect);
    }

    public static function  getFromPost () : array
    {
        return [
            'name' => $_POST['name'] ?? '',
        ];

    }
}
