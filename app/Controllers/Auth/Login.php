<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;

class Login extends BaseController
{
	public function showLoginForm()
	{
		$data['validation'] = \Config\Services::validation();
		$data['title'] = APP_NAME . ' - Log In';
		return view('auth/login', $data);
	}

	public function login()
	{
		$rules = [
			'username' => [
				'label' => 'Username atau Email',
				'rules' => 'required|max_length[25]|validateUsername[username]',
			],
			'password' => [
				'label' => 'Password',
				'rules' => 'required|min_length[6]|max_length[100]|validatePassword[username,password]',
			],
		];

		// Jika tidak sesuai
		if (!$this->validate($rules)) {
			$validation = $this->validator;
			return redirect()->back()->with('validation', $validation)->withInput();
		}

		// Jika sesuai
		else {
			// Mendapatkan data user
			$user = $this->UserModel->select('id, email_verified_at')->where('username', $this->request->getPost('username'))->orWhere('email', $this->request->getPost('username'))->first();

			// Menghapus session yang sudah tidak diperlukan (jika ada)
			session()->remove('verify_register_email');
			session()->remove('verify_forgot_email');
			session()->remove('reset_password');

			$LoginlogModel = new \App\Models\LoginlogModel();
			$agent = $this->request->getUserAgent();

			// Data Login Log
			$data_login = [
				'id_users' => $user['id'],
				'ip' => $this->request->getIPAddress(),
				'browser' => $agent->getBrowser() . ' ' . $agent->getVersion(),
				'platform' => $agent->getPlatform(),
			];

			// Insert Login Log
			$LoginlogModel->save($data_login);

			// Insert Activity Log
			$LogLibraries = new \App\Libraries\LogLibraries();
			$LogLibraries->setActivitylog([
				'id_users' => $user['id'],
				'log' => 'berhasil login.',
			]);

			// Membuat session yang diperlukan
			session()->set(['id' => $user['id']]);
			session()->set(['isLoggedIn' => true]);

			return redirect()->to(base_url('home'))->with('success', 'Log In berhasil.');
		}
	}
}
