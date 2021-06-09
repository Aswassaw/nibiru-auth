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
	$routes->get('register', 'Auth\Register::showRegisterForm', ['as' => 'show_register_form']);
	$routes->post('register', 'Auth\Register::register', ['as' => 'submit_register_form']);
	$routes->get('verify-register-alert', 'Auth\Register::verifyRegisterAlert', ['as' => 'verify_register_alert']);
	$routes->post('verify-register-alert', 'Auth\Register::resendRegisterEmail', ['as' => 'resend_register_email']);
	$routes->get('verify-register-email', 'Auth\Register::verifyRegisterEmail', ['filter' => null], ['as' => 'verify_register_email']); // Filter null agar bisa dikunjungi baik sebelum maupun setelah login

	// Controller Login
	$routes->get('login', 'Auth\Login::showLoginForm', ['as' => 'show_login_form']);
	$routes->post('login', 'Auth\Login::login', ['as' => 'submit_login_form']);

	// Group Password
	$routes->group('password', function ($routes) {
		// Controller Forgot
		$routes->get('forgot', 'Auth\Forgot::showForgotForm', ['as' => 'show_forgot_form']);
		$routes->post('forgot', 'Auth\Forgot::forgot', ['as' => 'submit_forgot_form']);
		$routes->get('verify-forgot-alert', 'Auth\Forgot::verifyForgotAlert', ['as' => 'verify_forgot_alert']);
		$routes->post('verify-forgot-alert', 'Auth\Forgot::resendForgotEmail', ['as' => 'resend_forgot_email']);
		$routes->get('verify-forgot-email', 'Auth\Forgot::verifyForgotEmail', ['as' => 'verify_forgot_email']);

		// Controller Reset
		$routes->get('reset', 'Auth\Reset::showResetForm', ['as' => 'show_reset_form']);
		$routes->patch('reset', 'Auth\Reset::reset', ['as' => 'submit_reset_form']);
	});
	$routes->post('logout', 'Auth\Logout::logout', ['filter' => 'beforeauth']);
});

// Group Account
$routes->group('account', ['filter' => 'beforeauth'], function ($routes) {
	// Controller Verify
	$routes->post('resend-register-email', 'Account\Verify::resendRegisterEmail', ['as' => 'resend_register_email_after_login']);

	// Controller User
	$routes->get('profile/(:segment)', 'Account\User::profile/$1', ['as' => 'user_profile']);
	$routes->get('change-data', 'Account\User::showChangeDataForm', ['as' => 'show_change_user_data_form']);
	$routes->patch('change-data', 'Account\User::changeData', ['as' => 'change_user_data']);
	$routes->get('change-password', 'Account\User::showChangePasswordForm', ['as' => 'show_change_user_password_form']);
	$routes->patch('change-password', 'Account\User::changePassword', ['as' => 'change_user_password']);
	$routes->patch('change-avatar', 'Account\User::changeAvatar', ['as' => 'change_user_avatar']);
	$routes->delete('delete-account', 'Account\User::deleteAccount', ['as' => 'delete_user_account']);

	// Controller Setting
	$routes->get('settings', 'Account\Setting::index', ['as' => 'user_settings']);
	$routes->get('activity-log', 'Account\Setting::showAllActivityLog', ['as' => 'user_activity_log']);
	$routes->get('login-log', 'Account\Setting::showAllLoginLog', ['as' => 'user_login_log']);
});

// Group Admin
$routes->group('admin', ['filter' => 'adminauth'], function ($routes) {
	// Controller Admin
	$routes->get('/', 'Admin\Admin::index', ['as' => 'admin_page']);
	$routes->post('modal-password', 'Admin\Admin::modalPassword', ['as' => 'modal_password']);
	$routes->post('verify-password', 'Admin\Admin::verifyPassword', ['as' => 'verify_password']);

	// Group User
	$routes->group('user', function ($routes) {
		// Controller User
		$routes->get('all-user', 'Admin\User::showAllUser', ['as' => 'show_all_user']);
		$routes->get('insert-data', 'Admin\User::showInsertDataForm', ['as' => 'admin_show_insert_user_data_form']);
		$routes->post('insert-data', 'Admin\User::insertData', ['as' => 'admin_insert_user_data']);
		$routes->get('change-data/(:num)', 'Admin\User::showChangeDataForm/$1', ['as' => 'admin_show_change_user_data_form']);
		$routes->patch('change-data/(:num)', 'Admin\User::changeData/$1', ['as' => 'admin_change_user_data']);
		$routes->get('change-password/(:num)', 'Admin\User::showChangePasswordForm/$1', ['as' => 'admin_show_change_user_password_form']);
		$routes->patch('change-password/(:num)', 'Admin\User::changePassword/$1', ['as' => 'admin_change_user_password']);
		$routes->get('change-avatar/(:num)', 'Admin\User::showChangeAvatarForm/$1', ['as' => 'admin_show_change_user_avatar_form']);
		$routes->patch('change-avatar/(:num)', 'Admin\User::changeAvatar/$1', ['as' => 'admin_change_user_avatar']);
		$routes->get('become-admin/(:num)', 'Admin\User::becomeAdmin/$1', ['as' => 'change_to_admin']);
		$routes->get('become-user/(:num)', 'Admin\User::becomeUser/$1', ['as' => 'change_to_user']);
		$routes->get('delete-account/(:num)', 'Admin\User::deleteAccount/$1', ['as' => 'admin_delete_user_account']);
		$routes->get('restore-account/(:num)', 'Admin\User::restoreAccount/$1', ['as' => 'admin_restore_user_account']);
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
