<?php

namespace App\Validation;

use App\Models\UserModel;

class LoginRules
{
    public function validateUsername(string $str, string $fields, array $data)
    {
        $model = new UserModel();
        // Pencarian data
        $username = $data['username'];

        // Login berdasarkan username
        $byUsername = $model->where('username', $username)->first();

        if ($byUsername) {
            return true;
        } else {
            // Login berdasarkan email
            $byEmail = $model->where('email', $username)->first();
            
            if ($byEmail) {
                return true;
            }
            return false;
        }
    }

    public function validatePassword(string $str, string $fields, array $data)
    {
        $model = new UserModel();
        // Pencarian data
        $username = $data['username'];
        $user = $model->where('username', $username)->orWhere('email', $username)->first();

        // Jika username atau email tidak ditemukan
        if (!$user) {
            return false;
        }

        // Validasi password
        return password_verify($data['password'], $user['password']);
    }
}
