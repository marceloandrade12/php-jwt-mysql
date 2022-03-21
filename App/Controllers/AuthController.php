<?php

namespace App\Controllers;

require_once('./App/Helpers/Connection.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController
{
    private static $key = 'Y3J5cHQha2V5'; //Application Key

    public static function login()
    {

        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            throw new \Exception('Missing Params');
        }

        $inputEmail = $_POST['email'];
        $inputPassword = $_POST['password'];

        $connPdo = \Connection::getInstance();

        $sql = 'SELECT * FROM user WHERE email=:email';
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':email', $inputEmail);
        $stmt->execute();

        $result =  $stmt->fetch(\PDO::FETCH_ASSOC);

        $resultEmail = $result['email'];
        $resultPassword =  $result['password'];
        $resultName = $result['name'];

        $passwordMatch = password_verify($inputPassword,  $resultPassword);

        $currentTime = time();

        if ($passwordMatch) {

            $payload = [
                'iat' =>  $currentTime,
                'exp' => $currentTime + 3600, // expire in 60 minutes
                'name' => $resultName,
                'email' => $resultEmail,
            ];

            return JWT::encode($payload, self::$key, 'HS256');
        }

        throw new \Exception('Error While Authenticate');
    }

    public static function checkAuth()
    {
        $http_header = apache_request_headers();

        if (isset($http_header['Authorization']) && $http_header['Authorization'] != null) {

            $token = explode(' ', $http_header['Authorization'])[1];

            $decoded = JWT::decode($token, new Key(self::$key, 'HS256'));

            if ($decoded->exp > time()) {
                return true;
            }
        }

        return false;
    }
}
