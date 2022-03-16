<?php

namespace App\Models;

require_once('./App/Database/Connection.php');

class User
{
    private static $table = 'user';

    public static function select(int $id)
    {
        $connPdo = \Connection::getInstance();

        $sql = 'SELECT * FROM ' . self::$table . ' WHERE id = :id';
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("USER_NOT_FOUND");
        }
    }

    public static function selectAll()
    {
        $connPdo = \Connection::getInstance();

        $sql = 'SELECT * FROM ' . self::$table;
        $stmt = $connPdo->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("USER_NOT_FOUND");
        }
    }

    public static function insert($data)
    {
        $connPdo = \Connection::getInstance();

        $sql = 'INSERT INTO ' . self::$table . ' (email, password, name) VALUES (:em, :pa, :na)';
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':em', $data['email']);
        $stmt->bindValue(':pa', $data['password']);
        $stmt->bindValue(':na', $data['name']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return 'User Added Successfully';
        } else {
            throw new \Exception("Error while add new user");
        }
    }
}
