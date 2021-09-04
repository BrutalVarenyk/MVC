<?php

namespace Core;

use Exception;
use PDO;

class Model
{

    protected static $table = null;


    protected static function db()
    {
        static $db = null;

        if ($db == null) {
            $dsn = "mysql:host=" . getenv("HOST") . ";dbname=" . getenv("DATABASE") . ";charset=utf8";
            $db = new PDO($dsn, getenv("USER"), getenv("PASSWORD"));

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }

    public static function all()
    {

        if (!is_null(static::$table)) {

            $query = "SELECT * FROM " . static::$table;
            $query_select = static::db()->prepare($query);
            $query_select->execute();

            return $query_select->fetchAll(PDO::FETCH_CLASS, static::class);
        } else {
            throw new Exception("Table doesn't exist");
        }
    }

    public static function find($id, $id_column = "id")
    {
        if (!is_null(static::$table)) {
            $query = "SELECT * FROM " . static::$table . " WHERE " . $id_column . " = " . $id;
            $query_select = static::db()->prepare($query);
            $query_select->execute();
            return $query_select->fetchAll(PDO::FETCH_CLASS, static::class);
        } else {
            throw new Exception("Table doesn't exist");
        }
    }

    public function create(array $column)
    {

        $table = static::$table;

        $query = "INSERT INTO " . $table . " (";

        foreach ($column as $key => $value) {
            if ($key !== 'id') {
                if (array_key_last($column) !== $key) {
                    $query .= "`{$key}`, ";
                } else {
                    $query .= "`{$key}`) VALUES ( ";
                }
            }
        }

        foreach ($column as $key => $value) {
            if ($key !== 'id') {
                if (array_key_last($column) !== $key) {
                    $query .= "'{$value}', ";
                } else {
                    $query .= "'{$value}') ";
                }
            }
        }
        $query_insert = static::db()->prepare($query);
        $query_insert->execute();
    }


    public function leftJoin(array $params)
    {
        if (!is_null(static::$table)) {

            $query = "SELECT ";

            foreach ($params['selected_columns'] as $key => $value) {
                if (array_key_last($params['selected_columns']) !== $key) {
                    $query .= " {$value},";
                } else {
                    $query .= " {$value} 
                    FROM {$params['tables'][0]}
                    LEFT JOIN {$params['tables'][1]}
                    ON {$params['equal_columns'][0]} = {$params['equal_columns'][1]}";
                }
            }
            dd($query);
            $query_select = static::db()->prepare($query);
            $query_select->execute();

            return $query_select->fetchAll();
        } else {
            throw new Exception("Table doesn't exist");
        }
    }

    //TODO написать методы all, find,
    // create, update - not static;


}