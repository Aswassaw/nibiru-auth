<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;

class User extends BaseController
{
    public function showAllUser()
    {
        if ($this->request->getGet('keyword')) {
            $keyword = $this->request->getGet('keyword');

            $data['users'] = $this->UserModel->select('id, username, slug, email, avatar, role, email_verified_at, created_at, deleted_at')->like('id', $keyword)->orLike('username', $keyword)->orLike('fullname', $keyword)->orLike('email', $keyword)->withDeleted()->orderBy('role', 'asc')->orderBy('username', 'asc')->paginate(10, 'users');
            $data['users_count'] = $this->UserModel->like('id', $keyword)->orLike('username', $keyword)->orLike('fullname', $keyword)->orLike('email', $keyword)->withDeleted()->countAllResults();
        } else {
            $data['users'] = $this->UserModel->select('id, username, slug, email, avatar, role, email_verified_at, created_at, deleted_at')->withDeleted()->orderBy('role', 'asc')->orderBy('username', 'asc')->paginate(10, 'users');
            $data['users_count'] = $this->UserModel->withDeleted()->countAllResults();
        }

        $data['pager'] = $this->UserModel->pager;
        $data['current_page'] = $this->request->getGet('page_users') ? $this->request->getGet('page_users') : 1;

        $data['me'] = $this->UserModel->select('username, slug, avatar, role, email_verified_at')->find(session()->get('id'));
        $data['title'] = 'Nibiru - Admin (User)';
        return view('admin/users/all-users', $data);
    }

    public function showInsertDataForm()
    {
        $data['validation'] = \Config\Services::validation();
        $data['me'] = $this->UserModel->select('username, slug, avatar, role, email_verified_at')->find(session()->get('id'));
        $data['title'] = APP_NAME . " - Admin (Insert New User)";
        return view('admin/users/insert-data', $data);
    }

    public function insertData()
    {
        $rules = [
            'fullname' => [
                'label' => 'Fullname',
                'rules' => 'required|alpha_space|max_length[50]',
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|valid_username[username]|max_length[25]|is_unique[users.username]',
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|max_length[100]|is_unique[users.email]',
            ],
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
            return redirect()->back()->with('validation', $validation)->withInput();
        }

        // Jika sesuai
        else {
            // Data Insert User
            $data_user = [
                'username' => htmlspecialchars($this->request->getPost('username')),
                'fullname' => htmlspecialchars($this->request->getPost('fullname')),
                'slug' => url_title($this->request->getPost('fullname'), '-', true),
                'email' => strtolower($this->request->getPost('email')),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'email_verified_at' => Time::now('Asia/Jakarta', 'id_ID'),
            ];

            // Insert User
            $this->UserModel->save($data_user);

            // Insert Log Activity
            $LogLibraries = new \App\Libraries\LogLibraries();
            $LogLibraries->setActivitylog([
                'id_users' => session()->get('id'),
                'log' => 'sebagai admin, berhasil menambahkan user baru ' . '<a href="' . route_to('user_profile', $data_user['slug']) . " \" class='link'>" . $data_user['username'] . '.</a>',
            ]);

            return redirect()->to(route_to('show_all_user'))->with('success', 'Data berhasil ditambahkan.');
        }
    }

