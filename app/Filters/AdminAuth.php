<?php

namespace App\Filters;
// Fungsi ini digunakan untuk autentikasi ketika user belum login, user yg belum login tidak akan bisa mengakses halaman home, dll

use Codeigniter\HTTP\RequestInterface;
use Codeigniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Inisiasi model
        $UserModel = new \App\Models\UserModel();
        // Mendapatkan data user
        $user = $UserModel->select('role')->find(session()->get('id'));

        // Jika user bukan admin
        if ($user['role'] > 2) {
            return redirect()->to(base_url('home'))->with('error', 'Anda tidak memiliki akses untuk melakukan aksi tersebut.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
