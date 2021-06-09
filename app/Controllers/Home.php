<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        $data['me'] = $this->UserModel->select('username, slug, avatar, role, email_verified_at')->find(session()->get('id'));
        $data['title'] = APP_NAME . ' - Home';
        return view('home', $data);
    }
}
