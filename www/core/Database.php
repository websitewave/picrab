<?php
// core/Database.php

class Database
{
    private static $connection;

    public static function connect($host, $user, $pass, $dbname)
    {
        self::$connection = new mysqli($host, $user, $pass, $dbname);

        if (self::$connection->connect_error) {
            die('Ошибка подключения к базе данных: ' . self::$connection->connect_error);
        }

        self::$connection->set_charset('utf8mb4');
    }

    public static function query($sql)
    {
        $result = self::$connection->query($sql);

        if (self::$connection->error) {
            die('Ошибка запроса: ' . self::$connection->error);
        }

        return $result;
    }

    public static function prepare($sql)
    {
        $stmt = self::$connection->prepare($sql);

        if (self::$connection->error) {
            die('Ошибка подготовки запроса: ' . self::$connection->error);
        }

        return $stmt;
    }

    public static function getConnection()
    {
        return self::$connection;
    }
}