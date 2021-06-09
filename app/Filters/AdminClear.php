<?php

namespace App\Filters;
// Fungsi ini digunakan untuk autentikasi ketika user belum login, user yg belum login tidak akan bisa mengakses halaman home, dll

use Codeigniter\HTTP\RequestInterface;
use Codeigniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminClear implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        session()->remove('admin');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
