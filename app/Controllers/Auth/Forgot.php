<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\TokenModel;

class Forgot extends BaseController
{
	public function showForgotForm()
	{
		$data['validation'] = \Config\Services::validation();
		$data['title'] = APP_NAME . ' - Forgot Password';
		return view('auth/password/forgot', $data);
	}

	public function forgot()
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
			$user = $this->UserModel->select('id')->where('email', $email)->first();

			// Jika user ditemukan
			if ($user) {
				// Send Email dan Insert Token
				$EmailLibraries = new \App\Libraries\EmailLibraries();
				$EmailLibraries->sendAuthEmail($email, 'forgot');

				// Insert Activity Log
				$LogLibraries = new \App\Libraries\LogLibraries();
				$LogLibraries->setActivitylog([
					'id_users' => $user['id'],
					'log' => 'berhasil meminta pengiriman link untuk reset password.',
				]);

				session()->set('verify_forgot_email', $email);
				return redirect()->to(base_url('auth/password/verify-forgot-alert'))->with('success', 'Link untuk reset password telah kami kirimkan ke email Anda.');
			}

			// Jika user tidak ditemukan
			else {
				return redirect()->back()->with('error', 'Email yang Anda masukkan belum terdaftar.')->withInput();
			}
		}
	}

	public function verifyForgotAlert()
	{
		// Jika tidak ada session verify_forgot_email
		if (!session()->get('verify_forgot_email')) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}

		$data['validation'] = \Config\Services::validation();
		$data['title'] = APP_NAME . ' - Verify Forgot Password';
		return view('auth/password/verify-forgot', $data);
	}

	public function resendForgotEmail()
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
			$user = $this->UserModel->select('id')->where('email', $email)->first();

			// Jika user ditemukan
			if ($user) {
				// Send Email dan Insert Token
				$EmailLibraries = new \App\Libraries\EmailLibraries();
				$EmailLibraries->sendAuthEmail($email, 'forgot');

				// Insert Log Activity
				$LogLibraries = new \App\Libraries\LogLibraries();
				$LogLibraries->setActivitylog([
					'id_users' => $user['id'],
					'log' => 'berhasil meminta pengiriman ulang link reset akun.',
				]);

				session()->set('verify_forgot_email', $email);
				return redirect()->back()->with('success', 'Link baru telah dikirim ke email Anda.');
			}

			// Jika user tidak ditemukan
			else {
				return redirect()->back()->with('error', 'Email yang Anda masukkan belum terdaftar.')->withInput();
			}
		}
	}

	public function verifyForgotEmail()
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

			// Jika token tersebut ada
			if ($token) {
				// Jika token belum kadaluarsa (30 menit)
				if (time() - $token['created_at'] < 1800) {
					session()->remove('verify_forgot_email');
					session()->set('reset_password', $email);
					return redirect()->to(base_url('auth/password/reset'))->with('success', 'Link yang Anda masukkan valid, silahkan ubah password anda.');
				}

				// Jika token telah kedaluwarsa
				else {
					session()->setFlashdata('error', 'Reset password gagal, link yang Anda gunakan telah kedaluwarsa.');
				}
			}

			// Jika token tidak ada di database
			else {
				session()->setFlashdata('error', 'Reset password gagal, link yang Anda gunakan tidak benar.');
			}
		}

		// Jika user tidak ditemukan
		else {
			session()->setFlashdata('error', 'Reset password gagal, email yang Anda masukkan belum terdaftar.');
		}

		session()->set('verify_forgot_email', $email);
		return redirect()->to(base_url('auth/password/verify-forgot-alert'));
	}
}
