<?php


class Connection
{

    protected static $instance;

    private function __construct()
    {
        try {
            self::$instance = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);
        } catch (PDOException $e) {
            echo "MySql Connection Error: " . $e->getMessage();
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
