<?php

namespace App\Controllers\Account;

use App\Controllers\BaseController;

class Verify extends BaseController
{
    public function resendRegisterEmail()
    {
        // Mendapatkan data user
        $user = $this->UserModel->select('id, email, email_verified_at')->find(session()->get('id'));

        // Jika user telah terverifikasi
        if ($user['email_verified_at']) {
            return redirect()->back()->with('error', 'Email yang Anda masukkan telah terverifikasi.')->withInput();
        }

        // Jika user belum terverifikasi
        else {
            // Send Email dan Insert Token
            $EmailLibraries = new \App\Libraries\EmailLibraries();
            $EmailLibraries->sendAuthEmail($user['email'], 'verify');

            // Insert Log Activity
            $LogLibraries = new \App\Libraries\LogLibraries();
            $LogLibraries->setActivitylog([
                'id_users' => $user['id'],
                'log' => 'berhasil meminta pengiriman ulang link verifikasi akun.',
            ]);

            return redirect()->back()->with('success', 'Link baru telah dikirim ke email Anda.');
        }
    }
}
