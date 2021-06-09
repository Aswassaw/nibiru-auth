<?php

namespace App\Filters;
// Fungsi ini digunakan untuk autentikasi ketika user sudah login, user yg sudah login tidak akan bisa mengakses halaman login, dll

use Codeigniter\HTTP\RequestInterface;
use Codeigniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AfterAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Jika terdapat sebuah sesi dengan nama isLoggedIn, maka user akan dipaksa redirect ke home
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('home'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
