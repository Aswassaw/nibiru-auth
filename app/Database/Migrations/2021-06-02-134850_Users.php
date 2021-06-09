<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			],
			'username' => [
				'type' => 'VARCHAR',
				'constraint' => 26,
			],
			'fullname' => [
				'type' => 'VARCHAR',
				'constraint' => 51,
				'default' => 'No Name',
			],
			'slug' => [
				'type' => 'VARCHAR',
				'constraint' => 51,
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => 101,
			],
			'password' => [
				'type' => 'VARCHAR',
				'constraint' => 501,
			],
			'birth_date' => [
				'type' => 'DATE',
				'null' => TRUE,
			],
			'avatar' => [
				'type' => 'VARCHAR',
				'constraint' => 251,
				'default' => 'default.jpg',
			],
			'role' => [
				'type' => 'TINYINT',
				'constraint' => 1,
				'default' => 3,
			],
		]);

		$this->forge->addField('email_verified_at TIMESTAMP NULL');
		$this->forge->addField('created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP()');
		$this->forge->addField('updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP()');
		$this->forge->addField('deleted_at TIMESTAMP NULL');

		// Primary
		$this->forge->addKey('id', TRUE);

		// Index
		$this->forge->addKey('id');
		$this->forge->addKey('username');
		$this->forge->addKey('email');

		$this->forge->createTable('users');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
