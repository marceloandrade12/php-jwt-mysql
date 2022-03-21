<?php

namespace App\Services;

use App\Controllers\UserController;

class UserService
{
    public function getAll()
    {

        return UserController::selectAll();
    }

    public function get($id = null)
    {
        if ($id) {
            return UserController::select($id);
        } else {
            throw new \Exception('Missing Params');
        }
    }

    public function add()
    {
        $data = $_POST;
        return UserController::insert($data);
    }

    public function update($id = null)
    {

        if ($id) {
            $data = $_POST;
            return UserController::update($data, $id);
        } else {
            throw new \Exception('Missing Params');
        }
    }

    public function delete($id = null)
    {
        if ($id) {
            return UserController::delete($id);
        } else {
            throw new \Exception('Missing Params');
        }
    }
}
