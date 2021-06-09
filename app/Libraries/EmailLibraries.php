<?php

namespace App\Libraries;

use App\Models\TokenModel;

class EmailLibraries
{
    public function __construct()
    {
        $this->TokenModel = new TokenModel();
    }

    public function sendAuthEmail($email, $type)
    {
        // Jika ada token dengan email yang sama, hapus token tersebut
        $this->TokenModel->where('email', $email)->delete();
        // Generate token
        $token = base64_encode(random_bytes(64));

        // Data Insert Token
        $data_token = [
            'email' => $email,
            'token' => $token,
            'type' => $type == 'verify' ? 'Verify Account' : 'Forgot Password',
            'created_at' => time(),
        ];

        // Send Email
        $this->_sendAuthEmail($token, $type, $email);

        // Insert Token
        $this->TokenModel->save($data_token);
    }

    private function _sendAuthEmail($token, $type, $emailParam)
    {
        $email = \Config\Services::email();
        $email->setFrom('resama227@gmail.com', APP_NAME);
        $email->setTo($emailParam);

        // Memilih tipe email
        if ($type == 'verify') {
            $data['url'] = base_url() . '/auth/verify-register-email?email=' . $emailParam . '&token=' . urlencode($token);
            $view_message = view('email/verify-email', $data);

            $email->setSubject('Verify Account');
            $email->setMessage($view_message);
        } elseif ($type == 'forgot') {
            $data['url'] = base_url() . '/auth/password/verify-forgot-email?email=' . $emailParam . '&token=' . urlencode($token);
            $view_message = view('email/forgot-email', $data);

            $email->setSubject('Reset Password');
            $email->setMessage($view_message);
        }

        // Jika pengiriman email berhasil
        if ($email->send()) {
            return true;
        } else {
            echo $email->printDebugger();
            die;
        }
    }
}
