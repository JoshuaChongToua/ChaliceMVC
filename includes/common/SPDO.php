<?php

namespace common;

use PDO;
use PDOStatement;

class SPDO
{
    /**
     * instance of PDO
     */
    private PDO $PDOInstance;

    /**
     * instance of SPDO
     */
    private static SPDO $instance;

    const DEFAULT_SQL_USER = 'root';
    const DEFAULT_SQL_HOST = 'localhost';
    const DEFAULT_SQL_PASS = '';
    const DEFAULT_SQL_DTB = 'chalice';

    /**
     * constructor
     */
    private function __construct()
    {
        $this->PDOInstance = new PDO('mysql:dbname='.self::DEFAULT_SQL_DTB.';host='.self::DEFAULT_SQL_HOST,self::DEFAULT_SQL_USER ,self::DEFAULT_SQL_PASS);
    }

    /**
     * create and return SPDO object
     */
    public static function getInstance(): SPDO
    {
        if(!isset(self::$instance))
        {
            self::$instance = new SPDO();
        }
        return self::$instance;
    }

    /**
     * Execute an sql query
     */
    public function execQuery(string $query): PDOStatement
    {
        return $this->PDOInstance->query($query);
    }
}