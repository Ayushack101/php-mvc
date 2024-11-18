<?php

namespace App\Core;

require_once __DIR__ . '/../config/config.php';

class DB
{
    private static ?\mysqli $connection = null;

    public static function mysql_connect(): \mysqli|null
    {
        if (!self::$connection) {
            try {
                self::$connection = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
                if (self::$connection->connect_error) {
                    throw new \Exception("Connection failed: " . self::$connection->connect_error);
                }
            } catch (\Exception $e) {
                // Handle exception or log it
                die("Database connection failed." . $e->getMessage());
            }
        }

        return self::$connection;
    }

    public static function getConnection(): \mysqli|null
    {
        if (!self::$connection) {
            self::mysql_connect();
        }
        return self::$connection;
    }
}
