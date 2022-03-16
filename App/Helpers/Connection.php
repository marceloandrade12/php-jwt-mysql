<?php

class Connection
{

    protected static $instance;

    private function __construct()
    {
        try {
            self::$instance = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);
        } catch (PDOException $e) {
            throw new \Exception('Database Connection Error');
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            new Connection();
        }

        return self::$instance;
    }
}
