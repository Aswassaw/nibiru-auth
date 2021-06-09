<?php

namespace App\Validation;

class UsernameRules
{
    public function valid_username(string $str, string $fields, array $data)
    {
        $username = $data['username'];
        // Jika username tidak mengandung karakter selain huruf, angka, dan underscore (_)
        if (!preg_match('@[^\w_]@', $username)) {
            return true;
        }

        return false;
    }
}
