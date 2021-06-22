<?php

namespace App\Controllers\Account;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;

class User extends BaseController
{
    public function profile($slug)
    {
        // Mendapatkan data-data untuk ditampilkan pada halaman
        $data['user'] = $this->UserModel->select('id, username, slug, fullname, email, avatar, birth_date, role, created_at')->where('slug', $slug)->first();
        $data['user']['created_at'] = Time::parse($data['user']['created_at'])->toLocalizedString('d MMMM yyyy');
        // Jika birth_date tidak kosong
        if ($data['user']['birth_date']) {
            $AgeLibraries = new \App\Libraries\AgeLibraries();
            $data['user']['age'] = $AgeLibraries->getAge($data['user']['birth_date']);
            $data['user']['birth_date'] = Time::parse($data['user']['birth_date'])->toLocalizedString('d MMMM yyyy');
        }

        $data['me'] = $this->UserModel->select('username, slug, avatar, role, email_verified_at')->find(session()->get('id'));
        $data['title'] = APP_NAME . ' - ' . $data['me']['username'] . ' Profile';
        return view('account/profile', $data);
    }

    public function showChangeDataForm()
    {
        $data['validation'] = \Config\Services::validation();
        $data['me'] = $this->UserModel->select('username, fullname, slug, avatar, birth_date, role, email_verified_at')->find(session()->get('id'));
        $data['title'] = APP_NAME . ' - Change ' . $data['me']['username'] . ' Data';
        return view('account/change-data', $data);
    }

    public function changeData()
    {
        $me = $this->UserModel->select('username, slug')->find(session()->get('id'));

        // Jika username lama sama dengan username baru
        if ($me['username'] == $this->request->getPost('username')) {
            $username_rules = 'required|valid_username[username]|max_length[25]';
        }

        // Jika username lama beda dengan username baru
        else {
            $username_rules = 'required|valid_username[username]|max_length[25]|is_unique[users.username]';
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

        // Jika user mengubah birth_date
        if ($this->request->getPost('birth_date')) {
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
                'id' => session()->get('id'),
                'username' => htmlspecialchars($this->request->getPost('username')),
                'fullname' => htmlspecialchars($this->request->getPost('fullname')),
            ];

            // Jika user mengubah birth_date
            if ($this->request->getPost('birth_date')) {
                $data_user['birth_date'] = htmlspecialchars($this->request->getPost('birth_date'));
            }

            // Insert User
            $this->UserModel->save($data_user);

            // Insert Log Activity
            $LogLibraries = new \App\Libraries\LogLibraries();
            $LogLibraries->setActivitylog([
                'id_users' => session()->get('id'),
                'log' => 'berhasil memperbarui data.',
            ]);

            return redirect()->to(base_url('account/profile/' . $me['slug']))->with('success', 'Data Anda berhasil diubah.');
        }
    }

    public function showChangePasswordForm()
    {
        $data['validation'] = \Config\Services::validation();
        $data['me'] = $this->UserModel->select('username, slug, avatar, role, email_verified_at')->find(session()->get('id'));
        $data['title'] = APP_NAME . ' - Change ' . $data['me']['username'] . ' Password';
        return view('account/change-password', $data);
    }

    public function changePassword()
    {
        $me = $this->UserModel->select('slug, password')->find(session()->get('id'));

        // Jika password benar
        if (password_verify($this->request->getPost('current_password'), $me['password'])) {
            $rules = [
                'current_password' => [
                    'label' => 'Password saat ini',
                    'rules' => 'required|min_length[6]|max_length[100]',
                ],
                'password' => [
                    'label' => 'Password baru',
                    'rules' => 'required|min_length[6]|valid_password[password]|max_length[100]',
                ],
            ];

            // Jika tidak sesuai
            if (!$this->validate($rules)) {
                $validation = $this->validator;
                return redirect()->back()->with('validation', $validation);
            }

            // Jika sesuai
            else {
                // Data Update User
                $data_user = [
                    'id' => session()->get('id'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                ];

                // Update User
                $this->UserModel->save($data_user);

                // Insert Log Activity
                $LogLibraries = new \App\Libraries\LogLibraries();
                $LogLibraries->setActivitylog([
                    'id_users' => session()->get('id'),
                    'log' => 'berhasil memperbarui password.',
                ]);

                return redirect()->to(base_url('account/profile/' . $me['slug']))->with('success', 'Password Anda berhasil diubah.');
            }
        } else {
            return redirect()->back()->with('error', 'Password Anda tidak sesuai, silahkan coba lagi.')->withInput();
        }
    }

    public function changeAvatar()
    {
        $rules = [
            'avatar' => [
                'label' => 'Avatar',
                'rules' => 'uploaded[avatar]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]|max_size[avatar,2048]|ext_in[avatar,jpg,jpeg,png,webp]',
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
            $me = $this->UserModel->select('slug, avatar')->find(session()->get('id'));

            if ($me['avatar'] != 'default.jpg') {
                // Mengecek apakah file avatar benar-benar ada
                try {
                    $exist = new \CodeIgniter\Files\File(AVATAR_100 . $me['avatar']);
                    $exist = $exist->getSize();
                } catch (\Exception $e) {
                    $exist = 0;
                }

                // Jika file avatar ada dalam directory, maka hapus file tersebut
                if ($exist) {
                    unlink(AVATAR_ORI . $me['avatar']);
                    unlink(AVATAR_400 . $me['avatar']);
                    unlink(AVATAR_100 . $me['avatar']);
                }
            }

            // Avatar Original
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
                'id' => session()->get('id'),
                'avatar' => $name,
            ];

            // Update User
            $this->UserModel->save($data_user);

            // Insert Log Activity
            $LogLibraries = new \App\Libraries\LogLibraries();
            $LogLibraries->setActivitylog([
                'id_users' => session()->get('id'),
                'log' => 'berhasil memperbarui foto profil.',
            ]);

            session()->setFlashdata('success', 'Avatar Anda berhasil diubah.');
            return redirect()->to(base_url('account/profile/' . $me['slug']));
        }
    }

    public function deleteAccount()
    {
        $rules = [
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[6]|max_length[100]',
            ],
        ];

        // Jika tidak sesuai
        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Password Anda tidak sesuai, silahkan coba lagi.');
        }

        // Jika sesuai
        else {
            $me = $this->UserModel->select('slug, password, role')->find(session()->get('id'));

            // Jika superadmin ingin menghapus akunnya sendiri
            if ($me['role'] == 1) {
                return redirect()->to(base_url('account/profile/' . $me['slug']))->with('error', 'Akun Super Admin tidak bisa dihapus!');
            }

            // Jika password benar
            if (password_verify($this->request->getPost('password'), $me['password'])) {
                // Menghapus akun
                $this->UserModel->delete(session()->get('id'));
                // Menghapus session
                session()->destroy();

                return redirect()->to(base_url('/'));
            }

            // Jika password salah
            else {
                return redirect()->back()->with('error', 'Password Anda tidak sesuai, silahkan coba lagi.');
            }
        }
    }
}
