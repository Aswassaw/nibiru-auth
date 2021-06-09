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

    public function modalPassword()
    {
        // Jika ada request ajax
        if ($this->request->isAJAX()) {
            $data = [
                'id' => $this->request->getPost('id'),
                'type' => $this->request->getPost('type'),
                'action' => $this->request->getPost('action'),
                'prevUrl' => $this->request->getPost('prevUrl'),
            ];

            $msg = [
                'success' => view('admin/modal-password', $data),
                'token' => csrf_hash(),
            ];

            echo json_encode($msg);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
    }

    public function verifyPassword()
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
            $admin = $this->UserModel->select('id, password, role')->find(session()->get('id'));

            // Jika password benar
            if (password_verify($this->request->getPost('password'), $admin['password'])) {
                $id = $this->request->getPost('id');
                $type = $this->request->getPost('type');
                $action = $this->request->getPost('action');
                $prevUrl = $this->request->getPost('prevUrl');

                // Mengecek hak akses jika data yang akan diatur berkaitan dengan user
                if ($type == 'user') {
                    $update = $this->UserModel->select('id, role')->withDeleted()->find($id);

                    // Jika data user yang akan diupdate tidak tersedia
                    if (!$update) {
                        throw new \CodeIgniter\Exceptions\PageNotFoundException();
                    }

                    // Jika action adalah become-admin atau become-user
                    if ($action == 'become-admin' || $action == 'become-user') {
                        // Jika yang melakukan tindakan ini bukan super-admin
                        if ($admin['role'] != 1) {
                            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk melakukan tindakan tersebut.');
                        }

                        // Jika data yang akan diupdate adalah super-admin
                        if ($update['role'] == 1) {
                            return redirect()->back()->with('error', 'Role Super Admin tidak dapat dimanipulasi.');
                        }
                    }

                    // Jika action adalah delete-account atau restore-account
                    if ($action == 'delete-account') {
                        $data = $this->UserModel->select('id')->find($id);
                        // Jika data yang akan dihapus sebenarnya sudah dihapus
                        if (!$data) {
                            return redirect()->back()->with('error', 'Account tersebut sudah dihapus.');
                        }
                    } else if ($action == 'restore-account') {
                        $data = $this->UserModel->select('id')->onlyDeleted()->find($id);
                        // Jika data yang akan direstore sebenarnya belum dihapus
                        if (!$data) {
                            return redirect()->back()->with('error', 'Account tersebut belum dihapus.');
                        }
                    }

                    $akses = false;

                    // Jika yang akan diubah adalah super admin
                    if ($update['role'] == 1) {
                        // Jika pengubah adalah super admin
                        if ($admin['role'] == 1) {
                            $akses = true;
                        }
                    }

                    // Jika yang akan diubah adalah admin
                    else if ($update['role'] == 2) {
                        // Jika pengubah adalah super admin atau admin dengan id yang sama
                        if ($admin['role'] == 1 || $update['id'] == $admin['id']) {
                            $akses = true;
                        }
                    }

                    // Jika yang akan diubah adalah user
                    else {
                        $akses = true;
                    }

                    // Jika hak akses salah
                    if (!$akses) {
                        return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk melakukan tindakan tersebut.');
                    }
                }

                // Jika sudah ada sesi dengan nama admin
                if (session()->get('admin')) {
                    $admin = session()->get('admin');
                    $admin[$id . '_' . $type . '_' . $action] = $prevUrl;

                    session()->set(['admin' => $admin]);
                }

                // Jika belum ada sesi dengan nama admin
                else {
                    session()->set([
                        'admin' => [
                            $id . '_' . $type . '_' . $action => $prevUrl,
                        ],
                    ]);
                }

                // Jika data yang akan diatur berkaitan dengan user
                if ($type == 'user') {
                    if ($action == 'update-data') {
                        return redirect()->to(route_to('admin_show_change_user_data_form', $id));
                    } else if ($action == 'update-password') {
                        return redirect()->to(route_to('admin_show_change_user_password_form', $id));
                    } else if ($action == 'update-avatar') {
                        return redirect()->to(route_to('admin_show_change_user_avatar_form', $id));
                    } else if ($action == 'become-admin') {
                        return redirect()->to(route_to('change_to_admin', $id));
                    } else if ($action == 'become-user') {
                        return redirect()->to(route_to('change_to_user', $id));
                    } else if ($action == 'delete-account') {
                        return redirect()->to(route_to('admin_delete_user_account', $id));
                    } else if ($action == 'restore-account') {
                        return redirect()->to(route_to('admin_restore_user_account', $id));
                    } else {
                        throw new \CodeIgniter\Exceptions\PageNotFoundException();
                    }
                }
            }

            // Jika password salah
            else {
                return redirect()->back()->with('error', 'Password Anda tidak sesuai, silahkan coba lagi.')->withInput();
            }
        }
    }
}
