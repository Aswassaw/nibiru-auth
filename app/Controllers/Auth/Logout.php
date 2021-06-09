<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;

class Logout extends BaseController
{
	public function logout()
	{
		session()->destroy();
		return redirect()->to(base_url('/'));
	}
}
