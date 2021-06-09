<?php

namespace App\Validation;

class PasswordRules
{
    public function valid_password(string $str, string $fields, array $data)
    {
        $password = $data['password'];
        // Harus mengandung huruf kapital
        $uppercase = preg_match('@[A-Z]@', $password);
        // Harus mengandung huruf kecil
        $lowercase = preg_match('@[a-z]@', $password);
        // Harus mengandung angka
        $number = preg_match('@[0-9]@', $password);

        // Jika salah satu syarat di atas tidak terpenuhi
        if ($uppercase && $lowercase && $number) {
            return true;
        }

        return false;
    }
}
