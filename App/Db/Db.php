<?php

namespace App\Db;

class Db
{
    private static $connect;
    private static $host = '127.0.0.1';
    private static $user = 'skorihv';
    private static $password = '';
    private static $bd = 'phpwebinars';


    public static function query ($query) {
        $conn = static::getConnect();
        $result = mysqli_query($conn, $query);

        if (mysqli_errno($conn)) {
            $error = mysqli_error($conn);
            var_dump($error);
            exit;
        }
        return $result;
    }


    public static function fetchAll(string $query): array
    {
        $result = static::query($query);

        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    public static function fetchRow (string $query): array
    {
        $result = static::query($query);
        $row = static::fetchAssoc($result);
        if (is_null($row)) {
            $row = [];
        }

        return $row;
    }

    public static function fetchAssoc($result): ?array
    {
        return mysqli_fetch_assoc($result);
    }

    public static function fetchOne(string $query): string
    {
        $result = static::query($query);

        $row = mysqli_fetch_row($result);
        return (string) ($row[0] ?? '');
    }

    public static function delete(string $tableName, string $where)
    {
        $query = "DELETE FROM " . $tableName;

        if ($where) {
            $query .= " WHERE " . $where;
        }

        static::query($query);
        return static::affectedRows();
    }

    public static function insert(string $tableName, array $fields)
    {
        $fieldsNames = [];
        $fieldsValues = [];

        foreach ($fields as $fieldName => $fieldValue) {
            $fieldsNames[] = "`$fieldName`";

            if ($fieldValue instanceof DbExp) {
                $fieldsValues[] = "$fieldValue";
            } else {
                $fieldValue = static::escape($fieldValue);
                $fieldsValues[] = "'$fieldValue'";
            }
        }

        $fieldsNames = implode(',', $fieldsNames);
        $fieldsValues = implode(',', $fieldsValues);

        $query = "INSERT INTO $tableName($fieldsNames) VALUES  ($fieldsValues)";

        static::query($query);
        return static::lastInsertId();
    }

    public static function update(string $tableName, array $fields, string $where)
    {
        $setFields = [];

        foreach ($fields as $fieldName => $fieldValue) {

            if ($fieldValue instanceof DbExp) {
                $setFields[] = " $fieldName = $fieldValue";
            } else {
                $fieldValue = static::escape($fieldValue);
                $setFields[] = " $fieldName = '$fieldValue'";
            }
        }
        $setFields = implode(',', $setFields);
        $query = "UPDATE $tableName SET $setFields";

        if ($where) {
            $query .= " WHERE " . $where;
        }

        static::query($query);
        return static::affectedRows();
    }

    public static function affectedRows()
    {
        $conn = static::getConnect();
        return mysqli_affected_rows($conn);
    }

    public static function lastInsertId()
    {
        $conn = static::getConnect();
        return mysqli_insert_id($conn);
    }


    public static function getConnect()
    {
        if (is_null(static::$connect)) {
            static::$connect = static::connect();
        }

        return static::$connect;
    }

    public static function escape(string $value)
    {
        $conn = static::getConnect();
        return mysqli_real_escape_string($conn, $value);
    }

    public static function expr(string $value)
    {
        return new DbExp($value);
    }

    private static function connect () {

        $connect = mysqli_connect(static::$host, static::$user, static::$password, static::$bd);
        if(mysqli_connect_errno()) {
            $error = mysqli_connect_error();
            var_dump($error);
            exit;
        }

        mysqli_query($connect, "SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
        mysqli_query($connect, "SET CHARACTER SET 'utf8'");

        return $connect;
    }
}

