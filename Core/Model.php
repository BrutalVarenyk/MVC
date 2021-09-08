<?php

namespace Core;

use Exception;
use PDO;

abstract class Model
{

    protected static $table = null;


    abstract public function addInfo(array $data);

    abstract public function getColumns();


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

    public static function all($order = 0)
    {

        if (!is_null(static::$table)) {

            $query = "SELECT * FROM " . static::$table;
            if($order == 1) {
                $query .= "  ORDER BY " . static::$table . ".id ASC";
            }
            $query_select = static::db()->prepare($query);
            $query_select->execute();

            return $query_select->fetchAll(PDO::FETCH_CLASS, static::class);
        } else {
            throw new Exception("Table doesn't exist");
        }
    }

    public static function find($value, $column = "id")
    {
        if (!is_null(static::$table)) {
            $query = "SELECT * FROM " . static::$table . " WHERE `{$column}` = '{$value}'" ;
//            dd($query);
            $query_select = static::db()->prepare($query);

            $query_select->execute();
            $result = $query_select->fetchAll(PDO::FETCH_CLASS, static::class);
            if(!empty($result)){
                return $result;
            }else{
                return false;
            }

        } else {
            throw new Exception("Record doesn't exist");
        }
    }


    public function leftJoin(array $params, $order = 1)
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
            if($order == 1) {
                $query .= "  ORDER BY " . static::$table . ".id DESC";
            }
//            dd($query);
            $query_select = static::db()->prepare($query);
            $query_select->execute();

            return $query_select->fetchAll(\PDO::FETCH_CLASS, static::class);
        } else {
            throw new Exception("Table doesn't exist");
        }
    }


    public function create(array $column)
    {

        $table = static::$table;

        $query = "INSERT INTO `" . $table . "` (";

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

                $value = nl2br($value);
                $value = preg_replace('/[(\\r)]*[(\\n)]*/', "", $value);

                if (array_key_last($column) !== $key) {
                    $query .= "'{$value}', ";
                } else {
                    $query .= "'{$value}') ";
                }
            }
        }
//        dd($query);
        $query_insert = static::db()->prepare($query);
//        dd($query_insert = static::db()->prepare($query));
//        dd($query_insert->execute());
        $query_insert->execute();
        return true;
    }

    public function update(array $column, string $where)
    {

        $table = static::$table;

        $query = "UPDATE `" . $table . "` SET ";

//        dd($column, $where);

        foreach ($column as $key => $value) {
            if ($key !== 'id') {
                if (array_key_last($column) !== $key) {
                    $query .= " `$key` = '$value' ";
                } else {
                    $query .= "`$key` = '$value' WHERE ";
                }
            }
        }

        $query .= $where;
        $query_update = static::db()->prepare($query);
        $query_update->execute();

    }

    public function delete(string $whereCondition)
    {
        $query = "DELETE FROM `" . static::$table . "` WHERE " . $whereCondition;
//        dd($query);
        $query_delete = static::db()->prepare($query);
        $query_delete->execute();

    }

    //TODO написать методы all, find,
    // create, update - not static;


}