    public function showChangeDataForm($id)
    {
        // Jika tidak ada session tersebut
        if (!isset(session()->get('admin')[$id . '_user_update-data'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        // Mendapatkan data user yang akan diupdate
        $data['user'] = $this->UserModel->select('id, username, fullname, slug, avatar, birth_date')->withDeleted()->find($id);

        // Jika data user yang akan diupdate tidak tersedia
        if (!$data['user']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $data['validation'] = \Config\Services::validation();
        $data['me'] = $this->UserModel->select('username, slug, avatar, role, email_verified_at')->find(session()->get('id'));
        $data['title'] = APP_NAME . " - Admin (Change " . $data['user']['username'] . " Data)";
        return view('admin/users/change-data', $data);
    }

    public function changeData($id)
    {
        // Mendapatkan data user yang akan diupdate
        $user = $this->UserModel->select('username, slug')->withDeleted()->find($id);

        // Jika username lama sama dengan username baru
        if ($user['username'] == $this->request->getPost('username')) {
            $username_rules = 'required|valid_username[users.username]|max_length[25]';
        }

        // Jika username lama beda dengan username baru
        else {
            $username_rules = 'required|valid_username[users.username]|is_unique[users.username]|max_length[25]';
        }

        $rules = [
            'username' => [
                'label' => 'Username',
                'rules' => $username_rules,
            ],
            'fullname' => [
                'label' => 'Fullname',
                'rules' => 'required|alpha_space|max_length[50]',
            ],
        ];

        // Jika Admin mengubah tanggal lahir
        if ($this->request->getPost('birth_date') != null) {
            $rules['birth_date'] = [
                'label' => 'Tanggal Lahir',
                'rules' => 'valid_date',
            ];
        }

        // Jika tidak sesuai
        if (!$this->validate($rules)) {
            $validation = $this->validator;
            return redirect()->back()->with('validation', $validation)->withInput();
        }

        // Jika sesuai
        else {
            // Data Update User
            $data_user = [
                'id' => $id,
                'username' => htmlspecialchars($this->request->getPost('username')),
                'fullname' => htmlspecialchars($this->request->getPost('fullname')),
            ];

            // Jika Admin mengubah tanggal lahir
            if ($this->request->getPost('birth_date') != null) {
                $data_user['birth_date'] = htmlspecialchars($this->request->getPost('birth_date'));
            }

            // Update User
            $this->UserModel->save($data_user);

            // Insert Log Activity
            $LogLibraries = new \App\Libraries\LogLibraries();
            $LogLibraries->setActivitylog([
                'id_users' => session()->get('id'),
                'log' => 'sebagai admin, berhasil memperbarui data ' . '<a href="' . route_to('user_profile', $user['slug']) . " \" class='link'>" . $user['username'] . '.</a>',
            ]);

            return redirect()->to(session()->get('admin')[$id . '_user_update-data'])->with('success', 'Data berhasil diubah.');
        }
    }

    public function showChangePasswordForm($id)
    {
        // Jika tidak ada session tersebut
        if (!isset(session()->get('admin')[$id . '_user_update-password'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        // Mendapatkan data user yang akan diupdate
        $data['user'] = $this->UserModel->select('id, username, slug')->withDeleted()->find($id);

        // Jika data user yang akan diupdate tidak tersedia
        if (!$data['user']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $data['validation'] = \Config\Services::validation();
        $data['me'] = $this->UserModel->select('username, slug, avatar, role, email_verified_at')->find(session()->get('id'));
        $data['title'] = APP_NAME . " - Admin (Change " . $data['user']['username'] . " Password)";
        return view('admin/users/change-password', $data);
    }

    public function changePassword($id)
    {
        // Mendapatkan data user yang akan diupdate
        $user = $this->UserModel->select('username, slug')->withDeleted()->find($id);

        $rules = [
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[6]|max_length[100]|valid_password[password]',
            ],
        ];

        // Jika tidak sesuai
        if (!$this->validate($rules)) {
            $validation = $this->validator;
            return redirect()->back()->with('validation', $validation)->withInput();
        }

        // Jika sesuai
        else {
            // Data Update User
            $data_user = [
                'id' => $id,
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            ];

            // Update User
            $this->UserModel->save($data_user);

            // Insert Log Activity
            $LogLibraries = new \App\Libraries\LogLibraries();
            $LogLibraries->setActivitylog([
                'id_users' => session()->get('id'),
                'log' => 'sebagai admin, berhasil memperbarui password ' . '<a href="' . route_to('user_profile', $user['slug']) . " \" class='link'>" . $user['username'] . '.</a>',
            ]);

            return redirect()->to(session()->get('admin')[$id . '_user_update-password'])->with('success', 'Password berhasil diubah.');
        }
    }

    public function showChangeAvatarForm($id)
    {
        // Jika tidak ada session tersebut
        if (!isset(session()->get('admin')[$id . '_user_update-avatar'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        // Mendapatkan data user yang akan diupdate
        $data['user'] = $this->UserModel->select('id, username, slug')->withDeleted()->find($id);

        // Jika data user yang akan diupdate tidak tersedia
        if (!$data['user']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $data['me'] = $this->UserModel->select('username, slug, avatar, role, email_verified_at')->find(session()->get('id'));
        $data['validation'] = \Config\Services::validation();
        $data['title'] = APP_NAME . " - Admin (Change " . $data['user']['username'] . " Avatar)";
        return view('admin/users/change-avatar', $data);
    }

    public function changeAvatar($id)
    {
        $rules = [
            'avatar' => [
                'label' => 'Avatar',
                'rules' => 'uploaded[avatar]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]|max_size[avatar,2048]|ext_in[avatar,jpg,jpeg,png,webp]',
            ],
        ];

        // Jika tidak sesuai
        if (!$this->validate($rules)) {
            return redirect()->back()->with('avatar', $this->validator->getErrors());
        }

        // Jika sesuai
        else {
            $avatar = $this->request->getFile('avatar');
            $name = $avatar->getRandomName();
            $user = $this->UserModel->select('username, slug, avatar')->withDeleted()->find($id);

            if ($user['avatar'] != 'default.jpg') {
                // Mengecek apakah file avatar benar-benar ada
                try {
                    $exist = new \CodeIgniter\Files\File(AVATAR_100 . $user['avatar']);
                    $exist = $exist->getSize();
                } catch (\Exception $e) {
                    $exist = 0;
                }

                // Jika file avatar ada dalam directory, maka hapus file tersebut
                if ($exist) {
                    unlink(AVATAR_ORI . $user['avatar']);
                    unlink(AVATAR_400 . $user['avatar']);
                    unlink(AVATAR_100 . $user['avatar']);
                }
            }

            // Avatar original
            $avatar->move(AVATAR_ORI, $name);
            // Avatar 400x400
            \Config\Services::image()
                ->withFile(AVATAR_ORI . $avatar->getName())
                ->fit(400, 400, 'center')
                ->save(AVATAR_400 . $name);
            // Avatar 100x100
            \Config\Services::image()
                ->withFile(AVATAR_ORI . $avatar->getName())
                ->fit(100, 100, 'center')
                ->save(AVATAR_100 . $name);

            // Data Update User
            $data_user = [
                'id' => $id,
                'avatar' => $name,
            ];

            // Update User
            $this->UserModel->save($data_user);

            // Insert Log Activity
            $LogLibraries = new \App\Libraries\LogLibraries();
            $LogLibraries->setActivitylog([
                'id_users' => session()->get('id'),
                'log' => 'sebagai admin, berhasil memperbarui avatar ' . '<a href="' . route_to('user_profile', $user['slug']) . " \" class='link'>" . $user['username'] . '.</a>',
            ]);

            return redirect()->to(session()->get('admin')[$id . '_user_update-avatar'])->with('success', 'Avatar berhasil diubah.');
        }
    }

    public function becomeAdmin($id)
    {
        // Jika tidak ada session tersebut
        if (!isset(session()->get('admin')[$id . '_user_become-admin'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        // Mendapatkan data user yang akan diupdate
        $user = $this->UserModel->select('id, username, slug')->withDeleted()->find($id);

        // Jika data user yang akan diupdate tidak tersedia
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        // Data Update User
        $data_user = [
            'id' => $id,
            'role' => 2,
        ];

        // Update User
        $this->UserModel->save($data_user);

        // Insert log activity
        $LogLibraries = new \App\Libraries\LogLibraries();
        $LogLibraries->setActivitylog([
            'id_users' => session()->get('id'),
            'log' => 'sebagai admin, berhasil mengubah role ' . '<a href="' . route_to('user_profile', $user['slug']) . " \" class='link'>" . $user['username'] . '</a> dari User menjadi Admin.',
        ]);

        return redirect()->to(session()->get('admin')[$id . '_user_become-admin'])->with('success', 'Role berhasil diubah.');
    }

    public function becomeUser($id)
    {
        // Jika tidak ada session tersebut
        if (!isset(session()->get('admin')[$id . '_user_become-user'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        // Mendapatkan data user yang akan diupdate
        $user = $this->UserModel->select('id, username, slug')->withDeleted()->find($id);

        // Jika data user yang akan diupdate tidak tersedia
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        // Data Update User
        $data_user = [
            'id' => $id,
            'role' => 3,
        ];

        // Update User
        $this->UserModel->save($data_user);

        // Insert log activity
        $LogLibraries = new \App\Libraries\LogLibraries();
        $LogLibraries->setActivitylog([
            'id_users' => session()->get('id'),
            'log' => 'sebagai admin, berhasil mengubah role ' . '<a href="' . route_to('user_profile', $user['slug']) . " \" class='link'>" . $user['username'] . '</a> dari Admin menjadi User.',
        ]);

        return redirect()->to(session()->get('admin')[$id . '_user_become-user'])->with('success', 'Role berhasil diubah.');
    }

    public function deleteAccount($id)
    {
        // Jika tidak ada session tersebut
        if (!isset(session()->get('admin')[$id . '_user_delete-account'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        // Mendapatkan data user yang akan delete
        $user = $this->UserModel->select('id, username, slug, role')->find($id);

        // Jika data user yang akan dihapus sudah dihapus
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        // Jika akun superadmin berusaha untuk dihapus
        if ($user['role'] == 1) {
            return redirect()->to(session()->get('admin')[$id . '_user_delete-account'])->with('error', 'Akun Super Admin tidak bisa dihapus!');
        }

        // Menghapus akun
        $this->UserModel->delete($id);

        // Query Log Activity
        $LogLibraries = new \App\Libraries\LogLibraries();
        $LogLibraries->setActivitylog([
            'id_users' => session()->get('id'),
            'log' => 'sebagai admin, berhasil menghapus akun ' . '<a href="' . route_to('user_profile', $user['slug']) . " \" class='link'>" . $user['username'] . '</a>',
        ]);

        return redirect()->to(session()->get('admin')[$id . '_user_delete-account'])->with('success', 'Akun tersebut berhasil dihapus.');
    }

    public function restoreAccount($id)
    {
        // Jika tidak ada session tersebut
        if (!isset(session()->get('admin')[$id . '_user_restore-account'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        // Mendapatkan data user yang akan restore
        $user = $this->UserModel->select('id, username, slug, role')->onlyDeleted()->find($id);

        // Jika data user yang akan restore belum didelete
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        // Menghapus akun
        $this->UserModel->save([
            'id' => $id,
            'deleted_at' => null,
        ]);

        // Query Log Activity
        $LogLibraries = new \App\Libraries\LogLibraries();
        $LogLibraries->setActivitylog([
            'id_users' => session()->get('id'),
            'log' => 'sebagai admin, berhasil mengembalikan akun ' . '<a href="' . route_to('user_profile', $user['slug']) . " \" class='link'>" . $user['username'] . '</a>',
        ]);

        return redirect()->to(session()->get('admin')[$id . '_user_restore-account'])->with('success', 'Akun tersebut berhasil direstore.');
    }
}
