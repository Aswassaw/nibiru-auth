<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\TokenModel;
use CodeIgniter\I18n\Time;

class Register extends BaseController
{
	public function showRegisterForm()
	{
		$data['validation'] = \Config\Services::validation();
		$data['title'] = APP_NAME . ' - Register';
		return view('auth/register', $data);
	}

	public function register()
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
			$email = strtolower($this->request->getPost('email'));

			// Data Insert User
			$data_user = [
				'username' => htmlspecialchars($this->request->getPost('username')),
				'fullname' => htmlspecialchars($this->request->getPost('fullname')),
				'slug' => url_title($this->request->getPost('fullname'), '-', true),
				'email' => $email,
				'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
			];

			// Send Email dan Insert Token
			$EmailLibraries = new \App\Libraries\EmailLibraries();
			$EmailLibraries->sendAuthEmail($email, 'verify');

			// Insert User
			$this->UserModel->save($data_user);
			$id = $this->UserModel->insertID();

			// Insert Log Activity
			$LogLibraries = new \App\Libraries\LogLibraries();
			$LogLibraries->setActivitylog([
				'id_users' => $id,
				'log' => 'berhasil melakukan registrasi akun.',
			]);

			session()->set('verify_register_email', $email);
			return redirect()->to(route_to('verify_register_alert'))->with('success', 'Link untuk verifikasi akun telah kami kirimkan ke email Anda.');
		}
	}

	public function verifyRegisterAlert()
	{
		// Jika tidak ada session verify_register_email
		if (!session()->get('verify_register_email')) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}

		$data['validation'] = \Config\Services::validation();
		$data['title'] = APP_NAME . ' - Verify Register';
		return view('auth/verify-register-alert', $data);
	}

	public function resendRegisterEmail()
	{
		$rules = [
			'email' => [
				'label' => 'Email',
				'rules' => 'required|valid_email|max_length[100]',
			],
		];

		// Jika tidak sesuai
		if (!$this->validate($rules)) {
			$validation = $this->validator;
			return redirect()->back()->with('validation', $validation)->withInput();
		}

		// Jika sesuai
		else {
			$email = strtolower($this->request->getPost('email'));
			$user = $this->UserModel->select('id, email_verified_at')->where('email', $email)->first();

			// Jika user ditemukan
			if ($user) {
				// Jika user telah terverifikasi
				if ($user['email_verified_at']) {
					return redirect()->back()->with('error', 'Email yang Anda masukkan telah terverifikasi, silahkan Log In.')->withInput();
				}

				// Jika user belum terverifikasi
				else {
					// Send Email dan Insert Token
					$EmailLibraries = new \App\Libraries\EmailLibraries();
					$EmailLibraries->sendAuthEmail($email, 'verify');

					// Insert Log Activity
					$LogLibraries = new \App\Libraries\LogLibraries();
					$LogLibraries->setActivitylog([
						'id_users' => $user['id'],
						'log' => 'berhasil meminta pengiriman ulang link verifikasi akun.',
					]);

					session()->set('verify_register_email', $email);
					return redirect()->back()->with('success', 'Link baru telah dikirim ke email Anda.');
				}
			}

			// Jika user tidak ditemukan
			else {
				return redirect()->back()->with('error', 'Email yang Anda masukkan belum terdaftar.')->withInput();
			}
		}
	}

	public function verifyRegisterEmail()
	{
		// Mengambil email dan token dari url
		$email = strtolower($this->request->getGet('email'));
		$token = $this->request->getGet('token');

		// Jika email atau token kosong
		if (!$email || !$token) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}

		$user = $this->UserModel->select('id')->where('email', $email)->first();

		// Jika user ditemukan
		if ($user) {
			$TokenModel = new TokenModel();
			// Mengambil data token
			$token = $TokenModel->select('created_at')->where('token', $token)->first();

			// Jika token ditemukan
			if ($token) {
				// Jika token belum kadaluarsa (30 menit)
				if (time() - $token['created_at'] < 1800) {
					// Data Update User
					$data_user = [
						'id' => $user['id'],
						'email_verified_at' => Time::now('Asia/Jakarta', 'id_ID'),
					];

					// Update User
					$this->UserModel->save($data_user);
					// Menghapus token yang sudah tidak dibutuhkan
					$TokenModel->where('email', $email)->delete();

					// Insert Activity Log
					$LogLibraries = new \App\Libraries\LogLibraries();
					$LogLibraries->setActivitylog([
						'id_users' => $user['id'],
						'log' => 'berhasil melakukan verifikasi akun.',
					]);

					if (session()->get('isLoggedIn')) {
						return redirect()->to(base_url('home'))->with('success', 'Selamat, akun Anda telah terverifikasi.');
					} else {
						session()->remove('verify_register_email');
						return redirect()->to(route_to('show_login_form'))->with('success', 'Selamat, akun Anda telah terverifikasi, silakan Log In.');
					}
				}

				// Jika token telah kedaluwarsa
				else {
					session()->setFlashdata('error', 'Verifikasi akun gagal, link yang Anda gunakan telah kedaluwarsa, cobalah untuk meminta link baru.');
				}
			}

			// Jika token tidak ditemukan
			else {
				session()->setFlashdata('error', 'Verifikasi akun gagal, link yang Anda gunakan tidak benar.');
			}
		}

		// Jika user tidak ditemukan
		else {
			session()->setFlashdata('error', 'Verifikasi akun gagal, email yang Anda masukkan belum terdaftar.');
		}

		if (session()->get('isLoggedIn')) {
			return redirect()->back();
		} else {
			session()->set('verify_register_email', $email);
			return redirect()->to(route_to('verify_register_alert'));
		}
	}
}
