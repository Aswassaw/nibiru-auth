<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Admin extends BaseController
{
    public function index()
    {
        $data['users_count'] = $this->UserModel->countAllResults();
        $data['users_deleted_count'] = $this->UserModel->onlyDeleted()->countAllResults();

        $data['me'] = $this->UserModel->select('username, slug, avatar, role, email_verified_at')->find(session()->get('id'));
        $data['title'] = APP_NAME . ' - Admin';
        return view('admin/index', $data);
    }
}
