<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Landing extends BaseController
{
	public function index()
	{
		$data['title'] = APP_NAME . ' - Landing';
		return view('landing', $data);
	}
}
