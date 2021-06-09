<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class Users extends Seeder
{
	public function run()
	{
		$data = [
			[
				'username' => 'superadmin',
				'fullname' => 'Super Admin',
				'slug' => 'super-admin',
				'email' => 'superadmin@example.com',
				'password' => password_hash('Superadmin123', PASSWORD_DEFAULT),
				'role' => 1,
				'email_verified_at' => Time::now(),
			],
			[
				'username' => 'admin',
				'fullname' => 'Normal Admin',
				'slug' => 'normal-admin',
				'email' => 'admin@example.com',
				'password' => password_hash('Admin123', PASSWORD_DEFAULT),
				'role' => 2,
				'email_verified_at' => Time::now(),
			],
			[
				'username' => 'user',
				'fullname' => 'User',
				'slug' => 'user',
				'email' => 'user@example.com',
				'password' => password_hash('User123', PASSWORD_DEFAULT),
				'role' => 3,
				'email_verified_at' => Time::now(),
			],
		];

		// Seeding Data
		$this->db->table('users')->insertBatch($data);
	}
}
