<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Loginlogs extends Migration
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
			'id_users' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'null' => TRUE,
			],
			'ip' => [
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,
			],
			'browser' => [
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,
			],
			'platform' => [
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,
			],
		]);

		// Menambahkan field created_at
		$this->forge->addField('created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP()');

		// Primary Key
		$this->forge->addKey('id', TRUE);

		// Foreign Key
		$this->forge->addForeignKey('id_users', 'users', 'id', 'CASCADE', 'RESTRICT');
		
		// Index
		$this->forge->addKey('id_users');

		$this->forge->createTable('loginlogs');
	}

	public function down()
	{
		$this->forge->dropTable('loginlogs');
	}
}
