<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UsersSample extends Seeder
{
	public function run()
	{
		$faker = \Faker\Factory::create('id_ID');
		$data = [];

		for ($i = 0; $i < 1000; $i++) {
			$gender = $faker->name($gender = rand(1, 2) == 1 ? 'male' : 'female');

			array_push($data, [
				'username' => $faker->username,
				'fullname' => $gender,
				'slug' => url_title($gender, '-', true),
				'email' => $faker->email,
				'password' => $faker->password,
				'birth_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
				'role' => 3,
				'email_verified_at' => Time::now('Asia/Jakarta', 'id_ID'),
			]);
		}

		$this->db->table('users')->insertBatch($data);
	}
}
