<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\TokenModel;

class Reset extends BaseController
{
    public function showResetForm()
    {
        // Jika tidak terdapat session reset_password
        if (!session()->get('reset_password')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $data['validation'] = \Config\Services::validation();
        $data['title'] = APP_NAME . ' - Reset Password';
        return view('auth/password/reset', $data);
    }

    public function reset()
    {
        $rules = [
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[6]|valid_password[password]|max_length[100]',
            ],
            'password_confirm' => [
                'label' => 'Password Confirm',
                'rules' => 'matches[password]',
            ]
        ];

        // Jika tidak sesuai
        if (!$this->validate($rules)) {
            $validation = $this->validator;
            return redirect()->back()->with('validation', $validation);
        }

        // Jika sesuai
        else {
            $TokenModel = new TokenModel();
            // Mendapatkan data user
            $user = $this->UserModel->select('id')->where('email', session()->get('reset_password'))->first();

            // Data Update User
            $data_user = [
                'id' => $user['id'],
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            ];

            // Update User
            $this->UserModel->save($data_user);
            // Menghapus token yang sudah tidak dibutuhkan
            $TokenModel->where('email', session()->get('reset_password'))->delete();

            // Insert Activity Log
            $LogLibraries = new \App\Libraries\LogLibraries();
            $LogLibraries->setActivitylog([
                'id_users' => $user['id'],
                'log' => 'berhasil melakukan reset password.',
            ]);

            session()->remove('reset_password');
            return redirect()->to(base_url('auth/login'))->with('success', 'Password anda berhasil diubah, silakan Log in.');
        }
    }
}
