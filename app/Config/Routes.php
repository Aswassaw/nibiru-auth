<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Landing');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
// $routes->set404Override();
$routes->set404Override(function () {
	return view('errors/custom/404');
});
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Landing::index', ['filter' => 'afterauth']);

// Group Auth
$routes->group('auth', ['filter' => 'afterauth'], function ($routes) {
	// Controller Register
	$routes->get('register', 'Auth\Register::showRegisterForm');
	$routes->post('register', 'Auth\Register::register');
	$routes->get('verify-register-alert', 'Auth\Register::verifyRegisterAlert');
	$routes->post('verify-register-alert', 'Auth\Register::resendRegisterEmail');
	$routes->get('verify-register-email', 'Auth\Register::verifyRegisterEmail', ['filter' => null]);

	// Controller Login
	$routes->get('login', 'Auth\Login::showLoginForm');
	$routes->post('login', 'Auth\Login::login');

	// Group Password
	$routes->group('password', function ($routes) {
		// Controller Forgot
		$routes->get('forgot', 'Auth\Forgot::showForgotForm');
		$routes->post('forgot', 'Auth\Forgot::forgot');
		$routes->get('verify-forgot-alert', 'Auth\Forgot::verifyForgotAlert');
		$routes->post('verify-forgot-alert', 'Auth\Forgot::resendForgotEmail');
		$routes->get('verify-forgot-email', 'Auth\Forgot::verifyForgotEmail');

		// Controller Reset
		$routes->get('reset', 'Auth\Reset::showResetForm');
		$routes->patch('reset', 'Auth\Reset::reset');
	});
	$routes->post('logout', 'Auth\Logout::logout', ['filter' => 'beforeauth']);
});

// Group Account
$routes->group('account', ['filter' => 'beforeauth'], function ($routes) {
	// Controller Verify
	$routes->post('resend-register-email', 'Account\Verify::resendRegisterEmail');

	// Controller User
	$routes->get('profile/(:segment)', 'Account\User::profile/$1');
	$routes->get('change-data', 'Account\User::showChangeDataForm');
	$routes->patch('change-data', 'Account\User::changeData');
	$routes->get('change-password', 'Account\User::showChangePasswordForm');
	$routes->patch('change-password', 'Account\User::changePassword');
	$routes->patch('change-avatar', 'Account\User::changeAvatar');
	$routes->patch('delete-account', 'Account\User::deleteAccount');

	// Controller Setting
	$routes->get('settings', 'Account\Setting::index');
	$routes->get('activity-log', 'Account\Setting::showAllActivityLog');
	$routes->get('login-log', 'Account\Setting::showAllLoginLog');
});

// Group Admin
$routes->group('admin', ['filter' => 'adminauth'], function ($routes) {
	// Controller Admin
	$routes->get('/', 'Admin\Admin::index');
	$routes->post('modal-password', 'Admin\Admin::modalPassword');
	$routes->post('verify-password', 'Admin\Admin::verifyPassword');

	// Group User
	$routes->group('user', function ($routes) {
		// Controller User
		$routes->get('all-user', 'Admin\User::showAllUser');
		$routes->post('all-user', 'Admin\User::filterAllUser');
		$routes->get('insert-data', 'Admin\User::showInsertDataForm');
		$routes->post('insert-data', 'Admin\User::insertData');
		$routes->get('change-data/(:num)', 'Admin\User::showChangeDataForm/$1');
		$routes->patch('change-data/(:num)', 'Admin\User::changeData/$1');
		$routes->get('change-password/(:num)', 'Admin\User::showChangePasswordForm/$1');
		$routes->patch('change-password/(:num)', 'Admin\User::changePassword/$1');
		$routes->get('change-avatar/(:num)', 'Admin\User::showChangeAvatarForm/$1');
		$routes->patch('change-avatar/(:num)', 'Admin\User::changeAvatar/$1');
		$routes->patch('become-admin/(:num)', 'Admin\User::becomeAdmin/$1');
		$routes->patch('become-user/(:num)', 'Admin\User::becomeUser/$1');
		$routes->patch('delete-account/(:num)', 'Admin\User::deleteAccount/$1');
		$routes->patch('restore-account/(:num)', 'Admin\User::restoreAccount/$1');
	});
});

// Home Controller
$routes->get('home', 'Home::index', ['filter' => 'beforeauth']);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
