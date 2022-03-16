<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function get($id = null)
    {
        if ($id) {
            return User::select($id);
        } else {
            return User::selectAll();
        }
    }

    public function post($id = null)
    {
        $data = $_POST;

        if ($id) {
            return User::update($data, $id);
        } else {
            return User::insert($data);
        }
    }

    public function delete($id = null)
    {
        return User::delete($id);
    }
}
