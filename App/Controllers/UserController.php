<?php

namespace App\Controllers;

require_once('./App/Helpers/Connection.php');

class UserController
{
    private static $table = 'user';

    public static function select(int $id)
    {
        if (!AuthController::checkAuth()) {
            http_response_code(401);
            throw new \Exception("NOT_AUTHENTICATED");
        }

        $connPdo = \Connection::getInstance();

        $sql = 'SELECT id, name, email FROM ' . self::$table . ' WHERE id = :id';
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

        if (!AuthController::checkAuth()) {
            http_response_code(401);
            throw new \Exception("NOT_AUTHENTICATED");
        }

        $connPdo = \Connection::getInstance();

        $sql = 'SELECT id, name, email FROM ' . self::$table;
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
        if (!AuthController::checkAuth()) {
            http_response_code(401);
            throw new \Exception("NOT_AUTHENTICATED");
        }

        // validate if has data
        if (
            isset($data['email']) &&
            isset($data['password']) &&
            isset($data['name']) &&
            strlen($data['password']) > 0 &&
            strlen($data['email']) > 0 &&
            strlen($data['name']) > 0
        ) {
            $connPdo = \Connection::getInstance();


            $sql = 'INSERT INTO ' . self::$table . ' (email, password, name) VALUES (:em, :pa, :na)';
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':em', $data['email']);
            $stmt->bindValue(':pa', password_hash($data['password'], PASSWORD_DEFAULT));
            $stmt->bindValue(':na', $data['name']);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return 'User Added Successfully';
            } else {
                throw new \Exception("Error while add new user");
            }
        } else {
            throw new \Exception("Missing Data");
        }
    }

    public static function update($data, $id = null)
    {
        if (!AuthController::checkAuth()) {
            http_response_code(401);
            throw new \Exception("NOT_AUTHENTICATED");
        }

        // validate if has data
        if (
            isset($data['password']) &&
            isset($data['name']) &&
            strlen($data['password']) > 0 &&
            strlen($data['name']) > 0
        ) {

            $connPdo = \Connection::getInstance();

            $sql = 'UPDATE ' . self::$table . ' set password=:pa, name=:na where id=:id';
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':pa', $data['password']);
            $stmt->bindValue(':na', $data['name']);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return 'Successfully Update';
            } else {
                throw new \Exception("Error while update user");
            }
        } else {
            throw new \Exception("Missing Data");
        }
    }

    public static function delete($id = null)
    {
        if (!AuthController::checkAuth()) {
            http_response_code(401);
            throw new \Exception("NOT_AUTHENTICATED");
        }

        // validate if has data
        if (isset($id)) {
            $connPdo = \Connection::getInstance();

            $sql = 'DELETE FROM ' . self::$table . ' where id=:id';
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return 'Successfully Deleted';
            } else {
                throw new \Exception("Error when try to delete user");
            }
        } else {
            throw new \Exception("Missing User ID to Delete");
        }
    }
}
