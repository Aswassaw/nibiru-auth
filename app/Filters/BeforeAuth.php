<?php

namespace App\Filters;
// Fungsi ini digunakan untuk autentikasi ketika user belum login, user yg belum login tidak akan bisa mengakses halaman home, dll

use Codeigniter\HTTP\RequestInterface;
use Codeigniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class BeforeAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Jika tidak terdapat sebuah sesi dengan nama isLoggedIn, maka user akan dipaksa redirect ke / atau login page
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('auth/login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
