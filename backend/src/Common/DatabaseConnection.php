<?php

namespace Src\Common;

class DatabaseConnection {

    private static $databaseConnection = null;

    private function __construct(){}

    private function initiateConnection(){
        $databasePath = $_ENV['DB_DATABASE'];
        $connection = $_ENV['DB_CONNECTION'];
        try {
            self::$databaseConnection = new \PDO(
                "$connection:$databasePath"
            );

        } catch (\PDOException $e) {
            exit('Connection not exists!');
        }
    }

    public static function getConnection()
    {
        if(self::$databaseConnection == null) self::initiateConnection();

        self::$databaseConnection->sqliteCreateFunction('regexp',
            function($string, $pattern) {
                if(preg_match('/^'.$pattern.'$/i', $string)) {
                    return true;
                }
                return false;
            });

        return self::$databaseConnection;
    }
}