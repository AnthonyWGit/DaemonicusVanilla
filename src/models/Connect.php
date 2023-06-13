<?php

namespace Models;

abstract class Connect
{
    const HOST = "localhost";
    const DB = "daemonicus";
    const USER ="root";
    const PASS = "";

        static function connexion()
    {
        try {
            return new \PDO(                                                     //Connecting to SQL server
                'mysql:
                host='. self::HOST .';
                dbname='. self::DB .';
                charset=utf8mb4',
                self::USER,
                self::PASS,
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );
        } 
        catch (\PDOException $e) 
        { 
            return $e->getMessage();
        }
    }
}